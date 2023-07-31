<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Utilities\LogActivity;
use App\Traits\CacheTrait;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use CacheTrait;
    protected $menu;
    public function __construct(Menu $menu)
    {
        $this->get_web();
        $this->middleware(['permission:menu-list|menu-create|menu-edit|menu-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:menu-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:menu-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:menu-delete'], ['only' => ['destroy']]);
        $this->menu = $menu;
    }

    public function index()
    {
        $this->menu = $this->menu->with('child_menu')
            ->where('show_on', "like", "%header%")
            ->orderby('position', 'asc')
            ->get();
        return view('admin.menu.menu-list')->with('data', $this->menu);
    }

    public function create()
    {
        $content_type = [
            'about' => 'About',
            'contact' => 'Contact',
            'services' => 'Services',
            'blog' => 'Blog',
            'team' => 'Team',
            'gallery' => 'Gallery',
            'portfolio' => 'Portfolio',
            'basicpage' => 'Basic Page',
            'career' => 'Career Page',

        ];
        $data = [
            'title' => 'Add Menu',
            'content_type' => $content_type,
        ];
        return view('admin.menu.menu-form')->with($data);
    }

    public function additional_menu($id)
    {
        $menu = $this->menu->find($id);
        // dd($menu);
        if (!$menu) {
            return redirect()->route('menu.index')->with('error', 'Error ! Menu Not Found');
        }
        // dd('sdfjsdflsdjf');
        $menu->featured_img_thumb_url = getFullImage($menu->featured_img, $menu->featured_img_path);
        $menu->featured_img_url = getFullImage($menu->featured_img, $menu->featured_img_path);
        $menu->parallex_img_thumb_url = getFullImage($menu->parallex_img, $menu->parallex_img_path);
        $menu->parallex_img_url = getFullImage($menu->parallex_img, $menu->parallex_img_path);
        // dd($menu);
        $data = [
            'data' => $menu,
            'title' => 'Edit Additional Data for Menu',
        ];
        return view('admin.menu.additional-menu')->with($data);
    }
    protected function validate_form()
    {
        // dd($this->_website->website_content_format);
        if ($this->_website == 'Nepali') {
            return [
                'np_title' => "required|string|max:100",
                'publish_status' => 'required|numeric|in:1,0',
                'content_type' => 'required',
                "np_short_description" => "nullable|string|max:3000",

                "np_description" => "nullable|string",

            ];
        } else if ($this->_website == 'English') {
            return [
                'en_title' => "required|string|max:100",
                'publish_status' => 'required|numeric|in:1,0',
                'content_type' => 'required',
                "en_short_description" => "nullable|string|max:3000",
                "en_description" => "nullable|string",
            ];
        } else if ($this->_website == 'Both') {

            return [
                'np_title' => "required|string|max:100",
                "en_title" => "required|string|max:100",
                'content_type' => 'required',
                'publish_status' => 'required|numeric|in:1,0',
                "np_short_description" => "nullable|string|max:3000",
                "en_short_description" => "nullable|string|max:3000",
                "np_description" => "nullable|string",
                "en_description" => "nullable|string",
            ];
        }
        // dd('dfzvbdfgvf');


    }
    protected function mapMenuTitles($request, $menuInfo = null)
    {
        // dd($request->en_description);
        // dd(str_slug($request->np_title, '-'));
        $slug = @$menuInfo->slug;
        // dd($slug);
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
                'en' => htmlentities($request->en_title),
                'np' => htmlentities($request->np_title)
            ],
            "slug" => $slug,
            "content_type" => $request->content_type,
            "publish_status" => $request->publish_status,
            'external_url' => $request->external_url ?? null,
            "description" => [
                'np' => htmlentities($request->np_description),
                'en' => htmlentities($request->en_description),
            ],
            "short_description" => [
                'en' => htmlentities($request->en_short_description),
                'np' => htmlentities($request->np_short_description),
            ],
            "show_on" => $request->show_on,
            "meta_title" =>  htmlentities($request->meta_title),
            "meta_description" => htmlentities($request->meta_description),
            "meta_keyword" => htmlentities($request->meta_keyword),
            "meta_keyphrase" => htmlentities($request->meta_keyphrase),
            "external_url" => $request->external_url,
            "news_section" => $request->news_section,
        ];

        // dd($data);

        // dd($request->all());
        if (!$menuInfo) {
            $data['created_by'] = $request->user()->id;
        }

        if ($request->featured_img && !empty($request->featured_img)) {
            // $image = getImageFromUrl($request->featured_img);
            $data['featured_img'] = $request->featured_img;
            // $data['featured_img_path'] = $image['path'];
        }
        if ($request->parallex_img && !empty($request->parallex_img)) {
            // $image = getImageFromUrl($request->parallex_img);
            $data['parallex_img'] = $request->parallex_img;
            // $data['parallex_img_path'] = $image['path'];
        }
        return $data;
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $this->validate($request,  $this->validate_form());
        // dd('dfzvbdfgvf');

        \DB::beginTransaction();
        try {
            $data = $this->mapMenuTitles($request);
            // dd($data);
            $status =  $this->menu->fill($data)->save();

            LogActivity::addToLog('New Menu Added');
            \DB::commit();
            if (!$status) {
                $request->session()->flash('error', "Sorry! Error While Creating Menu");
            }
            $request->session()->flash('success', 'Menu Created Successfully');
            $this->forgetMenuCache();
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('menu.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $content_type = [
            'about' => 'About',
            'contact' => 'Contact',
            'services' => 'Services',
            'blog' => 'Blog',
            'team' => 'Team',
            'gallery' => 'Gallery',
            'portfolio' => 'Portfolio',
            'basicpage' => 'Basic Page',
            'career' => 'Career Page',


        ];
        $this->menu = $this->menu->find($id);
        if (!$this->menu) {
            return redirect()->route('menu.index')->with('error', 'Error ! Menu Not Found');
        }
        // dd($this->menu);
        $data = [
            'data' => $this->menu,
            'content_type' => $content_type,
            'title' => 'Edit Menu',
        ];
        return view('admin.menu.menu-form')->with($data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request,  $this->validate_form());
        $this->menu = $this->menu->find($id);
        if (!$this->menu) {
            return redirect()->route('menu.index')->with('error', 'Error ! Menu Not Found');
        }
        \DB::beginTransaction();
        try {
            $data = $this->mapMenuTitles($request, $this->menu);
            $status = $this->menu->fill($data)->save();
            LogActivity::addToLog('Menu Edited');
            \DB::commit();
            if (!$status) {
                $request->session()->flash('error', 'Sorry! Error While Updating Menu');
            }
            $request->session()->flash('success', 'Menu Updated Successfully');
            $this->forgetMenuCache();
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('menu.index');
    }

    public function destroy($id)
    {
        $this->menu = $this->menu->find($id);
        if (!$this->menu) {
            return redirect()->route('menu.index')->with('error', 'Error ! Menu Not Found');
        }
        \DB::beginTransaction();
        try {
            if ($this->menu->parent_id == null) {
                $menus = Menu::where('parent_id', $id)->get();
                if ($menus->count() > 0) {
                    foreach ($menus as $child) {
                        Menu::where('id', $child->id)->update(['parent_id' => null]);
                    }
                }
                $status = $this->menu->delete();
            } else {
                $menus = Menu::where('parent_id', $id)->get();
                foreach ($menus as $child) {
                    Menu::where('id', $child->id)->update(['parent_id' => null]);
                    $this->update_child($child->id);
                }
                $status = $this->menu->delete();
            }
            LogActivity::addToLog('Menu Deleted');
            \DB::commit();
            $this->forgetMenuCache();

            if (!$status) {
                request()->session()->flash('error', 'Sorry! Error While Deleting Menu');
            }
            request()->session()->flash('success', 'Menu Updated Successfully');
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('menu.index');
    }

    public function updateMenuOrder(Request $request)
    {
        parse_str($request->sort, $arr);
        $order = 1;
        if (isset($arr['menuItem'])) {
            foreach ($arr['menuItem'] as $key => $value) {  //id //parent_id
                $this->menu->where('id', $key)
                    ->update(['position' => $order, 'parent_id' => ($value == 'null') ? NULL : $value]);
                $order++;
            }
        }
        LogActivity::addToLog('Menu order Updated');
        $this->forgetMenuCache();

        return true;
    }

    private function getSlug($title)
    {
        $slug = \Str::slug($title);
        if ($this->menu->where('slug', $slug)->count() > 0) {
            $slug .= date('Ymdhis');
        }
        return $slug;
    }

    private function update_child($id)
    {
        $menus = Menu::where('parent_id', $id)->get();
        if ($menus->count() > 1) {
            foreach ($menus as $child) {
                Menu::where('id', $child->id)->update(['parent_id' => $child->id]);
                $this->update_child($child->id);
            }
            $this->forgetMenuCache();
        }
    }

    public function resetorder()
    {
        $this->menu = $this->menu->with('child_menu')->orderby('id', 'asc')->get();
        return view('admin.menu.menu-list')->with('data', $this->menu);
    }
}
