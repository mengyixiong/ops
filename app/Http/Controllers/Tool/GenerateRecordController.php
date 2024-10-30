<?php

namespace App\Http\Controllers\Tool;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Tool\GenerateRecord\AddRequest;
use App\Http\Requests\Tool\GenerateRecord\UpdateRequest;
use App\Logics\Tool\GenerateRecordLogic;
use App\Models\GenerateRecord;

class GenerateRecordController extends BaseController
{

    public function __construct(
        protected GenerateRecordLogic $logic
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
    public function store()
    {
        $this->logic->insert();
        return $this->succOk();
    }

    /**
     * 详情
     */
    public function show(GenerateRecord $generateRecord)
    {
        return $this->succData($generateRecord);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, GenerateRecord $generateRecord)
    {
        $this->logic->update($request,$generateRecord);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(GenerateRecord $generateRecord)
    {
        $this->logic->delete($generateRecord);
        return $this->succOk();
    }
}
