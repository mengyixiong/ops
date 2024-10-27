<?php

namespace App\Logics{namespace};

use App\Logics\BaseLogic;
use App\Models\{modelName};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class {logicName} extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [{actionFields}
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = {modelName}::query()
            {where}
            ->paginate($this->request->get('limit', 15));

        return $data;
    }


    /**
     * 添加
     */
    public function insert($request): void
    {
        $data  = $request->only($this->actionFields);
        $model = new {modelName}($data);
        $model->save();
    }

    /**
     * 修改
     */
    public function update($request, {modelName} $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete({modelName} $model): void
    {
        $model->delete();
    }

}
