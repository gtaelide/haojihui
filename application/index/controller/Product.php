<?php
/*
 * 前台文章
 */
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\Address;
use app\index\model\User;
use think\Request;
use think\Session;
class Product extends Base{
    //文章列表
    public function productList(){
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
        //按分类查找
        $art = new Articles();
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //地区分类
        $adda = new Address();
        $adda_list = $adda->order('id','ASC')->select();
        $this->assign('address',$type_list);
        //最新产品
        $list_right_new = $art->where('types',2)->order('createtime','DESC')->limit(10)->select();
        $this->assign('list_right_new',$list_right_new);
        //热销产品
        $list_right_hot = $art->where('types',2)->order('nums','DESC')->limit(10)->select();
        $this->assign('list_right_hot',$list_right_hot);
        //查询
        $request = Request::instance();
        $pid = $request->param('pid') ? $request->param('pid') : '';
        $date = $request->param('date') ? $request->param('date') : '';
        $type_art = $request->param('type')?$request->param('type') : '';
        $this->assign('pid',$pid);
        $this->assign('url_date',$date);
        if($pid != '' && $date != ''){
            $list = $art->where('typeidd',$pid)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>$pid,'date'=>$date],]
                );
            $this->assign('list',$list);
        }else if($pid != ''){
            $list = $art->where('typeidd',$pid)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>$pid],]
                );
            $this->assign('list',$list);
        }else if($date != ''){
            $list = $art->where('types',2)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['date'=>$date],]
                );
            $this->assign('list',$list);
        }else if($type_art!=''){
            $list = $art->where('typeid',$type_art)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$type_art],]
                );
            $this->assign('list',$list); 
        }else{
            $list = $art->whereOr('typeidd','1')->whereOr('typeidd','2')->whereOr('typeidd','3')->
            whereOr('typeidd','7')->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page']
                );
            $this->assign('list',$list); 
        }
         return $this->fetch();
    }
    //文章展示
    public function productShow(){
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
        $art = Articles::get($id);
        $this->assign('show',$art);
        $art->setInc('nums',1);
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //最新产品
        $list_right_new = $art->where('types',2)->order('createtime','DESC')->limit(10)->select();
        $this->assign('list_right_new',$list_right_new);
        //热销产品
        $list_right_hot = $art->where('types',2)->order('nums','DESC')->limit(10)->select();
        $this->assign('list_right_hot',$list_right_hot);
        return $this->fetch();
    }
    //生成订单
    public function productCatid(){
        $this->isLogin();
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
        //信息分类
        $art = new Articles();
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //展示产品信息加入订单
        $request = Request::instance();
        $id = $request->param('id');
        $show = $art->where('id',$id)->find();
        $this->assign('show',$show);
        $user = User::get($user_uid);
        $this->assign('user',$user);
        return $this->fetch();
    }
    public function productCatidOK(){
        $this->isLogin();
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
        $this->error('该功能模块正在开发！','index/index/index');
    }
}