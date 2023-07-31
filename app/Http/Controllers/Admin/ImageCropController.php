<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageCropController extends Controller
{
    public function ajaxImageUpload(Request $request)
    {
        $uploadImage = uploadImageToTemp($request->image);
        return response()->json($uploadImage);
    }

    public function uploadCropImage(Request $request)
    {
        $cropimages = uploadCropImage($request);
        return response()->json($cropimages);
    }
}
