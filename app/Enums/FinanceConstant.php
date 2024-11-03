<?php

namespace App\Enums;

class FinanceConstant
{
    const ASSET = 'asset';
    const PROFIT = 'profit';
    const COST = 'cost';
    const COMMON = 'common';
    const OWNERSHIP = 'ownership';
    const LIABILITIES = 'liabilities';
    const settlement = 'settlement';

    const SUBJECT_TYPE = [
        self::ASSET => '资产类',
        self::PROFIT => '损益类',
        self::COST => '成本类',
        self::COMMON => '共同类',
        self::OWNERSHIP => '所有者权益类',
        self::LIABILITIES => '负债类',
        self::settlement => '结算对象类',
    ];

    const  AMOUNT= 'amount';
    const  CURRENCY_AMOUNT = 'currency_amount';

    const FORMAT = [
        self::AMOUNT => '金额式',
        self::CURRENCY_AMOUNT => '外币式金额',
    ];

    const LEVEL = [
        GlobalConstant::ONE => '1 级',
        GlobalConstant::TWO => '2 级',
        GlobalConstant::THREE => '3 级',
        GlobalConstant::FOUR => '4 级',
        GlobalConstant::FIVE => '5 级',
    ];

    const SETTLEMENT_RATE = 'settlement';
    const SELL_RATE = 'sell';
    const BUY_RATE = 'buy';

    Const RATE_TYPE = [
        self::SETTLEMENT_RATE => '结算汇率',
        self::SELL_RATE => '卖出汇率',
        self::BUY_RATE => '买入汇率',
    ];

    const SYSTEM_VOUCHER = 'system';
    const MANUAL_VOUCHER = 'manual';

    const VOUCHER_TYPE = [
        self::SYSTEM_VOUCHER => '系统凭证',
        self::MANUAL_VOUCHER => '手工凭证',
    ];
}
