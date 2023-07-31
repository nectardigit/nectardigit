<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Utilities\LogActivity;
use App\Models\Menu;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsefullLinksController extends Controller
{
    use CacheTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Menu $menu)
    {
        $this->menu  = $menu;
        $this->get_web();
    }
    public function index()
    {
        //
        $links = $this->menu->with('child_menu')
            ->where('show_on', "like", "%useful_links%")
            ->orderby('position', 'asc')->get();
        // dd($links);
        $data = [
            "page_title" => "Userful Links",
            'data' => $links
        ];
        return view('admin.useful-links.useful-links-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.useful-links.create-useful-links');
    }
    protected function validate_form()
    {
        // dd($this->_website->website_content_format);
        if ($this->_website == 'Nepali') {
            return [
                'np_title' => "required|string|max:100",
                'publish_status' => 'required|numeric|in:1,0',
                'content_type' => 'required|in:basicpage',
                "show_on"       => "required|in:useful_links"

            ];
        } else if ($this->_website == 'English') {
            return [
                'en_title' => "required|string|max:100",
                'publish_status' => 'required|numeric|in:1,0',
                'content_type' => 'required|in:basicpage',
                "show_on"       => "required|in:useful_links"
            ];
        } else if ($this->_website == 'Both') {

            return [
                'np_title' => "required|string|max:100",
                "en_title" => "required|string|max:100",
                'content_type' => 'required|in:basicpage',
                'publish_status' => 'required|numeric|in:1,0',
                "show_on"       => "required|in:useful_links"
            ];
        }
        // dd('dfzvbdfgvf');


    }
    protected function mapData($request, $menuInfo = null)
    {
        // dd($request->all());
        // dd(str_slug($request->np_title, '-'));
        $slug = @$menuInfo->slug;
        if (!$slug) {
            if ($request->en_title) {
                $slug  = str_slug($request->en_title, '-');
            } else if ($request->np_title) {
                $slug = str_slug($request->np_title, '-');
            }
        }
        // dd($slug);
        $data = [
            'title' => [
                'en' => $request->en_title ?? @$menuInfo->title['en'] ?? $request->np_title,
                'np' => $request->np_title ?? @$menuInfo->title['np'] ?? $request->en_title,
            ],
            "slug" => $slug,
            "content_type" => $request->content_type,
            "publish_status" => $request->publish_status,
            'external_url' => $request->external_url ?? null,

            "show_on" => [$request->show_on],

        ];

        // dd($data);


        if (!$menuInfo) {
            $data['created_by'] = auth()->id();
        }

        // if ($request->featured_img && !empty($request->featured_img)) {
        //     $image = getImageFromUrl($request->featured_img);
        //     $data['featured_img'] = $image['image'];
        //     $data['featured_img_path'] = $image['path'];
        // }
        // if ($request->parallex_img && !empty($request->parallex_img)) {
        //     $image = getImageFromUrl($request->parallex_img);
        //     $data['parallex_img'] = $image['image'];
        //     $data['parallex_img_path'] = $image['path'];
        // }
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
        //
        $this->validate($request, $this->validate_form());
        $data  = $this->mapData($request, null);
        //    dd($data);
        DB::beginTransaction();
        try {

            // dd($data);
            $status =  $this->menu->create($data);
            LogActivity::addToLog('New useful link Added');
            $this->forgetMenuCache();
            DB::commit();
            if (!$status) {
                $request->session()->flash('error', "Sorry! Error While Creating new useful link");
            }
            $request->session()->flash('success', 'Useful link created Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('usefullinks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function edit($id)
    {
        //

        $usefullinks = $this->menu->where('id', $id)->where('show_on', "like", "%useful_links%")->first();
        if (!$usefullinks) {
            request()->session()->flash('error', 'Invalid useful links information.');
            return redirect()->route('usefullinks.index');
        }

        $data = [
            "page_title" => "Userful Links",
            'data' => $usefullinks
        ];
        return view('admin.useful-links.create-useful-links', $data);
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
        //

        $usefullinks = $this->menu->where('id', $id)->where('show_on', "like", "%useful_links%")->first();
        if (!$usefullinks) {
            request()->session()->flash('error', 'Invalid useful links information.');
            return redirect()->route('usefullinks.index');
        }

        $this->validate($request, $this->validate_form());
        $data  = $this->mapData($request, null);
        //    dd($data);
        DB::beginTransaction();
        try {
            // dd($data);
            $status =  $usefullinks->fill($data)->save();
            LogActivity::addToLog('useful link updated');
            $this->forgetMenuCache();
            DB::commit();
            if (!$status) {
                $request->session()->flash('error', "Sorry! Error While updating new useful link");
            }
            $request->session()->flash('success', 'Useful link updated Successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('usefullinks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
