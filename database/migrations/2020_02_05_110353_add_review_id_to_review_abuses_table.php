<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewIdToReviewAbusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();
        Schema::table('review_abuses', function (Blueprint $table) use ($driver) {

            if ('sqlite' === $driver) {
                $table->unsignedBigInteger('review_id')->after('id')->default('');
                $table->foreign('review_id')
                    ->references('id')->on('reviews')
                    ->onDelete('cascade');
            } else {
                $table->unsignedBigInteger('review_id')->after('id');
                $table->foreign('review_id')
                    ->references('id')->on('reviews')
                    ->onDelete('cascade');
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
        Schema::table('review_abuses', function (Blueprint $table) {
            $table->dropForeign('review_abuses_review_id_foreign');
            $table->dropColumn('review_id');
        });
    }
}
