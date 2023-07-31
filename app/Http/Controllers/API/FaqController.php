<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Faq;
use App\Http\Resources\Faq as FaqResource;

class FaqController extends BaseController
{

    public function index()
    {
        $faqs = Faq::all();
        return $this->sendResponse(FaqResource::collection($faqs), 'Faq fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        try {
            $faq = Faq::create($input);
       //     dd($faq);
            return $this->sendResponse(new FaqResource($faq), 'Faq created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a Faq.');
        }

    }


    public function show($id)
    {
        $faq = Faq::find($id);
        if (is_null($faq)) {
            return $this->sendError('Faq does not exist.');
        }
        return $this->sendResponse(new FaqResource($faq), 'Faq fetched.');
    }


    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $faq->title = $input['title'];
        $faq->description = $input['description'];
        $faq->save();

        return $this->sendResponse(new FaqResource($faq), 'Faq updated.');
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();
        return $this->sendResponse([], 'Faq deleted.');
    }
}
