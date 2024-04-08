<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextStepsAllowedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_steps_allowed', function (Blueprint $table) {
            $table->unsignedBigInteger('from_status_id');
            $table->unsignedBigInteger('to_status_id');
            $table->text('description')->nullable();
            $table->foreign('from_status_id')
                ->references('id')
                ->on('work_flow_steps')
                ->onDelete('cascade');
            $table->foreign('to_status_id')
                ->references('id')
                ->on('work_flow_steps')
                ->onDelete('cascade');
            $table->primary(['from_status_id', 'to_status_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('next_steps_allowed');
    }
}
