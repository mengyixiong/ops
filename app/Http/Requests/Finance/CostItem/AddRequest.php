<?php

namespace App\Http\Requests\Finance\CostItem;

use App\Http\Requests\BaseRequest;

class AddRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
			'name'=>'required',
			'code'=>'required',
			'is_enable'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
			'name.required'=>'名称 不能为空',
			'code.required'=>'代码 不能为空',
			'is_enable.required'=>'请选择 是否启用'
        ];
    }
}
