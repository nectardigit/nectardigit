<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Menu;
use App\Http\Resources\Aboutus as AboutusResource;
   
class AboutusController extends BaseController
{

    public function index()
    { 
          $menus = Menu::where('slug', 'about')->get();
          return $this->sendResponse(AboutusResource::collection($menus), 'About us description fetched.');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'short_description' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        try {
            $aboutus = Menu::create($input);
            return $this->sendResponse(new AboutusResource($aboutus), 'About us description created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create aboutus description.');
        }
   
    }

   
    public function show($id)
    {
        $aboutus = Menu::find($id);
        if (is_null($aboutus)) {
            return $this->sendError('About us description does not exist.');
        }
        return $this->sendResponse(new AboutusResource($aboutus), 'About us description fetched.');
    }
    

    public function update(Request $request, $id)
    {
        $aboutus = Menu::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'short_description' => 'required',
            'description' => 'required',  
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $aboutus->short_description = $input['short_description'];
        $aboutus->description = $input['description'];
        $aboutus->save();
        
        return $this->sendResponse(new AboutusResource($aboutus), 'About us description updated.');
    }
   
    public function destroy($id)
    {
        $aboutus = Menu::find($id);
        $aboutus->delete();
        return $this->sendResponse([], 'About us description deleted.');
    }
}