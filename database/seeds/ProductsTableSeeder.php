<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'products' )->truncate();
        DB::table( 'product_main_images' )->truncate();
        DB::table( 'product_prices' )->truncate();
        DB::table( 'product_attribute_values' )->truncate();

        // create products with no categories, no images
        factory( Product::class, 2 )->create()
            ->each( function ( $product ) {
                $product->prices()->saveMany( factory( App\Models\ProductPrice::class, 3 )->make() );
                $product->productAttributeValues()->saveMany( factory( App\Models\ProductAttributeValue::class, 2 )->make() );
            } );

        // create products with no categories
        factory( Product::class, 5 )->create()
            ->each( function ( $product ) {
                $product->productMainImages()->saveMany( factory( App\Models\ProductMainImage::class, 5 )->make() );
                $product->prices()->saveMany( factory( App\Models\ProductPrice::class, 2 )->make() );
                $product->productAttributeValues()->saveMany( factory( App\Models\ProductAttributeValue::class, 2 )->make() );
            } );

        $categories = Category::rootParent()->get();
        $children = Category::children()->get();

        foreach ($categories as $category)
        {
            // create products with root categories
            $category->products()->saveMany(
                factory( Product::class, 3 )->create()
                    ->each( function ( $product ) {
                        $product->productMainImages()->saveMany( factory( App\Models\ProductMainImage::class, 3 )->make() );
                        $product->prices()->saveMany( factory( App\Models\ProductPrice::class, 2 )->make() );
                        $product->productAttributeValues()->saveMany( factory( App\Models\ProductAttributeValue::class, 2 )->make() );
                    } )
            );
        }

        foreach ($children as $category)
        {
            // create products with children categories
            $category->products()->saveMany(
                factory( Product::class, 2 )->create()
                    ->each( function ( $product ) {
                        $product->productMainImages()->saveMany( factory( App\Models\ProductMainImage::class, 3 )->make() );
                        $product->prices()->saveMany( factory( App\Models\ProductPrice::class, 2 )->make() );
                        $product->productAttributeValues()->saveMany( factory( App\Models\ProductAttributeValue::class, 2 )->make() );
                    } )
            );
        }

        $this->command->info( 'Products, Prices, Main Images, Attribute Values Seeded!' );
    }
}
