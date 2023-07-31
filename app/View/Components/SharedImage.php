<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SharedImage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $newsimage ; 
    public $title;
    public function __construct($newsimage, $title =null )
    {
        //
        // dd($newsimage);
        $this->newsimage = $newsimage;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.shared-image');
    }
}
