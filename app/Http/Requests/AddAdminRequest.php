<?php

namespace App\Http\Requests\System\Admin;

use App\Http\Requests\BaseRequest;

class AddAdminRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'username' => 'required|between:2,20|unique:system_admins,username',
            'email'    => 'required|email|unique:system_admins,email',
            'roles'    => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => '用户名不能为空',
            'username.unique'   => '用户名已存在',
            'email.required'    => '邮箱不能为空',
            'email.email'       => '邮箱格式不正确',
            'email.unique'      => '邮箱已存在',
            'roles.required'    => '请选择角色',
        ];
    }
}
