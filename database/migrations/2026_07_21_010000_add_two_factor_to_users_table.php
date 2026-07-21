<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id', 20)->unique()->nullable()->after('id');
            $table->string('avatar')->nullable()->after('email');
            $table->string('phone', 20)->nullable()->after('avatar');
            $table->string('timezone', 50)->default('UTC')->after('phone');
            $table->string('locale', 10)->default('en')->after('timezone');
            $table->text('two_factor_secret')->nullable()->after('remember_token');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
            $table->timestamp('two_factor_confirmed_at')->nullable()->after('two_factor_recovery_codes');
            $table->boolean('is_active')->default(true)->after('two_factor_confirmed_at');
            $table->boolean('must_change_password')->default(false)->after('is_active');
            $table->timestamp('password_changed_at')->nullable()->after('must_change_password');
            $table->timestamp('last_login_at')->nullable()->after('password_changed_at');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->softDeletes();

            $table->index('is_active');
            $table->index('employee_id');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->after('user_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'employee_id', 'avatar', 'phone', 'timezone', 'locale',
                'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at',
                'is_active', 'must_change_password', 'password_changed_at',
                'last_login_at', 'last_login_ip', 'deleted_at',
            ]);
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }
};
