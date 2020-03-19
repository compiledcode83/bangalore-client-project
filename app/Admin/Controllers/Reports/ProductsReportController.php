<?php

namespace App\Admin\Controllers\Reports;

use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Products Report';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->expandFilter();
        $grid->model()->orderBy('id', 'desc');
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->equal( 'categories.id', 'Categories' )->select( function () {
                $categories = Category::all()->pluck(  'name_en', 'id' )->toArray();
                return array_map( 'ucfirst', $categories );
            } );
        });

        $grid->column('id', __('Id'));
        $grid->column('name_en', __('Name'));
        $grid->column('sku', __('Sku'));
        $grid->column('supplier_price', __('Supplier price'));
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label( [
                0 => 'danger',
                1 => 'success',
            ] );
        $grid->column('created_at', __('Created at'));

        return $grid;
    }
}
