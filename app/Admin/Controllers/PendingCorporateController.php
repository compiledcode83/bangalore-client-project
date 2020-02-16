<?php

namespace App\Admin\Controllers;

use App\Mail\ApproveCorporateAccountMail;
use App\Mail\RejectCorporateAccountMail;
use App\models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PendingCorporateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pending Corporate Accounts';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new \App\Models\User );

        $grid->model()->where('type', User::TYPE_CORPORATE)
                    ->where('is_corporate_accepted', '0')
                    ->orderBy('id', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('company', __('Company'));
        $grid->column('email', __('Email'));
        $grid->column( 'is_corporate_accepted', __( 'Status' ) )
            ->using( ['0' => 'Pending', '1' => 'Active'] )
            ->label([
                0 => 'warning',
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

        $show->field('company', __('Company'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('job_title', __('Job Title'));
        $show->field('contact_person', __('Contact Person'));
        $show->field('company_license', __('Company License'))->file();
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

        $form->text('company', __('Company Name'));
        $form->mobile('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->select('is_corporate_accepted', __('Account Pending'))->options([
            '1' => __('Approve'),
            '2' => __('Reject'),
        ])->required();

        $form->saving(function ($form) {
            if($form->is_corporate_accepted == '1')
            {
                $form->hidden( 'is_active', 'status' )->default( '1' );
                //sending approval email
                \Mail::to($form->email)->send(new ApproveCorporateAccountMail($form->company));
            }
            elseif($form->is_corporate_accepted == '2')
            {
                //sending rejection email
                \Mail::to($form->email)->send(new RejectCorporateAccountMail($form->company));
            }
        });

        return $form;
    }
}
