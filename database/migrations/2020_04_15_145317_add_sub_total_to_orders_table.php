<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubTotalToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
        Schema::table('orders', function (Blueprint $table) use($driver) {
            if ('sqlite' === $driver)
            {
                $table->decimal('delivery_charges', 8,3)->default('')->after('total');
                $table->decimal('total_discount', 8,3)->default('')->after('total');
                $table->decimal('sub_total', 8,3)->default('')->after('total');
            }
            else
            {
                $table->decimal('delivery_charges', 8,3)->after('total');
                $table->decimal('total_discount', 8,3)->after('total');
                $table->decimal('sub_total', 8,3)->after('total');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('sub_total');
            $table->dropColumn('total_discount');
            $table->dropColumn('delivery_charges');
        });
    }
}
