<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\ProductAttributes;
use App\Admin\Forms\ProductDetails;
use App\Admin\Forms\ProductMainImages;
use App\Admin\Forms\ProductPrices;
use App\Admin\Forms\ProductRelated;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductController extends AdminController {

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';


    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
             ->title('Product Details')
            ->body($this->detail($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid( new Product );

        $grid->filter( function ( $filter ) {

            // Add Name filter
            $filter->like( 'name_en', 'Name' );

            // Add Status filter
            $filter->equal( 'is_active', 'Status' )->radio( [
                '' => 'All',
                0  => 'Not Active',
                1  => 'Active',
            ] );

        } );

        $grid->model()->orderBy('id', 'desc');

        $grid->column( 'id', __( 'Id' ) );
        $grid->column( 'name_en', __( 'Name' ) );
        $grid->column( 'sku', __( 'Sku' ) );
        $grid->column( 'main_image', __( 'Main image' ) )->image( '', 200, 100 );
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label( [
                0 => 'danger',
                1 => 'success',
            ] )->sortable();
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
    protected function detail( $id )
    {
        $show = new Show( Product::findOrFail( $id ) );

        $show->field( 'name_en', __( 'Name en' ) );
        $show->field( 'name_ar', __( 'Name ar' ) );
        $show->field( 'description_en', __( 'Description en' ) )->as(function($content){
            return strip_tags($content);
        });
        $show->field( 'description_ar', __( 'Description ar' ) )->as(function($content){
            return strip_tags($content);
        });
        $show->field( 'sku', __( 'Sku' ) );
        $show->field( 'main_image', __( 'Main image' ) )->image();
        $show->is_active(__('Status'))
            ->using(['0' => 'Not-Active', '1' => 'Active']);
        $show->field( 'created_at', __( 'Created at' ) );

        $show->panel()
            ->tools(function ($tools) {
                $tools->disableDelete();
            });

        $show->categories(__('Categories'), function ($category) {

            $category->setResource('/admin/categories');
            $category->name_en();
            $category->created_at();

            $category->disableActions();
            $category->disableCreateButton();
            $category->disableExport();
            $category->filter(function ($filter) {
                $filter->like('name_en');
            });
        });

        $show->prices(__('Product Prices'), function ($category) {

            $category->setResource('/admin/prices');
            $category->supplier_price(__('Supplier Price'));
            $category->max_qty(__('Max Quantity'));
            $category->individual_unit_price(__('Individual Unit Price'));
            $category->individual_discounted_unit_price(__('Discount Individual Unit Price'));
            $category->corporate_unit_price(__('Corporate Unit Price'));
            $category->corporate_discounted_unit_price(__('Discount Corporate Unit Price'));
            $category->created_at();

            $category->disableActions();
            $category->disableCreateButton();
            $category->disableExport();
            $category->filter(function ($filter) {
                $filter->like('max_qty');
            });
        });

        $show->productAttributeValues(__('Product Attribute'), function ($attribute) {

            $attribute->setResource('/admin/productAttributeValues');
            $attribute->attributeValue()->value_en(__('Color Name'));
            $attribute->main_images(__('Main imagess'))->image( '', 100, 50 );
            $attribute->sku(__('SKU'));
            $attribute->stock(__('Stock'));
            $attribute->is_active(__('Status'))
                ->using(['0' => 'Not-Active', '1' => 'Active']);
            $attribute->created_at();

            $attribute->disableActions();
            $attribute->disableCreateButton();
            $attribute->disableExport();
            $attribute->filter(function ($filter) {
                $filter->like('name_en');
            });
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @param  $id
     * @return Form
     */
    protected function form($id = null)
    {
        $form = new Form( new Product );

        $form->tab( 'Product Details', function ( $form ) {

            $form->text( 'name_en', 'English Name' )->rules( 'required' );
            $form->text( 'name_ar', 'Arabic Name' )->rules( 'required' );

            $form->ckeditor( 'short_description_en', 'English Short Description' );
            $form->ckeditor( 'short_description_ar', 'Arabic Short Description' );
            $form->ckeditor( 'description_en', 'English Full Description' )->rules( 'required' );
            $form->ckeditor( 'description_ar', 'Arabic Full Description' )->rules( 'required' );
            $form->ckeditor( 'more_information_en', 'English More Information' );
            $form->ckeditor( 'more_information_ar', 'Arabic More Information' );

            $form->text( 'sku', 'SKU' )
                ->creationRules('required|unique:product_attribute_values,sku|unique:products,sku' )
                ->updateRules( 'required|unique:product_attribute_values,sku|unique:products,sku,{{id}}' )
                ->help( 'Product unique identifier!' );
            $form->text( 'supplier_price', 'Supplier price' )->rules( 'required' )->help( 'Only Admin can see this price!' );
            $form->image( 'main_image', 'Main Image' )->rules( 'required' );
            $form->switch( 'is_active', __( 'Is active' ) )->default( 1 );
            $form->switch( 'show_left_qty', __( 'Show Left Qty to users' ) )->default( 0 );

            $categories = Category::all()->pluck('name_en', 'id');
            $form->multipleSelect('categories')->options($categories);

            //fix it by fixing db and migrations & seeds
            $form->multipleImage( 'main_gallery' , 'Main Gallery')->removable();

            $products = Product::all()->pluck('name_en', 'id');
            $form->multipleSelect('related', 'Related Products')->options($products);

        } )->tab( 'Prices', function ( $form ) {

            $form->hasMany( 'prices', 'Prices', function ( $form ) {
                $form->text( 'max_qty', 'qty' )->rules( 'required' );
                $form->text( 'individual_unit_price', 'Individual Unit Price' )->rules( 'required' );
                $form->text( 'individual_discounted_unit_price', 'Individual Discounted Unit Price' )
                        ->rules( 'required' )
                        ->help( 'Add 0 for No discount' );
                $form->text( 'corporate_unit_price', 'Corporate Unit Price' )->rules( 'required' );
                $form->text( 'corporate_discounted_unit_price', 'Corporate Discounted Unit Price' )
                    ->rules( 'required' )
                    ->help( 'Add 0 for No discount' );
            } );

        } );

        return $form;
    }
}
