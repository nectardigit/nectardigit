<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdImage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $adimage ;
    public $adTitle ; 
    public function __construct($adimage =null, $adtitle = null)
    {
        //
        // dd('sdfdsfsd');
         $this->adimage = $adimage;
         $this->adTitle = $adtitle ?? "Capital Nepal";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ad-image');
    }
}
