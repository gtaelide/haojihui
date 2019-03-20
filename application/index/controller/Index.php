<?php
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\Article;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\News;
use app\index\model\Engineering;
use app\index\model\Advert;
use app\index\model\Brand;
use app\index\model\Image;
use app\index\model\User;
use think\Session;
use think\Request;
class Index extends Base
{
    public function index()
    {
        //判断哪个端口访问
        if($this->isMobile()){
            $this->redirect('wap/index/index');
        }
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        $users = User::get($user_uid);
        $this->assign('users',$users);
        //新闻列表
        $article = new Article();
        $art_list = $article->order('createtime','DESC')->select();
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
        $news_list = $news->order('createtime','DESC')->select();
        $this->assign('news',$news_list);
        //工程类类
        $engineer = new Engineering();
        $engineer_list = $engineer->order('createtime','DESC')->select();
        $this->assign('engineer',$engineer_list);
        //广告类
        $ad = new Advert();
        $ad_list = $ad->order('createtime','DESC')->limit(1)->find();
        $ad_id = $ad_list->id;
        $ad_neter = $ad->where('id','<',$ad_id)->limit(1)->find();
        $this->assign('adb',$ad_neter);
        $this->assign('ada',$ad_list);
        //商家类
        $brand = new Brand();
        $brand_list = $brand->order('createtime','DESC')->select();
        $this->assign('brand',$brand_list);
        //幻灯片类
        $img = new Image();
        $img_list = $img->where('type',1)->order('id','ASC')->select();
        $this->assign('img',$img_list);
        return $this->fetch();
    }
    //搜索
    public function search(){
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
        $request = Request::instance();
        $keys = $request->param('keys');
    }
}
