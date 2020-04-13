<?php

namespace App\Admin\Controllers\Reports;

use App\Models\User;
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
    protected $title = 'Users Report';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->expandFilter();
        $grid->model()->orderBy('id', 'desc');
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();

            // Add User filter
            $filter->where(function ($query) {
                switch ($this->input) {
                    case 'individual':
                        // custom complex query if the 'yes' option is selected
                        $query->where('type', User::TYPE_USER);
                        break;

                    case 'corporate':
                        $query->where('type', User::TYPE_CORPORATE);
                        break;

                    case 'blocked':
                        $query->where('is_active', '0');
                }
            }, 'Account Type', 'accounts')->radio([
                '' => 'All',
                'individual' => 'Only Individual',
                'corporate' => 'Only corporate',
                'blocked' => 'Blocked Accounts',
            ]);
        });

        $grid->column('id', __('Id'));
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('company', __('Company'));
        $grid->column('contact_person', __('Contact person'));
        $grid->column('job_title', __('Job title'));
        $grid->column('company_license', __('Company license'));
        $grid->column('phone', __('Phone'));
        $grid->column('email', __('Email'));
        $grid->column('type', __('Type'))->display(function () {
            return $this->type == User::TYPE_USER ? __('User') : __('Corporate');
        })->sortable();
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label([
                0 => 'danger',
                1 => 'success',
            ]);
        $grid->column('created_at', __('Created at'));

        $grid->disableActions();
        $grid->disableBatchActions();
        $grid->disableCreateButton();
        $grid->disableExport();
        return $grid;
    }
}
