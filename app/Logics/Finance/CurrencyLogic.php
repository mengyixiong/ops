<?php

namespace App\Logics\Finance;

use App\Exceptions\ApiException;
use App\Logics\BaseLogic;
use App\Models\FinCurrency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyLogic extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [
        'code',
        'cn_name',
        'en_name',
        'symbol',
        'is_enable',
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = FinCurrency::query()
            # 关键字
            ->when(!empty($this->request->keyword), function (Builder $query) {
                $query->where('code', 'like', "%{$this->request->keyword}%")
                    ->orWhere('cn_name', 'like', "%{$this->request->keyword}%")
                    ->orWhere('en_name', 'like', "%{$this->request->keyword}%");
            })
            ->paginate($this->request->get('limit', 15));

        return $data;
    }


    /**
     * 添加
     */
    public function insert($request): void
    {
        $data  = $request->only($this->actionFields);
        $model = new FinCurrency($data);
        $model->save();
    }

    /**
     * 修改
     */
    public function update($request, FinCurrency $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete(FinCurrency $model): void
    {
        $model->delete();
    }

}
