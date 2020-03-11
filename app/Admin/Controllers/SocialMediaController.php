<?php

namespace App\Admin\Controllers;

use App\Models\SocialMedia;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SocialMediaController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Manage Social Media';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SocialMedia);

        $grid->column('id', __('Id'));
        $grid->column('icon', __('Icon'))->image();
        $grid->column('link', __('Link'));
        $grid->column('created_at', __('Created at'));

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
        $show = new Show(SocialMedia::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('icon', __('Icon'))->image();
        $show->field('link', __('Link'));
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
        $form = new Form(new SocialMedia);

        $form->image('icon', __('Icon'));
        $form->url('link', __('Link'));

        return $form;
    }
}
