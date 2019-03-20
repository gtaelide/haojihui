<?php
/*
首页新闻
 */
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\Engineering;
use app\index\model\Enginertype;
use app\index\model\Articletype;
use app\index\model\News as Newss;
use app\index\model\System;
use think\Request;
use think\Session;

class News extends Base{
	//列表
   public function newsList(){
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
        //直通车
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //右侧 
        $news = new Newss();
        $new_right_hot = $news->order('id','DESC')->limit(10)->select();
        $new_right_hang = $news->where('type',1)->order('nums','DESC')->limit(10)->select();
        $new_right_gong = $news->where('type',2)->order('nums','DESC')->limit(10)->select();
        $this->assign('new_right_hot',$new_right_hot);
        $this->assign('new_right_hang',$new_right_hang);
        $this->assign('new_right_gong',$new_right_gong);
        //分类查询
        $request = Request::instance();
        $typeid = $request->param('type')?$request->param('type') : '';
        $this->assign('typeid',$typeid);
        if($typeid != ''){
            $list = $news->where('type',$typeid)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$typeid],]
                );
            $this->assign('list',$list);
        }else{
            $list = $news->order('id','DESC')->paginate(15);
            $this->assign('list',$list);
        }
		return $this->fetch();
   }
	//查看
	public function newsShow(){
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
        $news = Newss::get($id);
        $this->assign('show',$news);
        $news->setInc('nums',1);
        //右侧
        $new_right_hot = $news->order('id','DESC')->limit(10)->select();
        $new_right_hang = $news->where('type',1)->order('nums','DESC')->limit(10)->select();
        $new_right_gong = $news->where('type',2)->order('nums','DESC')->limit(10)->select();
        $this->assign('new_right_hot',$new_right_hot);
        $this->assign('new_right_hang',$new_right_hang);
        $this->assign('new_right_gong',$new_right_gong);
        //查询
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        $news = new Newss();
        $news->where('id',$id)->setInc('nums',1);
        $front = $news->where("id",'>',$id)->order('id','ASC')->limit('1')->find();
        if(!empty($front)){
        	$this->assign('front',$front);
        }else{
        	$this->assign('front','');
        }
        $after = $news->where("id",'<',$id)->order('id','DESC')->limit('1')->find();
        if(!empty($after)){
        	$this->assign('after',$after);
        }else{
        	$this->assign('after','');
        }
        $this->assign('after',$after);
        return $this->fetch();
	}
}