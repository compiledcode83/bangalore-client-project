<?php

namespace App\Admin\Controllers;

use Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller {

    public function index( Content $content )
    {
        return Admin::content( function ( Content $content ) {
            $content->header( 'Dashboard' );
            $content->description( 'Statistics ...' );

            $content->row( function ( $row ) {
                $row->column( 6, new InfoBox( 'Individuals', 'users', 'yellow', '/admin/users', User::where( 'type', User::TYPE_USER )->count() ) );
                $row->column( 6, new InfoBox( 'Corporates', 'users', 'yellow', '/admin/corporates', User::where( 'type', User::TYPE_CORPORATE )->count() ) );
            } );

            $content->row( function ( Row $row ) {

                //Sales by month
                $totalSales = $this->totalSales( 1 );

                $salesPie = view( 'admin.charts.pie', ['dataset' => $totalSales] );
                $row->column( 2 / 4, new Box( 'Total Sales', $salesPie ) );

                // event chart

//                $count_event_type = Event::where( 'type', Event::TYPE_EVENT )->get()->count();
//                $count_activity_type = Event::where( 'type', Event::TYPE_ACTIVITY )->get()->count();
//                $count_service_type = Event::where( 'type', Event::TYPE_SERVICE )->get()->count();
//                $events_count = [
//                    'events'   => $count_event_type,
//                    'activity' => $count_activity_type,
//                    'service'  => $count_service_type,
//
//                ];
//
//                $bar = view( 'admin.chartjs.bar', ['events_count' => $events_count] );
//                $row->column( 2 / 6, new Box( 'Events', $bar ) );

            } );

        } );
    }

    public function totalSales( $month )
    {
        $now = Carbon::now();

        $individualSales= Order::with('user')
                ->whereHas('user', function($query){
                    $query->where('type', User::TYPE_USER);
                })
                ->where('final_status','delivered')
                ->whereYear( 'created_at', $now->year )
                ->whereMonth( 'created_at', $month )
            ->sum('total');

        $corporateSales= Order::with('user')
            ->whereHas('user', function($query){
                $query->where('type', User::TYPE_CORPORATE);
            })
            ->where('final_status','delivered')
            ->whereYear( 'created_at', $now->year )
            ->whereMonth( 'created_at', $month )
            ->sum('total');

        $dataset = [
            'individuals' => $individualSales,
            'corporates'  => $corporateSales
        ];

        return $dataset;

    }
}
