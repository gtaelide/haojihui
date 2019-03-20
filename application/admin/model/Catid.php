<?php 
/**
* 订单模型
*/
namespace app\admin\model;
use think\Model;
class Catid extends Model
{
	public function user(){
        return $this->belongsTo('User','uid');
    }
    public function product(){
        return $this->belongsTo('Article','pid');
    }
}