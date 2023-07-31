<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryCategoryController extends Controller
{
    public function __construct(GalleryCategory $gallerycategory)
    {
        $this->get_web();
        $this->middleware(['permission:gallerycategory-list|gallerycategory-create|gallerycategory-edit|gallerycategory-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:gallerycategory-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:gallerycategory-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:gallerycategory-delete'], ['only' => ['destroy']]);
        $this->gallerycategory = $gallerycategory;
    }

    protected function getQuery($request)
    {
        $query = $this->gallerycategory->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin.Gallery.Category.gallery-category-list', compact('data'));
    }

    public function create(Request $request)
    {
        $gallerycategory_info = null;
        $title = 'Add Gallery Category';
        return view('admin.Gallery.Category.gallery-category-form', compact('gallerycategory_info', 'title'));
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
            $this->gallerycategory->fill($data)->save();
            $request->session()->flash('success', 'Gallery Category created successfully.');
            return redirect()->route('gallerycategory.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $gallerycategory_info = $this->gallerycategory->find($id);
        if (!$gallerycategory_info) {
            abort(404);
        }
        $title = 'Update Gallery Category';
        return view('admin.Gallery.Category.gallery-category-form', compact('gallerycategory_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $gallerycategory_info = $this->gallerycategory->find($id);
        if (!$gallerycategory_info) {
            abort(404);
        }
        $this->validate($request, $this->validateTag());
        try {
            $data = $this->mapTagData($request, $gallerycategory_info);
            $gallerycategory_info->fill($data)->save();
            $request->session()->flash('success', 'Gallery Category updated successfully.');
            return redirect()->route('gallerycategory.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $gallerycategory_info = $this->gallerycategory->find($id);
        if (!$gallerycategory_info) {
            abort(404);
        }
        try {
            $gallerycategory_info->updated_by = Auth::user()->id;
            $gallerycategory_info->save();
            $gallerycategory_info->delete();
            $request->session()->flash('success', 'Gallery Category deleted successfully.');
            return redirect()->route('gallerycategory.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
