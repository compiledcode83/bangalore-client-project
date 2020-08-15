<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNumberOfDaysNewBadgeToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
        Schema::table('settings', function (Blueprint $table) use ($driver) {
            if ('sqlite' === $driver)
            {
                $table->string('number_of_days_for_new_badge')->after('id')->default('');
            }
            else
            {
                $table->string('number_of_days_for_new_badge')->after('id');
            }

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
            $table->dropColumn('number_of_days_for_new_badge');
        });
    }
}
