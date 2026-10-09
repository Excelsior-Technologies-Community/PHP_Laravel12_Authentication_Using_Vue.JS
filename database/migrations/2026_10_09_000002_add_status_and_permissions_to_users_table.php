<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('status', ['active', 'blocked'])->default('active')->after('role');
                $table->json('permissions')->nullable()->after('status');
                $table->string('block_reason')->nullable()->after('permissions');
            });
        }

        if (!Schema::hasColumn('login_activities', 'status')) {
            Schema::table('login_activities', function (Blueprint $table) {
                $table->string('status', 30)->default('success')->after('logout_time');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['status', 'permissions', 'block_reason']);
            });
        }

        if (Schema::hasColumn('login_activities', 'status')) {
            Schema::table('login_activities', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
