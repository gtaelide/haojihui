<?php
/*
 * 登陆模块
 */
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;
use app\admin\common\Base;
use app\admin\model\System;
use think\Session;
class Login extends Base{
    //登录页
    public function login(){
        $system = System::get('1');
        $this->assign('system',$system);
        return $this->fetch();
    }
    //登录检测方法
    public function loginOk(){
        $name = trim($_POST['username']);
        $passwords = md5(md5(trim($_POST['pwd'])));
        if( $name=='' || $passwords=='' ){
            $this->error('账号或者密码不能为空');
        }
        $code = trim($_POST['code']);
        if(!captcha_check($code)){
            $this->error('验证码错误,请重新登录','admin/login/login');
        }else{
            $table = new Admin();
            $res = $table->where(['username'=>$name,'password'=>$passwords])->find();
            if($res){
                $table->where('username',$name)->setInc('nums',1);
                Session::set('aid',$res->id);
                Session::set('username',$res->username);
                Session::set('time',date('Y-m-d H:i:s'));
                $this->success("登录成功！","admin/index/index");
            }else{
                $this->error("账号或密码错误！登录失败！");
            }
        }
    }
    //退出   
    public function loginOut(){
        Session::delete('aid');
        Session::delete('username');
        Session::delete('time');
        $this->success('退出成功','admin/login/login');
    }
}
?>