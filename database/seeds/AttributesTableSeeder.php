<?php

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('attributes')->truncate();
        DB::table('attribute_values')->truncate();

        // Create Color attribute and multiple values
        factory(App\Models\Attribute::class)->create([
            'name_en' => 'color',
            'name_ar' => 'اللون',
        ])->attributeValues()->saveMany(factory(App\Models\AttributeValue::class, 5)->make());

        $this->command->info('Attributes & Attribute Values Records Seeded!');
    }
}
