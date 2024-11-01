<?php

namespace App\Enums;

class GlobalConstant
{
    const YES = 'Y';
    const NO  = 'N';

    const YES_NO = [
        self::YES => '是',
        self::NO  => '否',
    ];

    const ZERO  = 0;
    const ONE   = 1;
    const TWO   = 2;
    const THREE = 3;
    const FOUR  = 4;
    const FIVE  = 5;

    public static function enums($array, $isIn = true): string|array
    {
        $enums = array_keys($array);
        if ($isIn) {
            return implode(',', $enums);
        }
        return $enums;
    }

    public static function map2Options($map): array
    {
        $options = [];
        foreach ($map as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
