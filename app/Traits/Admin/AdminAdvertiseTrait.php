<?php
namespace App\Traits\Admin;

use App\Models\AdvertisementPosition;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 *
 */
trait AdminAdvertiseTrait
{
    public $orderid;
    public $show_on = [
        'app' => "Display on Mobile Screen",
        "web" => "Display On Desktop screen Only",
        "all" => "Display on Mobile/Website screen Both",
    ];
    public $pages = [
        "all" => "All",
        'homepage' => "Homepage",
        'category' => "Category",
        'news_detail' => "News Detail",
    ];
    protected function validateAdvertiseForm()
    {
        return [
            'title' => 'required|string|min:3|max:190',
            "page" => "required|string|in:all,homepage,category,news_detail",
            "organization" => 'required|string|min:3|max:190',
            'publish_status' => 'nullable|numeric|in:1,0',
            "position" => 'required|numeric|exists:advertisement_positions,id',
            "columnType" => "required|string|in:col-lg-2,col-lg-3,col-lg-4,col-lg-6,col-lg-8,col-lg-9,col-lg-12",
            "position" => "required|numeric",
            "direction" => "nullable|string|in:left,right,bottom,top",
            "show_on" => "required|string|in:app,web,all",
            // "is_shared" => "required|string|in:YES,NO",
            "organization" => "required|string|max:191",
            "url" => "nullable|url",
            "from_date" => 'nullable|date_format:Y-m-d',
            "to_date" => 'nullable|date_format:Y-m-d',
        ];
    }
    protected function getAd($request)
    {
        $userRole = request()->user()->roles->first()->name;

        $data = $this->advertisement->query()->with(['get_position']);
        $data->where(function ($qr) use ($userRole) {
            // dd($userRole);
            if ($userRole != 'Super Admin' && $userRole != 'Admin') {
                return $qr->where('created_by', auth()->user()->id);
            }
        })
        ->orderBy('id', 'DESC');

        if ($request->keyword) {
            $keyword = $request->keyword;
            $data->where('title', 'like',  "%$keyword%")
            ->where('organization', 'like',  "%$keyword%");
        }
        return $data->paginate(20);
    }
    public function updateImage($thumbnail, $content, $table)
    {
        $imagepath = getImageFromUrl($thumbnail);
        $path = explode('/uploads/', $thumbnail);
        //  dd(getExt(".".@$thumbnail));
        $imagedata = [
            'url' => $thumbnail,
            'path' => @$path[1],
            'folder_path' => $imagepath['path'],
            'contentId' => $content->id,
            'table' => $table,
            // 'urls' => [''],
            'name' => str_replace("." . getExt(@$thumbnail), '', @$imagepath['image']),
            'extension' => getExt($thumbnail),
        ];
        // dd($imagedata);
        // dd($imagedata);
        $image = MediaLibrary::where('contentId', $content->id)
            ->where('table', $table)
            ->first();
        if ($image) {
            $image->fill($imagedata)->save();
        } else {
            MediaLibrary::create($imagedata);
        }
    }
    protected function getPosition()
    {
        $position = AdvertisementPosition::select('id', 'title as np_title', 'title as en_title')
            ->where('publish_status', '1')
            ->pluck(app()->getLocale() . '_title', 'id');
        return $position;
    }
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
    public function sharedPosition()
    {
        $position = AdvertisementPosition::select('id', 'title as np_title', 'title as en_title')
            ->where('publish_status', '1')
            ->where('sharing', 'shared')
            ->pluck(app()->getLocale() . '_title', 'id');
        return $position;
    }
    public function specificPosition()
    {
        $position = AdvertisementPosition::select('id', 'title as np_title', 'title as en_title')
            ->where('publish_status', '1')
            ->where('sharing', 'specific')
            ->pluck(app()->getLocale() . '_title', 'id');
        return $position;
    }

    protected function mapAdvertiseData($request, $advertisement_info = null)
    {
        // dd($request->all());
        $data = [
            'title' => $request->title,
            'page' => $request->page,
            'organization' => $request->organization,
            'position' => $request->position,
            'columnType' => $request->columnType,
            'url' => $request->url,
            // 'from_date' => date('Y-m-d H:i:s', strtotime(request('from_date'))),
            // 'to_date' => date('Y-m-d H:i:s', strtotime(request('to_date'))),
            'publish_status' => $request->publish_status ?? '0',
            "direction" => $request->direction,
            "show_on" => $request->show_on,
            // "section" => $request->section,
        ];
        if ($request->page == 'homepage') {
            $section = AdvertisementPosition::where('id', $request->position)->pluck('section')->first();
            // dd($section);
            $data['section'] = $section;
        }
        // dd($request->all());
        if ($request->all_screen_image_url && !empty($request->all_screen_image_url)) {
            //    dd(strpos($request->all_screen_image_url,','));
            if (filter_var($request->all_screen_image_url, FILTER_VALIDATE_URL)) {
                if (strpos($request->all_screen_image_url, ',')) {
                    $urls = explode(',', $request->all_screen_image_url);
                    foreach ($urls as $key => $url) {

                        if (filter_var($url, FILTER_VALIDATE_URL)) {
                            if ($key == 0) {
                                $data['img_url'] = $url;
                            }
                        }
                    }
                } else {
                    $data['img_url'] = $request->all_screen_image_url;
                }
            }
        }
        if ($request->mobile_screen_image_url && !empty($request->mobile_screen_image_url)) {
            //    dd(strpos($request->mobile_screen_image_url,','));
            if (filter_var($request->mobile_screen_image_url, FILTER_VALIDATE_URL)) {
                if (strpos($request->mobile_screen_image_url, ',')) {
                    $urls = explode(',', $request->mobile_screen_image_url);
                    foreach ($urls as $key => $url) {

                        if (filter_var($url, FILTER_VALIDATE_URL)) {
                            if ($key == 0) {
                                $data['img_url_app'] = $url;
                            }
                        }
                    }
                } else {
                    $data['img_url_app'] = $request->mobile_screen_image_url;
                }
            }
        }

        // dd($data);
        // if ($request->filepath && !empty($request->filepath)) {
        //     $imagepath = getImageFromUrl($request->filepath);

        //     if ($imagepath) {
        //         $path = explode('/uploads/', $request->filepath);
        //         //  dd(getExt(".".@$request->filepath));
        //         $data['img_url'] = $request->filepath;
        //         $data['img_name'] = str_replace("." . getExt(@$request->filepath), '', @$imagepath['image']);
        //         $data['img_extension'] = getExt($request->filepath);
        //         $data['img_path'] = @$path[1];
        //         $data['img_table'] = 'news';
        //         $data['folder_path']  = $imagepath['path'];
        //     }
        // }
        // if ($request->filepath_app && !empty($request->filepath_app)) {
        //     $imagepath = getImageFromUrl($request->filepath_app);
        //     if ($imagepath) {
        //         $path = explode('/uploads/', $request->filepath_app);
        //         //  dd(getExt(".".@$request->filepath_app));

        //         $data['img_url_app'] = $request->filepath_app;
        //         $data['img_name_app'] = str_replace("." . getExt(@$request->filepath_app), '', @$imagepath['image']);
        //         $data['img_extension_app'] = getExt($request->filepath_app);
        //         $data['img_path_app'] = @$path[1];
        //         $data['folder_path_app']  = $imagepath['path'];
        //         // dd($data);
        //     }
        // }
        if (!$advertisement_info) {
            $data['created_by'] = auth()->id();
        }

        // if ($request->filepath && !empty($request->filepath)) {
        //     // $image = getImageFromUrl($request->filepath);
        //     $data['thumbnail'] = $request->filepath;
        //     $data['path'] = $request->filepath;
        // }
        return $data;
    }

    public function filterdata($request)
    {
        $data = AdvertisementPosition::orderBy('id', 'DESC');

        if ($request->keyword) {
            $keyword = $request->keyword;
            $data = $data->where('title', 'like', '%' . $keyword . '%');
        }
        if ($request->page) {

            $data = $data->where('page', $request->page);
        }

        return $data->paginate(20);
    }

    public function advertisementssorting(Request $request)
    {

        $data = [
            'pages' => $this->pages,
            'data' => $this->filterdata($request),
        ];

        return view('admin/advertisement/advertisementsortlist')->with($data);
    }

    public function advertisementording(Request $request, $id)
    {
        $advertisement = AdvertisementPosition::find($id);
        $position = $advertisement->id;
        $data = $this->advertisement
            ->where('position', $position)
            ->orderby('order', 'asc')
            ->get();
        // dd($advertisement->id);
        session(['orderid' => $position]);
        $advertisementid = session('orderid');

        // dd(session('orderid'));

        return view('admin/advertisement/advertisementordinglist', compact('data', 'advertisementid'));
    }

    public function updateadvertisementOrder(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {

            parse_str($request->sort, $advertisement_data);
            // dd($advertisement_data);
            $order = 1;
            if (isset($advertisement_data['menuItem'])) {
                foreach ($advertisement_data['menuItem'] as $key => $value) { //id //parent_id
                    // dd($key);
                    $data = [
                        'order' => $order,
                        'id' => $key,
                    ];
                    $this->advertisement->where('id', $key)
                        ->update($data);
                    $order++;
                }
            }
            DB::commit();
            $this->forgetAdvertisementCache();
            return response()->json([
                "status" => true,
                'message' => "Advertisement position updated successfully.",
            ]);
        } catch (\Exception $error) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
            ]);
        }
        // LogActivity::addToLog('Advertisement  order Updated');
        // cache()->forget('app_menu');

    }

    public function originaladvertisementOrder()
    {
        // dd(session('orderid'));
        $advertisementid = session('orderid');
        $data = $this->advertisement
            ->where('position', $advertisementid)
            ->update(['order' => null]);

        $data = $this->advertisement->orderby('id', 'asc')->where('position', $advertisementid)->get();

        // dd($data);

        return view('admin/advertisement/advertisementordinglist', compact('data', 'advertisementid'));
    }
}
