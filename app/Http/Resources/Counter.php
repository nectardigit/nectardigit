<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Counter extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
     //   return parent::toArray($request);
     return [
        'id' => $this->id,
        'happy_client' => $this->happy_client['value'],
        'skil_export' => $this->skil_export['value'],
        'finesh_project' => $this->finesh_project['value'],
        'media_post' => $this->media_post['value'],

    ];

    }
}
