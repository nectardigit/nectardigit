<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Menu;
use App\Http\Resources\Marketing as MarketingResource;
   
class MarketingController extends BaseController
{

    public function index()
    {
        $marketings = Menu::where('parent_id', 10)->get();
        return $this->sendResponse(MarketingResource::collection($marketings), 'Marketing fetched.');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        try {
            $marketing = Menu::create($input);
            return $this->sendResponse(new MarketingResource($marketing), 'Marketing created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a marketing.');
        }
   
    }

   
    public function show($id)
    {
        $marketing = Menu::find($id);
        if (is_null($marketing)) {
            return $this->sendError('Marketing does not exist.');
        }
        return $this->sendResponse(new MarketingResource($marketing), 'Marketing fetched.');
    }
    

    public function update(Request $request, $id)
    {
        $marketing = Menu::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $marketing->title = $input['title'];
        $marketing->description = $input['description'];
        $marketing->save();
        
        return $this->sendResponse(new MarketingResource($marketing), 'Marketing updated.');
    }
   
    public function destroy($id)
    {
        $marketing = Menu::find($id);
        $marketing->delete();
        return $this->sendResponse([], 'Marketing deleted.');
    }
}