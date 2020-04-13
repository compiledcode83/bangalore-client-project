<?php

namespace App\Admin\Controllers;

use App\Models\Product;
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
    protected $title = 'Manage Reviews';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Review);

        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->in('product_id', 'Product')->multipleSelect(Product::all()->pluck('name_en', 'id'));

            $filter->where(function ($query) {
                switch ($this->input) {
                    case 'with_abuses':
                        $query->whereHas('abuses');
                        break;
                    case 'no_abuses':
                        $query->whereDoesntHave('abuses');
                }
            }, 'Abuses', '')->radio([
                '' => 'All',
                'with_abuses' => 'with abuses',
                'no_abuses' => 'no abuses',
            ]);
        });

        $grid->column('id', __('Id'));
        $grid->user()->first_name('By user');
        $grid->product()->name_en('Product');
        $grid->column('order_id', __('Order id'));

        $grid->column('abuses')->display(function ($abuses) {
            return "<span style='color:red'> ".count($abuses)." </span>";
        });

        $grid->column('rating', __('Rating'));
        $grid->column('review', __('Review'));
        $grid->column('created_at', __('Created at'));

        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        $grid->disableBatchActions();
        $grid->disableExport();
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Review);

        $form->number('rating', __('Rating'))->updateRules('integer|between:1,5');
        $form->textarea('review', __('Review'));

        $form->tools(function (Form\Tools $tools) {
            // Disable `Veiw` btn.
            $tools->disableView();
        });

        return $form;
    }
}
