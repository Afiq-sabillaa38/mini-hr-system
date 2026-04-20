<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Rename salary -> basic_salary only if salary exists
        if (Schema::hasColumn('users', 'salary') && !Schema::hasColumn('users', 'basic_salary')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('salary', 'basic_salary');
            });
        }

        // Add basic_salary if neither salary nor basic_salary exists
        if (!Schema::hasColumn('users', 'salary') && !Schema::hasColumn('users', 'basic_salary')) {
            Schema::table('users', function (Blueprint $table) {
                $table->decimal('basic_salary', 10, 2)->nullable();
            });
        }

        // Add join_date if missing
        if (!Schema::hasColumn('users', 'join_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('join_date')->nullable();
            });
        }

        // Drop department if it exists
        if (Schema::hasColumn('users', 'department')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('department');
            });
        }
    }

    public function down(): void
    {
        // Add department back if missing
        if (!Schema::hasColumn('users', 'department')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('department')->nullable();
            });
        }

        // Drop join_date if exists
        if (Schema::hasColumn('users', 'join_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('join_date');
            });
        }

        // Rename basic_salary back to salary if needed
        if (Schema::hasColumn('users', 'basic_salary') && !Schema::hasColumn('users', 'salary')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('basic_salary', 'salary');
            });
        }
    }
};