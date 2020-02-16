<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_license')->after('last_name')->nullable();
            $table->string('job_title')->after('last_name')->nullable();
            $table->string('contact_person')->after('last_name')->nullable();
            $table->string('company')->after('last_name')->nullable();
            $table->tinyInteger('is_corporate_accepted')->after('is_active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_license');
            $table->dropColumn('job_title');
            $table->dropColumn('contact_person');
            $table->dropColumn('company');
            $table->dropColumn('is_corporate_accepted');
        });
    }
}
