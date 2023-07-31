<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class IndexVideoSection extends Component
{
    public $readyToLoad = false;
    public $loadVideos  = false ;
    protected $listeners = ['pageLoaded' => 'getVideoNews'];
    public $videos;
    public $latest_video;
    public function loadHomepageVideos(){
        // $this->readyToLoad = true;
    }
    protected function getVideoNews()
    {


    //    $videos = Video::orderBy('created_at', 'desc')->take(7)->get();
        $this->loadVideos = true;
        // $this->latest_video = $videos ? $videos->first() : null;
        // $this->videos  = $videos ? $videos->skip(1) : null;

    }
    public function render()
    {
        return view('livewire.index-video-section');
    }
}
