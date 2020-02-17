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

                //Orders by month
                $totalOrders = $this->totalOrders( 1 );

                $ordersPie = view( 'admin.charts.pieOrders', ['dataset' => $totalOrders] );
                $row->column( 2 / 4, new Box( 'Total Orders', $ordersPie ) );

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

    public function totalOrders( $month )
    {
        $now = Carbon::now();

        $individualOrders= Order::with('user')
            ->whereHas('user', function($query){
                $query->where('type', User::TYPE_USER);
            })
            ->whereYear( 'created_at', $now->year )
            ->whereMonth( 'created_at', $month )
            ->count();

        $corporateOrders= Order::with('user')
            ->whereHas('user', function($query){
                $query->where('type', User::TYPE_CORPORATE);
            })
            ->whereYear( 'created_at', $now->year )
            ->whereMonth( 'created_at', $month )
            ->count();

        $dataset = [
            'individualsOrder' => $individualOrders,
            'corporatesOrder'  => $corporateOrders
        ];

        return $dataset;

    }
}
