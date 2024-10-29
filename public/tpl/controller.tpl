<?php

namespace App\Http\Controllers{namespace};

use App\Http\Controllers\BaseController;
use App\Http\Requests{namespace}\{baseName}\AddRequest;
use App\Http\Requests{namespace}\{baseName}\UpdateRequest;
use App\Logics{namespace}\{logicName};
use App\Models\{modelName};

class {controllerName} extends BaseController
{

    public function __construct(
        protected {logicName} $logic
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
    public function show({modelName} $model)
    {
        return $this->succData($model);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, {modelName} $model)
    {
        $this->logic->update($request,$model);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy({modelName} $model)
    {
        $this->logic->delete($model);
        return $this->succOk();
    }
}
