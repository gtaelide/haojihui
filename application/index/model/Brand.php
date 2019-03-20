<?php 
/*
合作商家
 */
namespace app\index\model;
use think\Model;
/**
* 
*/
class Brand extends Model
{
	public function addressadda(){
        return $this->belongsTo('Address','adda');
    }
}