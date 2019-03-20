<?php
/*
 * 商家品牌
 */
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\Brand as Brands;
use app\index\model\System;
use app\index\model\Address;
use think\Request;
use think\Session;
class Brand extends Base{
    //列表
    public function brandList(){
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
        //条件查询
        $request = Request::instance();
        $brand = new Brands();
        $adda = $request->param('adda')?$request->param('adda'):'';
        $this->assign('adda',$adda);
        if($adda != ''){
            $list = $brand->where('adda',$adda)->where('allow',1)->order('id','DESC')->paginate(16,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['adda'=>$adda],]
                );
            $this->assign('list',$list);
        }else{
            $list = $brand->where('allow',1)->order('id','DESC')->paginate(16);
            $this->assign('list',$list);
        }
        //左侧商家
        $left_brand = $brand->where('allow',1)->order('createtime','DESC')->limit(5)->select();
        $this->assign('left_brand',$left_brand);
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //地区处理
        $address = new Address();
        $address = $address->order('id','DESC')->select();
        $this->assign('address',$address);
        return $this->fetch();
    }
    //文章展示
    public function brandShow(){
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
    //商家申请
    public function brandShen(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //申请处理
        $name = $request->param('name');
        $catid = $request->param('catid');
        $yin = $request->param('yin');
        $tel = $request->param('tel');
        $qqs = $request->param('qqs');
        $href = $request->param('href');
        $desc = $request->param('desc');
        $adda = $request->param('adda');
        $data = ['name'=>$name,'catid'=>$catid,'yin'=>$yin,'tel'=>$tel,'qqs'=>$qqs,'href'=>$href,'desc'=>$desc,'createtime'=>date('Y-m-d H:i:s'),'allow'=>0,'adda'=>$adda];
        $brand = new Brands();
        $res = $brand->save($data);
        if($res){
            $this->success('申请成功，请等待客服联系','index/brand/brandList');
        }else{
            $this->success('申请失败，请检查申请资料','index/brand/brandList');
        }
    }
}