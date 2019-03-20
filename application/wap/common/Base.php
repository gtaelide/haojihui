<?php
/*
 * 公共控制器
*/
namespace app\wap\common;
use think\Controller;
use think\Session;
class Base extends Controller{
    //前置方法
    
    //是否已经登录
    protected function isLogin(){
        if(is_null(Session::get('uid'))){
            $this->redirect('wap/user/login');
        }
    }
    //判断是否为重复登录
    protected function alreadyLogin(){
        if(!is_null(Session::get('uid'))){
            $this->error('请不要重复登录','wap/index/index');
        }
    }
}