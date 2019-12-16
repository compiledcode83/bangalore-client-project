<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'orders' )->truncate();
        DB::table( 'order_status' )->truncate();

        factory( Order::class, 10 )->create()
            ->each( function ( $order ) {
                $order->orderItems()->saveMany( factory( App\Models\OrderItem::class, 3 )->make() );
                $order->orderStatuses()->saveMany( factory( App\Models\OrderStatus::class, 2 )->make() );
            } );

        $this->command->info( 'Orders, Items, Statuses Seeded!' );
    }
}
