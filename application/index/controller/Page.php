<?php
/*
 * 前台文章
 */
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\Pages;
use app\index\model\System;
use think\Request;
use think\Session;
class Page extends Base{
    //z展示
    public function pageShow(){
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
        $art = new Articles();
        $request = Request::instance();
        $id = $request->param('id');
        //单页面展示
        $page = Pages::get($id);
        $this->assign('show',$page);
        $pages = new Pages();
        $pages = $pages->order('id','ASC')->select();
        $this->assign('pages',$pages);
        //文章分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
    //文章展示
    public function articleShow(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
}