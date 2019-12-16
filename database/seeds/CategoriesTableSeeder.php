<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('categories')->truncate();

        // Create 2 root categories with no Sub
        factory(App\Models\Category::class)->create([
            'name_en' => 'Shoes',
            'name_ar' => 'Bags',
        ]);

        // Create 10 categories with 2-6 subs
        factory(App\Models\Category::class, 10)->create()
            ->each(function ($category) {
                $randomNumber = mt_rand(2,6);
                $category->subCategories()->saveMany(factory(App\Models\Category::class, $randomNumber)->make());
            });


        $this->command->info('Categories & SubCategories Records Seeded!');
    }
}
