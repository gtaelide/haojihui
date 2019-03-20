<?php
/*
 * 会员管理
 */
namespace app\admin\controller;
use app\admin\common\Base;
use think\Session;
use think\Request;
use app\admin\model\User as Users;
use app\admin\model\Catid;
use app\admin\model\Address;
class User extends Base{
	//会员管理
	public function userList(){
	    $this->isLogin();
	    $request = Request::instance();
		$user = new Users();
		$address = new Address();
		$adda = $address->where('type',1)->order('id','ASC')->select();
		$this->assign('address',$adda);
		$typeid = $request->param('typeid');
        $username = $request->param('username');
        $tel = $request->param('tel');
        $email = $request->param('email');
        if($typeid != ""){
            $list = $user->where('adda',$typeid)->where('del',0)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
            $num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }elseif ($username != "") {
        	$list = $user->where('username',$username)->where('del',0)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['username'=>$username],]
                );
           	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }elseif ($tel != "") {
        	$list = $user->where('tel',$tel)->where('del',0)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['tel'=>$tel],]
                );
          	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }elseif ($email != "") {
        	$list = $user->where('email',$email)->where('del',0)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['email'=>$email],]
                );
          	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }else{
        	$list = $user->order('id','DESC')->where('del',0)->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
           	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }
	}
	//会员增加
	public function userAdd(){
	    $this->isLogin();
        $address = new Address();
        $list = $address->order('id','DESC')->select();
        $this->assign('list',$list);
	    return $this->fetch();
	}
	//会员增加
	public function userAddOk(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $username = trim($request->param('username'));
	    $user = new Users();
	    $info = $user->where('username',$username)->find();
	    if($info){
	    	$data = ['msg'=>'该用户已经存在，请重新注册','status'=>0];
	    	echo json_encode($data);
	    }else{
            $password = md5(md5(trim($request->param('password1'))));
	        $email = $request->param('email');
	        $tel = $request->param('tel');
	        $address = $request->param('address');
	        $adda = intval($request->param('adda'));
	        $birthday = $request->param('birthday');
	        $name = $request->param('name');
	        $sex = $request->param('sex');
	        $data = [
	            'username'=>$username,
	            'password'=>$password,
	            'email'=>$email,
	            'tel'=>$tel,
	            'address'=>$address,
	            'adda'=>$adda,
	            'birthday'=>$birthday,
	            'name'=>$name,
	            'sex'=>$sex
	        ];   
	        $res = $user->save($data);
	        if($res){
	            $data = ['msg'=>'添加用户成功'];
	            echo json_encode($data);
	        }else{
	            $data = ['msg'=>'添加用户失败，请检查'];
	            echo json_encode($data);
	        }
	    }    
	}
	//会员查看
	public function userShow(){
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $show = Users::get($id);
	    $this->assign('show',$show);
		return $this->fetch();
	}
	//会员修改等级
	public function userUpdate(){
	    $this->isLogin();
		return $this->fetch();
	}
	//会员删除
	public function userDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $show = Users::get($id);
        $catid = new Catid();
        $catid = $catid->where('uid',$id)->find();
        if($catid){
            $data = ['msg'=>'该会员存在未完成订单不得删除!!','status'=>2];
            echo json_encode($data);
        }else{
            $res = $show->save(['del'=>1]);
            if($res){
	            $data = ['msg'=>'删除'.$show->username.'成功','status'=>1];
	            echo json_encode($data);
	        }else{
	    	    $data = ['msg'=>'删除'.$show->username.'失败','status'=>2];
	            echo json_encode($data);
	        }
        }
	}
	//删除会员列表
	public function userDelList(){
        $this->isLogin();
	    $request = Request::instance();
		$user = new Users();
		$address = new Address();
		$adda = $address->where('type',1)->order('id','ASC')->select();
		$this->assign('address',$adda);
		$typeid = $request->param('typeid');
        $username = $request->param('username');
        $tel = $request->param('tel');
        $email = $request->param('email');
        if($typeid != ""){
            $list = $user->where('adda',$typeid)->where('del',1)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
          	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }elseif ($username != "") {
        	$list = $user->where('username',$username)->where('del',1)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['username'=>$username],]
                );
          	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }elseif ($tel != "") {
        	$list = $user->where('tel',$tel)->where('del',1)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['tel'=>$tel],]
                );
           	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }elseif ($email != "") {
        	$list = $user->where('email',$email)->where('del',1)->order('id','DESC')->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['email'=>$email],]
                );
          	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }else{
        	$list = $user->order('id','DESC')->where('del',1)->paginate(8,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
          	$num = count($list);
	        $this->assign('num',$num);
		    $this->assign('list',$list);
		    return $this->fetch();
        }
	}
	//恢复会员
	public function userRecover(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $show = Users::get($id);
	    $res = $show->save(['del'=>0]);
	    if($res){
	        $data = ['msg'=>'会员'.$show->username.'恢复成功','status'=>1];
	        echo json_encode($data);
	    }else{
	    	$data = ['msg'=>'会员'.$show->username.'恢复失败','status'=>2];
	        echo json_encode($data);
	    }
	}
    //会员等级
    public function userLevel(){
         return "<span>该功能模块正在开发中... 敬请期待</span>";
	}
	//会员订单查看
	public function userCatid(){
		$this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $catid = new Catid();
	    $list = $catid->where('uid',$id)->order('createtime','DESC')->select();
	    $this->assign('list',$list);
		return $this->fetch();
	}
}