<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Apply extends JsonResource
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
      'name' => $this->name,
     'email' => $this->email,
     'mobile' => $this->mobile,
    'description' => $this->description,
    'documents' => $this->documents,
    'careerId' => $this->careers->title,


   ];

    }
}
