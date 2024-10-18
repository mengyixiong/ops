<?php

namespace App\Http\Requests\System\Role;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'menus' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            'menus.required' => '分配的权限不能为空',
            'menus.array'  => '请用数组传递分配的菜单',
        ];
    }
}
