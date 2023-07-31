<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Slider;
use App\Http\Resources\Slider as SliderResource;
   
class SliderController extends BaseController
{

    public function index()
    {
        $sliders = Slider::where('display_home','1')->get(); 
        return $this->sendResponse(SliderResource::collection($sliders), 'Slider fetched.');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'sub_title' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $input['image'] = $request->file('image')->store('apiImage');
        $input['image'] = asset($input['image']);

        try {
            $slider = Slider::create($input);
            return $this->sendResponse(new SliderResource($slider), 'Slider created.');
        } catch (\Throwable $th) {
            return $this->sendError('Can not create a slider.');
        }
   
    }

   
    public function show($id)
    {
        $slider = Slider::find($id);
        if (is_null($slider)) {
            return $this->sendError('Slider does not exist.');
        }
        return $this->sendResponse(new SliderResource($slider), 'Slider fetched.');
    }
    

    public function update(Request $request, Slider $slider)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'sub_title' => 'required',
            'image' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $slider->title = $input['title'];
        $slider->sub_title = $input['sub_title'];
        $slider->image = $input['image'];
        $slider->save();

        return $this->sendResponse(new SliderResource($slider), 'Slider updated.');
    }
   
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return $this->sendResponse([], 'Slider deleted.');
    }
}