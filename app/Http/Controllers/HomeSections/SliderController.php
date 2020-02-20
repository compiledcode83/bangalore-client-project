<?php

namespace App\Http\Controllers\HomeSections;

use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    public function homeSlides()
    {
        $slides = Slider::where('is_active', '1')
                        ->orderBy('order', 'asc')
                        ->get(['image', 'link', 'title', 'sub_title']);

        return $slides;
    }
}
