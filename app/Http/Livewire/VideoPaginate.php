<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\WithPagination;
use Livewire\Component;


class VideoPaginate extends Component
{
    use WithPagination;

    public $videoId;

    public function videos()
    {
        $this->videos = Video::paginate(10);
        if ($this->videos) {
            // dd($this->videos);
            $this->readyToLoad = true;
        }
    }
    // public function render()
    // {
    //     $this->videos = Video::paginate(10);

    //     if($this->videos){
    //         // dd($this->videos);
    //         $this->readyToLoad = true;
    //         // dd(  $this->videos);
    //         $videos =   $this->videos;
    //         return view('', compact('videos'));
    //     }
    // }
    public function render()
    {
        return view('livewire.video-paginate', [
            'videos' => Video::whereNotIn('id', $this->videoId)->orderBy('created_at', 'desc')->paginate(6)->count() ? Video::whereNotIn('id', $this->videoId)->orderBy('created_at', 'desc')->paginate(6) : null,
        ]);
    }
}
