<?php

namespace App\Http\Controllers\System;

use App\Exceptions\ApiException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\System\Menu\AddRequest;
use App\Http\Requests\System\Menu\UpdateRequest;
use App\Models\SystemCompany;
use App\Models\SystemMenu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MenuController extends BaseController
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $data = SystemMenu::with('children')
            ->where('pid', 0)
            ->paginate($request->get('limit', 15));
        return $this->succPage($data);
    }

    /**
     * 列表
     */
    public function getAllMenus(Request $request)
    {
        # 获取所有的菜单
        $menus = SystemMenu::query()
            ->when($request->has('id'), function (Builder $query) {
                $query->where('id', '<>', request()->id);
            })
            ->where('type', SystemMenu::TYPE_MENU)
            ->get();

        # 构建菜单树
        if ($menus) {
            $menus = buildTree($menus->toArray());
        }
        # 在menus前面添加顶级菜单
        array_unshift($menus, [
            'id'    => 0,
            'title' => '顶级菜单',
            'pid'   => 0
        ]);

        return $this->succData($menus);
    }

    public function getMenusAndPermissions()
    {
        $menus = SystemMenu::query()->select([
            'id','name','pid','title'
        ])->get();
        $menus = buildTree($menus->toArray());
        return $this->succData($menus);
    }

    /**
     * 添加
     */
    public function store(AddRequest $request)
    {
        $insertData = $request->only([
            'pid',
            'title',
            'is_hide_menu',
            'name',
            'path',
            'icon',
            'permission',
            'type',
            'component',
            'i18n_key',
            'sort',
            'com_id'
        ]);
        $menu       = new SystemMenu($insertData);
        $menu->save();
        return $this->succOk();
    }

    /**
     * 详情
     */
    public function show(SystemMenu $menu)
    {
        return $this->succData($menu);
    }

    /**
     * 修改
     */
    public function update(UpdateRequest $request, SystemMenu $menu)
    {
        $updateData = $request->only([
            'pid',
            'title',
            'is_hide_menu',
            'name',
            'path',
            'icon',
            'permission',
            'type',
            'component',
            'i18n_key',
            'sort',
            'com_id'
        ]);

        $menu->update($updateData);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(SystemMenu $menu)
    {
        # 判断是否有子菜单
        if ($menu->children()->count()) {
            throw new ApiException('请先删除子菜单', 400);
        }

        $menu->delete();
        return $this->succOk();
    }
}
