<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Client;
use App\Http\Resources\Client as ClientResource;


class ClientController extends BaseController
{

    public function index()
    {
        $clients = Client::paginate(10);

        return response()->json([
            'status' => true,
            'status_code' => 200,
            "data" => mapPageItems(ClientResource::collection($clients), 'client'),
            'message' => 'Clients fetched successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'logo' => 'required',
            'image' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }
        $input['logo'] = $request->file('logo')->store('apilogo');
        $input['logo'] = asset($input['logo']);
        $input['image'] = $request->file('image')->store('apiImage');
        $input['image'] = asset($input['image']);

        try {
            $client = Client::create($input);
            return $this->sendResponse(new ClientResource($client), 'Client created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a client.');
        }

    }


    public function show($id)
    {
        $client = Client::find($id);
        if (is_null($client)) {
            return $this->sendError('Client does not exist.');
        }
        return $this->sendResponse(new ClientResource($client), 'Client fetched.');
    }


    public function update(Request $request, Client $client)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'logo' => 'required',
            'image' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $client->title = $input['title'];
        $client->logo = $input['logo'];
        $client->image = $input['image'];

        $client->save();

        return $this->sendResponse(new ClientResource($client), 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return $this->sendResponse([], 'Client deleted.');
    }
}
