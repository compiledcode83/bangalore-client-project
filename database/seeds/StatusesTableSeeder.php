<?php

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'statuses' )->truncate();

        // create statuses for orders
        factory( Status::class)->create([
            'name_en'   => 'pending',
            'name_ar'   => 'pending'
        ]);
        factory( Status::class)->create([
            'name_en'   => 'shipped',
            'name_ar'   => 'shipped'
        ]);
        factory( Status::class)->create([
            'name_en'   => 'delivered',
            'name_ar'   => 'delivered'
        ]);

        $this->command->info( 'Statuses Seeded!' );
    }
}
