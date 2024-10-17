<?php

namespace App\Http\Requests\System\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|between:2,20|unique:system_admins,username,' . $this->route('admin')->id,
            'email'    => 'required|email|unique:system_admins,email,'.$this->route('admin')->id,
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => '用户名不能为空',
            'email.required'    => '邮箱不能为空',
            'email.email'       => '邮箱格式不正确',
        ];
    }
}
