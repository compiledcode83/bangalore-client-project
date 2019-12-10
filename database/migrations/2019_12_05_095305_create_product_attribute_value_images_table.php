<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeValueImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_value_images', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('product_attribute_value_id');
            $table->foreign('product_attribute_value_id', 'attribute_value_id_foreign')
                ->references('id')->on('product_attribute_values')
                ->onDelete('cascade');

            $table->string('image');

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
        Schema::dropIfExists('product_attribute_value_images');
    }
}
