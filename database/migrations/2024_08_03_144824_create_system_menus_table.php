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
        Schema::create('system_menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pid')->default(0)->comment('父级id');
            $table->string('title', 50)->comment('菜单名称');
            $table->string('name', 50)->nullable()->comment('前端路由名称,type:1时必填');
            $table->string('path', 100)->comment('菜单路径');
            $table->string('icon', 50)->nullable()->comment('菜单图标');
            $table->string('permission', 50)->comment('菜单权限');
            $table->enum('type', ['1', '2'])->default('1')->comment('1: 菜单 2: 按钮');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_menus');
    }
};
