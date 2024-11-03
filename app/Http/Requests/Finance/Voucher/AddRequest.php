<?php

namespace App\Http\Requests\Finance\Voucher;

use App\Http\Requests\BaseRequest;

class AddRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
			'com_id'=>'required',
			'voucher_num'=>'required',
			'billing_date'=>'required',
			'bookkeeper'=>'required',
			'make_people'=>'required',
			'make_at'=>'required',
			'dn_total'=>'required',
			'cn_total'=>'required',
			'is_effective'=>'required',
			'is_audit'=>'required',
			'is_foreign'=>'required',
			'is_recorded'=>'required',
			'type'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
			'com_id.required'=>'主体ID 不能为空',
			'voucher_num.required'=>'凭证号码 不能为空',
			'billing_date.required'=>'记账日期 不能为空',
			'bookkeeper.required'=>'记账人 不能为空',
			'make_people.required'=>'制单人 不能为空',
			'make_at.required'=>'制单时间 不能为空',
			'dn_total.required'=>'借方总额 不能为空',
			'cn_total.required'=>'贷方总额 不能为空',
			'is_effective.required'=>'请选择 有效',
			'is_audit.required'=>'请选择 审核',
			'is_foreign.required'=>'请选择 外币',
			'is_recorded.required'=>'请选择 入账',
			'type.required'=>'请选择 凭证类型'
        ];
    }
}
