<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function __construct(Slider $slider)
    {
        $this->middleware(['permission:slider-list|slider-create|slider-edit|slider-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:slider-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:slider-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:slider-delete'], ['only' => ['destroy']]);
        $this->slider = $slider;
    }

    protected function getSlider($request)
    {
        $query = $this->slider;
        if (isset($request->status)) {
            $query = $this->slider->where('publish_status', $request->status);
        }
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->orderBy('id', 'DESC')->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getSlider($request);
        return view('admin/sliders/list', compact('data'));
    }

    public function create(Request $request)
    {
        $slider_info = null;
        $title = 'Add Slider';
        return view('admin/sliders/form', compact('slider_info', 'title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->sliderValidate($request));
        try {
            $data = $this->mapSliderData($request);
            $this->slider->fill($data)->save();
            $request->session()->flash('success', 'Slider created successfully.');
            cache()->forget('app_sliders');
            return redirect()->route('slider.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    protected function sliderValidate($request)
    {
        $data = [
            'title' => 'required|string|min:3|max:190',
            'slider_type' => 'required',
            'position' => 'required|numeric',
            'publish_status' => 'required|numeric|in:0,1',
        ];
        if ($request->isMethod('post')) {
            $data['image'] = 'required';
        }
        return $data;
    }
    protected function mapSliderData($request)
    {
        $data = [
            'title' => htmlentities($request->title),
            'sub_title' => htmlentities($request->sub_title),
            'description' => $request->description,
            'slider_type' => $request->slider_type,
            'external_url' => $request->external_url,
            'position' => $request->position,
            'display_home' => $request->display_home,
            'publish_status' => $request->publish_status,
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }
        if ($request->image) {
            $data['image'] = $request->image;
        }
        return $data;
    }

    public function edit(Request $request, $id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
            abort(404);
        }
        $title = 'Update Slider';
        return view('admin/sliders/form', compact('slider_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
            abort(404);
        }
        $this->validate($request, $this->sliderValidate($request));
        try {
            $data = $this->mapSliderData($request);
            $slider_info->fill($data)->save();
            $request->session()->flash('success', 'Slider updated successfully.');
            return redirect()->route('slider.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $slider_info = $this->slider->find($id);
        if (!$slider_info) {
            abort(404);
        }
        try {
            $slider_info->updated_by = Auth::user()->id;
            $slider_info->save();
            $slider_info->delete();
            $request->session()->flash('success', 'Slider deleted successfully.');
            cache()->forget('app_sliders');
            return redirect()->route('slider.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request)
    {
        $this->slider->find($request->slider_id)->update(['publish_status'=>$request->status]);

    }
    public function changedisplayhome(Request $request)
    {
        $this->slider->find($request->id)->update(['display_home'=>$request->status]);

    }
}
