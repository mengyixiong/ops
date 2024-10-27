<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    # 模型默认名称
    public string $name = 'record';

    # 模型默认忽略所有批量赋值字段
    protected $guarded = [];

    # 将 created_at 和 updated_at 转换为指定的日期格式
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    /**
     * 查询时增加主体查询域
     * @param $query
     * @return void
     */
    public function scopeCom($query): void
    {
        $query->where('com_id', auth()->id());
    }


    /**
     * 添加时填充公司
     * @param int $id :主体ID
     */
    public function fillCom(int $id = 0): static
    {
        if (!$id) {
            if (auth()->check()) {
                $id = auth()->user()->current_com_id;
            }
        }

        $this->fill(['com_id' => $id]);
        return $this;
    }

    /**
     * 添加或修改时填充操作人
     * @param bool $isUpdate:是否是修改
     * @return $this
     */

    public function fillOperator(bool $isUpdate = false): static
    {
        if (!auth()->check()) {
            return $this;
        }

        $fill = [
            'update_by' => auth()->id(),
        ];
        if (!$isUpdate) {
            $fill['create_by'] = auth()->id();
        }
        $this->fill($fill);
        return $this;
    }
}
