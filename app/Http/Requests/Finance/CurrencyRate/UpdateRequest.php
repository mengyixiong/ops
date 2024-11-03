<?php

namespace App\Http\Requests\Finance\CurrencyRate;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
			'code'=>'required',
			'com_id'=>'required',
			'rate'=>'required',
			'effective_date'=>'required',
			'type'=>'required',
			'is_enable'=>'required',
			'remark'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
			'code.required'=>'币种名称 不能为空',
			'com_id.required'=>'主体ID 不能为空',
			'rate.required'=>'汇率 不能为空',
			'effective_date.required'=>'生效日期 不能为空',
			'type.required'=>'请选择 汇率类型',
			'is_enable.required'=>'请选择 生效',
			'remark.required'=>'备注 不能为空'
        ];
    }
}
