<?php

namespace App\Admin\Controllers\Reports;

use App\models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\models\User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', __('Id'));
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('company', __('Company'));
        $grid->column('contact_person', __('Contact person'));
        $grid->column('job_title', __('Job title'));
        $grid->column('company_license', __('Company license'));
        $grid->column('phone', __('Phone'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('password', __('Password'));
        $grid->column('type', __('Type'));
        $grid->column('is_subscribed', __('Is subscribed'));
        $grid->column('is_active', __('Is active'));
        $grid->column('is_corporate_accepted', __('Is corporate accepted'));
        $grid->column('remember_token', __('Remember token'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('company', __('Company'));
        $show->field('contact_person', __('Contact person'));
        $show->field('job_title', __('Job title'));
        $show->field('company_license', __('Company license'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('type', __('Type'));
        $show->field('is_subscribed', __('Is subscribed'));
        $show->field('is_active', __('Is active'));
        $show->field('is_corporate_accepted', __('Is corporate accepted'));
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
        $form->text('company', __('Company'));
        $form->text('contact_person', __('Contact person'));
        $form->text('job_title', __('Job title'));
        $form->text('company_license', __('Company license'));
        $form->mobile('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->switch('type', __('Type'))->default(1);
        $form->switch('is_subscribed', __('Is subscribed'));
        $form->switch('is_active', __('Is active'))->default(1);
        $form->switch('is_corporate_accepted', __('Is corporate accepted'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
