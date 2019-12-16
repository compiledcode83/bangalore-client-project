<?php

namespace App\Admin\Controllers;

use App\Models\Review;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ReviewController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Review';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Review);

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('product_id', __('Product id'));
        $grid->column('order_id', __('Order id'));
        $grid->column('rating', __('Rating'));
        $grid->column('review', __('Review'));
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
        $show = new Show(Review::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('product_id', __('Product id'));
        $show->field('order_id', __('Order id'));
        $show->field('rating', __('Rating'));
        $show->field('review', __('Review'));
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
        $form = new Form(new Review);

        $form->number('user_id', __('User id'));
        $form->number('product_id', __('Product id'));
        $form->number('order_id', __('Order id'));
        $form->number('rating', __('Rating'));
        $form->text('review', __('Review'));

        return $form;
    }
}
