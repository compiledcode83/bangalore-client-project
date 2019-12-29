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
            // ->title('title')
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

        $grid->column( 'id', __( 'Id' ) );
        $grid->column( 'name_en', __( 'Name' ) );
        $grid->column( 'description_en', __( 'Description' ) )->width( 500 );
        $grid->column( 'sku', __( 'Sku' ) );
        $grid->column( 'main_image', __( 'Main image' ) )->image( '', 200, 100 );
        $grid->column( 'is_active', __( 'Status' ) )
            ->using( ['0' => 'Not-Active', '1' => 'Active'] )
            ->label( [
                0 => 'danger',
                1 => 'success',
            ] )->sortable();
        $grid->column( 'created_at', __( 'Created' ) )->date( 'M d Y H:i' )->width( 150 )->sortable();

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

        $show->field( 'id', __( 'Id' ) );
        $show->field( 'name_en', __( 'Name en' ) );
        $show->field( 'name_ar', __( 'Name ar' ) );
        $show->field( 'description_en', __( 'Description en' ) );
        $show->field( 'description_ar', __( 'Description ar' ) );
        $show->field( 'sku', __( 'Sku' ) );
        $show->field( 'main_image', __( 'Main image' ) );
        $show->field( 'slug', __( 'Slug' ) );
        $show->field( 'is_active', __( 'Is active' ) );
        $show->field( 'created_at', __( 'Created at' ) );
        $show->field( 'updated_at', __( 'Updated at' ) );
        $show->field( 'deleted_at', __( 'Deleted at' ) );

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
            $form->textarea( 'description_en', 'English Description' )->rules( 'required' );
            $form->textarea( 'description_ar', 'Arabic Description' )->rules( 'required' );
            $form->text( 'sku', 'SKU' )->rules( 'required' )->help( 'Product unique identifier!' );
            $form->image( 'main_image', 'Main Image' )->rules( 'required' );
            $form->switch( 'is_active', __( 'Is active' ) )->default( 1 );

            $categories = Category::all()->pluck('name_en', 'id');
            $form->multipleSelect('categories')->options($categories);

            //fix it by fixing db and migrations & seeds
            $form->multipleImage( 'main_gallery' , 'Main Gallery')->removable();

            $products = Product::all()->pluck('name_en', 'id');
            $form->multipleSelect('related', 'Related Products')->options($products);

        } )->tab( 'Product Attributes', function ( $form ) {

            // z-song name convention
            $form->hasMany( 'productattributevalues', 'Product Attributes', function ( $form ) {

                $form->select( 'attribute_value_id', 'Color' )->options( function ( $id ) {
                    return AttributeValue::options($id);
                } );
                $form->text( 'sku', 'sku' )->rules( 'required' );
                $form->text( 'stock', 'stock' )->rules( 'required' );
                $form->switch( 'is_active', __( 'Is active' ) )->default( 1 );
                $form->multipleImage( 'main_imagess' , 'asasdasda images');
            } );

        } )->tab( 'Prices', function ( $form ) {

            $form->hasMany( 'prices', 'Prices', function ( $form ) {
                $form->text( 'max_qty', 'qty' )->rules( 'required' );
                $form->text( 'individual_unit_price', 'Individual Unit Price' )->rules( 'required' );
                $form->text( 'individual_discounted_unit_price', 'Individual Discounted Unit Price' )->rules( 'required' );
                $form->text( 'corporate_unit_price', 'Corporate Unit Price' )->rules( 'required' );
                $form->text( 'corporate_discounted_unit_price', 'Corporate Discounted Unit Price' )->rules( 'required' );
            } );

        } );

        return $form;
    }
}
