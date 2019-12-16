<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class WishListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'wish_lists' )->truncate();

        $users = User::all();

        foreach ($users as $user)
        {
            // create user wish list
            $user->wishLists()->saveMany(
                factory( App\Models\Wishlist::class, 3 )->make()
            );
        }

        $this->command->info( 'Wish Lists Seeded!' );
    }
}
