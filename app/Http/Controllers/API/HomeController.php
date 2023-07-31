<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Client;
use App\Models\Container;
use App\Models\Menu;
use App\Models\Application;
use App\Models\Blog;
use App\Models\Career;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Information;
use App\Models\Slider;
use App\Models\Counter;
use App\Models\Team;
use App\Http\Resources\Team as TeamResource;
use App\Http\Resources\Slider as SliderResource;
use App\Http\Resources\Service as ServiceResource;
use App\Http\Resources\Marketing as MarketingResource;
use App\Http\Resources\Faq as FaqResource;
use App\Http\Resources\Contact as ContactResource;
use App\Http\Resources\Career as CareerResource;
use App\Http\Resources\Blog as BlogResource;
use App\Http\Resources\Apply as ApplyResource;
use App\Http\Resources\Aboutus as AboutusResource;
use App\Http\Resources\About as AboutResource;
use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\Counter as CounterResource;




class HomeController extends BaseController
{

    public function index()
    {
        $clients = Client::all()->take(5);
        $blogs = Blog::with('user')->latest()->get()->take(5);
        $sliders = Slider::where('display_home','1')->get();
        $counters = Counter::all();
        $services = Information::all()->take(5);


        $data = [
            "services" => ServiceResource::collection($services),
            "clients" => ClientResource::collection($clients),
            "blogs" => BlogResource::collection($blogs),
            "sliders" => SliderResource::collection($sliders),
            "counters" => CounterResource::collection($counters),
        ];

        return response()->json([
            'status' => true,
            'status_code' => 200,
            "data" => $data,
            'message' => 'Data fetched successfully',
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
