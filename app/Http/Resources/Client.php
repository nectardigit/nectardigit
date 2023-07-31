<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Client extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);

      return [
        'id' => $this->id,
        'title' => $this->title,
        'logo' => $this->logo,
        'image' => $this->image,
        'develop_by' => $this->develop_by,
        'clients_name' => $this->client_name,
        'date' => date('F j, Y', strtotime($this->created_at)),


    ];

    }
}
