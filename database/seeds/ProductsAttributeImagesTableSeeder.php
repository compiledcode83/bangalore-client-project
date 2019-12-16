<?php

use App\Models\ProductAttributeValue;
use Illuminate\Database\Seeder;

class ProductsAttributeImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'product_attribute_value_images' )->truncate();

        $attributeValues = ProductAttributeValue::all();

        foreach ($attributeValues as $attribute)
        {
            // create 5 images for each product attribute
            $attribute->attributeImages()->saveMany(
                factory( App\Models\ProductAttributeValueImage::class, 5 )->make()
            );
        }

        $this->command->info( 'Product Attribute Value Images Seeded!' );
    }
}
