<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\AccountSubject\AddRequest;
use App\Http\Requests\Finance\AccountSubject\UpdateRequest;
use App\Logics\Finance\AccountSubjectLogic;
use App\Models\FinAccountSubject;

class AccountSubjectController extends BaseController
{

    public function __construct(
        protected AccountSubjectLogic $logic
    )
    {

    }

    /**
     * 列表
     */
    public function index()
    {
        return $this->succPage($this->logic->pageQuery());
    }

    /**
     * 添加
     */
    public function store(AddRequest $request)
    {
        $this->logic->insert($request);
        return $this->succOk();
    }

    /**
     * 详情
     */
    public function show(FinAccountSubject $accountSubject)
    {
        return $this->succData($accountSubject);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinAccountSubject $accountSubject)
    {
        $this->logic->update($request,$accountSubject);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(FinAccountSubject $accountSubject)
    {
        $this->logic->delete($accountSubject);
        return $this->succOk();
    }
}
