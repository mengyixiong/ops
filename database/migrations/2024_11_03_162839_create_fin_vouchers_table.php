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
        Schema::create('fin_vouchers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('com_id')->comment('主体ID');
            $table->string('voucher_num',10)->comment('凭证号码');
            $table->date('billing_date')->comment('记账日期');
            $table->unsignedBigInteger('bookkeeper')->comment('记账人');
            $table->unsignedBigInteger('auditor')->nullable()->comment('审核人');
            $table->timestamp('audit_at')->nullable()->comment('审核时间');
            $table->unsignedBigInteger('cashier')->nullable()->comment('出纳');
            $table->unsignedBigInteger('make_people')->comment('制单人');
            $table->timestamp('make_at')->comment('制单时间');
            $table->decimal('dn_total',18)->comment('借方总额');
            $table->decimal('cn_total',18)->comment('贷方总额');
            $table->enum('is_effective',array_keys(GlobalConstant::YES_NO))->default(GlobalConstant::YES)->comment('有效');
            $table->enum('is_audit',array_keys(GlobalConstant::YES_NO))->default(GlobalConstant::NO)->comment('审核');
            $table->enum('is_foreign',array_keys(GlobalConstant::YES_NO))->default(GlobalConstant::NO)->comment('外币');
            $table->enum('is_recorded',array_keys(GlobalConstant::YES_NO))->default(GlobalConstant::NO)->comment('入账');
            $table->enum('type',array_keys(FinanceConstant::VOUCHER_TYPE))->comment('凭证类型');
            $table->text('remarks')->nullable()->comment('备注');
            $table->unsignedBigInteger('created_by')->comment('创建人');
            $table->unsignedBigInteger('updated_by')->comment('更新人');
            $table->timestamps();
            $table->comment('凭证表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_vouchers');
    }
};
