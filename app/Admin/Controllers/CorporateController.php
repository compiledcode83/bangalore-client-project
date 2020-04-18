<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CorporateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Corporate Accounts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new \App\Models\User );

        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add Name filter
            $filter->like('company', 'Company');

        });

        $grid->model()->where('type', User::TYPE_CORPORATE)
                    ->where('is_corporate_accepted', '1')
                    ->orWhere('is_corporate_accepted', '2')
                    ->orderBy('id', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('company', __('Company'));
        $grid->column('email', __('Email'));
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label([
                0 => 'danger',
                1 => 'success',
            ])->sortable();

        $grid->column( 'is_corporate_accepted', __( 'Approved/Rejected' ) )
            ->using( ['1' => 'Approved', '2' => 'Rejected'] )
            ->label([
                1 => 'success',
                2 => 'danger',
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

        $show->field('company', __('Company'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('job_title', __('Job Title'));
        $show->field('contact_person', __('Contact Person'));
        $show->company_license()->as(function ($company_license) {
            if($company_license)
            {
                return '/uploads/corporates/'.$company_license;
            }
            return "No uploads";
        })->link();
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

        $form->hidden( 'type', 'Type' )->default( User::TYPE_CORPORATE );
        $form->text('company', __('Company Name'));
        $form->mobile('phone', __('Phone'))->options(['mask' => ''])->rules('required');
        $form->email('email', __('Email'))
            ->creationRules('required|unique:users,email' )
            ->updateRules( 'required|unique:users,email,{{id}}' );
        if($form->isCreating())
        {
            $form->password('password', __('Password'));
        }
        $form->switch('is_active', __('Is active'))->default(1);

        return $form;
    }
}
