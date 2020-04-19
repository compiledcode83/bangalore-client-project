<?php

namespace App\Http\Controllers;

use App\Models\
{Setting, Subsidiarie
};
use Illuminate\Http\Request;

class AboutController extends Controller {

    public function getInformations()
    {
        $settings = Setting::find( 1 );
        $subsidiariesData = Subsidiarie::where( 'is_active', '!=', '0' )->get();
        $subsidiaries = [];
        foreach ($subsidiariesData as $subsidiary)
        {
            $subsidiaries [] = [
                'id'          => $subsidiary->id,
                'logo'        => $subsidiary->logo,
                'url'         => $subsidiary->url,
                'description' => $subsidiary->description
            ];
        }

        return [
            'about_img'         => $settings->about_img,
            'about_description' => $settings->about_description,
            'subsidiaries'      => $subsidiaries
        ];

    }
}
