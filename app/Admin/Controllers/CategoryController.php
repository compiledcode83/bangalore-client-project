<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Categories';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category);

        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add Name filter
            $filter->like('name_en', 'Name');

            // Add Status filter
            $filter->equal('is_active', 'Status')->radio([
                ''   => 'All',
                0    => 'Not Active',
                1    => 'Active',
            ]);

        });

        $grid->column('parent_id', __('Parent'))->display(function () {
            return $this->parent ? $this->parent->name_en : 'Root';
        })->sortable();
        $grid->column('name_en', __('Name'))->sortable()->filter('name');
        $grid->column('description_en', __('Description'));
        $grid->column('banner', __('Banner'))->image('', 200, 100);
        $grid->column('is_active', __('Status'))
            ->using(['0' => 'Not-Active', '1' => 'Active'])
            ->label([
                0 => 'danger',
                1 => 'success',
            ])->sortable();

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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('parent_id', __('Parent id'));
        $show->field('name_en', __('Name en'));
        $show->field('name_ar', __('Name ar'));
        $show->field('description_en', __('Description en'));
        $show->field('description_ar', __('Description ar'));
        $show->field('slug', __('Slug'));
        $show->field('banner', __('Banner'));
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
        $form = new Form(new Category);


        $rootCategories = Category::rootParent()->pluck('name_en');
        $rootCategories->prepend('Root --Top Level');

        $form->select('parent_id', __('Select Parent'))->options($rootCategories);
        $form->text('name_en', __('Name en'));
        $form->text('name_ar', __('Name ar'));
        $form->textarea('description_en', __('Description en'));
        $form->textarea('description_ar', __('Description ar'));
//        $form->text('slug', __('Slug'));
        $form->image('banner', __('Banner'));
        $form->image('image', __('Image'));
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
