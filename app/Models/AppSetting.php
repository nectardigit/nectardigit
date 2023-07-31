<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'name',
    //     'address',
    //     'email',
    //     'phone',
    //     'is_favicon',
    //     'twitter',
    //     'facebook',
    //     'youtube',
    //     'otp_expire',
    //     'from_time',
    //     'commission',
    //     'to_time',
    //     'driver_app_url',
    //     'customer_app_url',
    //     'is_meta',
    //     'vat',
    //     'vat_discount_status',
    //     'vat_status',
    //     'meta_title',
    //     'meta_key',
    //     'meta_key',
    //     'driver_app_image',
    //     'customer_app_image',
    //     'meta_desc',
    //     'logo',
    //     'favicon',
    //     'og_image',
    //     "from_time",
    //     "to_time",
    //     'front_feature_description',
    //     'front_counter_description',
    //     'front_testimonial_description',
    //     "contact_no"
    // ];

    protected $fillable = [
        'name',
        'address',
        'map_url',
        'embedded_url',
        'email',
        'phone',
        'is_favicon',
        'app_url',
        "website_content_format",
        "website_content_item",
        'app_image',
        'twitter',
        'front_feature_description',
        'front_counter_description',
        'front_testimonial_description',
        'facebook',
        'youtube',
        'is_meta',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_keyphrase',
        'logo',
        'favicon',
        'og_image',
        'registration_date',
        'registration_number',
        // 'banner_news',
        'is_startup_ad',
        // 'startup_ad_number',

        'logo_path',
        'logo_extension',
        'logo_name',
        'logo_url',
        'folder_path',
        'thumbnail',
        "linkedIn",
        "instagram",
        "advertisement_detail"

    ];
    protected $casts = [
        'phone' => 'json',
        "website_content_item" => "json"
    ];
}
