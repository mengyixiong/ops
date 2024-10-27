<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\Currency\AddRequest;
use App\Http\Requests\Finance\Currency\UpdateRequest;
use App\Logics\Finance\CurrencyLogic;
use App\Models\FinCurrency;

class CurrencyController extends BaseController
{

    public function __construct(
        protected CurrencyLogic $logic
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
    public function show(FinCurrency $currency)
    {
        return $this->succData($currency);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinCurrency $currency)
    {
        $this->logic->update($request,$currency);
        return $this->succOk();
    }

    /**
     * 软删除
     */
    public function destroy(FinCurrency $currency)
    {
        $this->logic->delete($currency);
        return $this->succOk();
    }
}
