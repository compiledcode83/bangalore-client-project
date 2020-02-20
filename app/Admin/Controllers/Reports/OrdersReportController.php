<?php

namespace App\Admin\Controllers\Reports;

use App\models\Order;
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
    protected $title = 'App\models\Order';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('order_code', __('Order code'));
        $grid->column('final_status', __('Final status'));
        $grid->column('address', __('Address'));
        $grid->column('total', __('Total'));
        $grid->column('payment_method', __('Payment method'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

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
        $show->field('payment_method', __('Payment method'));
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
        $form->text('payment_method', __('Payment method'));

        return $form;
    }
}
