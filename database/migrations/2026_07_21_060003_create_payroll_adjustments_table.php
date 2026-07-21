<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_run_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payroll_component_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type'); // earning, deduction
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('IDR');
            $table->text('reason')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('status')->default('active');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_adjustments');
    }
};
