<?php

namespace App\Admin\Controllers;

use App\Models\Setting;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SettingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Settings';

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function updateSettings($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->body($this->form()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return redirect()->route('settings.edit', '1');
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Setting);

        $form->tab('General', function ($form) {
                $form->switch('individual_can_register', __('Enable Individuals To Register'))->default(0);
                $form->text('header_phone', __('Header Phone'));
            })->tab('Banners', function ($form) {
            $form->image('contact_us_banner', __('Contact us banner'));
            $form->image('faq_banner', __('Faq banner'));
            $form->image('sitemap_banner', __('Sitemap banner'));
            $form->image('media_banner', __('Media banner'));
            $form->image('services_banner', __('Services banner'));
            $form->image('special_offers_banner', __('Special offers banner'));
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableList();
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
