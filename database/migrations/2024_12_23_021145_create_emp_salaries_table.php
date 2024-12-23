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
        Schema::create('emp_salaries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
        $table->integer('month');
        $table->integer('year');
        $table->double('basic_salary', 15, 2);
        $table->double('bonus', 15, 2)->nullable();
        $table->double('bpjs', 15, 2)->nullable();
        $table->double('jp', 15, 2)->nullable();
        $table->double('loan', 15, 2)->nullable();
        $table->double('total_salary', 15, 2);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_salaries');
    }
};
