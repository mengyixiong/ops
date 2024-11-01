<?php

namespace App\Http\Requests\Finance\AccountSubject;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
			'pid'=>'required',
			'level'=>'required',
			'code'=>'required',
			'cn_name'=>'required',
			'type'=>'required',
			'format'=>'required',
			'currency'=>'required',
			'com_id'=>'required',
			'is_foreign'=>'required',
			'is_dn'=>'required',
			'is_frozen'=>'required',
			'is_last'=>'required',
			'is_cash'=>'required',
			'balance'=>'required',
			'foreign_balance'=>'required',
			'opening_balance'=>'required',
			'opening_foreign_balance'=>'required',
			'year_opening_balance'=>'required',
			'year_opening_foreign_balance'=>'required',
			'vendor_required'=>'required',
			'clerk_required'=>'required',
			'team_required'=>'required',
			'branch_required'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
			'pid.required'=>'上一级，顶级为0 不能为空',
			'level.required'=>'请选择 级别',
			'code.required'=>'级别 不能为空',
			'cn_name.required'=>'中文名称 不能为空',
			'type.required'=>'请选择 科目类型',
			'format.required'=>'请选择 账页格式',
			'currency.required'=>'核算比重 不能为空',
			'com_id.required'=>'主体ID 不能为空',
			'is_foreign.required'=>'请选择 外币核算',
			'is_dn.required'=>'请选择 余额方向',
			'is_frozen.required'=>'请选择 冻结',
			'is_last.required'=>'请选择 末级科目',
			'is_cash.required'=>'请选择 现金流',
			'balance.required'=>'期末余额 不能为空',
			'foreign_balance.required'=>'外币余额，外币核算时有值 不能为空',
			'opening_balance.required'=>'期初余额 不能为空',
			'opening_foreign_balance.required'=>'外币期初余额 不能为空',
			'year_opening_balance.required'=>'年期初余额 不能为空',
			'year_opening_foreign_balance.required'=>'外币年期初余额 不能为空',
			'vendor_required.required'=>'请选择 往来单位必填',
			'clerk_required.required'=>'请选择 员工必填',
			'team_required.required'=>'请选择 部门必填',
			'branch_required.required'=>'请选择 分公司必填'
        ];
    }
}
