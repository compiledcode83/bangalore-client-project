<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactAttributeToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('cantry_en')->nullable()->after('id');
            $table->string('cantry_ar')->nullable()->after('id');

            $table->string('city_en')->nullable()->after('id');
            $table->string('city_ar')->nullable()->after('id');

            $table->string('area_en')->nullable()->after('id');
            $table->string('area_ar')->nullable()->after('id');

            $table->string('street_en')->nullable()->after('id');
            $table->string('street_ar')->nullable()->after('id');

            $table->string('building_en')->nullable()->after('id');
            $table->string('building_ar')->nullable()->after('id');

            $table->string('lat')->nullable()->after('id');
            $table->string('lng')->nullable()->after('id');

            $table->string('tel')->nullable()->after('id');
            $table->string('fax')->nullable()->after('id');

            $table->string('email')->nullable()->after('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('cantry_en');
            $table->dropColumn('cantry_ar');
            $table->dropColumn('city_en');
            $table->dropColumn('city_ar');
            $table->dropColumn('area_en');
            $table->dropColumn('area_ar');
            $table->dropColumn('street_en');
            $table->dropColumn('street_ar');
            $table->dropColumn('building_en');
            $table->dropColumn('building_ar');
            $table->dropColumn('lat');
            $table->dropColumn('lng');
            $table->dropColumn('tel');
            $table->dropColumn('fax');
            $table->dropColumn('email');
        });
    }
}
