<?php

namespace App\Http\Controllers\Finance;

use App\Enums\FinanceConstant;
use App\Enums\GlobalConstant;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\CurrencyRate\AddRequest;
use App\Http\Requests\Finance\CurrencyRate\UpdateRequest;
use App\Logics\Finance\CurrencyRateLogic;
use App\Models\FinCurrency;
use App\Models\FinCurrencyRate;

class CurrencyRateController extends BaseController
{

    public function __construct(
        protected CurrencyRateLogic $logic
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

    public function initData()
    {
        return $this->succData([
            'currencyOptions'  => FinCurrency::getAllCurrenciesOptions(),
            'typeMap'   => FinanceConstant::RATE_TYPE,
            'typeOptions'   => GlobalConstant::map2Options(FinanceConstant::RATE_TYPE),
        ]);
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
    public function show(FinCurrencyRate $currencyRate)
    {
        return $this->succData($currencyRate);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinCurrencyRate $currencyRate)
    {
        $this->logic->update($request,$currencyRate);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(FinCurrencyRate $currencyRate)
    {
        $this->logic->delete($currencyRate);
        return $this->succOk();
    }
}
