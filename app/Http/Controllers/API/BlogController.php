<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;

class BlogController extends BaseController
{

    public function index()
    {
      //  $blogs = Blog::latest()->get();
        $blogs = Blog::with('user')->latest()->get();

        return $this->sendResponse(BlogResource::collection($blogs), 'Blog fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['featured_image'] = $request->file('featured_image')->store('apiImage');
        $input['featured_image'] = asset($input['featured_image']);

        try {
            $blog = Blog::create($input);
            return $this->sendResponse(new BlogResource($blog), 'Blog created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a Blog.');
        }

    }


    public function show($id)
    {
        $blog = Blog::find($id);
        if (is_null($blog)) {
            return $this->sendError('Blog does not exist.');
        }
        return $this->sendResponse(new BlogResource($blog), 'Blog fetched.');
    }


    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->featured_image = $input['featured_image'];
        $blog->save();

        return $this->sendResponse(new BlogResource($blog), 'Blog updated.');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return $this->sendResponse([], 'Blog deleted.');
    }
}
