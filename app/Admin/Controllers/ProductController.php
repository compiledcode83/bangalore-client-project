<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->column('id', __('Id'));
        $grid->column('name_en', __('Name en'));
        $grid->column('name_ar', __('Name ar'));
        $grid->column('description_en', __('Description en'));
        $grid->column('description_ar', __('Description ar'));
        $grid->column('sku', __('Sku'));
        $grid->column('main_image', __('Main image'));
        $grid->column('slug', __('Slug'));
        $grid->column('is_active', __('Is active'));
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name_en', __('Name en'));
        $show->field('name_ar', __('Name ar'));
        $show->field('description_en', __('Description en'));
        $show->field('description_ar', __('Description ar'));
        $show->field('sku', __('Sku'));
        $show->field('main_image', __('Main image'));
        $show->field('slug', __('Slug'));
        $show->field('is_active', __('Is active'));
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
        $form = new Form(new Product);

        $form->text('name_en', __('Name en'));
        $form->text('name_ar', __('Name ar'));
        $form->textarea('description_en', __('Description en'));
        $form->textarea('description_ar', __('Description ar'));
        $form->text('sku', __('Sku'));
        $form->text('main_image', __('Main image'));
        $form->text('slug', __('Slug'));
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
