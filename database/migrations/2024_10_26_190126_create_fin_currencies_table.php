<?php

use App\Enums\GlobalConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fin_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->unique()->comment('币种名称');
            $table->string('cn_name',20)->comment('中文名称');
            $table->string('en_name',20)->comment('英文名称');
            $table->string('symbol', 10)->comment('币种符号');
            $table->enum('is_enable',array_keys(GlobalConstant::YES_NO))->default('Y')->comment('是否启用');
            $table->timestamps();
            $table->comment('币种表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_currencies');
    }
};
