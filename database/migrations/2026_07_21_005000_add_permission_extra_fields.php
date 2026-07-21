<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
            $table->string('module', 100)->nullable()->after('guard_name');
            $table->string('group_name', 100)->nullable()->after('module');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->string('description')->nullable()->after('name');
            $table->string('display_name')->nullable()->after('name');
            $table->boolean('is_system')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'module', 'group_name']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'is_system']);
        });
    }
};
