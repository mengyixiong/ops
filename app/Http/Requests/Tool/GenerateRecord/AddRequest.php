<?php

namespace App\Http\Requests\Tool\GenerateRecord;

use App\Http\Requests\BaseRequest;

class AddRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
			'table_name'=>'required',
			'controller'=>'required',
			'logic'=>'required',
			'add_request'=>'required',
			'update_request'=>'required',
			'index_vue'=>'required',
			'api_type'=>'required',
			'search_form'=>'required',
			'operate_drawer'=>'required',
			'lang_zh'=>'required',
			'service_api'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
			'table_name.required'=>'表名 不能为空',
			'controller.required'=>'控制器 不能为空',
			'logic.required'=>'逻辑类 不能为空',
			'add_request.required'=>'添加验证 不能为空',
			'update_request.required'=>'更新验证 不能为空',
			'index_vue.required'=>'列表 不能为空',
			'api_type.required'=>'api类型 不能为空',
			'search_form.required'=>'搜索表单 不能为空',
			'operate_drawer.required'=>'操作表单 不能为空',
			'lang_zh.required'=>'中文语言 不能为空',
			'service_api.required'=>'服务api 不能为空'
        ];
    }
}
