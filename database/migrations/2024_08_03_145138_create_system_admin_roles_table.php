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
        Schema::create('system_admin_roles', function (Blueprint $table) {
            $table->bigInteger('admin_id')->comment('管理员id');
            $table->bigInteger('role_id')->comment('角色id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_admin_roles');
    }
};
