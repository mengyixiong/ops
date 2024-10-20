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
        Schema::create('system_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('主体名称');
            $table->char('is_default', 1)->default(GlobalConstant::NO)->comment('是否默认主体');
            $table->string('abb', 50)->nullable()->comment('主体简称');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_companies');
    }
};
