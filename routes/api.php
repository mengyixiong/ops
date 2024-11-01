<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Finance\AccountSubjectController;
use App\Http\Controllers\Finance\CostItemController;
use App\Http\Controllers\Finance\CurrencyController;
use App\Http\Controllers\Finance\SubjectController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\System\CompanyController;
use App\Http\Controllers\System\MenuController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\AdminController;
use App\Http\Controllers\Tool\GenerateRecordController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::post('/gen',[GenerateController::class,'generate']);
Route::post('/del/{table_name}',[GenerateController::class,'del']);

# 授权相关路由
Route::group([
    'prefix' => 'auth',
    'as'     => 'auth.',
], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');
        Route::get('/get_user_routes', [AuthController::class, 'getUserRoutes'])->name('get_user_routes');
        Route::get('/is_route_exist', [AuthController::class, 'isRouteExist'])->name('is_route_exist');
        Route::post('/change_company', [AuthController::class, 'changeCompany'])->name('change_company');
    });
});

# 上传文件
Route::group([
    'prefix' => 'upload',
    'as'     => 'upload.',
], function () {
    Route::post('/upload_avatar', [UploadController::class, 'uploadAvatar'])->name('upload_avatar');
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
        Route::get('/company/get_all_companies', [CompanyController::class, 'getAllCompanies'])->name('role.get-all-companies');
        Route::apiResource('/company', CompanyController::class);

        # 角色
        Route::post('/role/assign_permission/{role}', [RoleController::class, 'assignPermission'])->name('role.assign-permission');
        Route::get('/role/get_all_roles', [RoleController::class, 'getAllRoles'])->name('role.get-roles');
        Route::apiResource('/role', RoleController::class);

        # 菜单/权限
        Route::get('/menu/get_menus_and_permissions', [MenuController::class, 'getMenusAndPermissions'])->name('role.get-menus-and-permissions');
        Route::get('/menu/get_all_menus', [MenuController::class, 'getAllMenus'])->name('role.get-all-menus');
        Route::apiResource('/menu', MenuController::class);
    });


    # 财务模块
    Route::group([
        'prefix' => 'finance',
        'as'     => 'finance.',
    ], function () {
        # 会计科目
        Route::get('/accountSubject/operateInitData', [AccountSubjectController::class,'operateInitData'])->name('accountSubject.operateInitData');
        Route::apiResource('/accountSubject', AccountSubjectController::class);
        # 币种
        Route::apiResource('/currency', CurrencyController::class);
        Route::apiResource('/costItem',CostItemController::class);
    });

    # 工具模块
    Route::group([
        'prefix' => 'tool',
        'as'     => 'tool.',
    ], function () {
        Route::apiResource('/generateRecord', GenerateRecordController::class);
    });
});


