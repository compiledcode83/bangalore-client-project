<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

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
