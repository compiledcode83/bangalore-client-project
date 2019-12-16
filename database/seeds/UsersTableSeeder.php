<?php

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('user_addresses')->truncate();

        // Create default user
        factory(User::class)->create([
            'email' => 'test@test.com',
        ])->userAddresses()->saveMany(factory(UserAddress::class, 5)->make());

        // Create 10 dummy user accounts
        factory(User::class, 10)->create()
            ->each(function ($user) {
                $user->userAddresses()->saveMany(factory(UserAddress::class, 5)->make());
            });

        // Create 10 dummy corporate accounts
        factory(User::class, 10)->create(['type' => User::TYPE_CORPORATE])
            ->each(function ($user) {
                $user->userAddresses()->saveMany(factory(UserAddress::class, 5)->make());
            });


        $this->command->info('Users & User Address Records Seeded!');
    }
}
