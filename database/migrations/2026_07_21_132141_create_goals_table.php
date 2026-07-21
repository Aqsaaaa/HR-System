<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cycle_id')->nullable()->constrained('performance_cycles')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('key_results')->nullable();
            $table->decimal('weight', 5, 2)->default(0);
            $table->decimal('progress', 5, 2)->default(0);
            $table->string('status')->default('draft');
            $table->date('due_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
