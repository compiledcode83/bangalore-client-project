<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Orders';

    /**
     * Create interface.
     *
     * @param Content $content
     *
     */
    public function create(Content $content)
    {
        abort(404);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order);

        $grid->disableCreateButton();

        $grid->expandFilter();

        $grid->filter( function ( $filter ) {

            // Remove the default id filter
            $filter->disableIdFilter();
            // Add order code filter
            $filter->like( 'order_code', 'Code' );

            $filter->equal( 'final_status', 'Status' )->select(function (){

                $finalStatus = Order::groupBy('final_status')->pluck('final_status')->toArray();
                //copy values to keys
                $statusFilter = array_combine($finalStatus, $finalStatus);

                return array_map('ucfirst', $statusFilter);
            });

        } );

        $grid->column('order_code', __('Order code'));
        $grid->column('user_id', __('User'))->display(function () {

            $user = User::find($this->user_id);
            return $user->first_name . $user->last_name;
        })->sortable();

        $grid->column('final_status', __('Status'))->sortable();
        $grid->column('total', __('Total'));

        $grid->column( 'created_at', __( 'Created' ) )->date( 'M d Y H:i' )->width( 150 )->sortable();

        return $grid;
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['show'] ?? trans('admin.show'))
            ->body(
                view('admin.order_details')
                    ->with('order', Order::findOrFail($id))
            );
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

        $show->field('user_id', __('User id'));
        $show->field('order_code', __('Order code'));
        $show->field('address', __('Address'));
        $show->field('total', __('Total'));
        $show->field('created_at', __('Created at'));

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
        $form->text('address', __('Address'));
        $form->decimal('total', __('Total'));

//        @todo update table order_status to save history
        $form->select('final_status', __('Status'))
            ->options(Status::all()->pluck('name_en', 'name_en'))
            ->rules('required');

        return $form;
    }
}
