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
        $media_banner = Setting::find( 1 )->get( ['media_banner'] );
        $medias = MediaService::where( [['is_active', '=', '1'], ['type', '=', '1']] )->get();

//                                ->get( ['title_en', 'id', 'short_description_en','image','created_at'] );

        return [
            'media_banner' => $media_banner,
            'medias'       => MediaResource::collection( $medias )
        ];

    }

    public function getServices()
    {
        $settings = Setting::find( 1 );
        $servicesData = MediaService::where( [['is_active', '=', '1'], ['type', '=', '2']] )->get();
//                                ->get( ['title_en', 'id', 'short_description_en','image'] );

//        $services = $servicesData->getCollection();
        foreach ($servicesData as $service)
        {
            $services [] = [
                'id'                => $service->id,
                'title'             => $service->logo,
                'short_description' => $service->short_description,
                'image'             => $service->image
            ];
        }

        $serviceszz =  $this->paginate($services, $perPage = 5, $page = null, $options = []);
//        $servicesData->deleteCollection();
//        $servicesData->setCollection($services);

        return [
            'services_banner' => $settings->services_banner,
            'services'        => $serviceszz
        ];

    }

    public function getServicesDetails( $id )
    {
        $settings = Setting::find( 1 );
        $service = MediaService::find( $id );

        $services = [
            'id'                => $service->id,
            'title'             => $service->logo,
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
     * @param array|Collection      $items
     * @param int   $perPage
     * @param int  $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);


        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
