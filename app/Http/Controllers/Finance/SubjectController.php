<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\Subject\AddRequest;
use App\Http\Requests\Finance\Subject\UpdateRequest;
use App\Logics\Finance\SubjectLogic;
use App\Models\FinAccountSubject;

class SubjectController extends BaseController
{

    public function __construct(
        protected SubjectLogic $logic
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
    public function show(FinAccountSubject $subject)
    {
        return $this->succData($subject);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinAccountSubject $subject)
    {
        $this->logic->update($request,$subject);
        return $this->succOk();
    }

    /**
     * 软删除
     */
    public function destroy(FinAccountSubject $subject)
    {
        $this->logic->delete($subject);
        return $this->succOk();
    }
}
