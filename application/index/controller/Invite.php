<?php
/*
工程人员
 */
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\Address;
use think\Request;
use think\Session;
class Invite extends Base{
    //文章列表
    public function inviteList(){
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
        //职位分类
        $type = new Articletype();
        $position = $type->where('pid',5)->order('id','DESC')->select();
        $this->assign('position',$position);
        //分类直通车
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //地区分类
        $add = new Address();
        $adda = $add->where('type',1)->order('id','ASC')->select();
        $this->assign('address',$adda);
        //右侧
        $art = new Articles();
        $list_left_new = $art->where('types',3)->where('filled',0)->order('createtime','DESC')->limit(15)->select();
        $list_left_hot = $art->where('types',3)->where('filled',1)->order('nums','DESC')->limit(15)->select();
        $this->assign('list_left_new',$list_left_new);
        $this->assign('list_left_hot',$list_left_hot);
        //请求变量
        $request = Request::instance();
        $address = $request->param('address') ? $request->param('address') : '';
        $date = $request->param('date') ? $request->param('date') : '';
        $position = $request->param('position') ? $request->param('position') : '';
        $type_art = $request->param('type') ? $request->param('type') : '';
        $this->assign('url_address',$address);
        $this->assign('url_date',$date);
        $this->assign('url_position',$position);
        //文章查询
        if($address != '' && $date !='' && $position != ''){
            $list = $art->where('types',3)->where('adda',$address)->where('typeid',$position)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'$date'=>$date,'position'=>$position],]
                );
            $this->assign('list',$list);
        }elseif($address != '' && $date !=''){
            $list = $art->where('types',3)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'$date'=>$date,],]
                );
            $this->assign('list',$list);
        }elseif($address != '' && $position != ''){
            $list = $art->where('types',3)->where('adda',$address)->where('typeid',$position)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'position'=>$position]]
                );
            $this->assign('list',$list);
        }elseif($date !='' && $position != ''){
            $list = $art->where('types',3)->where('typeid',$position)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['$date'=>$date,'position'=>$position]]
                );
            $this->assign('list',$list);
        }elseif($address != ''){
            $list = $art->where('types',3)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address],]
                );
            $this->assign('list',$list);
        }elseif($date !=''){
            $list = $art->where('types',3)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['date'=>$date],]
                );
            $this->assign('list',$list);
        }elseif($position != ''){
            $list = $art->where('types',3)->where('typeid',$position)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['position'=>$position],]
                );
            $this->assign('list',$list);
        }elseif($type_art != ''){
            $list = $art->where('types',3)->where('typeid',$type_art)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$type_art],]
                );
            $this->assign('list',$list);
        }else{
            $list = $art->where('types',3)->order('id','DESC')->paginate(20);
            $this->assign('list',$list);
        }
        //渲染输出
        return $this->fetch();
    }
    //文章展示
    public function inviteShow(){
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
        //右侧
        $list_left_new = $art->where('types',3)->where('filled',0)->order('createtime','DESC')->paginate(15);
        $list_left_hot = $art->where('types',3)->where('filled',1)->order('nums','DESC')->paginate(15);
        $this->assign('list_left_new',$list_left_new);
        $this->assign('list_left_hot',$list_left_hot);
        //需求直通车
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
}