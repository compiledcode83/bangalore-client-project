<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class s extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function individual_can_view_products()
    {
        $product = factory(Product::class)->create();

        $this->get(route('product.show.details', $product->slug))
            ->assertStatus(200);
    }
}
