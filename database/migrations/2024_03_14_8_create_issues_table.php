<?php

use App\Common\Enums\Priority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Foreign keys
            $table->unsignedBigInteger('assignee_id')->nullable();
            $table->unsignedBigInteger('reporter_id')->nullable();
            $table->unsignedBigInteger('parent_issue_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            // Attribute
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->float('remaining_time')->nullable();
            $table->enum('priority', Priority::toArray())->default(Priority::MEDIUM);
            $table->timestamps();
            // Refs
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreign('assignee_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
            $table->foreign('reporter_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
            $table->foreign('parent_issue_id')
                ->references('id')
                ->on('issues')
                ->nullOnDelete();
            $table->foreignId('issue_type_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreign('status_id')
                ->references('id')
                ->on('work_flow_steps')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
