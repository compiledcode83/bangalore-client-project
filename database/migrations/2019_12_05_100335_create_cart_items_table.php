<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')
                ->references('id')->on('carts')
                ->onDelete('cascade');

            $table->unsignedBigInteger('product_attribute_value_id');
            $table->foreign('product_attribute_value_id')
                ->references('id')->on('product_attribute_values')
                ->onDelete('cascade');

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
        Schema::dropIfExists('cart_items');
    }
}
