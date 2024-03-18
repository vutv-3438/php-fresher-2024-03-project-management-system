<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('user_name');
            $table->string('avatar')->nullable();
            $table->string('phone_number')->unique();
            $table->tinyInteger('is_active')->default(true);
            $table->tinyInteger('is_admin')->default(false);
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
            $table->string('name');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('user_name');
            $table->dropColumn('avatar');
            $table->dropColumn('phone_number');
            $table->dropColumn('is_active');
            $table->dropColumn('is_admin');
        });
    }
}
