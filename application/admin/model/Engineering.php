<?php
namespace app\admin\model;
use think\Model;

class Engineering extends Model{
	public function type()
    {
        return $this->belongsTo('Enginertype','typeid');
    }
    public function addressadda(){
        return $this->belongsTo('Address','adda');
    }
}