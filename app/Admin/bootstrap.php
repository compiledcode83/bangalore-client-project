<?php

/**
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Encore\Admin\Form;
use App\Admin\Extensions\Form\CKEditor;

Form::extend('ckeditor', CKEditor::class);
Encore\Admin\Form::forget(['map', 'editor']);

Admin::js('/vendor/chartjs/Chart.min.js');
Admin::js('/js/main.js');
