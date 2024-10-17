<?php

namespace App\Models;

class SystemRole extends BaseModel
{

    /**
     * 关联菜单
     */
    public function menus()
    {
        return $this->belongsToMany(SystemMenu::class, 'system_role_menus', 'role_id', 'menu_id');
    }
}
