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

class Index extends Base{
	public function index(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        $users = User::get($user_uid);
        $this->assign('users',$users);
        //产品资讯
        $article = new Article();
        $art_list = $article->whereOr('typeidd',1)->whereOr('typeidd',2)->whereOr('typeidd',3)->whereOr('typeidd',7)->order('createtime','DESC')->limit(9)->select();
        $this->assign('article',$art_list);
        //资讯分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //新闻类
        $news = new News();
        $news_list = $news->field('id,title,desc,createtime')->order('createtime','DESC')->limit(10)->select();
        $this->assign('news',$news_list);
        //广告类
        $ad = new Advert();
        $ad_list = $ad->order('createtime','DESC')->limit(1)->find();
        $ad_id = $ad_list->id;
        $ad_neter = $ad->where('id','<',$ad_id)->limit(1)->find();
        $this->assign('adb',$ad_neter);
        $this->assign('ada',$ad_list);
        //商家类
        $brand = new Brand();
        $brand_list = $brand->order('createtime','DESC')->limit(0,3)->select();
        $this->assign('brand',$brand_list);
        //幻灯片类
        $img = new Image();
        $img_list = $img->where('type',1)->order('id','ASC')->select();
        $this->assign('img',$img_list);
        $about = new Pages();
        $pages = $about->where('id',1)->find();
        $this->assign('about',$pages);
	    return $this->fetch();
	}
    //新闻列表
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
        $ad = new Advert();
        $ads = $ad->order('id','DESC')->find();
        $this->assign('ad',$ads);
        $news = new News();
        $request = Request::instance();
        $id = $request->param('id');
        $news_list = $news->order('id','DESC')->select();
        $this->assign('list',$news_list);
        return $this->fetch();
    } 
    //新闻展示
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
        $news = new News();
        $request = Request::instance();
        $id = $request->param('id');
        $news_list = $news->where('id',$id)->find();
        $this->assign('show',$news_list);
        return $this->fetch();
    }
    //招商合作页面
    public function pages(){
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
        $id = $_GET['id'];
        $res = $pages->where('id',$id)->find();
        $this->assign('id',$id);
        $this->assign('show',$res);
        return $this->fetch();
    }

}