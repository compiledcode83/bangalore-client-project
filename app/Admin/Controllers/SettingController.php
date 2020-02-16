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
//    public function index(Content $content)
//    {
//        return redirect()->route('admin.updateSettings', '1');
//    }

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function updateSettings($id, Content $content)
    {
//        $settings = Setting::find(1);
//        if(!$settings)
//        {
//            return $content
//                ->header($this->title)
//                ->body($this->form());
//        }

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
//            $grid = new Grid(new Setting);
//
//            $grid->column('id', __('Id'));
//            $grid->column('contact_us_banner', __('Contact us banner'));
//            $grid->column('faq_banner', __('Faq banner'));
//            $grid->column('sitemap_banner', __('Sitemap banner'));
//            $grid->column('media_banner', __('Media banner'));
//            $grid->column('services_banner', __('Services banner'));
//            $grid->column('special_offers_banner', __('Special offers banner'));
//            $grid->column('created_at', __('Created at'));
//            $grid->column('updated_at', __('Updated at'));
//            $grid->column('deleted_at', __('Deleted at'));
//
//            return $grid;
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

        $form
            ->tab('General', function ($form) {
            $form->text('header_phone', __('Header Phone'));
            })
            ->tab('Banners', function ($form) {
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
