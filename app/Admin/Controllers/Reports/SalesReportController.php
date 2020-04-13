<?php

namespace App\Admin\Controllers\Reports;

use App\Models\Order;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SalesReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Sales Report';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);
        $grid->expandFilter();
        $grid->model()->where('final_status', 'delivered');
        $grid->model()->orderBy('id', 'desc');
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add date between filter
            $filter->between('created_at', 'Date')->date();

            // Add payment filter
            $filter->equal('payment_method', 'Payment Method')->radio([
                ''   => 'All',
                'cash'    => 'CASH',
                'knet'    => 'KNET',
                'visa'   => 'VISA & MASTER'
            ]);

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

        $grid->user()->type('Account Type')->display(function ($type) {
            if($type == '1')
            {
                return 'Individual';
            }
            return 'Corporate';
        });

        $grid->column('order_code', __('Order code'));
        $grid->column('final_status', __('Status'));
        $grid->column('address', __('Address'));
        $grid->column('total', __('Total'));
        $grid->column('total', __('Total'));
        $grid->column('payment_method', __('Payment Method'));

        $grid->disableActions();
        $grid->disableCreateButton();
        $grid->disableBatchActions();
        $grid->disableExport();
        return $grid;
    }
}
