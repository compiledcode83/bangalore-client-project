<?php

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement( 'SET FOREIGN_KEY_CHECKS=0' );
        DB::table( 'reviews' )->truncate();

        factory( Review::class, 10 )->create();

        $this->command->info( 'Reviews Seeded!' );
    }
}
