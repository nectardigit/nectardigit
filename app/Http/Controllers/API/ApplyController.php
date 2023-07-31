<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Application;
use App\Http\Resources\Apply as ApplyResource;

class ApplyController extends BaseController
{

    public function index()
    {
        $applys = Application::with('careers')->get();
        return $this->sendResponse(ApplyResource::collection($applys), 'Apply fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'description' => 'required',
            'documents' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $input['documents'] = $request->file('documents')->store('apiDocuments');


        try {

            $apply = Application::create($input);
        //    dd($apply);
            return $this->sendResponse(new ApplyResource($apply), 'Apply created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create apply.');
        }

    }


    public function show($id)
    {
        $apply = Application::find($id);
        if (is_null($apply)) {
            return $this->sendError('Apply does not exist.');
        }
        return $this->sendResponse(new ApplyResource($apply), 'Apply fetched.');
    }


    public function update(Request $request, $id)
    {

        $apply = Application::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'description' => 'required',
            'documents' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $apply->name = $input['name'];
        $apply->email = $input['email'];
        $apply->mobile = $input['mobile'];
        $apply->description = $input['description'];
        $apply->documents = $input['documents'];
        $apply->save();

        return $this->sendResponse(new ApplyResource($apply), 'Apply updated.');
    }

    public function destroy($id)
    {
        $apply = Application::find($id);
        $apply->delete();
        return $this->sendResponse([], 'Apply deleted.');
    }
}
