<?php
/*
 * 订单模型
 */
namespace app\index\model;
use think\Model;
class Catid extends Model{
    public function product(){
    	return $this->belongsTo('Article','pid');
    }
    public function user(){
        return $this->belongsTo('User','uid');
    }
}