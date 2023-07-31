<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Testimonial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function __construct(Testimonial $testimonial)
    {
        $this->middleware(['permission:testimonial-list|testimonial-create|testimonial-edit|testimonial-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:testimonial-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:testimonial-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:testimonial-delete'], ['only' => ['destroy']]);
        $this->testimonial = $testimonial;
    }

    protected function getQuery($request)
    {
        if($request->status=='1'){

            $query = $this->testimonial->orderBy('id','DESC')->where('publish_status','1');
        }
        elseif ($request->status=='0') {
            $query = $this->testimonial->orderBy('id','DESC')->where('publish_status','0');

        }
        else{
            $query = $this->testimonial->orderBy('id','DESC');
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
        return view('admin/testimonials/list', compact('data'));
    }

    public function create(Request $request)
    {
        $testimonial_info = null;
        $title = 'Add Testimonial Type';
        return view('admin/testimonials/form', compact('testimonial_info', 'title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'designation' => $request->designation,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'created_by' => Auth::user()->id,
            'image' => $request->image_name ?? null,
        ];

        try {
            if ($request->image_name) {
                moveImage($request->image_name, testimonialimagepath);
            }
            $this->testimonial->fill($data)->save();
            $request->session()->flash('success', 'Testimonial created successfully.');
            return redirect()->route('testimonial.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $testimonial_info = $this->testimonial->find($id);
        if (!$testimonial_info) {
            abort(404);
        }
        $title = 'Update Testimonial Type';
        return view('admin/testimonials/form', compact('testimonial_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $testimonial_info = $this->testimonial->find($id);
        if (!$testimonial_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'image' => $request->image_name ?? null,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'updated_by' => Auth::user()->id
        ];
        
        if($request->image && $request->image_name){
            moveImage($request->image_name, testimonialimagepath);
            if ($testimonial_info) {
                $oldImage =  $testimonial_info->image;
                if ($request->image_name != $oldImage) {
                    removeImage($oldImage, testimonialimagepath);
                }
            }
        }

        try {
            $testimonial_info->fill($data)->save();
            $request->session()->flash('success', 'Testimonial updated successfully.');
            return redirect()->route('testimonial.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $testimonial_info = $this->testimonial->find($id);
        if (!$testimonial_info) {
            abort(404);
        }
        try {
            $testimonial_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Testimonial deleted successfully.');
            return redirect()->route('testimonial.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
