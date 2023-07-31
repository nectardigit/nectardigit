<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Team;
use App\Http\Resources\Team as TeamResource;

class TeamController extends BaseController
{

    public function index()
    {
        $teams = Team::with('designation')->where('publish_status','1')->get();
        return $this->sendResponse(TeamResource::collection($teams), 'Team fetched.');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'full_name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'title' => 'required'

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $input['image'] = $request->file('image')->store('apiImage');


        try {
            $team = Team::create($input);
            return $this->sendResponse(new TeamResource($team), 'Team created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a team.');
        }

    }


    public function show($id)
    {
        $team = Team::find($id);
        if (is_null($team)) {
            return $this->sendError('Team does not exist.');
        }
        return $this->sendResponse(new TeamResource($team), 'Team fetched.');
    }


    public function update(Request $request, $id)
    {
        $team = Team::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'full_name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'title' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        $team->full_name = $input['full_name'];
        $team->image = $input['image'];
        $team->description = $input['description'];
        $team->designation->title = $input['title'];
        $team->save();

        return $this->sendResponse(new TeamResource($team), 'Team updated.');
    }

    public function destroy($id)
    {
        $team = Team::find($id);
        $team->delete();
        return $this->sendResponse([], 'Team deleted.');
    }
}
