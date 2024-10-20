<?php

namespace App\Http\Requests\System\Menu;

use App\Http\Requests\BaseRequest;
use App\Models\SystemMenu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddRequest extends BaseRequest
{
    public function rules(Request $request): array
    {
        return [
            'pid'        => Rule::when($request->pid !== 0, [
                'required', // 只有当 pid 不为 0 时才需要
                'exists:system_menus,id' // 并且必须存在于 system_menus 表的 id 列中
            ]),
            'name'       => 'required_if:type,1',
            'path'       => 'required_if:type,1',
            'permission' => [
                'required_if:type,2',
                Rule::unique('system_menus', 'permission')->where(function ($query) {
                    return $query->where('type', SystemMenu::TYPE_PERMISSION);
                })
            ],
            'type'       => 'sometimes|in:1,2',
        ];
    }
    public function messages(): array
    {
        return [
            'pid.required'        => '父级菜单不能为空',
            'pid.exists'          => '父级菜单不存在',
            'name.required'       => '菜单名称不能为空',
            'path.required_if'    => '菜单路径不能为空',
            'permission.required' => '菜单权限不能为空',
            'permission.unique'   => '菜单权限已存在',
        ];
    }
}
