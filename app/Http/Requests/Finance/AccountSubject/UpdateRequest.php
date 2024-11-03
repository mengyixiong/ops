<?php

namespace App\Http\Requests\Finance\AccountSubject;

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
            'pid'             => Rule::when($request->pid !== 0, [
                'required',              // 只有当 pid 不为 0 时才需要
                'exists:fin_account_subjects,id' // 并且必须存在于 system_menus 表的 id 列中
            ]),
            'level'           => 'required|in:' . GlobalConstant::enums(FinanceConstant::LEVEL),
            'code'            => ['required', new SubjectCode],
            'abb'             => 'nullable|between:2,32',
            'cn_name'         => 'required|between:2,32',
            'en_name'         => 'nullable|between:2,32',
            'type'            => 'required|in:' . GlobalConstant::enums(FinanceConstant::SUBJECT_TYPE),
            'format'          => 'required|in:' . GlobalConstant::enums(FinanceConstant::FORMAT),
            'is_foreign'      => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'is_dn'           => 'required|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'is_frozen'       => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'is_last'         => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'is_cash'         => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'vendor_required' => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'clerk_required'  => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'team_required'   => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
            'branch_required' => 'nullable|in:' . GlobalConstant::enums(GlobalConstant::YES_NO),
        ];
    }

    public function messages(): array
    {
        return [
            'pid.required'        => '所选的父级科目不存在。',
            'pid.exists'          => '所选的父级科目不存在。',
            'level.required'      => '级别字段是必填项。',
            'level.in'            => '所选的级别无效，请选择有效的级别。',
            'code.required'       => '科目代码是必填项。',
            'abb.between'         => '简称必须介于 2 到 32 个字符之间。',
            'cn_name.required'    => '中文名称是必填项。',
            'cn_name.between'     => '中文名称必须介于 2 到 32 个字符之间。',
            'en_name.between'     => '英文名称必须介于 2 到 32 个字符之间。',
            'type.required'       => '类型字段是必填项。',
            'type.in'             => '所选的类型无效，请选择有效的类型。',
            'format.required'     => '格式字段是必填项。',
            'format.in'           => '所选的格式无效，请选择有效的格式。',
            'is_foreign.nullable' => '是否外币字段是必填项。',
            'is_foreign.in'       => '所选的是否外币状态无效，请选择有效的状态。',
            'is_dn.required'      => '借贷必填字段是必填项。',
            'is_dn.in'            => '所选的借贷必填状态无效，请选择有效的状态。',
            'is_frozen.nullable'  => '是否冻结字段是必填项。',
            'is_frozen.in'        => '所选的是否冻结状态无效，请选择有效的状态。',
            'is_last.nullable'    => '是否末级字段是必填项。',
            'is_last.in'          => '所选的是否末级状态无效，请选择有效的状态。',
            'is_cash.nullable'    => '是否现金字段是必填项。',
            'is_cash.in'          => '所选的是否现金状态无效，请选择有效的状态。',
            'vendor_required.in'  => '供应商要求字段的值无效，请选择有效的值。',
            'clerk_required.in'   => '职员要求字段的值无效，请选择有效的值。',
            'team_required.in'    => '团队要求字段的值无效，请选择有效的值。',
            'branch_required.in'  => '分支要求字段的值无效，请选择有效的值。',
        ];
    }
}
