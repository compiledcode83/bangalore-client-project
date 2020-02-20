<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->tinyInteger('is_default_billing')->after('user_id')->nullable();
            $table->tinyInteger('is_default_shipping')->after('user_id')->nullable();
            $table->tinyInteger('type')->comment('shipping => 1, billing => 2')->after('user_id')->default('1');

            $table->dropColumn('country', 'city', 'avenue', 'apartment');

            $table->string('governorate')->nullable()->after('is_default_billing');
            $table->string('office_address')->nullable()->after('floor');
            $table->string('office_number')->nullable()->after('floor');
            $table->string('house_number')->nullable()->after('floor');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropColumn('is_default_shipping', 'is_default_billing', 'type');

            $table->string('country');
            $table->string('city');
            $table->string('avenue')->nullable();
            $table->string('apartment')->nullable();

            $table->dropColumn('governorate', 'office_address', 'office_number', 'house_number');
        });
    }
}
