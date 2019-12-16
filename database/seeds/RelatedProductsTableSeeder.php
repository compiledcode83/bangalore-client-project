<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class RelatedProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'related_products' )->truncate();

        $products = Product::all();

        foreach ($products as $product)
        {
            // create related products for each one
            $product->relatedProducts()->saveMany(
                factory( App\Models\RelatedProduct::class, 3 )->make()
            );
        }

        $this->command->info( 'Related Products Seeded!' );
    }
}
