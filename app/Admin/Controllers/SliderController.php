<?php

namespace App\Admin\Controllers;

use App\Models\Slider;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SliderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Home Slider';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Slider);

        $grid->model()->orderBy( 'id', 'desc' );

        $grid->disableExport();

        $grid->column('id', __('Id'));
        $grid->column('title_en', __('Title'));
        $grid->column('order', __('Order'));
        $grid->column('image', __('Image'))->image('', '200');
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label( [
                0 => 'danger',
                1 => 'success',
            ] )->sortable();
        $grid->column('created_at', __('Created at'));

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
    protected function detail($id)
    {
        $show = new Show(Slider::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('sub_title', __('Sub title'));
        $show->field('order', __('Order'));
        $show->field('image', __('Image'))->image('', '200');
        $show->field('link', __('Link'));
        $show->is_active(__('Status'))
            ->using(['0' => 'Not-Active', '1' => 'Active']);
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
        $form = new Form(new Slider);

        $form->text('order', __('Order'))->rules( 'required' );
        $form->text('title_en', __('English Title'));
        $form->text('sub_title_en', __('English Sub title'));
        $form->text('title_ar', __('Arabic Title'));
        $form->text('sub_title_ar', __('Arabic Sub title'));
        $form->image('image', __('Image'))->rules( 'required' );
        $form->url('link', __('Link'))->rules( 'required' );
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
