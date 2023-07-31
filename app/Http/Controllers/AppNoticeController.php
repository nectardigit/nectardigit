<?php

namespace App\Http\Controllers;

use App\Models\AppNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppNoticeController extends Controller
{
    public function __construct(AppNotice $appNotice)
    {
        $this->middleware(['permission:$appNotice-list|$appNotice-create|$appNotice-edit|$appNotice-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:$appNotice-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:$appNotice-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:$appNotice-delete'], ['only' => ['destroy']]);
        $this->appNotice = $appNotice;
    }

    protected function getNotice($request)
    {
        $query = $this->appNotice->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }

    public function index(Request $request)
    {
        $data = $this->getNotice($request);
        $notices = AppNotice::pluck('title', 'id');
        $data = [
            'data' => $data,
            'notices' => $notices,
        ];
        return view('admin/appnotice/list')->with($data);
    }

    public function create()
    {
        $appnotice_info = null;
        $title = 'Add App Notice';
        $data = [
            'appnotice_info' => $appnotice_info,
            'title' => $title,
        ];
        return view('admin/appnotice/form')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'description' => 'nullable|string|min:3|max:190',
            'from_date' => 'required|before:to_date',
            'to_date' => 'required|after:from_date',
            'from_time' => 'required',
            'to_time' => 'required',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'publish_status' => $request->publish_status,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'to_time' => $request->to_time,
            'from_time' => $request->from_time,
        ];
        $data['added_by'] = Auth::user()->id;
        if ($request->image) {
            $image_name = uploadFile($request->image, 'uploads/appnotices/', false, time());
            if ($image_name) {
                $data['image'] = $image_name;
            }
        }
        try {
            $this->appNotice->fill($data)->save();
            $request->session()->flash('success', 'App Notice created successfully.');
            return redirect()->route('appnotice.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $appnotice_info = $this->appNotice->find($id);
        if (!$appnotice_info) {
            abort(404);
        }
        $title = 'Update App Notice';
        $data = [
            'title' => $title,
            'appnotice_info' => $appnotice_info,
        ];
        return view('admin/appnotice/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $appnotice_info = $this->appNotice->find($id);
        if (!$appnotice_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'description' => 'nullable|string|min:3|max:190',
            'from_date' => 'required|before:to_date',
            'to_date' => 'required|after:from_date',
            'from_time' => 'required',
            'to_time' => 'required',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'publish_status' => $request->publish_status,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'to_time' => $request->to_time,
            'from_time' => $request->from_time,
        ];
        $data['added_by'] = Auth::user()->id;
        if ($request->image) {
            $image_name = uploadFile($request->image, 'uploads/appnotices/', false, time());
            if ($image_name) {
                $data['image'] = $image_name;
            }
        }
        try {
            $appnotice_info->fill($data)->save();
            $request->session()->flash('success', 'App Notice created successfully.');
            return redirect()->route('appnotice.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }


    public function destroy(Request $request, $id)
    {
        $appnotice_info = $this->appNotice->find($id);
        if (!$appnotice_info) {
            abort(404);
        }
        try {
            $appnotice_info->delete();
            $request->session()->flash('success', 'App Notice deleted successfully.');
            return redirect()->route('appnotice.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
