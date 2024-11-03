<?php

namespace App\Rules;

use App\Enums\GlobalConstant;
use App\Models\FinAccountSubject;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SubjectCode implements ValidationRule
{
    private array $levelToCodeLength = [
        GlobalConstant::ONE   => 4,
        GlobalConstant::TWO   => 6,
        GlobalConstant::THREE => 9,
        GlobalConstant::FOUR  => 11,
        GlobalConstant::FIVE  => 13,
    ];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $level = request()->input('level');
        $subject = request()->route('accountSubject');

        if (empty($level)) {
            $fail('请选择科目级别');
        }

        if (!isset($this->levelToCodeLength[$level])) {
            $fail('科目级别不存在');
        }

        if (strlen($value) !== $this->levelToCodeLength[$level]) {
            $fail('科目代码长度不正确');
        }

        # 验证唯一性
        $query = FinAccountSubject::com()->where('code', $value);

        if ($subject){
            $query->where('id','!=',$subject->id);
        }

        $exist = $query->exists();
        if ($exist) {
            $fail('科目代码已存在');
        }
    }
}
