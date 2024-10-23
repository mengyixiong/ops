<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\System\CompanyController;
use App\Http\Controllers\System\MenuController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\AdminController;
use Illuminate\Support\Facades\Route;

# 授权相关路由
Route::group([
    'prefix' => 'auth',
    'as'     => 'auth.',
], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware(['auth:sanctum', 'permission'])->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::get('/get_user_routes', [AuthController::class, 'getUserRoutes'])->name('get_user_routes');
        Route::get('/is_route_exist', [AuthController::class, 'isRouteExist'])->name('is_route_exist');
        Route::post('/change_company', [AuthController::class, 'changeCompany'])->name('change_company');
    });
});


# 需要认证的路由
Route::middleware(['auth:sanctum', 'permission'])->group(function () {

    # 系统管理
    Route::group([
        'prefix' => 'system',
        'as'     => 'system.',
    ], function () {
        # 管理员
        Route::apiResource('/admin', AdminController::class);

        # 主体
        Route::apiResource('/company', CompanyController::class);

        # 角色
        Route::post('/role/assign_permission/{role}', [RoleController::class, 'assignPermission'])->name('role.assign-permission');
        Route::get('/role/get_all_roles', [RoleController::class, 'getAllRoles'])->name('role.get-roles');
        Route::apiResource('/role', RoleController::class);

        # 菜单/权限
        Route::get('/menu/get_all_menus', [MenuController::class, 'getAllMenus'])->name('role.get-all-menus');
        Route::apiResource('/menu', MenuController::class);
    });
});


