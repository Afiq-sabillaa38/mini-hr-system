<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->string('month');
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->integer('unpaid_leave_days')->default(0);
            $table->decimal('unpaid_leave_deduction', 10, 2)->default(0);
            $table->integer('late_minutes')->default(0);
            $table->integer('chargeable_late_minutes')->default(0);
            $table->decimal('late_deduction', 10, 2)->default(0);
            $table->decimal('other_deductions', 10, 2)->default(0);
            $table->decimal('epf', 10, 2)->default(0);
            $table->decimal('socso', 10, 2)->default(0);
            $table->decimal('eis', 10, 2)->default(0);
            $table->decimal('total_deductions', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['employee_id', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};