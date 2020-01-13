<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomepageSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->increments('id');

            $table->string('type')->comment('new_arrivals, special_offers');
            $table->string('title_en');
            $table->string('title_ar');
            $table->string('image');
            $table->string('link');
            $table->string('item_location')->comment('right, left or middle');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homepage_sections');
    }
}
