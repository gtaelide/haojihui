<?php
/*
 * 信息分类
 */
namespace app\index\model;
use think\Model;
class Engineering extends Model{
     public function type()
    {
        return $this->belongsTo('Enginertype','typeid');
    }
}