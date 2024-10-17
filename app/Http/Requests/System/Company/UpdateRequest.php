<?php

namespace App\Http\Requests\System\Company;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|between:2,50|unique:system_companies,name,' . $this->route('company')->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '名称不能为空',
            'name.between'   => '名称必须在2-50之间',
            'name.unique'   => '名称已存在',
        ];
    }
}
