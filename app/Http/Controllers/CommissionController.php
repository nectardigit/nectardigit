<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\RidingRequest;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function __construct(RidingRequest $ridingRequest)
    {
        $this->ridingRequest = $ridingRequest;
    }
    protected function getRides($request)
    {
        $query = $this->ridingRequest->where('riding_status','complete');
        if ($request->keyword) {
            $keyword = $request->keyword;
            // $rider = User::where('name', 'LIKE', "%{$keyword}%")->pluck('id');
            $query = $query->where('rider_id',$keyword);
        }
        if ($request->city) {
            $city = $request->city;
            $query = $query->where('city_id',$city);
        }
        if ($request->from && $request->to) {
            $from = $request->from;
            $to = $request->to;
            $query = $query->whereBetween('completed_at',[$from.' 00:00:00', $to.' 23:59:59']);
        }
        if ($request->from) {
            $from = $request->from;
            $query = $query->whereBetween('completed_at',[$from.' 00:00:00', $from.' 23:59:59']);
        }
        if ($request->vehicleType) {
            $vehicleType = $request->vehicleType;
            $query = $query->where('vehicle_type_id', $vehicleType );
        }
        return $query->paginate(20);
    }

    public function monthlyCommission(Request $request){
        $data = $this->getRides($request);
        $vehicleType = VehicleType::where('status', 'active')->pluck('type', 'id');
        $cities = City::where('status', '1')->pluck('name', 'id');
        $driver = User::pluck('status', 'id');
        $temp = User::where('type', 'rider')->get();
        $riders = [];
        foreach ($temp as $value) {
            $riders[$value->id] = $value->mobile.' - '.$value->name;
        }
        $data = [
            'data' => $data,
            'riders' => $riders,
            'driver' => $driver,
            'temp' => $temp,
            'vehicleType' => $vehicleType,
            'cities' => $cities,
        ];
        return view('admin/commission/monthlycommisson')->with($data);
    }
    public function verifyBonus(Request $request){
        if($request->id){
            $ride = RidingRequest::findOrFail($request->id);
            if($ride->bonus_status)
            $ride->bonus_status = '0';
            else
            $ride->bonus_status = '1';

            $ride->save();
        }
        elseif($request->rider_id){
            RidingRequest::where('rider_id', $request->rider_id)->update(['bonus_status' => '1']);
        }
        return redirect()->back();
    }
    public function verifyCompanyIncome(Request $request){
        if($request->id){
            $ride = RidingRequest::findOrFail($request->id);
            if($ride->company_income_status)
            $ride->company_income_status = '0';
            else    
            $ride->company_income_status = '1';

            $ride->save();
        }
        elseif($request->rider_id){
            RidingRequest::where('rider_id', $request->rider_id)->update(['company_income_status' => '1']);
        }
        return redirect()->back();
    }

}
