<?php

use App\Models\Cart;
use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'carts' )->truncate();
        DB::table( 'cart_items' )->truncate();

        factory( Cart::class, 10 )->create()
            ->each( function ( $cart ) {
                $cart->cartItems()->saveMany( factory( App\Models\CartItem::class, 3 )->make() );
            } );

        $this->command->info( 'Carts, Cart Items Seeded!' );
    }
}
