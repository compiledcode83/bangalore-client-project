<?php

namespace App\Admin\Controllers\Reports;

use App\models\Order;
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

                $query->where('user_id', 'like', "%{$this->input}%")
                    ->orWhere('user_id', 'like', "%{$this->input}%");

            }, 'Text');
//            $filter->equal('user_id', 'Account Type')->radio([
//                ''   => 'All',
//                ['1', '2']    => 'Individual',
//                '1'    => 'Corporate'
//            ]);

//            $filter->user_id()->where(function ($query) {
//                switch ($this->input) {
//                    case 'Individual':
//                        // custom complex query if the 'yes' option is selected
//                        $query->has('user', funnction(){
//
//                        });
//                        break;
//                    case 'Corporate':
//                        $query->doesntHave('user');
//                        break;
//                }
//            }, 'User Types', 'name_for_url_shortcut')->radio([
//                '' => 'All',
//                'Individual' => 'Only with relationship',
//                'Corporate' => 'Only without relationship',
//            ]);


        });


        $grid->column('id', __('Id'));
        $grid->user()->type('Account Type')->display(function () {
            if($this->user->type == '1')
            {
                return 'Individual';
            }
            return 'Corporate';
        });
        $grid->user()->type('Account Name')->display(function () {
            if($this->user->type == '1')
            {
                return $this->user->first_name . ' ' . $this->user->last_name;
            }
            return $this->user->company;
        });
        $grid->column('order_code', __('Order code'));
        $grid->column('final_status', __('Status'));
        $grid->column('address', __('Address'));
        $grid->column('total', __('Total'));
        $grid->column('created_at', __('Created at'));

        $grid->disableActions();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('order_code', __('Order code'));
        $show->field('final_status', __('Final status'));
        $show->field('address', __('Address'));
        $show->field('total', __('Total'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->number('user_id', __('User id'));
        $form->text('order_code', __('Order code'));
        $form->text('final_status', __('Final status'));
        $form->text('address', __('Address'));
        $form->decimal('total', __('Total'));

        return $form;
    }
}
