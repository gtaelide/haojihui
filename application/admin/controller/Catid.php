<?php
/*
 * 订单管理
 * 
 */
namespace app\admin\controller;
use app\admin\model\Article as Articles;
use app\admin\model\Articletype;
use app\admin\model\Address;
use app\admin\model\Catid as Catids;
use app\admin\common\Base;
use think\Request;
use think\Session;
class Catid extends Base{
	//订单列表:未完结
	public function catidList1() {
	    $this->isLogin();
	    $catid = new Catids();
	    $request = Request::instance();
	    $name = $request->param('name');
	    $before = $request->param('before');
	    $after = $request->param('after');
	    if($name != ''){
	        $res = $catid->where('bian',$name)->where('enter',0)->order('id','DESC')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $this->assign('list',$res);
	        $num = count($res);
	        $this->assign('num',$num);
	        return $this->fetch();
	    }else if($before != '' && $after != ''){ 
	        $res = $catid->where('createtime','between time',[$before,$after])->where('enter',0)->order('id','DESC')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else{
	        $res = $catid->where('enter',0)->order('id','desc')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }   
	}
	//订单列表:已完结
	public function catidList2() {
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $catid = new Catids();
	    $request = Request::instance();
	    $name = $request->param('name');
	    $before = $request->param('before');
	    $after = $request->param('after');
	    if($name != ''){
	        $res = $catid->where('bian',$name)->where('enter',1)->order('id','DESC')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($before != '' && $after != ''){ 
	        $res = $catid->where('createtime','between time',[$before,$after])->where('enter',1)->order('id','DESC')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        echo $this->fetch();
	    }else{
	        $res = $catid->where('enter',1)->order('id','desc')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }   
	}
	//订单查看
	public function catidShow1() {
	    $this->isLogin();
	    $catid = new Catids();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $catid = Catids::get($id);
	    $this->assign('show',$catid);
		return $this->fetch();
	}
	//订单查看：已完结
	public function catidShow2() {
	    $this->isLogin();
	    $catid = new Catids();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $catid = Catids::get($id);
	    $this->assign('show',$catid);
	    return $this->fetch();
	}	
	//订单查看：已完结
	public function catidShow2Ok() {
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $data = ['msg'=>'','status'=>1];
        echo json_encode($data);
	}	
	//订单发货处理
	public function catidShow1Ok(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $catid = new Catids();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $data = ['status'=>$request->param('status'),'fatime'=>date("Y-m-d H:i:s"),'daima'=>$request->param('daima')];
	    $res = $catid ->save($data,['id'=>$id]);
	    if($res){
	    	$data = ['msg'=>'发货成功，请返回刷新页面','status'=>1];
	    	echo json_encode($data);
	    }else{
	    	$data = ['msg'=>'发货失败，请检查','status'=>0];
	    	echo json_encode($data);
	    }
	}
	//订单删除
	public function catidDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $catid = Catids::get($id);
	    $bian = $catid->bian;
	    $res = $catid->delete();
	    if($res){
	    	$data =['msg'=>'订单:'.$bian.',已删除!','status'=>1];
	    	echo json_encode($data);
	    }else{
	    	$data =['msg'=>'订单'.$bian.',删除失败！','status'=>0];
	    	echo json_encode($data);
	    }
	}
	//订单收货处理
	public function catidEnter(){
	    $this->isLogin();
		return $this->fetch();
	}
	
}