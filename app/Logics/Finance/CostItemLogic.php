<?php

namespace App\Logics\Finance;

use App\Logics\BaseLogic;
use App\Models\FinCostItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CostItemLogic extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [
		'name',
		'en_name',
		'code',
		'is_enable',
		'remark',
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = FinCostItem::query()
            
            ->paginate($this->request->get('limit', 15));

        return $data;
    }


    /**
     * 添加
     */
    public function insert($request): void
    {
        $data  = $request->only($this->actionFields);
        $model = new FinCostItem($data);
        $model->save();
    }

    /**
     * 修改
     */
    public function update($request, FinCostItem $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete(FinCostItem $model): void
    {
        $model->delete();
    }

}
