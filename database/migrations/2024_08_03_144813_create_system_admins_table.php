<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_admins', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->comment('用户名')->unique();
            $table->string('nickname', 50)->comment('昵称')->unique();
            $table->string('password', 100)->comment('管理员密码');
            $table->enum('is_enable', ['Y', 'N'])->default('Y')->comment('是否启用,Y是,N否');
            $table->enum('is_super_admin', ['Y', 'N'])->default('N')->comment('是否超级管理员,Y是,N否');
            $table->bigInteger('current_com_id')->comment('当前主体ID');
            $table->string('avatar')->comment('管理员头像');
            $table->string('email', 50)->comment('管理员邮箱')->unique();
            $table->string('phone', 20)->nullable()->comment('管理员手机')->unique();
            $table->timestamp('last_login_at')->nullable()->comment('最后一次登录时间');
            $table->string('last_login_ip', 16)->nullable()->comment('最后一次登录IP');
            $table->bigInteger('created_by')->comment('创建人');
            $table->bigInteger('updated_by')->comment('更新人');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_admins');
    }
};
