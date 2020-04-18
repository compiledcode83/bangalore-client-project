<?php

namespace App\Http\Controllers\HomeSections;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller {

    public function homeSlides()
    {
        $slides = Slider::where( 'is_active', '1' )
            ->orderBy( 'order', 'asc' )
            ->get();

        $response = [];
        foreach ($slides as $slide)
        {
            $response[] = [
                'id'        => $slide->id,
                'link'      => $slide->link,
                'image'     => $slide->image,
                'title'     => $slide->title,
                'sub_title' => $slide->sub_title
            ];
        }

        return $response;
    }
}
