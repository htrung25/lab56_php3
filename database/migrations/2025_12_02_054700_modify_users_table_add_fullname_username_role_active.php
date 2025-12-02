<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Thêm các cột mới trước
            $table->string('fullname')->after('name');           // Họ tên
            $table->string('username')->unique()->after('fullname'); // Tên đăng nhập, duy nhất
            $table->string('avatar')->nullable()->after('password'); // Ảnh đại diện
            $table->enum('role', ['admin', 'user'])->default('user')->after('avatar');
            $table->boolean('active')->default(1)->after('role');

            // 2. Xóa các cột cũ không dùng nữa (name, email_verified_at, remember_token)
            $table->dropColumn(['name', 'email_verified_at', 'remember_token']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hoàn nguyên lại cấu trúc cũ của Laravel
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();

            // Xóa các cột mình vừa thêm
            $table->dropColumn(['fullname', 'username', 'avatar', 'role', 'active']);
        });
    }
};