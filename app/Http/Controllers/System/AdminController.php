<?php

namespace App\Http\Controllers\System;

use App\Exceptions\ApiException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\System\Admin\AddRequest;
use App\Http\Requests\System\Admin\UpdateAdminRequest;
use App\Http\Requests\System\Admin\UpdateRequest;
use App\Models\SystemAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 后台用户管理控制器
 */
class AdminController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $data = SystemAdmin::query()
            ->leftJoin('system_companies as b', 'system_admins.current_com_id', '=', 'b.id')
            # 用户名查询
            ->when(!empty($request->username), function ($query) use ($request) {
                $query->where('username', 'like', '%' . $request->username . '%');
            })

            # 启用查询
            ->when(!empty($request->is_enable), function ($query) use ($request) {
                $query->where('is_enable', $request->is_enable);
            })
            ->orderBy('created_at', 'desc')
            ->select(['system_admins.*', 'b.name as current_com_name'])
            ->paginate($request->get('limit', 15));

        return $this->succPage($data);
    }

    /**
     * 添加
     */
    public function store(AddRequest $request)
    {
        DB::beginTransaction();
        try {
            # 添加用户
            $insertData             = $request->only([
                'username',
                'password',
                'com_id',
                'avatar',
                'email',
                'phone',
            ]);
            $insertData['password'] = $insertData['password'] ? bcrypt($request->password) : bcrypt('123456');
            $insertData['avatar']   = 'default.png';
            $insertData['com_id']   = 1;
            $admin                  = new SystemAdmin($insertData);
            $admin->save();

            # 添加管理员角色关系
            $admin->roles()->attach($request->roles);

            DB::commit();
            return $this->succOk();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * 详情
     */
    public function show(SystemAdmin $admin)
    {
        $admin->load('roles.menus');
        return $this->succData($admin);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, SystemAdmin $admin)
    {

        DB::beginTransaction();
        try {
            $updateData             = $request->only([
                'username',
                'password',
                'com_id',
                'avatar',
                'email',
                'phone',]);
            $updateData['password'] = bcrypt($request->password);

            # 更新用户
            $res = $admin->update($updateData);

            # 更新管理员角色关系
            $admin->roles()->sync($request->roles);

            DB::commit();
            return $this->succOk($res);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * 软删除
     */
    public function destroy(SystemAdmin $admin)
    {
        $admin->roles()->detach();
        $admin->delete();
        return $this->succOk();
    }

}
