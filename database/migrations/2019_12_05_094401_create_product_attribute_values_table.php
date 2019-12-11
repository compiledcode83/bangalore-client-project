<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeValuesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'product_attribute_values', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->unsignedBigInteger( 'product_id' );
            $table->foreign( 'product_id' )
                ->references( 'id' )->on( 'products' )
                ->onDelete( 'cascade' );

            $table->unsignedBigInteger( 'attribute_value_id' );
            $table->foreign( 'attribute_value_id' )
                ->references( 'id' )->on( 'attribute_values' )
                ->onDelete( 'cascade' );

            $table->string( 'sku' )->unique();
            $table->integer( 'stock' );

            $table->tinyInteger( 'is_active' )->default( '1' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'product_attribute_values' );
    }
}
