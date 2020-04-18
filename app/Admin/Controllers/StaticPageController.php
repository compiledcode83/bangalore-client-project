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
    protected $title = 'Pages';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StaticPage);

        $grid->disableExport();

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->model()->orderBy( 'id', 'desc' );

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'));
        $grid->column('title_en', __('Title en'));
        $grid->column('banner', __('Banner'))->image( '', 100, 100 );
        $grid->column('slug', __('Slug'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableBatchActions();
        $grid->disableExport();
        $grid->disableCreateButton();
        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new StaticPage);

        $form->text('type', __('Type'))->rules( 'required' );
        $form->text('title_en', __('Title en'))->rules( 'required' );
        $form->text('title_ar', __('Title ar'))->rules( 'required' );
        $form->ckeditor('body_en', __('Body en'))->rules( 'required' );
        $form->ckeditor('body_ar', __('Body ar'))->rules( 'required' );
        $form->image('banner', __('Banner'))->move('pages')->uniqueName()->rules( 'required' );
        $form->text('slug', __('Slug'))
        ->creationRules(['required', "unique:static_pages"])
        ->updateRules(['required', "unique:static_pages,id,{{id}}"]);

        $form->tools(function (Form\Tools $tools) {

            // Disable `Delete` btn.
            $tools->disableDelete();

            // Disable `Veiw` btn.
            $tools->disableView();

        });

        return $form;
    }
}
