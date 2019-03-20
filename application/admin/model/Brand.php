<?php 
/*
合作商家
 */
namespace app\admin\model;
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