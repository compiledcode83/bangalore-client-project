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
            $form->switch('enable_offers_page', __('Enable Offers Page'))->default(0);
            $form->text('header_phone', __('Header Phone'));
            })->tab('Banners', function ($form) {
                $form->image('contact_us_banner', __('Contact us banner'))->rules( 'required' )->required();
                $form->image('faq_banner', __('Faq banner'))->rules( 'required' )->required();
                $form->image('sitemap_banner', __('Sitemap banner'))->rules( 'required' )->required();
                $form->image('media_banner', __('Media banner'))->required();
                $form->image('services_banner', __('Services banner'))->rules( 'required' )->required();
                $form->image('special_offers_banner', __('Special offers banner'))->rules( 'required' )->required();
                $form->image('account_banner', __('User Account Banner'))->rules( 'required' )->required();
            })->tab('Contact', function ($form) {
                $form->image('contact_img', __('Contact Banner'))->move('pages')->uniqueName()->rules( 'required' )->required();
                $form->email('email', __('Contact Email'));
                $form->text('tel', __('Contact Phone'))->icon('fa-phone');
                $form->text('fax', __('Contact Fax'))->icon('fa-fax');
                $form->text('cantry_en', __('Contact Cantry en'));
                $form->text('cantry_ar', __('Contact Cantry ar'));
                $form->text('city_en', __('Contact City en'));
                $form->text('city_ar', __('Contact City ar'));
                $form->text('area_en', __('Contact Area en'));
                $form->text('area_ar', __('Contact Area ar'));
                $form->text('street_en', __('Contact Street en'));
                $form->text('street_ar', __('Contact Street ar'));
                $form->text('building_en', __('Contact Building en'));
                $form->text('building_ar', __('Contact Building ar'));
                $form->latlong('lat', 'lng', 'Position');
            })->tab('About', function ($form) {
                $form->image('about_img', __('About Banner'))->move('pages')->uniqueName()->rules( 'required' );
                $form->ckeditor('about_description_en', __('Body en'))->rules( 'required' );
                $form->ckeditor('about_description_ar', __('Body ar'))->rules( 'required' );
            })->tab('Our Client', function ($form) {
                $form->image('client_img', __('Client Banner'))->move('pages')->uniqueName()->rules( 'required' );
                $form->ckeditor('client_description_en', __('Body en'))->rules( 'required' );
                $form->ckeditor('client_description_ar', __('Body ar'))->rules( 'required' );
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
