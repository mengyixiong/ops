<?php

use App\Enums\GlobalConstant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fin_cost_items', function (Blueprint $table) {
            $table->id();
            $table->string('name',30)->comment('名称');
            $table->string('en_name',50)->nullable()->comment('英文名称');
            $table->string('code',5)->unique()->comment('代码');
            $table->enum('is_enable',array_keys(GlobalConstant::YES_NO))->default('Y')->comment('是否启用');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_cost_items');
    }
};
