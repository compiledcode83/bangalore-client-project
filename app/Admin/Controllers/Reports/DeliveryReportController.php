<?php

namespace App\Admin\Controllers\Reports;

use App\Models\Area;
use App\Models\Order;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class DeliveryReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Delivery Report';

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

            $filter->equal( 'user_id', 'User Account' )->select( function () {
                $userAccounts = User::where( 'is_active', '1' )
                                    ->where( 'type', User::TYPE_USER )
                                    ->whereHas('orders')
                                    ->select('id', DB::raw("CONCAT(users.first_name,' ',users.last_name) as name"))
                                    ->pluck('name', 'id')->toArray();
                $corporateAccounts = User::where( 'is_active', '1' )
                    ->where( 'type', User::TYPE_CORPORATE )
                    ->whereHas('orders')
                    ->select('id', DB::raw("company as name"))
                    ->pluck('name', 'id')->toArray();

                foreach ($corporateAccounts as $key => $value)
                {
                    $userAccounts[$key] = $value;
                }

                return array_map( 'ucfirst', $userAccounts );
            } );

            $filter->like( 'address', 'Area' )->select( function () {
                $areas = Area::where( 'is_active', '1' )->pluck( 'name_en' )->toArray();
                //copy values to keys
                $areasFilter = array_combine( $areas, $areas );

                return array_map( 'ucfirst', $areasFilter );
            } );
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
