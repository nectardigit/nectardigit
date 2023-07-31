<?php

define('newsimagepath', '/news/');
define('profileimagepath', '/profile/');
define('sliderimagepath', '/slider/');
define('informationimagepath', '/information/');
define('featureimagepath', '/feature/');
define('blogimagepath', '/blog/');
define('testimonialimagepath', '/testimonial/');
define('teamImagePath', '/team/');

function uploadImageToTemp($image_file)
{

    if ($image_file) {
        $image_main_name = time() . '.' . strtolower($image_file->getClientOriginalExtension());
        $image_name = "main__" . $image_main_name;

        // Laravel Image upload and resize resolution  of image without cropping image
        $mainPath = public_path() . "/uploads/temp";
        if (!File::exists($mainPath)) {
            File::makeDirectory($mainPath, 0777, true, true);
        }
        $image = Image::make($image_file->getRealPath())
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio(); //to preserve the aspect ratio
                $constraint->upsize();
            })
            ->save($mainPath . '/' . $image_name);

        // dd($image_name);
        try {
            if ($image) {
                $image_path = asset('/uploads/temp/' . $image_name);
                return [
                    'status' => true,
                    'message' => 'Image uploaded ',
                    'path' => $image_path,
                    'image_main_name' => $image_main_name,
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message_is' => $e->getMessage(),
            ];
        }
    } else {
        return [
            'status' => false,
            'message' => 'Invalid access.',
        ];
    }
}

function saveBannerImage($data)
{
    $bannerImage = $data['bannerImage'];

    try {

        $success = Image::make($data['image'])
            ->crop($data['Imagewidth'], $data['Imageheight'], $data['ImageX'], $data['ImageY'])
        // ->text('hajurkokhabar', 0, 0, function ($font) {
        //     // $font->file('foo/bar.ttf');
        //     $font->size(1200);
        //     $font->color('#000');
        //     $font->align('center');
        //     $font->valign('top');
        //     $font->angle(45);
        // })
            ->save($bannerImage);
        return true;
    } catch (\Exception $error) {
        return false;
    }
}

function uploadCropImage($request)
{

    $image_name = $request->ImageName;
    $banner_image = "banner__" . $image_name;

    $storage_path = public_path() . "/uploads/temp/";
    if (!File::exists($storage_path)) {
        File::makeDirectory($storage_path, 0777, true, true);
    }
    $image = $storage_path . "main__" . $request->ImageName;

    $bannerImage = $storage_path . $banner_image;
    $data = [
        'image' => $image,
        'bannerImage' => $bannerImage,
        'Imagewidth' => $request->Imagewidth,
        'Imageheight' => $request->Imageheight,
        'ImageX' => $request->ImageX,
        'ImageY' => $request->ImageY,
    ];

    $success = saveBannerImage($data);
    if ($success) {
        $thumbnail_image = $storage_path . "/thumbnail__" . $image_name;
        Image::make($bannerImage)->resize(240, null, function ($constraint) {
            $constraint->aspectRatio(); //to preserve the aspect ratio
            $constraint->upsize();
        })->save($thumbnail_image);
        $midium_image = $storage_path . "/medium__" . $image_name;
        Image::make($bannerImage)->resize(800, null, function ($constraint) {
            $constraint->aspectRatio(); //to preserve the aspect ratio
            $constraint->upsize();
        })->save($midium_image);

        $feature_image = $storage_path . "/feature__" . $image_name;
        Image::make($bannerImage)->resize(480, null, function ($constraint) {
            $constraint->aspectRatio(); //to preserve the aspect ratio
            $constraint->upsize();
        })->save($feature_image);

        return [
            'status' => true,
            'message' => 'Image Uploaded Successfully',
            'image' => $image_name,
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Image could not Uploaded Successfully',
            'image' => null,
        ];
    }
}

function galleryImage($image, $id = null, $path = null)
{

    $thumbnail = asset('assets/admin/images/default.png');
    $imagePath = '/uploads/gallery/';

    $imageName = "main__" . $image;

    if ($id) {

        $imagePath = $imagePath . $id . '/';

        $imageName = $image;
        //    dd(public_path().$imagePath.$imageName);
    } else {
        $imageName = '/banner__' . $image;
    }

    if (isset($imageName) && !empty($imageName) && file_exists(public_path() . $imagePath . $imageName)) {
        $thumbnail = asset($imagePath . $imageName);
    }

    return $thumbnail;
}

function getImageUrl($image, $path)
{
    $thumbnail = asset('assets/image_upload/default.png');
    // dd($image);
    $imagePath = '/uploads/' . $path . '/banner__' . $image;
    // dd($imagePath);
    if (isset($image) && !empty($image) && file_exists(public_path() . $imagePath)) {
        $thumbnail = asset($imagePath);
    }
    return $thumbnail;
}
function getUniversityAuthUserImage($authorityInfo, $type)
{
    $thumbnail = asset('/assets/front/images\edulogo_for_ourteam.jpg');
    if ($type == 'authorizedUser') {
        $image = @$authorityInfo->authorities['authorized_person']['image'];
    } else if ($type == 'authorizedCertificate') {
        $image = @$authorityInfo->authorities['certification']['authorized_letter'];
    } else if ($type == 'membershipCertificate') {
        $image = @$authorityInfo->authorities['certification']['membership_certificate'];
    }

    $imagePath = "/uploads/university/" . $authorityInfo->id . '/authorized/' . $image;
    // dd($imagePath);

    if (isset($image) && !empty($image) && file_exists(public_path() . $imagePath)) {
        $thumbnail = asset($imagePath);
    }
    return $thumbnail;
}

function GetImage($image, $path)
{

    $thumbnail = asset('assets/admin/images/default.png');
    $imagePath = '/uploads/' . $path . '/banner__' . $image;
    if (isset($image) && !empty($image) && file_exists(public_path() . $imagePath)) {
        $thumbnail = asset($imagePath);
    }
    return $thumbnail;
}

function UserImage($image)
{

    $thumbnail = asset('assets/admin/images/profile.png');
    if (isset($image) && !empty($image) && file_exists(public_path() . '/uploads/users/feature__' . $image)) {
        $thumbnail = asset('/uploads/users/feature__' . $image);
    }
    return $thumbnail;
}
function staffImage($image)
{

    $thumbnail = asset('assets/admin/images/profile.png');
    if (isset($image) && !empty($image) && file_exists(public_path() . '/uploads/system-user/feature__' . $image)) {
        $thumbnail = asset('/uploads/system-user/feature__' . $image);
    }
    return $thumbnail;
}

function myprofileImage()
{
    $thumbnail = asset('assets/admin/images/profile.png');
    // dd(auth()->user()->userProfile);
    $image = @auth()->user()->adminProfile->image;
    if (isset($image) && !empty($image) && file_exists(public_path() . '/uploads/users/feature__' . $image)) {
        $thumbnail = asset('/uploads/users/feature__' . $image);
    }
    return $thumbnail;
}

function PostImage($image)
{

    $thumbnail = asset('assets/admin/images/default.png');
    if (isset($image) && !empty($image) && file_exists(public_path() . '/uploads/posts/banner__' . $image)) {
        $thumbnail = asset('/uploads/posts/banner__' . $image);
    }
    return $thumbnail;
}

function updateUniversityFile($file, $slug, $path)
{
    $file_name = $slug . '-' . date('Y-m-d') . '-' . rand(1000, 1099) . '.' . strtolower($file->getClientOriginalExtension());

    $storage_path = public_path() . "/uploads/university/" . $path;
    // if ($path) {
    //     $storage_path = public_path() . "/uploads/" . $path;
    // }
    if (!File::exists($storage_path)) {
        File::makeDirectory($storage_path, 0777, true, true);
    }
    @set_time_limit(0);
    $success = $file->move($storage_path, $file_name);
    if ($success) {
        return $file_name;
    } else {
        return null;
    }
}

function getUniversityFile($file,   $path)
{
    $thumbnail =asset('/assets/front/images/edulogo_for_ourteam.jpg');
    $filepath = public_path() . "/uploads/university/" . $path.$file;
    $url = asset('/uploads/university/' . $path.$file);
    if (isset($file) && !empty($file) && file_exists($filepath)) {
        $thumbnail = $url;
    }
    return $thumbnail;
}

function fileUpload($file, $slug, $path = null)
{
    $file_name = $slug . '-' . date('Y-m-d') . '-' . rand(1000, 1099) . '.' . strtolower($file->getClientOriginalExtension());

    $storage_path = public_path() . "/uploads/documents";
    if ($path) {
        $storage_path = public_path() . "/uploads/" . $path;
    }
    if (!File::exists($storage_path)) {
        File::makeDirectory($storage_path, 0777, true, true);
    }
    @set_time_limit(0);
    $success = $file->move($storage_path, $file_name);
    if ($success) {
        return $file_name;
    } else {
        return null;
    }
}

function moveImage($image_name, $path)
{
    $old_path = public_path() . '/uploads/temp/';
    $new_path = public_path() . '/uploads/' . $path . '/';
    if (!File::exists($new_path)) {
        File::makeDirectory($new_path, 0777, true, true);
    }
    $preName = [
        [
            'oldPath' => $old_path . 'main__' . $image_name,
            'newPath' => $new_path . 'main__' . $image_name,
        ],
        [
            'oldPath' => $old_path . 'banner__' . $image_name,
            'newPath' => $new_path . 'banner__' . $image_name,
        ],
        [
            'oldPath' => $old_path . 'feature__' . $image_name,
            'newPath' => $new_path . 'feature__' . $image_name,
        ],
        [
            'oldPath' => $old_path . 'thumbnail__' . $image_name,
            'newPath' => $new_path . 'thumbnail__' . $image_name,
        ],
        [
            'oldPath' => $old_path . 'medium__' . $image_name,
            'newPath' => $new_path . 'medium__' . $image_name,
        ],

    ];
    foreach ($preName as $imagePath) {
        if ($imagePath['oldPath'] && file_exists($imagePath['oldPath'])) {
            File::move($imagePath['oldPath'], $imagePath['newPath']);
        }
    }
}

function removeRelatedImage($image, $path)
{
    $mainImage = public_path('/uploads/' . $path . '/' . $image);
    if ((file_exists($mainImage))) {
        unlink($mainImage);
    }
}

function removeImage($image, $path)
{
    $mainImage = public_path('/uploads/' . $path . '/main__' . $image);
    $thumbnailImage = public_path('/uploads/' . $path . '/thumbnail__' . $image);
    $bannerImage = public_path('/uploads/' . $path . '/banner__' . $image);
    $featureImage = public_path('/uploads/' . $path . '/feature__' . $image);
    $mideumImage = public_path('/uploads/' . $path . '/medium__' . $image);

    if ((file_exists($mainImage))) {
        unlink($mainImage);
    }
    if ((file_exists($thumbnailImage))) {
        unlink($thumbnailImage);
    }
    if ((file_exists($bannerImage))) {
        unlink($bannerImage);
    }
    if ((file_exists($featureImage))) {
        unlink($featureImage);
    }
    if ((file_exists($mideumImage))) {
        unlink($mideumImage);
    }
}

function removeFile($file, $path)
{
    $filepath = public_path('/uploads/' . $path . '/' . $file);
    if ((file_exists($filepath))) {
        unlink($filepath);
    }
}

function uploadImage($image_file, $image_name)
{
    $mainPath = public_path() . "/uploads/gallery";
    if (!File::exists($mainPath)) {
        File::makeDirectory($mainPath, 0777, true, true);
    }
    try {
        $image = Image::make($image_file->getRealPath())->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio(); //to preserve the aspect ratio
            $constraint->upsize();
        })->save($mainPath . '/' . $image_name);
        if ($image) {
            return ['image_path' => asset($mainPath . '/' . $image_name)];
        }
    } catch (\Exception $e) {
        return $message = $e->getMessage();
    }
}
