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
        Schema::create('fin_voucher_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('voucher_id')->comment('凭证Id');
            $table->unsignedBigInteger('com_id')->comment('主体ID');
            $table->date('billing_date')->comment('记账日期');
            $table->string('ref')->comment('摘要');
            $table->string('subject',32)->comment('明细科目');
            $table->string('subject_code',32)->comment('明细科目代码');
            $table->decimal('dn', 15)->nullable()->comment('借方金额');
            $table->decimal('cn', 15)->nullable()->comment('代码金额');

            $table->enum('is_foreign', array_keys(GlobalConstant::YES_NO))->default(GlobalConstant::NO)->comment('外币');
            $table->string('foreign_currency', 4)->nullable()->comment('外币');
            $table->decimal('foreign_cost', 15)->nullable()->comment('外币金额');
            $table->decimal('foreign_rate', 7, 4)->nullable()->comment('外币汇率');

            $table->string('level_one', 20)->nullable()->comment('一级代码');
            $table->string('level_two', 20)->nullable()->comment('二级代码');
            $table->string('level_three', 20)->nullable()->comment('三级代码');
            $table->string('level_four', 20)->nullable()->comment('四级代码');

            $table->string('vendor', 20)->nullable()->comment('往来单位');
            $table->string('clerk', 20)->nullable()->comment('员工');
            $table->string('team', 20)->nullable()->comment('部门');
            $table->string('branch', 20)->nullable()->comment('分公司');

            $table->comment('凭证明细表');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_voucher_details');
    }
};
