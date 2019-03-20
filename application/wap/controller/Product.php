<?php
namespace app\wap\controller;
use app\wap\common\Base;
use app\index\model\Article;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\News;
use app\index\model\Engineering;
use app\index\model\Advert;
use app\index\model\Brand;
use app\index\model\Image;
use app\index\model\User;
use app\index\model\Pages;
use think\Session;
use think\Request;

class Product extends Base{
	public function lists(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        $users = User::get($user_uid);
        $this->assign('users',$users);
        //资讯列表
        $request = Request::instance();
        $choose = !empty($request->param('choose')) ?  $request->param('choose') : 0;
        $article = new Article();
       
        if($choose == 0){
            $art_list = $article->whereOr('typeidd',1)->whereOr('typeidd',2)->whereOr('typeidd',3)->whereOr('typeidd',7)->order('createtime','DESC')->select();
            $this->assign('list',$art_list);
        }else if($choose == 1){
            //机械买卖2
            $art_list = $article->where('typeidd',2)->order('createtime','DESC')->select();
            $this->assign('list',$art_list);
        }else if($choose == 2){
            //机械租赁1
            $art_list = $article->where('typeidd',1)->order('createtime','DESC')->select();
            $this->assign('list',$art_list);
        }else if($choose == 3){
            //建筑材料
            $art_list = $article->where('typeidd',3)->order('createtime','DESC')->select();
            $this->assign('list',$art_list);
        }else if($choose = 4){
            //配件五金7
            $art_list = $article->where('typeidd',7)->order('createtime','DESC')->select();
            $this->assign('list',$art_list);
        }
        //资讯分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //广告类
        $ad = new Advert();
        $ad_list = $ad->order('createtime','DESC')->limit(1)->find();
        $ad_id = $ad_list->id;
        $ad_neter = $ad->where('id','<',$ad_id)->limit(1)->find();
        $this->assign('adb',$ad_neter);
        $this->assign('ada',$ad_list);
 
	    return $this->fetch();
	}
    //新闻列表
    public function show(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        $users = User::get($user_uid);
        $this->assign('users',$users);
        $article = new Article();
        $request = Request::instance();
        $id = $request->param('id');
        $res = $article->where('id',$id)->find();
        $this->assign('show',$res);
        return $this->fetch();
    }
    //招商合作页面
    public function indexBrand(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        $users = User::get($user_uid);
        $this->assign('users',$users);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //页面获取
        $pages = new Pages();
        $res = $pages->where('id',10)->find();
        $this->assign('show',$res);
        return $this->fetch();
    }
    //订单提交
    public function orderSubmit(){
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
        $request = Request::instance();
        $use = User::get($user_uid);
        $id = $request->param('id');
        $article = new Article();
        $res = $article->where('id',$id)->find();
        $this->assign('show',$res);
        $this->assign('user',$use);
        return $this->fetch();
    }
}