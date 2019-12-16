<?php

namespace App\Admin\Controllers;

use App\Models\StaticPage;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StaticPageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\StaticPage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StaticPage);

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'));
        $grid->column('title_en', __('Title en'));
        $grid->column('title_ar', __('Title ar'));
        $grid->column('body_en', __('Body en'));
        $grid->column('body_ar', __('Body ar'));
        $grid->column('banner', __('Banner'));
        $grid->column('slug', __('Slug'));
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
        $show = new Show(StaticPage::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('title_en', __('Title en'));
        $show->field('title_ar', __('Title ar'));
        $show->field('body_en', __('Body en'));
        $show->field('body_ar', __('Body ar'));
        $show->field('banner', __('Banner'));
        $show->field('slug', __('Slug'));
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
        $form = new Form(new StaticPage);

        $form->text('type', __('Type'));
        $form->text('title_en', __('Title en'));
        $form->text('title_ar', __('Title ar'));
        $form->textarea('body_en', __('Body en'));
        $form->textarea('body_ar', __('Body ar'));
        $form->text('banner', __('Banner'));
        $form->text('slug', __('Slug'));

        return $form;
    }
}
