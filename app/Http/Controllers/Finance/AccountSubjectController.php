<?php

namespace App\Http\Controllers\Finance;

use App\Enums\FinanceConstant;
use App\Enums\GlobalConstant;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Finance\AccountSubject\AddRequest;
use App\Http\Requests\Finance\AccountSubject\UpdateRequest;
use App\Logics\Finance\AccountSubjectLogic;
use App\Models\FinAccountSubject;
use Illuminate\Support\Facades\DB;

class AccountSubjectController extends BaseController
{

    public function __construct(
        protected AccountSubjectLogic $logic
    )
    {

    }

    /**
     * 列表
     */
    public function index()
    {
        $subjects       = DB::connection('rq')->table('fx_account_titles')->where('level', '=', 1)
            ->where('companyId', '=', 1)
            ->get();
        $subjects = json_decode(json_encode($subjects),true);
        foreach ($subjects as $subject) {
            FinAccountSubject::create([
                'pid'                          => $subject['pid'],
                'level'                        => $subject['level'],
                'code'                         => $subject['code'],
                'abb'                          => $subject['abb'],
                'cn_name'                      => $subject['cnName'],
                'en_name'                      => $subject['enName'],
                'type'                         => $subject['type'],
                'format'                       => $subject['format'],
                'currency'                     => $subject['currency'],
                'com_id'                       => $subject['companyId'],
                'is_foreign'                   => $subject['isForeign'],
                'is_dn'                        => $subject['isDn'],
                'is_frozen'                    => $subject['isFreezed'],
                'is_last'                      => $subject['isLast'],
                'is_cash'                      => $subject['isCash'],
                'vendor_required'              => $subject['venderRequired'],
                'clerk_required'               => $subject['clerkRequired'],
                'team_required'                => $subject['teamRequired'],
                'branch_required'              => $subject['branchRequired'],
            ]);
        }
        return $this->succPage($this->logic->pageQuery());
    }

    public function operateInitData()
    {
        return $this->succData([
            'levelOptions'  => GlobalConstant::map2Options(FinanceConstant::LEVEL),
            'typeOptions'   => GlobalConstant::map2Options(FinanceConstant::SUBJECT_TYPE),
            'formatOptions' => GlobalConstant::map2Options(FinanceConstant::FORMAT),
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
    public function show(FinAccountSubject $accountSubject)
    {
        return $this->succData($accountSubject);
    }

    /**
     * 更新
     */
    public function update(UpdateRequest $request, FinAccountSubject $accountSubject)
    {
        $this->logic->update($request, $accountSubject);
        return $this->succOk();
    }

    /**
     * 删除
     */
    public function destroy(FinAccountSubject $accountSubject)
    {
        $this->logic->delete($accountSubject);
        return $this->succOk();
    }
}
