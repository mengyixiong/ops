<?php

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
        Schema::create('generate_records', function (Blueprint $table) {
            $table->id();
            $table->string('table_name')->unique()->comment('表名');
            $table->string('controller')->comment('生成的控制器路径');
            $table->string('logic')->comment('生成的逻辑类路径');
            $table->string('add_request')->comment('生成的add_request路径');
            $table->string('update_request')->comment('生成的update_request路径');
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
