<?php
namespace app\wap\controller;
use app\wap\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\News;
use app\index\model\Engineering;
use app\index\model\Advert;
use app\index\model\Brand;
use app\index\model\Image;
use app\index\model\User;
use app\index\model\Address;
use think\Session;
use think\Request;

class Article extends Base{
    //文章列表
    public function lists(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_name);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //按分类查找
        $art = new Articles();
        $type = new Articletype();
        $type_list = $type->order('id','ASC')->select();
        $this->assign('articletype',$type_list);
        //地区分类
        $adda = new Address();
        $adda_list = $adda->order('id','ASC')->select();
        $this->assign('address',$adda_list);
        //广告
        $ad = new Advert();
        $ads = $ad->order('id','DESC')->find();
        $this->assign('ad',$ads);
        //查询
        $request = Request::instance();
        $address = $request->param('address') ? $request->param('address') : '';
        $this->assign('url_address',$address);
        $date = $request->param('date') ? $request->param('date') : '';
        $this->assign('date',$date);
        $type_art = $request->param('type') ? $request->param('type') : '';
        $choose = $request->param('choose') ? $request->param('choose'): '';
        if($address != ''){
            $list = $art->whereOr('typeidd',4)->whereOr('typeidd',5)->whereOr('typeidd',6)->whereOr('typeidd',8)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }elseif ($choose != '') {
             $list = $art->where('typeidd',$choose)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$type_art],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else if($date != ''){
            $list = $art->whereOr('typeidd',4)->whereOr('typeidd',5)->whereOr('typeidd',6)->whereOr('typeidd',8)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['date'=>$date],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else if($type_art != ''){
            $list = $art->where('typeidd',$type_art)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$type_art],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else{
            $list = $art->field('id,title,createtime')->whereOr('typeidd',4)->whereOr('typeidd',5)->whereOr('typeidd',6)->whereOr('typeidd',8)->order('id','DESC')->paginate(20);
            $this->assign('list',$list);
            return $this->fetch();
        }
    }
    //展示页
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
        $art = Articles::get($id);
        $this->assign('show',$art);
        $art->setInc('nums',1);
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //右侧信息  1
        $art_right = new Articles();
        $art_right1 = $art_right->where('types',1)->order('createtime','DESC')->limit(1)->select();
        $this->assign('right1',$art_right1);
        //右侧信息  2
        $art_right2 = $art_right->where('types',3)->where('filled',1)->order('createtime','DESC')->limit(1)->select();
        $this->assign('right2',$art_right2);
        //右侧信息  3
        $art_right3 = $art_right->where('types',3)->where('filled',0)->order('createtime','DESC')->limit(1)->select();
        $this->assign('right3',$art_right3);
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
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //按分类查找
        $art = new Articles();
        $type = new Articletype();
        $type_list = $type->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //地区分类
        $adda = new Address();
        $adda_list = $adda->order('id','ASC')->select();
        $this->assign('address',$adda_list);
        //查询
        $request = Request::instance();
        $pid = $request->param('pid') ? $request->param('pid') : '';
        $this->assign('pid',$pid);
        $address = $request->param('address') ? $request->param('address') : '';
        $this->assign('url_address',$address);
        $date = $request->param('date') ? $request->param('date') : '';
        $this->assign('date',$date);
        $keys = $request->param('search');
        $list = $art->whereOr('typeidd',1)->whereOr('typeidd',2)->whereOr('typeidd',3)->whereOr('typeidd',7)->where('title','like','%'.$keys.'%')->order('id','DESC')->paginate(20);
        $this->assign('list',$list);
        $this->assign('keys',$keys);
        return $this->fetch();
    }
}