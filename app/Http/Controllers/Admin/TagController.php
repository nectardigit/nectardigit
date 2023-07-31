<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function __construct(Tag $tag)
    {
        $this->get_web();
        $this->middleware(['permission:tag-list|tag-create|tag-edit|tag-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:tag-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:tag-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:tag-delete'], ['only' => ['destroy']]);
        $this->tag = $tag;
    }

    protected function getQuery($request)
    {
        $query = $this->tag->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/blogs/tag-list', compact('data'));
    }

    public function create(Request $request)
    {
        $tag_info = null;
        $title = 'Add Tag';
        return view('admin/blogs/tag-form', compact('tag_info', 'title'));
    }
    protected function validateTag()
    {
        $data = [
            "title" => "required|string|max:100",
            "publish_status" => "required|numeric|in:1,0",
        ];
        return $data;
    }
    protected function mapTagData($request)
    {
        $data = [
            "title" => $request->title,
            "publish_status" => $request->publish_status,
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }
        return $data;
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validateTag());
        try {
            $data = $this->mapTagData($request);
            $this->tag->fill($data)->save();
            $request->session()->flash('success', 'Tag created successfully.');
            return redirect()->route('tag.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $tag_info = $this->tag->find($id);
        if (!$tag_info) {
            abort(404);
        }
        $title = 'Update Tag';
        return view('admin/blogs/tag-form', compact('tag_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $tag_info = $this->tag->find($id);
        if (!$tag_info) {
            abort(404);
        }
        $this->validate($request, $this->validateTag());
        try {
            $data = $this->mapTagData($request, $tag_info);
            $tag_info->fill($data)->save();
            $request->session()->flash('success', 'Tag updated successfully.');
            return redirect()->route('tag.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $tag_info = $this->tag->find($id);
        if (!$tag_info) {
            abort(404);
        }
        try {
            $tag_info->updated_by = Auth::user()->id;
            $tag_info->save();
            $tag_info->delete();
            $request->session()->flash('success', 'Tag deleted successfully.');
            return redirect()->route('tag.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
