<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOurClientAttributeToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('client_description_en')->nullable()->after('id');
            $table->text('client_description_ar')->nullable()->after('id');
            $table->string('client_img')->nullable()->after('id');
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
            $table->dropColumn('client_description_en');
            $table->dropColumn('client_description_ar');
            $table->dropColumn('client_img');
        });
    }
}
