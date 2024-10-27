<?php

namespace App\Http\Requests\Finance\Currency;

use App\Enums\FinanceConstant;
use App\Enums\GlobalConstant;
use App\Http\Requests\BaseRequest;
use App\Rules\SubjectCode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseRequest
{
    public function rules(Request $request): array
    {
        return [
            'code'      => 'required|unique:fin_currencies,code,' . $this->route('currency')->id,
            'cn_name'   => 'required|between:2,20',
            'en_name'   => 'required|between:2,20',
            'symbol'    => 'required',
            'is_enable' => 'sometimes|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'    => '币种代码是必填项。',
            'code.unique'      => '币种代码已存在。',
            'abb.between'      => '简称必须介于 2 到 32 个字符之间。',
            'cn_name.required' => '中文名称是必填项。',
            'en_name.required' => '英文名称是必填项。',
            'cn_name.between'  => '中文名称必须介于 2 到 20 个字符之间。',
            'en_name.between'  => '英文名称必须介于 2 到 20 个字符之间。',
            'symbol.required'  => '币种符号为必填。',
        ];
    }
}
