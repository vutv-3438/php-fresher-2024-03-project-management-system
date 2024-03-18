<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_times', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Attribute
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('logged_time');
            $table->dateTime('logged_date')->default(now());
            $table->timestamps();
            // Refs
            $table->foreignId('issue_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_times');
    }
}
