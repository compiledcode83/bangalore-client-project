<?php

namespace App\Admin\Controllers;

use App\Models\Faq;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FaqController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'FAQ';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Faq);

        $grid->disableExport();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->model()->orderBy( 'id', 'desc' );

        $grid->column('id', __('Id'));
        $grid->column('title_en', __('Title en'));
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
        $show = new Show(Faq::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title_en', __('Title en'));
        $show->field('title_ar', __('Title ar'));
        $show->field('description_en', __('Description en'));
        $show->field('description_ar', __('Description ar'));
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
        $form = new Form(new Faq);

        $form->textarea('title_en', __('Title en'))->rules( 'required' );
        $form->textarea('title_ar', __('Title ar'))->rules( 'required' );
        $form->textarea('description_en', __('Description en'))->rules( 'required' );
        $form->textarea('description_ar', __('Description ar'))->rules( 'required' );
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
