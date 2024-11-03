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
        $yesNoKeys = array_keys(GlobalConstant::YES_NO);
        Schema::create('fin_account_subjects', function (Blueprint $table) use ($yesNoKeys){
            $table->id();
            $table->unsignedBigInteger('pid')->default(GlobalConstant::ZERO)->comment('上一级，顶级为0');
            $table->enum('level',array_keys(FinanceConstant::LEVEL))->default(GlobalConstant::ONE)->comment('级别');
            $table->string('code', 32)->comment('代码');
            $table->string('abb', 32)->nullable()->comment('助记码');
            $table->string('cn_name', 32)->comment('中文名称');
            $table->string('en_name', 100)->nullable()->comment('英文名称');
            $table->enum('type', array_keys(FinanceConstant::SUBJECT_TYPE))->comment('科目类型');
            $table->enum('format', array_keys(FinanceConstant::FORMAT))->comment('账页格式');
            $table->string('currency',10)->default('CNY')->comment('核算比重');
            $table->unsignedBigInteger('com_id')->comment('主体ID');
            $table->enum('is_foreign',$yesNoKeys)->default(GlobalConstant::NO)->comment('外币核算');
            $table->enum('is_dn',$yesNoKeys)->default(GlobalConstant::YES)->comment('余额方向');
            $table->enum('is_frozen',$yesNoKeys)->default(GlobalConstant::NO)->comment('冻结');
            $table->enum('is_last',$yesNoKeys)->default(GlobalConstant::NO)->comment('末级科目');
            $table->enum('is_cash',$yesNoKeys)->default(GlobalConstant::NO)->comment('现金流');
            $table->decimal('balance', 18)->default(GlobalConstant::ZERO)->comment('期末余额');
            $table->decimal('foreign_balance', 18)->default(GlobalConstant::ZERO)->comment('外币余额，外币核算时有值');
            $table->decimal('opening_balance', 18)->default(GlobalConstant::ZERO)->comment('期初余额');
            $table->decimal('opening_foreign_balance', 18)->default(GlobalConstant::ZERO)->comment('外币期初余额');
            $table->decimal('year_opening_balance', 18)->default(GlobalConstant::ZERO)->comment('年期初余额');
            $table->decimal('year_opening_foreign_balance', 18)->default(GlobalConstant::ZERO)->comment('外币年期初余额');
            $table->enum('vendor_required',$yesNoKeys)->default(GlobalConstant::NO)->comment('往来单位必填');
            $table->enum('clerk_required',$yesNoKeys)->default(GlobalConstant::NO)->comment('员工必填');
            $table->enum('team_required',$yesNoKeys)->default(GlobalConstant::NO)->comment('部门必填');
            $table->enum('branch_required',$yesNoKeys)->default(GlobalConstant::NO)->comment('分公司必填');
            $table->timestamps();
            $table->comment('会计科目');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fin_account_subjects');
    }
};
