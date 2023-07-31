<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\Coupon;
use App\Models\City;
use App\Models\VehicleType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function index(Request $request)
    {
        $data = $this->coupon
            ->orderBy('id','DESC')
            ->paginate(20);
        return view('admin/coupons/list', compact('data'));
    }

    public function create()
    {

        $vehicleType = VehicleType::pluck('type', 'id');
        $city = City::pluck('name', 'id');
        $coupon_info = null;
        $title = 'Add Coupon';

        return view('admin.coupons.form',compact('coupon_info','title','vehicleType','city'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'code' => 'required|string|min:3|max:20|unique:coupons',
            'publish_status' => 'required|numeric|in:1,0',

            'all_city' => 'required|numeric|in:1,0',
            'spent_amount' => 'nullable|numeric',
            'description' => 'required',
            'distance' => 'nullable|numeric',
            'coupon_type' => 'required',

            'vehicleType_id' => 'required|numeric',
            'flat_amount' => 'nullable|numeric',
            'percent' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|mimes:jpeg,jpg,svg,png',
            'city_id' => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);
        $data = [
            'title' => $request->title,
            'code' => Str::upper(preg_replace('/\s+/', '',$request->code)),
            'publish_status' => $request->publish_status,
            'vehicleType_id' => $request->vehicleType_id,
            'flat_amount' => $request->flat_amount,
            'percent' => $request->percent,
            'city_id' => $request->city_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'all_city' => $request->all_city,
            'spent_amount' => $request->spent_amount,
            'description' => $request->description,
            'coupon_type' => $request->coupon_type,
            
        ];
        $data['added_by'] = Auth::user()->id;
        if ($request->image) {
            $image_name = uploadFile($request->image, 'uploads/coupons/', false, time());
            if ($image_name) {
                $data['image'] = $image_name;
            }
        }
        try {
            $this->coupon->fill($data)->save();
            $request->session()->flash('success', 'Coupon created successfully.');
            return redirect()->route('coupon.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function edit(Request $request, $id)
    {
        $coupon_info = $this->coupon->find($id);
        if (!$coupon_info) {
            abort(404);
        }
        $title = 'Update Coupon';
        $vehicleType = VehicleType::pluck('type', 'id');
        $city = City::pluck('name', 'id');
        return view('admin.coupons.form', compact('coupon_info', 'title', 'vehicleType', 'city'));
    }
    public function update(Request $request, $id)
    {
        $coupon_info = $this->coupon->find($id);
        if (!$coupon_info) {
            abort(404);
        }
        $this->validate($request, [
            'title' => 'required|string|min:3|max:190',
            'code' => 'required|string|min:3|max:20',
            'publish_status' => 'required|numeric|in:1,0',
            'vehicleType_id' => 'required|numeric',
            'flat_amount' => 'nullable|numeric',
            'percent' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|mimes:jpeg,jpg,svg,png',
            'city_id' => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d|before:end_date',
            'end_date' => 'required|date|date_format:Y-m-d|after:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'all_city' => 'required|numeric|in:1,0',
            'spent_amount' => 'nullable|numeric',
            'description' => 'required',
            'distance' => 'nullable|numeric',
            'coupon_type' => 'required',
        ]);
        $data = [
            'title' => $request->title,
            'code' => Str::upper(preg_replace('/\s+/', '',$request->code)),
            'publish_status' => $request->publish_status,
            'vehicleType_id' => $request->vehicleType_id,
            'flat_amount' => $request->flat_amount,
            'percent' => $request->percent,
            'city_id' => $request->city_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'all_city' => $request->all_city,
            'spent_amount' => $request->spent_amount,
            'description' => $request->description,
            'coupon_type' => $request->coupon_type,
        ];
        $data['added_by'] = Auth::user()->id;
        if ($request->image) {
            $image_name = uploadFile($request->image, 'uploads/coupons/', false, time());
            if ($image_name) {
                $data['image'] = $image_name;
            }
        }
        try {
            $coupon_info->fill($data)->save();
            $request->session()->flash('success', 'Coupon updated successfully.');
            return redirect()->route('coupon.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    public function destroy(Request $request, $id)
    {
        $coupon_info = $this->coupon->find($id);
        if (!$coupon_info) {
            abort(404);
        }
        try {
            $coupon_info->delete();
            $request->session()->flash('success', 'Coupon deleted successfully.');
            return redirect()->route('coupon.index');
        } catch (\Exception $error) {
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
}
