<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdvertisementPosition;
use App\Models\Menu;
use App\Models\CategoryAdvertisementPosition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Async\Pool;

class AdvertisementPositionController extends Controller
{
    use CacheTrait;
    public function __construct(AdvertisementPosition $advertisementposition, CategoryAdvertisementPosition $category_advertisement_position)
    {
        $this->middleware(['permission:advertisementposition-list|advertisementposition-create|advertisementposition-edit|advertisementposition-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:advertisementposition-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:advertisementposition-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:advertisementposition-delete'], ['only' => ['destroy']]);
        $this->advertisementposition = $advertisementposition;
        $this->category_advertisement_position = $category_advertisement_position;
        $this->get_web();
    }
    public $ad_position_types = [
        'page_shared' => 'Page Sharing',
        "page_specific" => "Page Specific"
    ];
    public $pages  = [
        "all" => "All",
        'homepage' => "Homepage",
        'category' => "Category",
        'news_detail' => "News Detail",
    ];
    protected function getAdPosition($request)
    {

        // dd($request->all());
        // dd($request->page);

        $query = $this->advertisementposition
            ->with(['get_section'])
            ->orderBy('id', 'DESC');

        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'like', '%' . $keyword . '%');
        }
        if ($request->page) {

            $query = $query->where('page', $request->page);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        // $data = $this->advertisementposition->select(
        //     "id" ,
        // "title" ,
        // "key" ,
        // "section",
        // "page",
        // "quantity",
        // "publish_status",
        // )->get()->toArray() ;
        // dd($data);

        $data = [
            'pages' => $this->pages,
            'data' => $this->getAdPosition($request)
        ];
        // dd($data);
        return view('admin/advertisementPosition/advertisementPosition-list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function getSection()
    {
        // $section = Menu::select('id', 'title->np as np_title', 'title->en as en_title')
        //     ->where('content_type', 'category')
        //     ->where('publish_status', '1')
        //     ->pluck(app()->getLocale() . '_title', 'id');
        // return $section; 

        $news_category = Menu::select("id", 'title')
            ->where('content_type', 'category')
            ->where('show_on', 'like', "%homepage%")
            ->where('publish_status', '1')
            ->get();
        // dd($news_category);
        $cat_items = [];
        foreach ($news_category as $category) {
            $cat_items[$category->id] = $category->title[$this->locale];
        }
        // dd($cat_items);
        return $cat_items;
    }
    public function create(Request $request)
    {
        // dd($section);
        $section = $this->getSection();
        // dd($section);
        $data = [
            'advertisementposition_info' => null,
            'title' => 'Add Advertisement Position',
            'section' => $section,
            "ad_position_types" => $this->ad_position_types,
            "pages" => $this->pages
        ];


        return view('admin/advertisementPosition/advertisementPosition-form', $data);
    }
    protected function mapPositionData($request, $adposition = null)
    {
        $data = [
            'title' => $request->title,
            'key' => $request->key,
            'quantity' => $request->quantity,
            'publish_status' => $request->publish_status,
            "page" => $request->page
        ];

        if ($request->page  == 'homepage') {
            $data['section'] = $request->section;
        } else {
            $data['section'] =  NULL;
        }
        if (!$adposition) {
            $data['created_by'] = auth()->id();
        } else {
            $data['updated_by'] = auth()->id();
        }
        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0',
            "quantity" => "required|numeric|min:1",
            "section" => "nullable|numeric|exists:menus,id",
            "key" => "required|string|unique:advertisement_positions,key",
            "page" => "required|string|in:all,homepage,category,news_detail"
        ]);
        // dd($request->all());

        $data = $this->mapPositionData($request);
        // dd($data);
        DB::beginTransaction();
        try {
            $advertisementposition = $this->advertisementposition->create($data);
            DB::commit();
            $request->session()->flash('success', 'Advertisement Position created successfully.');
            // $this->updateCategory($advertisementposition, $request);
            $this->forgetAdvertisementPosition();
            return redirect()->route('advertisementposition.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updateCategory($adPosition, $request)
    {
        $cat = $request->section;
        // dd($cat);
      
            // dd($cat);
            $cat_data  = [
                'adPositionId' => $adPosition->id,
                'categoryId' => (int) $cat,
            ];
            // dd($cat_data);

            $this->category_advertisement_position->create($cat_data);
       
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $section = $this->getSection();
        $advertisementposition_info = $this->advertisementposition->find($id);
        abort_if(!$advertisementposition_info, 404);

        $data = [
            'advertisementposition_info' => $advertisementposition_info,
            'title' => 'Update Advertisement Position',
            'section' => $this->getSection(),
            "ad_position_types" => $this->ad_position_types,
            "pages" => $this->pages
        ];
        return view('admin/advertisementPosition/advertisementPosition-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advertisementposition_info = $this->advertisementposition->find($id);

        abort_if(!$advertisementposition_info, 404);
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0',
            "quantity" => "required|numeric|min:1",
            "section" => "nullable|numeric|exists:menus,id",
            "key" => "required|string|unique:advertisement_positions,key," . $advertisementposition_info->id,
            "page" => "required|string|in:all,homepage,category,news_detail"
        ]);
        $data = $this->mapPositionData($request, $advertisementposition_info);

        DB::beginTransaction();
        try {
            $advertisementposition_info->fill($data)->save();
            DB::commit();
            $this->forgetAdvertisementPosition();
            $request->session()->flash('success', 'Advertisement Position updated successfully.');
            return redirect()->route('advertisementposition.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $advertisementposition_info = $this->advertisementposition->find($id);
        abort_if(!$advertisementposition_info, 404);
        DB::beginTransaction();
        try {
            $data['updated_by'] = auth()->id();
            $advertisementposition_info->delete();
            DB::commit();
            $this->forgetAdvertisementPosition();
            $request->session()->flash('success', 'Advertisement Position deleted successfully.');
            return redirect()->route('advertisementposition.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function getAdpositions(Request $request)
    {
        // dd($request->all());
        $positions = $this->advertisementposition
            ->where('page', $request->page)
            ->pluck('title', 'id');
        $position = $request->position;
        $html = view('admin.advertisementPosition.select-option', compact('positions', 'position'))->render();
        return response()->json([
            'status' => true,
            "html" => $html,
        ]);
    }
}
