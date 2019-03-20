<?php
/*
 * 文章咨询模型
 */
namespace app\admin\model;
use think\Model;

class Article extends Model{
    public function type()
    {
        return $this->belongsTo('Articletype','typeid');
    }
    public function addressadda(){
        return $this->belongsTo('Address','adda');
    }
    public function addressaddb(){
        return $this->belongsTo('Address','addb');
    }
    public function addressaddc(){
        return $this->belongsTo('Address','addc');
    }
}