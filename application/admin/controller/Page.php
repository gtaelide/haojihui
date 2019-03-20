<?php
/*
单页面
 */
namespace app\admin\controller;
use app\admin\common\Base;
use think\Request;
use think\Session;
use app\admin\model\Admin;
use app\admin\model\Pages;
use app\admin\model\Pagetype;
class Page extends Base{
	//展示
	public function pageShow(){
		$this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$pagetype = Pagetype::get($id);
		$this->assign('pagetype',$pagetype);
		$page = new Pages();
		$show = $page->where('typeid',$id)->find();
        $this->assign('show',$show);
        return $this->fetch();
	}
	//新增
	public function pageUpdate(){
		header("Content-Type:application/json;charset=utf-8");
        $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$from=$request->param('from');
		$content = $request->param('content');
		$page = new Pages();
		$data = ['from'=>$from,'content'=>$content,'createtime'=>date('Y-m-d H:i:s')];
		$res = $page->save($data,['id'=>$id]);
		if($res){
			$data = ['msg'=>'更新成功','status'=>1];
			echo json_encode($data);
		}else{
			$data = ['msg'=>'更新失败','status'=>2];
			echo json_encode($data);
		}
	}
}
