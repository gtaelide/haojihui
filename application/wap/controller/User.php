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
use app\admin\model\Catid;
use app\index\model\User as Users;
use think\Session;
use think\Request;

class User extends Base{
    //会员登录
    public function login(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
    //登录处理
    public function loginOK(){
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        
        $name = trim($_POST['username']);
        $passwords = md5(md5(trim($_POST['password'])));
        if( $name=='' || $passwords=='' ){
            $this->error('账号或者密码不能为空');
        }
        $code = trim($_POST['code']);
        if(!captcha_check($code)){
            $this->error('验证码错误,请重新登录','wap/user/login');
        }else{
            $table = new users();   
            $res = $table->where(['username'=>$name,'password'=>$passwords])->find();
            if($res){
                Session::set('uid',$res->id);
                Session::set('name',$res->username);
                Session::set('time',date('Y-m-d H:i:s'));
                $this->success("登录成功！","wap/index/index");
            }else{
                $this->error("账号或密码错误！登录失败！");
            }
        }
    } 
    //会员注册
    public function register(){
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
         $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
    //会员注册处理
    public function registerOk(){
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //会员处理
        $user = new Users();
        $request = Request::instance();
        $username = $request->param('username');
        $pwd1 = $request->param('password1');
        $pwd2 = $request->param('password2');
        if($pwd1 != $pwd2){
            $this->error('两次输入的密码不一致,请检查');
        }else if($pwd1 == '' && $username == ''){
            $this->error('账号或者密码不能为空,请检查');
        }else{
            $pwd1 = md5(md5(trim($pwd1)));
            $res = $user->where('username',$username)->find();
            if($res){
                $this->error('该账号已经存在,请重新注册');
            }else{
                $data = ['username'=>$username,'password'=>$pwd1];
                $resu = $user->save($data);
                if($resu){
                    $this->success('注册成功,请登录','wap/user/login');
                }else{
                    $this->error('注册失败');
                }
            }
        }  
    }
    //会员查看
    public function show(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //会员展示
        $id = Session::get('uid');
        $user = Users::get($id);
        $this->assign('show',$user);
        return $this->fetch();
    }
    //会员修改
    public function update(){
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
        $user = new Users();
        $request = Request::instance();
        $password = $request->param('password');
        $password2 = $request->param('password2');
        $name = $request->param('name');
        $sex = $request->param('sex');
        $address = $request->param('address');
        $birthday = $request->param('birthday');
        $tel = $request->param('tel');
        $email = $request->param('email');
        $qqs = $request->param('qqs');
        if($password != ''){
            if($password == $password2){
                $password = md5(md5(trim($password)));
                $data = [
                   'password'=>$password,
                   'name'=>$name,
                   'sex'=>$sex,
                   'address'=>$address,
                   'birthday'=>$birthday,
                   'tel'=>$tel,
                   'email'=>$email,
                   'qqs'=>$qqs,
                ];
                $res = $user->save($data,['id'=>Session::get('uid')]);
                if($res){
                    $this->success('修改成功','wap/user/login');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error('两次输入的密码不一致,请检查');
            }
        }else{
            $data = [
                'name'=>$name,
                'sex'=>$sex,
                'address'=>$address,
                'birthday'=>$birthday,
                'tel'=>$tel,
                'email'=>$email,
                'qqs'=>$qqs,
            ];
            $res = $user->save($data,['id'=>Session::get('uid')]);
            if($res){
                $this->success('修改成功','wap/user/show');
            }else{
                $this->error('修改失败，请检查');
            }
        }
    }
    //查看订单
    public function showCatid(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        $request = Request::instance();
        $catid = new Catid();
        $catids = $catid->where('uid',$user_uid)->order('id','DESC')->select();
        $this->assign('list',$catids);
        return $this->fetch();
    }
    //查看发货订单
    public function showShop(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        $request = Request::instance();
        $catid = new Catid();
        $catids = $catid->where('mid',$user_uid)->order('id','DESC')->select();
        $this->assign('list',$catids);
        return $this->fetch();
    }
    //确认订单
    public function enterOk(){
        $request = Request::instance();
        $id = $request->param('id');
        $catid = new Catid();
        $data = ['enter'=>1];
        $res = $catid->save($data,['id'=>$id]);
        if($res){
            $this->success("收货成功！",'wap/user/showCatid');
        }else{
            $this->error("收货失败！");
        }
    }
    //确认收发货
    public function shopOk(){
        $request = Request::instance();
        $id = $request->param('id');
        $catid = new Catid();
        $data = ['status'=>1];
        $res = $catid->save($data,['id'=>$id]);
        if($res){
            $this->success("收货成功！",'wap/user/showCatid');
        }else{
            $this->error("收货失败！");
        }
    }
    //查看发布
    public function showMake(){
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
      
        //信息查询
        $article = new Article();
        $res = $article->field('id,title')->whereOr('typeidd','4')->whereOr('typeidd','5')->whereOr('typeidd','6')->whereOr('typeidd','8')->where('uid',$user_uid)->order('id','DESC')->select();
        $this->assign('list',$res);
        return $this->fetch();
    }
    //查看发布
    public function showProduct(){
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
      
        //信息查询
        $article = new Article();
        $res = $article->field('id,title')->whereOr('typeidd','1')->whereOr('typeidd','2')->whereOr('typeidd','3')->whereOr('typeidd','7')->where('uid',$user_uid)->order('id','DESC')->select();
        $this->assign('list',$res);
        return $this->fetch();
    }
    //会员发信息 -- 供求信息
    public function make1(){
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
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }

}