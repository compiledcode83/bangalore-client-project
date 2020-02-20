<?php

namespace App\Http\Controllers;

use App\Models\{Setting,MediaService};
use Illuminate\Http\Request;
use App\Http\Resources\Media as MediaResource;
use App\Http\Resources\Service as ServiceResource;

class MediaServiceController extends Controller
{
    public function getMedias()
    {
        $settings = Setting::find(1)->get( ['media_banner'] );
        $medias = MediaService::where([
                                    ['is_active', '=', '1'],
                                    ['type', '=', '1'],
                                ] )
                                ->get( ['title_en', 'id', 'short_description_en','image','created_at'] );

        return [
            'informations' => $settings,
            'medias' => MediaResource::collection($medias)
        ];

    }

    public function getServices()
    {
        $settings = Setting::find(1)->get( ['services_banner'] );
        $services = MediaService::where([
                                    ['is_active', '=', '1'],
                                    ['type', '=', '2'],
                                ] )
                                ->get( ['title_en', 'id', 'short_description_en','image'] );

        return [
            'informations' => $settings,
            'services' => ServiceResource::collection($services)
        ];

    }
}
