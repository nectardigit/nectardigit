<?php

namespace App\Http\Controllers;

use App\Http\Requests\CareerApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Career;
use Illuminate\Support\Facades\Mail;
use App\Mail\CareerVerification;
use App\Models\AppSetting;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class CareerController extends Controller
{
    public function careerAdd(CareerApplicationRequest $request, $slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        $data = $request->validated();
        $data['careerId'] = $career->id;

        try {
            if ($request->file()) {
                $fileName = time() . '_' . $request->documents->getClientOriginalName();
                $filePath = $request->file('documents')->storeAs('applications', $fileName, 'public');
                $data['documents'] = $fileName;
            }
            $application =  Application::create($data);
            Mail::to($application->email)
                ->send(new CareerVerification($application->name, $application->verificationCode));
            request()->session()->flash('success', 'Successfully Applied, Please Verify your Email');
            return redirect()->back();
        } catch (\Throwable $th) {
            request()->session()->flash('error', 'Your request cannot be submitted at the moment . please try again later');
            return redirect()->back();
        }
    }

    public function careerDetails($slug)
    {
        $career = Career::where('slug', $slug)
            ->whereDate('deadLine', '>=', today())
            ->where('publish_status', 1)
            ->firstorfail();
        $meta = $this->getMetaData($career);
        // dd($career);
        $banner_img = Menu::where('slug', 'career')->pluck('parallex_img')->first();

        $data = [
            'career' => $career,
            'meta' => $meta,
            'banner_img' => $banner_img,
        ];

        // return
        return view('website.careerdetails', $data);
    }

    public function careerVerification($verificationCode)
    {
        $application = Application::where('verificationCode', $verificationCode)->firstorfail();
        $application->verifyCareer();
        return redirect()->route('index');
    }
    protected function getMetaData($data = null)
    {
        // dd($data);
        $website = AppSetting::select('*')->orderBy('created_at', 'desc')->first();
        // dd($website);
        $image = null;
        if (isset($data->features)) {
            // dd('ss');
            $image = $data->features;
            // dd($image);
        }
        if (isset($data->image) && validate_url($data->image)) {
            // dd('ss');
            $image = $data->image;
        }
        if (isset($data->featured_image) && validate_url($data->featured_image)) {
            $image = $data->featured_image;
        }
        if (isset($data->featured_img)) {
            $image = env('APP_URL') . '/uploads/' . $data->featured_img_path . $data->featured_img;
        }
        // dd(create_image_url($image, 'same'));
        $meta = [
            'meta_title' => @$data->meta_title ?? $website->meta_title ?? 'nectar-digit',
            'meta_keyword' =>  @$data->meta_keyword ?? $website->meta_keyword ?? 'nectar-keyword',
            'meta_description' =>  @$data->meta_description ?? $website->meta_description ?? 'nectar-description',
            'meta_keyphrase' => @$data->meta->keyphrase ?? $website->meta_keyphrase ?? 'nectar-keyphrase',
            'og_image' => create_image_url($image, 'same') ?? $image ?? create_image_url($website->logo_url, 'banner') ?? env('APP_URL') . '/images/logo.png',
            'og_url' => route('index'),
            'og_site_name' => $website->name,
        ];
        // dd($meta);
        return $meta;
    }
}
