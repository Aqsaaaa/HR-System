<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_runs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('period_type')->default('monthly');
            $table->integer('month');
            $table->integer('year');
            $table->date('period_start');
            $table->date('period_end');
            $table->date('payment_date')->nullable();
            $table->string('status')->default('draft');
            $table->decimal('total_gross', 15, 2)->default(0);
            $table->decimal('total_deductions', 15, 2)->default(0);
            $table->decimal('total_net', 15, 2)->default(0);
            $table->integer('total_employees')->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['period_type', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_runs');
    }
};
