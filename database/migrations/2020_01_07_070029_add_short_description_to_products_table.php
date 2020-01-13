<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShortDescriptionToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('short_description_en')->after('name_ar')->nullable();
            $table->string('short_description_ar')->after('name_ar')->nullable();
            $table->text('more_information_en')->after('description_ar')->nullable();
            $table->text('more_information_ar')->after('description_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('short_description_en');
            $table->dropColumn('short_description_ar');
            $table->dropColumn('more_information_en');
            $table->dropColumn('more_information_ar');
        });
    }
}
