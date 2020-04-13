<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Users Accounts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->model()->where('type', User::TYPE_USER)->orderBy('id', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('full_name')->display(function () {
            return $this->first_name.' '.$this->last_name;
        });
        $grid->column('email', __('Email'));
//        $grid->column('type', __('Type'))->display(function () {
//            return $this->type == User::TYPE_USER ? __('User') : __('Corporate');
//        })->sortable();
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label([
                0 => 'danger',
                1 => 'success',
            ])->sortable();
        $grid->column( 'created_at', __( 'Created' ) )->date( 'M d Y H:i' )->width( 150 )->sortable();

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
        $show = new Show(User::findOrFail($id));

        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));

        $show->type(__('Account Type'))
            ->using([User::TYPE_USER => 'USER', User::TYPE_CORPORATE => 'CORPORATE']);
        $show->is_subscribed(__('Is subscribed'))
            ->using(['0' => 'Not subscribed', '1' => 'Subscribed']);
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
        $form = new Form(new User);

        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->mobile('phone', __('Phone'))->options(['mask' => '']);
        $form->email('email', __('Email'));
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
