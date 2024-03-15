<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkFlowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_flow_steps', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Attribute
            $table->string('name');
            $table->unsignedSmallInteger('order');
            $table->text('description')->nullable();
            $table->timestamps();
            // Refs
            $table->foreignId('work_flow_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_flow_steps');
    }
}
