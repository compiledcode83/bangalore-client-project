<?php

namespace App\Admin\Controllers;

use App\Models\MediaService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Services';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MediaService);

        $grid->model()->orderBy( 'id', 'desc' );
        $grid->model()->where( 'type', '=', MediaService::TYPE_SERVICE );

        $grid->disableExport();

        $grid->column('id', __('Id'));
        $grid->column('title_en', __('Title'));
        $grid->column('image', __('Image'))->image( '', 200, 100 );;
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
        $show = new Show(MediaService::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title_en', __('Title en'));
        $show->field('title_ar', __('Title ar'));
        $show->field('short_description_en', __('Short description en'));
        $show->field('short_description_ar', __('Short description ar'));
        $show->field('full_description_en', __('Full description en'));
        $show->field('full_description_ar', __('Full description ar'));
        $show->image(__('Image'))->image();
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
        $form = new Form(new MediaService);

        $form->hidden( 'type', 'Type' )->default( MediaService::TYPE_SERVICE );

        $form->text('title_en', __('Title en'))->rules( 'required' );
        $form->text('title_ar', __('Title ar'))->rules( 'required' );

        $form->ckeditor('short_description_en', __('Short English Description'))->rules( 'required' );
        $form->ckeditor('short_description_ar', __('Short Arabic Description'))->rules( 'required' );
        $form->ckeditor('full_description_en', __('Full English Description'))->rules( 'required' );
        $form->ckeditor('full_description_ar', __('Full Arabic Description'))->rules( 'required' );

        $form->image('image', __('Image'))->rules( 'required' );
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
