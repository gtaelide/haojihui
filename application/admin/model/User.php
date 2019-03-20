<?php
/*
 *
 * 会员控制模型
 */
namespace app\admin\model;

use think\Model;
class User extends Model{
    //关联地区模型
    public function addas(){
        return $this->belongsTo('Address','adda');
    }
}