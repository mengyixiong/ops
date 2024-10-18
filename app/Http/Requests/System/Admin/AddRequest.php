<?php

namespace App\Http\Requests\System\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|between:2,20|unique:system_admins,username',
            'password' => 'sometimes|between:6,20',
            'email'    => 'required|email|unique:system_admins,email',
            'roles'    => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => '用户名不能为空',
            'username.between'  => '用户名在6-20位之间',
            'username.unique'   => '用户名已存在',
            'password.between'  => '密码位数在6-20位之间',
            'email.required'    => '邮箱不能为空',
            'email.email'       => '邮箱格式不正确',
            'email.unique'      => '邮箱已存在',
            'roles.required'    => '请选择角色',
        ];
    }
}
