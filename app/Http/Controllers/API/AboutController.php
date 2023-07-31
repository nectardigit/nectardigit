<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Container;
use App\Http\Resources\About as AboutResource;

class AboutController extends BaseController
{

    public function index()
    {
          $abouts = Container::whereIn('type', ['mission_vision', 'customer_satisfy'])->get();
          return $this->sendResponse(AboutResource::collection($abouts), 'About us fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'icon' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $input['icon'] = $request->file('icon')->store('apiImage');
        $input['icon'] = asset($input['icon']);

        try {
            $about = Container::create($input);
            return $this->sendResponse(new AboutResource($about), 'About us created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create aboutus.');
        }

    }


    public function show($id)
    {
        $about = Container::find($id);
        if (is_null($about)) {
            return $this->sendError('About us does not exist.');
        }
        return $this->sendResponse(new AboutResource($about), 'About us fetched.');
    }


    public function update(Request $request, $id)
    {
        $about = Container::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'icon' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $about->title = $input['title'];
        $about->icon = $input['icon'];
        $about->description = $input['description'];

        $about->save();

        return $this->sendResponse(new AboutResource($about), 'About us updated.');
    }

    public function destroy($id)
    {
        $about = Container::find($id);
        $about->delete();
        return $this->sendResponse([], 'About us deleted.');
    }
}
