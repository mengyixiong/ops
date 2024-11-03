<?php

namespace App\Logics\Finance;

use App\Logics\BaseLogic;
use App\Models\FinCurrencyRate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CurrencyRateLogic extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [
		'code',
		'com_id',
		'rate',
		'effective_date',
		'type',
		'is_enable',
		'remark',
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = FinCurrencyRate::query()

            ->paginate($this->request->get('limit', 15));

        return $data;
    }


    /**
     * 添加
     */
    public function insert($request): void
    {
        $data  = $request->only($this->actionFields);
        $model = new FinCurrencyRate($data);
        $model->fillCom()->save();
    }

    /**
     * 修改
     */
    public function update($request, FinCurrencyRate $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete(FinCurrencyRate $model): void
    {
        $model->delete();
    }

}
