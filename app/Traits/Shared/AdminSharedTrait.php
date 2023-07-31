<?php

namespace App\Traits\Shared;

/**
 *
 */

trait AdminSharedTrait
{
    protected $frameworkType = [
        'laravel' => "Laravel",
        "PHP" => "PHP",
        "wordpress" => "Wordpress",
        "ci" => "CI",
    ];
    protected $website_available_content = [
        [
            'value' => "news",
            'title' => "News",
        ],
        [
            'value' => "blogs",
            'title' => "Blogs",
        ],
        [
            'value' => "slider",
            'title' => "Slider",
        ],
        [
            'value' => "information",
            'title' => "Information",
        ],
        [
            'value' => "features",
            'title' => "Features",
        ],
        [
            'value' => "faq",
            'title' => "Faqs",
        ],
        [
            'value' => "testimonial",
            'title' => "Testimonial",
        ],
        [
            'value' => "user",
            'title' => "User",
        ],
        [
            'value' => "reporter",
            'title' => "Reporter",
        ],
        [
            'value' => "advertisement",
            'title' => "Advertisement",
        ],
        [
            'value' => "environment",
            'title' => ".Env File",
        ],
        [
            'value' => "fetchtable",
            'title' => "Fetch Table",
        ],
        [
            'value' => "migrateOldDatabase",
            'title' => "Migrate Old DB",
        ],
        [
            'value' => "menu",
            'title' => "Menu",
        ],
        [
            'value' => "team",
            'title' => "Team",
        ],
        [
            'value' => 'video',
            'title' => 'Video',
        ],
        [
            'value' => 'subscriber',
            'title' => 'subscriber',
        ],
        [
            'value' => "mediaLibrary",
            'title' => "Media Library",
        ],
        [
            'value' => "horoscope",
            'title' => "horoscope",
        ],
        [
            'value' => 'career',
            'title' => 'Career',
        ],
        [
            'value' => 'application',
            'title' => 'Application',
        ]
    ];

    protected function websiteFormat()
    {
        return [
            'laravel' => "Laravel",
            "PHP" => "PHP",
            "wordpress" => "Wordpress",
            "ci" => "CI",
        ];
    }
    protected function resetAppsetting()
    {
        cache()->forget('sitesetting');
    }
}
