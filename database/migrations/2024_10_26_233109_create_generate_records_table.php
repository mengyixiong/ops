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
        Schema::create('generate_records', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->unique()->comment('表名');
            $table->string('controller')->comment('控制器');
            $table->string('logic')->comment('逻辑类');
            $table->string('add_request')->comment('添加验证');
            $table->string('update_request')->comment('更新验证');

            $table->string('index_vue')->comment('列表');
            $table->string('api_type')->comment('api类型');
            $table->string('search_form')->comment('搜索表单');
            $table->string('operate_drawer')->comment('操作表单');
            $table->string('lang_zh')->comment('中文语言');
            $table->string('service_api')->comment('服务api');
            $table->comment('生成记录');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_records');
    }
};
