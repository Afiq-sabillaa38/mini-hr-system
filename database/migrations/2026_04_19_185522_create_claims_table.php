<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('claims', function (Blueprint $table) {
        $table->id();

        $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');

        $table->string('title');
        $table->decimal('amount', 10, 2);
        $table->string('category');
        $table->string('receipt_upload');

        $table->string('status')->default('Submitted');
        $table->text('remarks')->nullable();

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};