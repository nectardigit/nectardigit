<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function __construct(Faq $faq)
    {
        $this->middleware(['permission:faq-list|faq-create|faq-edit|faq-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:faq-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:faq-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:faq-delete'], ['only' => ['destroy']]);
        $this->faq = $faq;
    }

    protected function getQuery($request)
    {
        $query = $this->faq->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/faqs/list', compact('data'));
    }

    public function create(Request $request)
    {
        $faq_info = null;
        $title = 'Add Faq Type';
        return view('admin/faqs/form', compact('faq_info', 'title'));
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
            'description' => $request->description,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'display_home' => $request->display_home,
        ];
        // dd($data);

        try {
            $this->faq->fill($data)->save();
            $request->session()->flash('success', 'Faq created successfully.');
            return redirect()->route('faq.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $faq_info = $this->faq->find($id);
        if (!$faq_info) {
            abort(404);
        }
        $title = 'Update Faq Type';
        return view('admin/faqs/form', compact('faq_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $faq_info = $this->faq->find($id);
        if (!$faq_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
            'display_home' => $request->display_home,
        ];

        try {
            $faq_info->fill($data)->save();
            $request->session()->flash('success', 'Faq updated successfully.');
            return redirect()->route('faq.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $faq_info = $this->faq->find($id);
        if (!$faq_info) {
            abort(404);
        }
        try {
            $faq_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Faq deleted successfully.');
            return redirect()->route('faq.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function changeStatus(Request $request)
    {
        // dd( $this->faq->find($request->id));
        $this->faq->find($request->id)->update(['publish_status'=>$request->status]);

    }
    public function changedisplayhome(Request $request)
    {
        $this->faq->find($request->id)->update(['display_home'=>$request->status]);

    }
}
