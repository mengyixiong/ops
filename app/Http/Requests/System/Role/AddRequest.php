<?php

namespace App\Http\Requests\System\Role;

use App\Http\Requests\BaseRequest;

class AddRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|between:2,20|unique:system_roles,name',
            'code' => 'required|between:2,20|unique:system_roles,code',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '角色名不能为空',
            'name.between'  => '角色名必须在2-20位之间',
            'name.unique'   => '角色名已存在',
            'code.required' => '角色代码不能为空',
            'code.between'  => '角色代码必须在2-20位之间',
            'code.unique'   => '角色代码已存在',
        ];
    }
}
