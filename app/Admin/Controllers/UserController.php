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
    protected $title = 'Accounts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', __('Id'));
        $grid->column('full_name')->display(function () {
            return $this->first_name.' '.$this->last_name;
        });
        $grid->column('email', __('Email'));
        $grid->column('type', __('Type'))->display(function () {
            return $this->type == User::TYPE_USER ? __('User') : __('Corporate');
        })->sortable();
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label([
                0 => 'danger',
                1 => 'success',
            ])->sortable();
        $grid->column( 'created_at', __( 'Created' ) )->date( 'M d Y H:i' )->width( 150 )->sortable();

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

        $show->field('id', __('Id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('type', __('Type'));
        $show->field('is_subscribed', __('Is subscribed'));
        $show->field('is_active', __('Is active'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User);

        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->mobile('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->password('password', __('Password'));
        $form->select('type', __('Account Type'))->options([
            User::TYPE_USER => __('User'),
            User::TYPE_CORPORATE => __('Corporate'),
        ]);
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
