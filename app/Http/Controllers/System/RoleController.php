<?php

namespace App\Http\Controllers\System;

use App\Exceptions\ApiException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\System\Role\AddRequest;
use App\Http\Requests\System\Role\AssignPermissionRequest;
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
            # 名称查询
            ->when(!empty($request->name), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->paginate($request->get('limit', 15));
        return $this->succPage($data);
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
        $updateData = $request->only(['name', 'permission']);
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

        # 查询父级菜单
        $menusToAdd = collect();
        foreach ($menus as $menu) {
            $menusToAdd->push($menu);

            # 将此菜单的所有父级菜单添加到集合中
            $parent = $menu->parent;
            while ($parent !== null) {
                $menusToAdd->push($parent);
                $parent = $parent->parent;
            }
        }

        # 菜单去重
        $menuIds = $menusToAdd->pluck('id')->sort()->unique();

        # 分配菜单
        $role->menus()->sync($menuIds);

        return $this->succOk();
    }
}
