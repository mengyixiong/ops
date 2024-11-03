<?php

namespace App\Logics\Finance;

use App\Logics\BaseLogic;
use App\Models\FinVoucher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VoucherLogic extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [
		'com_id',
		'voucher_num',
		'billing_date',
		'bookkeeper',
		'auditor',
		'audit_at',
		'cashier',
		'make_people',
		'make_at',
		'dn_total',
		'cn_total',
		'is_effective',
		'is_audit',
		'is_foreign',
		'is_recorded',
		'type',
		'remarks',
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = FinVoucher::query()
            
            ->paginate($this->request->get('limit', 15));

        return $data;
    }


    /**
     * 添加
     */
    public function insert($request): void
    {
        $data  = $request->only($this->actionFields);
        $model = new FinVoucher($data);
        $model->save();
    }

    /**
     * 修改
     */
    public function update($request, FinVoucher $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete(FinVoucher $model): void
    {
        $model->delete();
    }

}
