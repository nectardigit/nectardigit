<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Aboutus extends JsonResource
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
        'short_description' => html_entity_decode($this->short_description['en']),
        'description' => html_entity_decode($this->description['en']),
    ];
    }
}
