<?php

namespace App\Http\Controllers;

use App\Models\{Setting,Subsidiarie};
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function getInformations()
    {
        $settings = Setting::find(1)->get( ['about_img','about_description_en'] );
        $subsidiaries = Subsidiarie::where( 'is_active', '!=', '0' )
        ->get( ['description_en', 'id', 'logo','url'] );

        return [
            'informations'  => $settings,
            'subsidiaries'  => $subsidiaries
        ];

    }
}
