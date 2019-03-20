<?php
/*
 * 管理员管理
 */
namespace app\admin\controller;
use app\admin\common\Base;

use think\Request;
use think\Session;
use app\admin\model\Admin as Admins;
class Admin extends Base{
	//管理员管理
	public function adminList(){
	    $this->isLogin();
	    $admin = new Admins();
	    $request = Request::instance();
	    $username = $request->param('username');
	    if($username != ''){
            $list = $admin->where('username',$username)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['username'=>$username],]
                );
            $num = count($list);
	        $this->assign('num',$num);
	         $this->assign('list',$list);
		     return $this->fetch();
	    }else{
	    	$list = $admin->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	    	$num = count($list);
	        $this->assign('num',$num);
	        $this->assign('list',$list);
		    return $this->fetch();
	    }
	}
	//管理员增加
	public function adminAdd(){
	    $this->isLogin();
		return $this->fetch();
	}
	//管理员查看
	public function adminShow(){
		$request = Request::instance();
	    $id = Session::get('aid');
	    $admins = Admins::get($id);
	    $this->assign('show',$admins);
		return $this->fetch();
	}
	//管理员删除
	public function adminDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    if($id == 1){
            $data = ["msg"=>"超级管理员不能删除！","status"=>0];
            echo json_encode($data);
	    }else if($id == Session::get('aid')){
	    	$data = ["msg"=>'对不起,您不能删除自己！','status'=>3];
	    	echo json_encode($data);
	    }else{
	    	$admin = Admins::get($id);
            $res = $admin->delete();
            if($res){
                $data = ['msg'=>'该管理员已删除','status'=>1];
                echo json_encode($data);
            }else{
                $data = ['msg'=>'该管理员删除失败','status'=>2];
                echo json_encode($data);
            }
	    }
	}
	//管理员增加
	public function adminAddOk(){
		header("Content-Type:application/json;charset=utf-8");
		$admins = new Admins();
		$request = Request::instance();
		$username = trim($request->param('username'));
		$info = $admins->where('username',$username)->find();
		if($info){
			$data = ['msg'=>'该用户已经存在，请重新注册','status'=>0];
			echo json_encode($data);
		}else{
            $password = md5(md5(trim($request->param('password'))));
		    $phone = $request->param('tel');
		    $email = $request->param('email');
		    $data = ['username'=>$username,'password'=>$password,'tel'=>$phone,'email'=>$email,'createtime'=>date("Y-m-d H:i:s")];
		    $res = $admins->save($data);
		    if($res){
                $data = ['msg'=>'添加管理员成功','status'=>1];
                echo json_encode($data);
		    }else{
                $data = ['msg'=>'添加管理员失败','status'=>2];
                echo json_encode($data);
		    }
		}
	}
	//管理员修改
	public function adminUpdate(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$admins = new Admins();
		$request = Request::instance();
		$pass = $request->param('password2');
		if( strlen($pass)  == 0){
		    $data = ['msg'=>'密码不得为空','status'=>0];
		    echo json_encode($data);
		}elseif( strlen($pass) < 4 || strlen($pass) > 20 ){
			$data = ['msg'=>'密码不得少于4位或者多于20位','status'=>2];
			echo json_encode($data);
		}else{
            $password = md5(md5(trim($request->param('password'))));
		    $info = $admins->where('username',Session::get('username'))->where('password',$password)->find();
		    if($info){
			    $pass = md5(md5(trim($pass)));
			    $phone = $request->param('tel');
			    $email = $request->param('email');
			    $data = ['password'=>$pass,'tel'=>$phone,'email'=>$email];
			    $res = $admins->save($data,['id'=>Session::get('aid')]);
			    if($res){
                     $data = ['msg'=>'修改信息成功','status'=>1];
			         echo json_encode($data);
			    }else{
                     $data = ['msg'=>'修改信息失败','status'=>4];
			         echo json_encode($data);
			    }
		    }else{
		        $data = ['msg'=>'原密码不正确，不得修改密码','status'=>3];
			    echo json_encode($data);
		    }

	    }
	}
}