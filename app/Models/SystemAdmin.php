<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SystemAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public string $name = '管理员';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $guarded = [];

    /**
     * 关联角色
     */
    public function roles()
    {
        return $this->belongsToMany(SystemRole::class, 'system_admin_roles', 'admin_id', 'role_id');
    }

    /**
     * 获取菜单
     */
    public function menus()
    {
        return $this->hasManyThrough(
            SystemRole::class,
            SystemMenu::class,
            'project_id', // 在 environments 表上的外键...
            'environment_id', // 在 deployments 表上的外键...
            'id', // 在 projects 表上的本地键...
            'id' // 在 environments 表格上的本地键...
        );
    }
}
