<?php

namespace App\Http\Controllers\System;

use App\Exceptions\ApiException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\System\Role\AddRequest;
use App\Http\Requests\System\Role\AssignPermissionRequest;
use App\Http\Requests\System\Role\UpdateRequest;
use App\Models\SystemMenu;
use App\Models\SystemRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $data = SystemRole::query()
            ->with('menus')
            # 名称查询
            ->when(!empty($request->name), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })

            # 代码查询
            ->when(!empty($request->code), function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->code . '%');
            })
            ->paginate($request->get('limit', 15));

        # 现在处理每个用户，将角色 IDs 提取为一个数组
        $transformedCollection = $data->getCollection()->transform(function ($role) {
            # 提取角色ID并重新赋值
            $role->menus = $role->menus->pluck('id')->toArray();
            $role->setRelation('menus', $role->menus);

            return $role;
        });

        // 将修改后的集合重新设置回分页对象
        $data->setCollection($transformedCollection);

        return $this->succPage($data);
    }

    /**
     * 列表
     */
    public function getAllRoles()
    {
        $data = SystemRole::query()->select([
            'id', 'name', 'code'
        ])->get();
        return $this->succData($data);
    }

    /**
     * 添加
     */
    public function store(AddRequest $request)
    {
        $insertData = $request->only(['name', 'code', 'description']);
        $role       = new SystemRole($insertData);
        $role->save();

        return $this->succOk();
    }

    /**
     * 详情
     */
    public function show(SystemRole $role)
    {
        $role->load('menus');
        return $this->succData($role);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, SystemRole $role)
    {
        $updateData = $request->only(['name', 'code', 'description']);
        $role->update($updateData);
        return $this->succOk();
    }

    /**
     * 软删除
     */
    public function destroy(SystemRole $role)
    {
        DB::beginTransaction();
        try {
            $role->menus()->detach();
            $role->delete();
            DB::commit();
            return $this->succOk();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new ApiException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * 分配权限
     */
    public function assignPermission(SystemRole $role, AssignPermissionRequest $request)
    {
        # 判断菜单是否存在
        $menus = SystemMenu::whereIn('id', $request->menus)->get();
        if ($menus->count() != count($request->menus)) {
            throw new ApiException('菜单不存在');
        }
        $requestMenus = $request->menus;
        if (!in_array(1, $requestMenus)) {

            # 每个角色必须有首页菜单
            array_unshift($requestMenus, 1);
        }

        if (!in_array(2, $requestMenus)) {

            # 每个角色必须有首页菜单
            array_unshift($requestMenus, 2);
        }

        $role->menus()->sync($requestMenus);

        return $this->succOk();
    }
}
