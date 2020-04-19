<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\
{Setting, MediaService
};
use Illuminate\Http\Request;
use App\Http\Resources\Media as MediaResource;
use App\Http\Resources\Service as ServiceResource;

class MediaServiceController extends Controller {

    public function getMedias()
    {
        $settings = Setting::find( 1 );
        $mediaItems = MediaService::where( [['is_active', '=', '1'], ['type', '=', '1']] )->get();

        $mediaData = [];
        foreach ($mediaItems as $item)
        {
            $mediaData [] = [
                'id'                => $item->id,
                'title'             => $item->logo,
                'short_description' => $item->short_description,
                'image'             => $item->image,
                'date'              => date( "d M Y", strtotime( $item->created_at ) ),
            ];
        }

        $mediaData = $this->paginate( $mediaData, $perPage = 6, $page = null, $options = [] );

        return [
            'media_banner' => $settings->media_banner,
            'mediaItems'   => $mediaData
        ];

    }

    public function getMediaDetails( $id )
    {
        $settings = Setting::find( 1 );
        $mediaItem = MediaService::find( $id );

        $mediaItem = [
            'id'                => $mediaItem->id,
            'title'             => $mediaItem->title,
            'short_description' => $mediaItem->short_description,
            'full_description'  => $mediaItem->full_description,
            'image'             => $mediaItem->image,
            'date'              => date( "d M Y", strtotime( $mediaItem->created_at ) ),
        ];

        return [
            'media_banner' => $settings->media_banner,
            'mediaItems'        => $mediaItem
        ];
    }

    public function getServices()
    {
        $settings = Setting::find( 1 );
        $servicesData = MediaService::where( [['is_active', '=', '1'], ['type', '=', '2']] )->get();

        $services = [];
        foreach ($servicesData as $service)
        {
            $services [] = [
                'id'                => $service->id,
                'title'             => $service->title,
                'short_description' => $service->short_description,
                'image'             => $service->image
            ];
        }

        $services = $this->paginate( $services, $perPage = 5, $page = null, $options = [] );

        return [
            'services_banner' => $settings->services_banner,
            'services'        => $services
        ];

    }

    public function getServicesDetails( $id )
    {
        $settings = Setting::find( 1 );
        $service = MediaService::find( $id );

        $services = [
            'id'                => $service->id,
            'title'             => $service->title,
            'short_description' => $service->short_description,
            'full_description'  => $service->full_description,
            'image'             => $service->image
        ];

        return [
            'services_banner' => $settings->services_banner,
            'services'        => $services
        ];
    }

    /**
     * Gera a paginação dos itens de um array ou collection.
     *
     * @param array|Collection $items
     * @param int              $perPage
     * @param int              $page
     * @param array            $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate( $items, $perPage = 5, $page = null, $options = [] )
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make( $items );


        return new LengthAwarePaginator( $items->forPage( $page, $perPage ), $items->count(), $perPage, $page, $options );
    }
}
