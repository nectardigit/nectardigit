<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Career;
use App\Http\Resources\Career as CareerResource;

class CareerController extends BaseController
{

    public function index()
    {
        $careers = Career::all();
        return $this->sendResponse(CareerResource::collection($careers), 'Career fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'experience' => 'required',
            'slug' => 'required',
            ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        try {
            $career = Career::create($input);
            return $this->sendResponse(new CareerResource($career), 'Career created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create career.');
        }

    }


    public function show($id)
    {
        $career = Career::find($id);
        if (is_null($career)) {
            return $this->sendError('Career does not exist.');
        }
        return $this->sendResponse(new CareerResource($career), 'Career fetched.');
    }


    public function update(Request $request, $id)
    {
        $career = Career::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'experience' => 'required',
            'slug' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $career->title = $input['title'];
        $career->description = $input['description'];
        $career->experience = $input['experience'];
        $career->save();

        return $this->sendResponse(new CareerResource($career), 'Career updated.');
    }

    public function destroy($id)
    {
        $career = Career::find($id);
        $career->delete();
        return $this->sendResponse([], 'Career deleted.');
    }
}
