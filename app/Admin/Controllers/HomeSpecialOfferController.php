<?php

namespace App\Admin\Controllers;

use App\Models\HomepageSection;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HomeSpecialOfferController extends AdminController {

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Special Offers';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid( new HomepageSection );

        admin_info('Instructions', 'Only 4 records available, 1 record represent left side, 1 record represent right side and 2 records represent middle');

        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });


        $grid->model()->orderBy( 'item_location', 'desc' );
        $grid->model()->where( 'type', '=', 'special_offers' );

        $grid->column( 'id', __( 'Id' ) );
        $grid->column( 'title_en', __( 'Title' ) );
        $grid->column( 'image', __( 'Image' ) )->image( '', 200, 100 );
        $grid->column( 'item_location', __( 'Item location' ) );
        $grid->column( 'created_at', __( 'Created at' ) );

        $grid->disableBatchActions();
        $grid->disableExport();
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail( $id )
    {
        $show = new Show( HomepageSection::findOrFail( $id ) );

        $show->field('id', __('Id'));
        $show->field('title_en', __('Title en'));
        $show->field('title_ar', __('Title ar'));
        $show->image(__('Image'))->image();
        $show->field('link', __('Link'));
        $show->field('item_location', __('Item location'));
        $show->field('created_at', __('Created at'));

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableDelete();
            });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form( new HomepageSection );

        $form->hidden( 'type', 'Type' )->default( 'special_offers' );;

        $form->text( 'title_en', __( 'Title en' ) );
        $form->text( 'title_ar', __( 'Title ar' ) );
        $form->image( 'image', __( 'Image' ) )
            ->help('SIZE MUST BE for left/right images: 370×420 | SIZE MUST BE for Middle images: 370×200');
        $form->url( 'link', __( 'Link' ) );

        $form->select( 'item_location', __( 'Item location' ) )->options( function () {
            return [
                'left'   => 'left',
                'right'  => 'right',
                'middle' => 'middle'
            ];
        } );

        $form->footer(function ($footer) {

            // disable `View` checkbox
            $footer->disableViewCheck();

            // disable `Continue Creating` checkbox
            $footer->disableCreatingCheck();

        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
        });

        return $form;
    }
}
