<?php

namespace App\Logics\Finance;

use App\Exceptions\ApiException;
use App\Logics\BaseLogic;
use App\Models\FinAccountSubject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountSubjectLogic extends BaseLogic
{
    private Request $request;

    /**
     *
     */
    public array $actionFields = [
        'pid',
        'level',
        'code',
        'abb',
        'cn_name',
        'en_name',
        'type',
        'format',
        'currency',
        'is_foreign',
        'is_dn',
        'is_frozen',
        'is_last',
        'is_cash',
        'balance',
        'foreign_balance',
        'opening_balance',
        'opening_foreign_balance',
        'year_opening_balance',
        'year_opening_foreign_balance',
        'vendor_required',
        'clerk_required',
        'team_required',
        'branch_required',
    ];

    public function __construct()
    {
        $this->request = app('request');
    }

    public function pageQuery()
    {
        $data = FinAccountSubject::com()
            # 关键字
            ->when(!empty($this->request->keyword), function (Builder $query) {
                $query->where('cn_name', 'like', "%$this->request->keyword%")
                    ->orWhere('en_name', 'like', "%$this->request->keyword%")
                    ->orWhere('abb', 'like', "%$this->request->keyword%");
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
        $model = new FinAccountSubject($data);
        $model->fillCom()->save();
    }

    /**
     * 修改
     */
    public function update($request, FinAccountSubject $model): void
    {
        $updateData = $request->only($this->actionFields);
        $model->update($updateData);
    }

    /**
     * 删除
     */
    public function delete(FinAccountSubject $model): void
    {
        # 判断是否有下级
        $hasChild = $model->where('pid', $model->id)->exists();
        if ($hasChild){
            throw new ApiException('该科目下还有子科目，不能删除');
        }

        $model->delete();
    }

}
