<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Contact;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends BaseController
{

    public function index()
    {
        $contacts = Contact::all();
        return $this->sendResponse(ContactResource::collection($contacts), 'Contact fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        try {
            $contact = Contact::create($input);
            return $this->sendResponse(new ContactResource($contact), 'Contact created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a contact.');
        }

    }


    public function show($id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return $this->sendError('contact does not exist.');
        }
        return $this->sendResponse(new ContactResource($contact), 'Contact fetched.');
    }


    public function update(Request $request, $id)
    {

        $contact = Contact::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $contact->name = $input['name'];
        $contact->email = $input['email'];
        $contact->subject = $input['subject'];
        $contact->message = $input['message'];
        $contact->save();

        return $this->sendResponse(new ContactResource($contact), 'Contact updated.');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return $this->sendResponse([], 'Contact deleted.');
    }
}
