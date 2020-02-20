<?php

namespace App\Admin\Controllers\Reports;

use App\models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\models\Product';

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
        $grid->column('short_description_ar', __('Short description ar'));
        $grid->column('short_description_en', __('Short description en'));
        $grid->column('description_en', __('Description en'));
        $grid->column('description_ar', __('Description ar'));
        $grid->column('more_information_ar', __('More information ar'));
        $grid->column('more_information_en', __('More information en'));
        $grid->column('sku', __('Sku'));
        $grid->column('main_image', __('Main image'));
        $grid->column('main_gallery', __('Main gallery'));
        $grid->column('supplier_price', __('Supplier price'));
        $grid->column('slug', __('Slug'));
        $grid->column('show_left_qty', __('Show left qty'));
        $grid->column('is_active', __('Is active'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->column('related', __('Related'));

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
        $show->field('short_description_ar', __('Short description ar'));
        $show->field('short_description_en', __('Short description en'));
        $show->field('description_en', __('Description en'));
        $show->field('description_ar', __('Description ar'));
        $show->field('more_information_ar', __('More information ar'));
        $show->field('more_information_en', __('More information en'));
        $show->field('sku', __('Sku'));
        $show->field('main_image', __('Main image'));
        $show->field('main_gallery', __('Main gallery'));
        $show->field('supplier_price', __('Supplier price'));
        $show->field('slug', __('Slug'));
        $show->field('show_left_qty', __('Show left qty'));
        $show->field('is_active', __('Is active'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('related', __('Related'));

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
        $form->text('short_description_ar', __('Short description ar'));
        $form->text('short_description_en', __('Short description en'));
        $form->textarea('description_en', __('Description en'));
        $form->textarea('description_ar', __('Description ar'));
        $form->textarea('more_information_ar', __('More information ar'));
        $form->textarea('more_information_en', __('More information en'));
        $form->text('sku', __('Sku'));
        $form->text('main_image', __('Main image'));
        $form->textarea('main_gallery', __('Main gallery'));
        $form->decimal('supplier_price', __('Supplier price'))->default(0.000);
        $form->text('slug', __('Slug'));
        $form->switch('show_left_qty', __('Show left qty'));
        $form->switch('is_active', __('Is active'))->default(1);
        $form->text('related', __('Related'));

        return $form;
    }
}
