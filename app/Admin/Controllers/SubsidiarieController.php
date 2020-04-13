<?php

namespace App\Admin\Controllers;

use App\Models\Subsidiarie;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SubsidiarieController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Subsidiaries';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Subsidiarie);

        $grid->disableExport();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->model()->orderBy( 'id', 'desc' );

        $grid->column('id', __('Id'));
        $grid->column('logo', __('Logo'))->image( '', 100, 100 );
        $grid->column('url', __('Url'))->link();
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label( [
                0 => 'danger',
                1 => 'success',
            ] );
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Subsidiarie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('logo', __('Logo'))->image();
        $show->field('description_en', __('Description en'));
        $show->field('description_ar', __('Description ar'));
        $show->field('url', __('Url'))->link();
        $show->is_active(__('Status'))
            ->using(['0' => 'Not-Active', '1' => 'Active']);
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Subsidiarie);

        $form->image('logo', __('Logo'))->move('subsidiaries')->uniqueName()->rules( 'required' );
        $form->textarea('description_en', __('Description en'));
        $form->textarea('description_ar', __('Description ar'));
        $form->url('url', __('Url'));
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
