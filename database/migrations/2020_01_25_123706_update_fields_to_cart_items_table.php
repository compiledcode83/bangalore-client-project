<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->tinyInteger('is_print_accepted')->after('product_attribute_value_id')->default(0);
            $table->string('print_image')->after('product_attribute_value_id')->nullable();
            $table->decimal('unit_price', 8,3)->after('product_attribute_value_id')->nullable();
            $table->string('color_name')->after('product_attribute_value_id')->nullable();
            $table->integer('qty')->after('product_attribute_value_id')->nullable();
            $table->string('item_image')->after('product_attribute_value_id')->nullable();
            $table->string('item_name')->after('product_attribute_value_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('is_print_accepted');
            $table->dropColumn('print_image');
            $table->dropColumn('unit_price');
            $table->dropColumn('color_name');
            $table->dropColumn('qty');
            $table->dropColumn('item_image');
            $table->dropColumn('item_name');
        });
    }
}
