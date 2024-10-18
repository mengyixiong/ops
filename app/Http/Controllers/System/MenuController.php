<?php

namespace App\Http\Controllers\System;

use App\Exceptions\ApiException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\System\Menu\AddMenuRequest;
use App\Http\Requests\System\Menu\AddRequest;
use App\Http\Requests\System\Menu\UpdateMenuRequest;
use App\Http\Requests\System\Menu\UpdateRequest;
use App\Models\SystemMenu;

class MenuController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        $data = SystemMenu::with('children')->where('pid', 0)->get();
        return $this->succData($data);
    }

    /**
     * 添加
     */
    public function store(AddRequest $request)
    {
        $insertData = $request->only([
            'pid',
            'title',
            'name',
            'path',
            'icon',
            'permission',
            'type',
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
            'name',
            'path',
            'icon',
            'permission',
            'type',
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
