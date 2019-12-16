<?php

namespace App\Admin\Controllers;

use App\Models\Setting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SettingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Models\Setting';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Setting);

        $grid->column('id', __('Id'));
        $grid->column('contact_us_banner', __('Contact us banner'));
        $grid->column('faq_banner', __('Faq banner'));
        $grid->column('sitemap_banner', __('Sitemap banner'));
        $grid->column('media_banner', __('Media banner'));
        $grid->column('services_banner', __('Services banner'));
        $grid->column('special_offers_banner', __('Special offers banner'));
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
        $show = new Show(Setting::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('contact_us_banner', __('Contact us banner'));
        $show->field('faq_banner', __('Faq banner'));
        $show->field('sitemap_banner', __('Sitemap banner'));
        $show->field('media_banner', __('Media banner'));
        $show->field('services_banner', __('Services banner'));
        $show->field('special_offers_banner', __('Special offers banner'));
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
        $form = new Form(new Setting);

        $form->text('contact_us_banner', __('Contact us banner'));
        $form->text('faq_banner', __('Faq banner'));
        $form->text('sitemap_banner', __('Sitemap banner'));
        $form->text('media_banner', __('Media banner'));
        $form->text('services_banner', __('Services banner'));
        $form->text('special_offers_banner', __('Special offers banner'));

        return $form;
    }
}
