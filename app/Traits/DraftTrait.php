<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait DraftTrait
{

    public function index()
    {
        $news =  $this->news->where('publish_status', 2)
            ->where('publish_date', '<', carbon::now()->format('Y-m-d H:i:s'))
            ->update(['publish_status' => 1]);
        return $news;
    }
}
