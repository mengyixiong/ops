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

    # 将 created_at 和 updated_at 转换为指定的日期格式
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

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
}
