<?php

namespace App\Admin\Controllers;

use App\Models\Status;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StatusController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Status';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Status);

        $grid->column('id', __('Id'));
        $grid->column('name_en', __('Name'))->width(1000);

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
        $show = new Show(Status::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name_en', __('Name en'));
        $show->field('name_ar', __('Name ar'));
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
        $form = new Form(new Status);

        $form->text('name_en', __('English Name'));
        $form->text('name_ar', __('Arabic Name'));

        return $form;
    }
}
