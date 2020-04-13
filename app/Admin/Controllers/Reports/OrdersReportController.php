<?php

namespace App\Admin\Controllers\Reports;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrdersReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Orders Report';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->expandFilter();
        $grid->model()->orderBy('id', 'desc');
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add date between filter
            $filter->between('created_at', 'Date')->date();

            $filter->equal( 'final_status', 'Status' )->select( function () {
                $finalStatus = Order::groupBy( 'final_status' )->pluck( 'final_status' )->toArray();
                //copy values to keys
                $statusFilter = array_combine( $finalStatus, $finalStatus );

                return array_map( 'ucfirst', $statusFilter );
            } );

            // Add User filter
            $filter->where(function ($query) {
                switch ($this->input) {
                    case 'individual':
                        // custom complex query if the 'yes' option is selected
                        $query->whereHas('user', function ($query) {
                            $query->where('type', '1');
                        });
                        break;
                    case 'corporate':
                        $query->whereHas('user', function ($query) {
                            $query->where('type', '2');
                        });
                }
            }, 'Account Type', 'accounts')->radio([
                '' => 'All',
                'individual' => 'Only Individual',
                'corporate' => 'Only corporate',
            ]);
        });

        $grid->column('id', __('Id'));
        $grid->user()->type('Account Name')->display(function ($ttype) {
            if($ttype == '1')
            {
                return $this->user->first_name . ' ' . $this->user->last_name;
            }
            return $this->user->company;
        });
        $grid->column('order_code', __('Order code'));
        $grid->column('final_status', __('Final status'));
        $grid->column('address', __('Address'));
        $grid->column('total', __('Total'));
        $grid->column('payment_method', __('Payment method'));
        $grid->column('created_at', __('Created at'));

        $grid->disableActions();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        return $grid;
    }
}
