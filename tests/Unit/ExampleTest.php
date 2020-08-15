<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCategoryProducts extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_individual_can_view_products()
    {
        $product = factory(Product::class)->create();

        $this->visit('api/v1/products/'.$product->slug);
        $this->see($product->name_en);
//        dd($product->slug);
        $this->get('api/v1/products/'.$product->slug)
//            route('product.show.details', $product->slug))
            ->assertStatus(200);
    }
}
