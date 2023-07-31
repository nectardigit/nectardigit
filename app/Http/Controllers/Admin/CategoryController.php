<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\CacheTrait;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use CacheTrait;
    public function __construct(Category $category)
    {
        $this->middleware(['permission:category-list|category-create|category-edit|category-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:category-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:category-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:category-delete'], ['only' => ['destroy']]);
        $this->category = $category;
    }

    protected function getQuery($request)
    {
        $query = $this->category->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/blogs/category-list', compact('data'));
    }

    public function create(Request $request)
    {
        $category_info = null;
        $title = 'Add Category Type';
        return view('admin/blogs/category-form', compact('category_info', 'title'));
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

            'position' => $request->position,
            'publish_status' => $request->publish_status,
        ];
        $data['created_by'] = Auth::user()->id;

        try {
            $this->category->fill($data)->save();
            $request->session()->flash('success', 'Category created successfully.');
            return redirect()->route('category.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $category_info = $this->category->find($id);
        if (!$category_info) {
            abort(404);
        }
        $title = 'Update Category Type';
        return view('admin/blogs/category-form', compact('category_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $category_info = $this->category->find($id);
        if (!$category_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'publish_status' => 'required|numeric|in:1,0'
        ]);
        $data = [
            'title' => $request->title,
            'position' => $request->position,
            'publish_status' => $request->publish_status,
        ];
        $data['updated_by'] = Auth::user()->id;
        try {
            $category_info->fill($data)->save();
            $request->session()->flash('success', 'Category updated successfully.');
            return redirect()->route('category.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $category_info = $this->category->find($id);
        if (!$category_info) {
            abort(404);
        }
        try {
            $category_info->delete();
            $data['updated_by'] = Auth::user()->id;
            $request->session()->flash('success', 'Category deleted successfully.');
            return redirect()->route('category.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function changeStatus(Request $request)
    {
        $this->category->find($request->id)->update(['publish_status' => $request->status]);

    }
}
