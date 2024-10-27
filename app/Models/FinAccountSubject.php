<?php

namespace App\Models;
class FinAccountSubject extends BaseModel
{
    /**
     * 使用关联模型获取顶级分类
     */
    public function cates()
    {
        return $this->hasMany(get_class($this), 'pid', 'id');
    }


    public function children()
    {
        return $this->cates()->with('children');
    }

}
