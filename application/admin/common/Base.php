<?php
/*
 * 公共控制器
 */
namespace app\admin\common;
use think\Controller;
use think\Session;
class Base extends Controller{
    //是否已经登录
    protected function isLogin(){
        if(is_null(Session::get('aid'))){
            $this->redirect('admin/login/login');
        }
    }
    //判断是否为重复登录
    protected function alreadyLogin(){
        if(!is_null(Session::get('aid'))){
            $this->error('请不要重复登录','admin/index/index');
        }
    }
}