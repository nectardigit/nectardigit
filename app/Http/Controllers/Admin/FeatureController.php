<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    public function __construct(Feature $feature)
    {
        $this->middleware(['permission:feature-list|feature-create|feature-edit|feature-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:feature-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:feature-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:feature-delete'], ['only' => ['destroy']]);
        $this->feature = $feature;
    }

    protected function getQuery($request)
    {
        if($request->status=='1'){
            $query = $this->feature->orderBy('id','DESC')->where('publish_status','1');
        }
        elseif ($request->status=='0') {
            $query = $this->feature->orderBy('id','DESC')->where('publish_status','0');;
        }
        else {
            $query = $this->feature->orderBy('id','DESC');
        }
       
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/feature/list', compact('data'));
    }

    public function create()
    {
        $feature_info = null;
        $title = 'Add Feature';
        return view('admin/feature/form', compact('feature_info', 'title'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'icon' => $request->icon_name ?? null,
            'parallax_image' => $request->parallax_image_name ?? null,
            'feature_image' => $request->feature_image_name ?? null,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'created_by' => Auth::user()->id,
        ];
        try {
            if ($request->icon_name) {
                moveImage($request->icon_name, featureimagepath);
            }
            if ($request->parallax_name) {
                moveImage($request->parallax_name, featureimagepath);
            }
            if ($request->feature_image_name) {
                moveImage($request->feature_image_name, featureimagepath);
            }
            $this->feature->fill($data)->save();
            $request->session()->flash('success', 'Feature created successfully.');
            return redirect()->route('feature.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $feature_info = $this->feature->find($id);
        if (!$feature_info) {
            abort(404);
        }
        $title = 'Update Feature Type';
        return view('admin/feature/form', compact('feature_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $feature_info = $this->feature->find($id);
        if (!$feature_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'short_title' => $request->short_title,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
            'icon' => $request->icon_name ?? null,
            'parallax_image' => $request->parallax_image_name ?? null,
            'feature_image' => $request->feature_image_name ?? null,
        ];

        try {
            if($request->icon && $request->icon_name){
                moveImage($request->icon_name, featureimagepath);
                if ($feature_info) {
                    $oldImage =  $feature_info->icon;
                    if ($request->icon_name != $oldImage) {
                        removeImage($oldImage, featureimagepath);
                    }
                }
            }
            if($request->featured_image && $request->featured_image_name){
                moveImage($request->featured_image_name, featureimagepath);
                if ($feature_info) {
                    $oldImage =  $feature_info->featured_image;
                    if ($request->featured_image_name != $oldImage) {
                        removeImage($oldImage, featureimagepath);
                    }
                }
            }
            if($request->parallax_image && $request->parallax_image_name){
                moveImage($request->parallax_image_name, featureimagepath);
                if ($feature_info) {
                    $oldImage =  $feature_info->parallax_image;
                    if ($request->parallax_image_name != $oldImage) {
                        removeImage($oldImage, featureimagepath);
                    }
                }
            }
            $feature_info->fill($data)->save();
            $request->session()->flash('success', 'Feature updated successfully.');
            return redirect()->route('feature.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $feature_info = $this->feature->find($id);
        if (!$feature_info) {
            abort(404);
        }
        try {
            $feature_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Feature deleted successfully.');
            return redirect()->route('feature.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
