<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Information;
use App\Http\Resources\Service as ServiceResource;

class ServiceController extends BaseController
{

    public function index()
    {
        $services = Information::all();
        return $this->sendResponse(ServiceResource::collection($services), 'Service fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['image'] = $request->file('image')->store('apiImage');
        $input['image'] = asset($input['image']);

        try {
            $service = Information::create($input);
            return $this->sendResponse(new ServiceResource($service), 'Service created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a service.');
        }

    }


    public function show($id)
    {
        $service = Information::find($id);
        if (is_null($service)) {
            return $this->sendError('Service does not exist.');
        }
        return $this->sendResponse(new ServiceResource($service), 'Service fetched.');
    }


    public function update(Request $request, Information $service)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $service->title = $input['title'];
        $service->description = $input['description'];
        $service->image = $input['image'];
        $service->save();

        return $this->sendResponse(new ServiceResource($service), 'Service updated.');
    }

    public function destroy(Information $service)
    {
        $service->delete();
        return $this->sendResponse([], 'Service deleted.');
    }
}
