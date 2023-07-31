<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Information;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function __construct(Information $information)
    {
        $this->middleware(['permission:information-list|information-create|information-edit|information-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:information-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:information-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:information-delete'], ['only' => ['destroy']]);
        $this->get_web();
        $this->information = $information;
    }

    protected function getInfo($request)
    {
        $query = $this->information->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getInfo($request);
        // dd($data);
        return view('admin/informations/list', compact('data'));
    }

    public function create(Request $request)
    {
        $information_info = null;
        $title = 'Add Service';
        return view('admin/informations/form', compact('information_info', 'title'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, $this->informationValidate($request));
        try {
            $data = $this->mapInformationData($request);
            $this->information->fill($data)->save();
            $request->session()->flash('success', 'Service created successfully.');
            return redirect()->route('information.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    protected function informationValidate($request)
    {
        $data = [
            'title' => 'required|string|min:3|max:190',
            'position' => 'required|numeric',
            'publish_status' => 'required|numeric|in:0,1',
        ];
        if ($request->isMethod('post')) {
            $data['image'] = 'required';
        }
        return $data;
    }
    protected function mapInformationData($request, $newsInfo = null)
    {
        $data = [
            'title' => htmlentities($request->title),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'meta_title' => $request->meta_title,
            'meta_keyphrase' => $request->meta_keyphrase,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
            'slug' => Str::slug($request->title),

            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'display_home' => $request->display_home,
            'created_by' => Auth::user()->id,
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }
        if ($request->image) {
            $data['image'] = $request->image;
        }
        if ($request->features) {
            $data['features'] = $request->features;
        }
        if ($request->banner) {
            $data['banner'] = $request->banner;
        }
        return $data;
    }
    public function edit(Request $request, $id)
    {
        $information_info = $this->information->find($id);
        if (!$information_info) {
            abort(404);
        }
        $title = 'Update Service';
        return view('admin/informations/form', compact('information_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $information_info = $this->information->find($id);
        if (!$information_info) {
            abort(404);
        }
        $this->validate($request, $this->informationValidate($request));
        try {
            $data = $this->mapInformationData($request);
            $information_info->fill($data)->save();
            $request->session()->flash('success', 'Service updated successfully.');
            return redirect()->route('information.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $information_info = $this->information->find($id);
        if (!$information_info) {
            abort(404);
        }
        try {
            $information_info->updated_by = Auth::user()->id;
            $information_info->save();
            $information_info->delete();
            $request->session()->flash('success', 'Service deleted successfully.');
            return redirect()->route('information.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request)
    {
        $this->information->find($request->id)->update(['publish_status' => $request->status]);
    }
    public function changedisplayhome(Request $request)
    {
        $this->information->find($request->id)->update(['display_home' => $request->status]);
    }
}
