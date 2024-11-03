<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\Voucher\AddRequest;
use App\Http\Requests\Finance\Voucher\UpdateRequest;
use App\Logics\Finance\VoucherLogic;
use App\Models\FinVoucher;

class VoucherController extends BaseController
{

    public function __construct(
        protected VoucherLogic $logic
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
    public function show(FinVoucher $voucher)
    {
        return $this->succData($voucher);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinVoucher $voucher)
    {
        $this->logic->update($request,$voucher);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(FinVoucher $voucher)
    {
        $this->logic->delete($voucher);
        return $this->succOk();
    }
}
