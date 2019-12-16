<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AttributesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(RelatedProductsTableSeeder::class);
        $this->call(ProductsAttributeImagesTableSeeder::class);
        $this->call(WishListsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(CartsTableSeeder::class);
    }
}
