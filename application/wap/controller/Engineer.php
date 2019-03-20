<?php
namespace app\wap\controller;
use app\wap\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\News;
use app\index\model\Engineering;
use app\index\model\Enginertype;
use app\index\model\Advert;
use app\index\model\Brand;
use app\index\model\Image;
use app\index\model\User;
use app\index\model\Address;
use think\Session;
use think\Request;

class Engineer extends Base{
    public function lists(){
	    //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
         //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        $request=Request::instance();
        $engineering = new Engineering();
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //分类 
        $engineertype = new Enginertype();
        $engineertype_list = $engineertype->order('id','ASC')->select();
        $this->assign('engineertype',$engineertype_list);
        //右侧
        $engineering_right =  $engineering->order('nums','DESC')->limit(20)->select();
        $this->assign('engineering_right',$engineering_right);
        //查询
        $typeid = $request->param('type') ? $request->param('type') : '';
        $this->assign('type_id',$typeid);
        if($typeid != ''){
            $list = $engineering->where('typeid',$typeid)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$typeid],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else{
            $list = $engineering->order('id','DESC')->paginate(20);
            $this->assign('list',$list);
            return $this->fetch();
        }
    }
    //工程项目展示
    public function show(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
         //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        $request = Request::instance();
        $id = $request->param('id');
        $engineer = Engineering::get($id);
        $this->assign('show',$engineer);
        $engineer->setInc('nums',1);
        //工程分类
        $engineertype = new Enginertype();
        $engineertype_list = $engineertype->order('id','ASC')->select();
        $this->assign('engineertype',$engineertype_list);
        $type_id = $request->param('type')?$request->param('type'):'';
        $this->assign('type_id',$type_id);
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //右侧
        $engineering = new Engineering();
        $engineering_right =  $engineering->order('nums','DESC')->select();
        $this->assign('engineering_right',$engineering_right);
        //前篇 后篇
        $engineering->where('id',$id)->setInc('nums',1);
        $front = $engineering->where("id",'>',$id)->order('id','ASC')->limit('1')->find();
        if(!empty($front)){
            $this->assign('front',$front);
        }else{
            $this->assign('front','');
        }
        $after = $engineering->where("id",'<',$id)->order('id','DESC')->limit('1')->find();
        if(!empty($after)){
            $this->assign('after',$after);
        }else{
            $this->assign('after','');
        }
        return $this->fetch();
    }
}