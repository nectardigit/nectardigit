<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Blog extends JsonResource
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
        'title' => html_entity_decode($this->title),
        'slug' => $this->slug,
        'description' => $this->description,
        'featured_image' => $this->featured_image,
        'date' => date('F j, Y', strtotime($this->created_at)),
        'author' => $this->user->name['en'],
    ];

    }
}
