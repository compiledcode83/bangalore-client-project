<?php

namespace App\Admin\Controllers;

use App\Models\MediaService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MediaServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\MediaService';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MediaService);

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'));
        $grid->column('title_en', __('Title en'));
        $grid->column('title_ar', __('Title ar'));
        $grid->column('short_description_en', __('Short description en'));
        $grid->column('short_description_ar', __('Short description ar'));
        $grid->column('full_description_en', __('Full description en'));
        $grid->column('full_description_ar', __('Full description ar'));
        $grid->column('image', __('Image'));
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
        $show = new Show(MediaService::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('title_en', __('Title en'));
        $show->field('title_ar', __('Title ar'));
        $show->field('short_description_en', __('Short description en'));
        $show->field('short_description_ar', __('Short description ar'));
        $show->field('full_description_en', __('Full description en'));
        $show->field('full_description_ar', __('Full description ar'));
        $show->field('image', __('Image'));
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
        $form = new Form(new MediaService);

        $form->switch('type', __('Type'));
        $form->text('title_en', __('Title en'));
        $form->text('title_ar', __('Title ar'));
        $form->textarea('short_description_en', __('Short description en'));
        $form->textarea('short_description_ar', __('Short description ar'));
        $form->textarea('full_description_en', __('Full description en'));
        $form->textarea('full_description_ar', __('Full description ar'));
        $form->image('image', __('Image'));
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
