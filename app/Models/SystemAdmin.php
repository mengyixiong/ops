<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class SystemAdmin extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    // Rest omitted for brevity

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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
