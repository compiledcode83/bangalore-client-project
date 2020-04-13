<?php

namespace App\Admin\Controllers;

use App\Mail\PrintImagesConfirmation;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Status;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends AdminController {

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
    public function create( Content $content )
    {
        abort( 404 );
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit( $id, Content $content )
    {
        return $content
            ->header( 'Edit Order' )
            ->description( 'description' )
            ->body(
                view( 'admin.order.edit' )
                    ->with( 'order', Order::find( $id ) )
                    ->with( 'statuses', Status::all() )
                    ->with( 'orderStatuses', OrderStatus::where( 'order_id', $id )->get() )
                    ->with( 'is_create', false )
            );
    }

    public function updateDetails( Request $request )
    {
        $attribute = $request->only( 'address', 'order', 'status', 'print_image' );
        $order = Order::find( $attribute['order'] );
        $customerEmail = $order->user->email;

        $status = Status::find( $attribute['status'] );
        $checkStatusHistory = OrderStatus::where( 'order_id', $attribute['order'] )
            ->where( 'status_id', $attribute['status'] )
            ->first();
        if ( !$checkStatusHistory )
        {
            OrderStatus::create( [
                'order_id'  => $attribute['order'],
                'status_id' => $attribute['status']
            ] );
        }

        $updateOrderFields = [
            'final_status' => $status->name_en,
            'address'      => $attribute['address']
        ];

        if ( $order->final_status != $status->name_en )
        {
            //status changes, @ToDo send email with new status
        }

        $sendEmailWithPrintImageStatus = [];
        foreach ($order->orderItems as $orderItem)
        {
            $printImageAttribute = $request->only('print_image_' . $orderItem->id);
            // check if item has print image
            if ( isset( $printImageAttribute ) )
            {
                //in case order has multiple print images if admin accepted some and rejected
                // others will send email with all accepted and rejected prints
                //if it's approved add it to email
                if ( $printImageAttribute == 'approved' )
                {
                    $orderItem->update( [
                        'is_print_image_accepted' => '1'
                    ] );
                    $sendEmailWithPrintImageStatus[] = [
                        'item_name'   => $orderItem->productAttributeValue->product->name_en,
                        'print_image' => $orderItem->print_image,
                        'status'      => 'approved'
                    ];
                } else
                {
                    //if it's rejected add it to email
                    $orderItem->update( [
                        'is_print_image_accepted' => '2'
                    ] );
                    $sendEmailWithPrintImageStatus[] = [
                        'item_name'   => $orderItem->productAttributeValue->product->name_en,
                        'print_image' => $orderItem->print_image,
                        'status'      => 'rejected'
                    ];
                }
            }
        }

        $order->update( $updateOrderFields );
        if ( !empty( $sendEmailWithPrintImageStatus ) )
        {
            //send email with these results
            Mail::to( $customerEmail )->send( new PrintImagesConfirmation( $sendEmailWithPrintImageStatus ) );
        }

        return redirect()->route('orders.index');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid( new Order );

        $grid->disableCreateButton();
        $grid->expandFilter();
        $grid->filter( function ( $filter ) {
            // Remove the default id filter
            $filter->disableIdFilter();
            // Add order code filter
            $filter->like( 'order_code', 'Code' );
            $filter->equal( 'final_status', 'Status' )->select( function () {
                $finalStatus = Order::groupBy( 'final_status' )->pluck( 'final_status' )->toArray();
                //copy values to keys
                $statusFilter = array_combine( $finalStatus, $finalStatus );

                return array_map( 'ucfirst', $statusFilter );
            } );
        } );

        $grid->model()->orderBy( 'id', 'desc' );
        $grid->column( 'order_code', __( 'Order code' ) );
        $grid->column( 'user_id', __( 'User' ) )->display( function () {

            $user = User::find( $this->user_id );

            if($user->type == User::TYPE_USER)
            {
                return $user->first_name .' '. $user->last_name;
            }

            return $user->company;
        } )->sortable();

        $grid->column( 'final_status', __( 'Status' ) )->sortable();
        $grid->column( 'total', __( 'Total' ) );

        $grid->column( 'created_at', __( 'Created' ) )->date( 'M d Y H:i' )->width( 150 )->sortable();

        $grid->disableBatchActions();
        $grid->disableExport();
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
    public function show( $id, Content $content )
    {
        return $content
            ->title( $this->title() )
            ->description( $this->description['show'] ?? trans( 'admin.show' ) )
            ->body(
                view( 'admin.order_details' )
                    ->with( 'order', Order::findOrFail( $id ) )
            );
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail( $id )
    {
        $show = new Show( Order::findOrFail( $id ) );

        $show->field( 'user_id', __( 'User id' ) );
        $show->field( 'order_code', __( 'Order code' ) );
        $show->field( 'address', __( 'Address' ) );
        $show->field( 'total', __( 'Total' ) );
        $show->field( 'created_at', __( 'Created at' ) );

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form( new Order );

        $form->tab( 'Order', function ( $form ) {
            $form->text( 'order_code', __( 'Order code' ) );
            $form->text( 'address', __( 'Address' ) );
            $form->decimal( 'total', __( 'Total' ) );

            //        @todo update table order_status to save history
            $form->select( 'final_status', __( 'Status' ) )
                ->options( Status::all()->pluck( 'name_en', 'name_en' ) )
                ->rules( 'required' );

            $form->text( 'id', 'id' );
        } )->tab( 'Order Items', function ( $form ) {

            $form->hasMany( 'orderItems', 'Order Items', function ( $form ) {
                $form->text( 'id', 'id' );
            } );
        } );

        $form->saving( function ( $form ) {

        } );

        return $form;
    }
}
