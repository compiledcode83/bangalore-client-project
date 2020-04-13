<?php

namespace App\Admin\Controllers;

use App\Models\AttributeValue;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ColorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Colors';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AttributeValue);

        $grid->model()->orderBy( 'created_at', 'desc' );
        $grid->model()->where( 'attribute_id', '=', '1' );

        $grid->column('id', __('Id'));
        $grid->column('value_en', __('Name'));
        $grid->column('other_value', __('Color Code'))->display(function ($content) {

            return "<span style='color:{$content}'>$content</span>";

        });
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
        $show = new Show(AttributeValue::findOrFail($id));

        $show->field('value_en', __('English Name'));
        $show->field('value_ar', __('Arabic Name'));
        $show->field('other_value', __('Color Code'));

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
        $form = new Form(new AttributeValue);

        $form->hidden( 'attribute_id', 'attribute_id' )->default( '1' );

        $form->text('value_en', __('English Name'))->rules( 'required' );
        $form->text('value_ar', __('Arabic Name'))->rules( 'required' );

        $form->color('other_value', __('Color Code'))->rules( 'required' );

        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
