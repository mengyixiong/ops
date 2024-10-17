<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use App\Http\Requests\System\Company\AddRequest;
use App\Http\Requests\System\Company\UpdateRequest;
use App\Models\SystemCompany;
use Illuminate\Http\Request;

/**
 * 主体控制器
 */
class CompanyController extends BaseController
{
    public function index(Request $request)
    {
        $data = SystemCompany::query()
            # 名称查询
            ->when(!empty($request->name), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->paginate($request->get('limit', 15));
        return $this->succPage($data);
    }

    public function store(AddRequest $request)
    {
        $insertData = $request->only(['name', 'abb']);
        SystemCompany::create($insertData);
        return $this->succOk('添加成功');
    }

    public function show(SystemCompany $company)
    {
        return $this->succData($company);
    }

    public function update(UpdateRequest $request,SystemCompany $company)
    {
        $updateData = $request->only(['name', 'abb']);
        $company->update($updateData);
        return $this->succOk('更新成功');
    }

    public function destroy(SystemCompany $company)
    {
        $company->delete();
        return $this->succOk();
    }
}
