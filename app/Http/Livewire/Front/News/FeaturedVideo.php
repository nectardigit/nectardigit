<?php

namespace App\Http\Livewire\Front\News;

use App\Models\Video;
use Livewire\Component;

class FeaturedVideo extends Component
{


    public $footerVideo;
    public $loadFooterVideo;
    protected $listeners = ['pageLoaded' => 'displayFeaturedVideo']; 
    public function displayFeaturedVideo(){
        // dd('hello from video livewire');
     $this->footerVideo =   Video::where([['publish_status', true], ['featured', true]])
     ->orderBy('created_at', 'desc')
     ->first();
     $this->loadFooterVideo = true; 
    }
    public function render()
    {
        return view('livewire.front.news.featured-video');
    }
}
