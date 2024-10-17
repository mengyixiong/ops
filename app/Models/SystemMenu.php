<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemMenu extends BaseModel
{
    /**
     * 使用关联模型获取顶级分类
     */
    public function cates() {
        return $this->hasMany(get_class($this), 'pid' ,'id');
    }

    /**
     * 获取所有子集分类
     */
    public function children() {
        return $this->cates()->with( 'children' );
    }

    /**
     * 获取上级
     */
    public function parent() {
        return $this->belongsTo(get_class($this), 'pid' ,'id');
    }

    public function getAncestors()
    {
        $ancestors = collect([]);

        $parent = $this->parent;
        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }
}
