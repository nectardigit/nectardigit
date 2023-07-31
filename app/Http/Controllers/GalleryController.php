<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    public function __construct(Gallery $gallery)
    {
        $this->get_web();
        $this->middleware(['permission:gallery-list|gallery-create|gallery-edit|gallery-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:gallery-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:gallery-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:gallery-delete'], ['only' => ['destroy']]);
        $this->gallery = $gallery;
    }

    protected function getQuery($request)
    {
        $query = $this->gallery->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin.Gallery.gallery-list', compact('data'));
    }

    public function create(Request $request)
    {
        $gallery_info = null;
        $title = 'Add Gallery';
        return view('admin.Gallery.gallery-form', compact('gallery_info', 'title'));
    }
    protected function validategallery()
    {
        $data = [
            "title" => "required|string|max:100",
            "publish_status" => "required|numeric|in:1,0",
        ];
        return $data;
    }
    protected function mapgallery($request, $gallery_info = null)
    {
        // dd($request->all());
        $data = [
            "title" => $request->title,
            "position" => $request->position,
            "slug" => $this->getSlug($request->title),
            "meta_title" => $request->meta_title,
            "meta_description" => $request->meta_description,
            "meta_keyword" => $request->meta_keyword,
            "meta_keyphrase" => $request->meta_keyphrase,
            "publish_status" => $request->publish_status,
        ];

        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }

        if ($request->cover_image) {
            if (validate_url($request->cover_image)) {
                $data['cover_image'] = $request->cover_image;
            } else {
                $request->session()->flash('error', 'Invalid Cover Image');
                return redirect()->back();
            }
        }

        if ($request->gallery_images) {
            $images = explode(',', $request->gallery_images[0]);
            // dd($images);

            foreach ($images as $image) {
                if (validate_url($image)) {

                    $gallery_image[] = $image;
                } else {
                    $request->session()->flash('error', 'Invalid Galarey Images');
                    return redirect()->back();
                }
            }
                if ($request->isMethod('post')) {
                    $data['gallery_images'] = $gallery_image;
                }
                if ($request->isMethod('put')) {
                    // dd($gallery_image);
                    $previous_images = $gallery_info->gallery_images;
                    $new_images = array_unique(array_merge($previous_images, $gallery_image));
                    $data['gallery_images'] = $new_images;
                }

        }
        // dd($data);
        return $data;
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validategallery());
        try {
            $data = $this->mapgallery($request);
            // dd($data);
            $this->gallery->fill($data)->save();
            $request->session()->flash('success', 'Gallery created successfully.');
            return redirect()->route('gallery.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        $gallery_info = $this->gallery->find($id);
        if (!$gallery_info) {
            abort(404);
        }
        $title = 'Update Gallery';
        return view('admin.Gallery.gallery-form', compact('gallery_info', 'title'));
    }

    public function update(Request $request, $id)
    {
        $gallery_info = $this->gallery->find($id);
        if (!$gallery_info) {
            abort(404);
        }
        $this->validate($request, $this->validategallery());
        try {
            $data = $this->mapgallery($request, $gallery_info);
            // dd($data);
            $gallery_info->fill($data)->save();
            $request->session()->flash('success', 'Gallery updated successfully.');
            return redirect()->route('gallery.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $gallery_info = $this->gallery->find($id);
        if (!$gallery_info) {
            abort(404);
        }
        try {
            $gallery_info->updated_by = Auth::user()->id;
            $gallery_info->save();
            $gallery_info->delete();
            $request->session()->flash('success', 'Gallery Category deleted successfully.');
            return redirect()->route('gallerycategory.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->gallery->where('slug', $slug)->first();
        if (request()->isMethod('post')) {
            if ($find) {
                $slug = $slug . '-' . rand(1111, 9999);
            }
        }
        return $slug;
    }
    public function changeStatus(Request $request)
    {
        $this->gallery->find($request->id)->update(['publish_status' => $request->status]);
    }

    public function removeimage(Request $request)
    {
        // dd($request->all());
        $image = $request->image;
        $data = $this->gallery->find($request->id);
        $previous_images = $data->gallery_images;
        $new_images = array_diff($previous_images, [$request->image]);
        $data->update(['gallery_images' => $new_images]);
        return response()->json([
            'status' => true,
            'image' => $image,
        ]);
    }
}
