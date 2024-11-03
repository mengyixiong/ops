<?php

use App\Enums\FinanceConstant;
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
        Schema::create('fin_currency_rates', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->unique()->comment('币种名称');
            $table->unsignedBigInteger('com_id')->comment('主体ID');
            $table->decimal('rate',10,4)->comment('汇率');
            $table->date('effective_date')->comment('生效日期');
            $table->enum('type',array_keys(FinanceConstant::RATE_TYPE))->default(FinanceConstant::SETTLEMENT_RATE)->comment('汇率类型');
            $table->enum('is_enable',array_keys(GlobalConstant::YES_NO))->default(GlobalConstant::YES)->comment('生效');
            $table->string('remark',255)->nullable()->comment('备注');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_currency_rates');
    }
};
