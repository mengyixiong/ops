<?php

namespace App\Http\Requests\Finance\CurrencyRate;

use App\Enums\FinanceConstant;
use App\Enums\GlobalConstant;
use App\Http\Requests\BaseRequest;

class AddRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
			'code'=>'required',
			'rate'=>'required',
			'effective_date'=>'required|date',
			'type'=>'nullable|in:'.GlobalConstant::enums(FinanceConstant::RATE_TYPE),
			'is_enable'=>'nullable|in:'.GlobalConstant::enums(GlobalConstant::YES_NO),
        ];
    }

    public function messages(): array
    {
        return [
			'code.required'=>'币种名称 不能为空',
			'rate.required'=>'汇率 不能为空',
			'effective_date.required'=>'生效日期 不能为空',
			'type.in'=>'汇率类型 不合法',
			'is_enable.in'=>'生效 不合法',
        ];
    }
}
