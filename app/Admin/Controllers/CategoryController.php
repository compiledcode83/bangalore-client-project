<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
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
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->title)
            ->body($this->form());
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->body($this->editForm($id)->edit($id));
    }

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

        $grid->model()->orderBy('id', 'desc');

        $grid->column('parent_id', __('Parent'))->display(function () {
            //in case parent deleted
            if($this->parent_id != '0' AND !$this->parent)
            {
                return '';
            }
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
        $show = new Show(Category::findOrFail($id));

        $rootCategories = Category::rootParent()->pluck('name_en', 'id')->toArray();
        $rootCategories[0] = 'Root';

        $show->field('id', __('Id'));
        $show->field('parent_id', __('Parent'))
            ->using($rootCategories);
        $show->products(__('Products'), function ($product) {

            $product->setResource('/admin/products');
            $product->name_en();
            $product->created_at();

            $product->disableActions();
            $product->disableCreateButton();
        });

        $show->field('name_en', __('Name en'));
        $show->field('name_ar', __('Name ar'));
        $show->field('description_en', __('Description en'));
        $show->field('description_ar', __('Description ar'));
        $show->field('slug', __('Slug'));
        $show->is_active(__('Status'))
            ->using(['0' => 'Not-Active', '1' => 'Active']);
        $show->in_homepage(__('In HomePage Menu Header'))
            ->using(['0' => 'No', '1' => 'Yes']);
        $show->field('created_at', __('Created at'));
        $show->divider();
        $show->banner(__('Banner'))->image();
        $show->image(__('Image'))->image();

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


        $rootCategories = Category::rootParent()->pluck('name_en', 'id')->toArray();
        $rootCategories[0] = 'Root --Top Level';

        $form->select('parent_id', __('Select Parent'))->options($rootCategories);
        $form->text('name_en', __('Name en'))->rules( 'required' );
        $form->text('name_ar', __('Name ar'))->rules( 'required' );
        $form->textarea('description_en', __('Description en'));
        $form->textarea('description_ar', __('Description ar'));
        $form->image('banner', __('Banner'))->rules( 'required' );
        $form->image('image', __('Image'))->rules( 'required' );
        $form->switch('is_active', __('Is active'))->default(1);
        $form->switch('in_homepage', __('In HomePage Menu Header'))->default(0);

        return $form;
    }

    /**
     * Make a form builder.
     * @param $id
     * @return Form
     */
    protected function editForm($id)
    {
        $form = new Form(new Category);


        $rootCategories = Category::rootParent()->pluck('name_en', 'id')->toArray();
        unset($rootCategories[$id]);

        $rootCategories[0] = 'Root --Top Level';
        $form->select('parent_id', __('Select Parent'))->options($rootCategories);
        $form->text('name_en', __('Name en'))->rules( 'required' );
        $form->text('name_ar', __('Name ar'))->rules( 'required' );
        $form->textarea('description_en', __('Description en'));
        $form->textarea('description_ar', __('Description ar'));
        $form->image('banner', __('Banner'))->rules( 'required' );
        $form->image('image', __('Image'))->rules( 'required' );
        $form->switch('is_active', __('Is active'))->default(1);
        $form->switch('in_homepage', __('In HomePage Menu Header'))->default(0);

        return $form;
    }
}
