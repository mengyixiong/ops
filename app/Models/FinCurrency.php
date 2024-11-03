<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class FinCurrency extends BaseModel
{
    public static function getAllCurrenciesOptions()
    {
        return self::query()->select(['cn_name as label', 'code as value'])->get()->toArray();
    }

    public static function getCurrencyMap()
    {
        return  self::query()->select([ DB::raw("CONCAT(cn_name, ' (', code,')') AS label"), 'code as value'])->pluck('label','value')->toArray();
    }

}
