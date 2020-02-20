<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Page extends JsonResource
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
            'title_en' => $this->title_en ,
            'body_en' => $this->body_en,
            'banner' => $this->banner,
            'slug' => $this->slug,
        ];
    }
}
