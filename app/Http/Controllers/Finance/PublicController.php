<?php

namespace App\Http\Controllers\Finance;

use App\Enums\FinanceConstant;
use App\Enums\GlobalConstant;
use App\Http\Controllers\BaseController;
use App\Models\FinCurrency;

class PublicController extends BaseController
{
    public function getCurrencyMap()
    {
        return $this->succData(
            FinCurrency::getCurrencyMap()
        );
    }

    public function getInitData()
    {
        return $this->succData([
            'currencyMap' => FinCurrency::getCurrencyMap(),
            'levelMap'    => FinanceConstant::LEVEL,
            'typeMap'     => FinanceConstant::SUBJECT_TYPE,
            'formatMap'   => FinanceConstant::FORMAT,
            'rateTypeMap' => FinanceConstant::RATE_TYPE,
        ]);
    }

}
