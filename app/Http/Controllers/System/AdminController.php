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
            ->with('roles') // 只选择 roles 关联的 id 字段
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

        # 现在处理每个用户，将角色 IDs 提取为一个数组
        $transformedCollection = $data->getCollection()->transform(function ($user) {
            $user->role_names = $user->roles->pluck('name');
            # 提取角色ID并重新赋值
            $user->roles = $user->roles->pluck('id')->toArray();
            $user->setRelation('roles', $user->roles);
            return $user;
        });

        // 将修改后的集合重新设置回分页对象
        $data->setCollection($transformedCollection);

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
            $insertData                   = $request->only([
                'username',
                'password',
                'is_enable',
                'is_super_admin',
                'avatar',
                'email',
                'phone',
            ]);
            $insertData['password']       = $request->has('password') ? bcrypt($request->password) : bcrypt('123456');
            $insertData['avatar']         = $request->has('avatar') ? getUri($request->avatar) : 'default.png';
            $insertData['current_com_id'] = 1;
            $insertData['created_by']     = auth()->id();
            $insertData['updated_by']     = auth()->id();
            $admin                        = new SystemAdmin($insertData);
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
                'is_enable',
                'is_super_admin',
                'avatar',
                'email',
                'phone',
            ]);
            $updateData['updated_by']     = auth()->id();
            $updateData['avatar']         = $request->has('avatar') ? getUri($request->avatar) : $admin->avatar;
            $updateData['password'] = $request->has('password')
                ? bcrypt($request->password)
                : $admin->password;

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
