<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Media extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title_en' => $this->title_en ,
            'short_description_en' => $this->short_description_en,
            'image' => $this->image,
            'date' => date("d M Y",strtotime($this->created_at)),
        ];
    }
}
