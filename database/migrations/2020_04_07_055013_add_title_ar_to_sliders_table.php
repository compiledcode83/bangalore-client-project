<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleArToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
//            remove old titles
            $table->dropColumn('sub_title');
            $table->dropColumn('title');

            $table->string('sub_title_ar')->after('id')->nullable();
            $table->string('sub_title_en')->after('id')->nullable();
            $table->string('title_ar')->after('id')->nullable();
            $table->string('title_en')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            //go back to old version

            $table->string('sub_title')->after('id')->nullable();
            $table->string('title')->after('id')->nullable();

            $table->dropColumn('sub_title_ar');
            $table->dropColumn('sub_title_en');
            $table->dropColumn('title_ar');
            $table->dropColumn('title_en');
        });
    }
}
