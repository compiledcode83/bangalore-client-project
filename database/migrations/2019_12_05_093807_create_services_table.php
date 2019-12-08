<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_services', function (Blueprint $table) {
            $table->increments('id');

            $table->tinyInteger('type')->comment('1 ==> media, 2 ==> services');

            $table->string('title_en');
            $table->string('title_ar');

            $table->text('short_description_en');
            $table->text('short_description_ar');

            $table->text('full_description_en');
            $table->text('full_description_ar');

            $table->string('image');

            $table->tinyInteger('is_active')->default('1');

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
        Schema::dropIfExists('services');
    }
}
