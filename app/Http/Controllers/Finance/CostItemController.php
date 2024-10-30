<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\CostItem\AddRequest;
use App\Http\Requests\Finance\CostItem\UpdateRequest;
use App\Logics\Finance\CostItemLogic;
use App\Models\FinCostItem;

class CostItemController extends BaseController
{

    public function __construct(
        protected CostItemLogic $logic
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
    public function show(FinCostItem $costItem)
    {
        return $this->succData($costItem);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinCostItem $costItem)
    {
        $this->logic->update($request,$costItem);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(FinCostItem $costItem)
    {
        $this->logic->delete($costItem);
        return $this->succOk();
    }
}
