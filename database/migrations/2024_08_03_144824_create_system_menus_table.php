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
            $table->tinyInteger('sort')->nullable()->comment('排序，升序');
            $table->string('i18n_key', 50)->nullable()->comment('语言包名称');
            $table->string('is_hide_menu', 50)->nullable()->comment('是否菜单显示,Y:是 N:否');
            $table->string('name', 50)->nullable()->comment('前端路由名称,type:1时必填');
            $table->string('path', 100)->nullable()->comment('菜单路径,type:1时必填');
            $table->string('component', 100)->nullable()->comment('组件名称,type:1时必填');
            $table->string('icon', 50)->nullable()->comment('菜单图标');
            $table->json('com_id')->comment('主体ID,不属于任何主体时为0')->nullable();
            $table->string('permission', 50)->nullable()->comment('菜单权限, type为2时必填');;
            $table->enum('type', ['1', '2'])->default('1')->comment('1: 菜单 2: 权限');
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
