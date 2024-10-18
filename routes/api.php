<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\System\CompanyController;
use App\Http\Controllers\System\MenuController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\AdminController;
use Illuminate\Support\Facades\Route;

# 授权相关路由
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});


# 需要认证的路由
Route::middleware('auth:sanctum')->group(function () {

    # 系统管理
    Route::group(['prefix' => 'system'], function () {
        Route::apiResource('/admin', AdminController::class);
        Route::apiResource('/company', CompanyController::class);
        Route::apiResource('/role', RoleController::class);
        Route::post('/assign_permission/{role}', [RoleController::class, 'assignPermission']);
        Route::apiResource('/menu', MenuController::class);
    });
});


