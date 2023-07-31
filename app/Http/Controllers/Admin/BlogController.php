<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Mail\BlogSendMail;
use App\Models\Category;
use App\Models\subscriber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    public function __construct(Blog $blog)
    {
        $this->middleware(['permission:blog-list|blog-create|blog-edit|blog-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:blog-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:blog-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:blog-delete'], ['only' => ['destroy']]);
        $this->blog = $blog;
    }

    protected function getQuery($request)
    {
        $query = $this->blog->orderBy('id', 'DESC');
        if (isset($request->status)) {
            $query = $this->blog->where('publish_status', $request->status);
        }
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', 'LIKE', "%{$keyword}%");
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/blogs/blog-list', compact('data'));
    }
    public function create(Request $request)
    {
        $blog_info = null;
        $title = 'Add Blog';
        $tags = Tag::where('publish_status', '1')->pluck('title', 'id');
        $category=Category::where('publish_status','1')->orderby('position','ASC')->pluck('title','id');
        $data=[
            'blog_info'=>$blog_info,
            'title'=>$title,
            'tags'=>$tags,
            'category'=>$category,
        ];
        return view('admin/blogs/blog-form')->with($data);
    }
    protected function blogValidate($request)
    {
        $data = [
            "title" => "required|string|max:200",
            "description" => "required|string",
            "tags" => "required",
            "publish_status" => "required|numeric|in:0,1",
            "meta_title" => "nullable|string|max:300",
            "meta_keyword" => "nullable|string|max:300",
            "meta_keyphrase" => "nullable|string|max:300",
        ];
        if ($request->isMethod('post')) {
            $data['featured_image'] = 'required';
            $data['parallax_image'] = 'required';
        }
        return $data;
    }
    protected function mapBlogData($request, $newsInfo = null)
    {
        $data = [
            "title" => htmlentities($request->title),
            "slug" => $this->getSlug($request->title),
            "description" => $request->description,
            "publish_status" => $request->publish_status ?? '0',
            "display_home" => $request->display_home ?? '0',
            "meta_title" => htmlentities($request->meta_title),
            "meta_description" => htmlentities($request->meta_description),
            "meta_keyword" => htmlentities($request->meta_keyword),
            "meta_keyphrase" => htmlentities($request->meta_keyphrase),
        ];
        if ($request->isMethod('post')) {
            $data['created_by'] = Auth::user()->id;
        } elseif ($request->isMethod('put')) {
            $data['updated_by'] = Auth::user()->id;
        }
        if ($request->featured_image) {
            $data['featured_image'] = $request->featured_image;
        }
        if ($request->parallax_image) {
            $data['parallax_image'] = $request->parallax_image;
        }
        // dd($data);
        return $data;
    }
    public function store(Request $request)
    {
        // dd($request->tags);
        $this->validate($request, $this->blogValidate($request));
        try {

            DB::beginTransaction();
            $data = $this->mapBlogData($request);

            // dd($data);

            $blog = Blog::create($data);
            $blog->tags()->sync($request->tags);
            $blog->category()->sync($request->category);


            //For Blog Mail for Subscriber

            if ($request->publish_status == '1') {
                $blog_data = [
                    'title' => $data['title'],
                    'description' => $data['description'],

                ];
                if (isset($data['featured_image'])) {
                    $blog_data['featured_image'] = $data['featured_image'];
                }
                $email = subscriber::orderBy('id', 'DESC')->pluck('email');
                foreach ($email as $value) {
                    Mail::to($value)->send(new BlogSendMail($blog_data));
                }
            }

            //End Blog Mail for Subscriber


            $request->session()->flash('success', 'Blog created successfully.');
            DB::commit();
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->to(url()->previous());
        }
    }

    public function edit(Request $request, $id)
    {
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        $title = 'Update Blog';
        $tags = Tag::where('publish_status','1')->pluck('title', 'id');
        $selectedtags = DB::table('blog_tag')->where('blog_id', $id)->pluck('tag_id', 'tag_id');
        $category=Category::where('publish_status','1')->orderby('position','ASC')->pluck('title','id');
        $selectedcategory= DB::table('blog_categories')->where('blog_id', $id)->pluck('category_id', 'category_id');

        $data=[
            'blog_info'=>$blog_info,
            'title'=>$title,
            'tags'=>$tags,
            'category'=>$category,
            'selectedtags'=>$selectedtags,
            'selectedcategory'=>$selectedcategory,
        ];
        return view('admin/blogs/blog-form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        $this->validate($request, $this->blogValidate($request));
        try {
            DB::beginTransaction();
            $data = $this->mapBlogData($request);
            $blog_info->fill($data)->save();
            // dd($blog_info->tags);
            $blog_info->tags()->sync($request->tags);
            $blog_info->category()->sync($request->category);


            //For Blog Mail for Subscriber

            if ($request->publish_status == '1') {
                $blog_data = [
                    'title' => $data['title'],
                    'description' => $data['description'],
                ];
                if (isset($data['featured_image'])) {
                    $blog_data['featured_image'] = $data['featured_image'];
                } else {
                    $blog_data['featured_image'] = $blog_info->featured_image;
                }
                $email = subscriber::orderBy('id', 'DESC')->pluck('email');
                foreach ($email as $value) {
                    Mail::to($value)->send(new BlogSendMail($blog_data));
                }
            }
            //End Blog Mail for Subscriber


            $request->session()->flash('success', 'Blog updated successfully.');
            DB::commit();
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request, $id)
    {
        $blog_info = $this->blog->find($id);
        if (!$blog_info) {
            abort(404);
        }
        try {
            $blog_info->updated_by = Auth::user()->id;
            $blog_info->save();
            $blog_info->delete();
            $request->session()->flash('success', 'Blog deleted successfully.');
            return redirect()->route('blog.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    protected function getSlug($title)
    {
        $slug = Str::slug($title);
        $find = $this->blog->where('slug', $slug)->first();
        if (request()->isMethod('post')) {
            if ($find) {
                $slug = $slug . '-' . rand(1111, 9999);
            }
        }
        return $slug;
    }

    public function changeStatus(Request $request)
    {
        $this->blog->find($request->id)->update(['publish_status' => $request->status]);
    }
    public function changedisplayhome(Request $request)
    {
        $this->blog->find($request->id)->update(['display_home' => $request->status]);
    }
}
