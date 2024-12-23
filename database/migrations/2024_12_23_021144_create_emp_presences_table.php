<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emp_presences', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('employee_id');
        $table->dateTime('check_in');
        $table->dateTime('check_out');
        $table->integer('late_in');
        $table->integer('early_out');
        $table->timestamps();

        $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_presences');
    }
};
