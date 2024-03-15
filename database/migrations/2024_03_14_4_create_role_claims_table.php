<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_claims', function (Blueprint $table) {
            // Primary key
            $table->id();
            // Attribute
            $table->string('claim_type');
            $table->string('claim_value');
            $table->timestamps();
            // Refs
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_claims');
    }
}
