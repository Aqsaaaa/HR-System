<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('name')->unique();
            $table->string('code', 20)->unique()->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('budget_currency', 3)->default('USD');
            $table->string('cost_center', 50)->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('parent_id');
            $table->index('manager_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
