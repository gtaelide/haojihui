<?php
/**
* 幻灯片控制器
*/
namespace app\admin\controller;
use app\admin\common\Base;
use app\admin\model\Image as Images;
use think\Session;
use think\Request;
use think\Db;
class Image extends Base
{
	//列表页
	public function imageList()
	{
		$this->isLogin();
		$img = new Images();
		$list = $img->order('id','ASC')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}
	//查看修改
	public function imageShow(){
		$request = Request::instance();
		$id = $request->param('id');
		$img = Images::get($id);
		$this->assign('show',$img);
		return $this->fetch();
	}
	//修改
	public function imageShowOk(){
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $image = new Images();
	    $file = request()->file('img');
	    if(!empty($file)){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                $path =  $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError(),'brandShow');
            }
            //数据更新
            $img = strtr($path,'\\','/');
	        $title = $request->param('title');
	        $content = $request->param('content');
	        $createtime = date("Y-m-d H:i:s");
	        $keys = $request->param('keys');
	        $from = $request->param('from');
	        $data = [
	            'title'=>$title,
	            'img'=>$img,
	            'content'=>$content,
	            'createtime'=>$createtime,
	            'keys'=>$keys,
	            'from'=>$from
	        ];
	        $res = $image->save($data,['id'=>$id]);
	        if($res){
	            $this->success('幻灯片信息修改成功','admin/em/closes');
	        }else{
	            $this->error('幻灯片信息修改失败');
	        }
        }else{	       
	        $title = $request->param('title');
	        $content = $request->param('content');
	        $createtime = date("Y-m-d H:i:s");
	        $keys = $request->param('keys');
	        $from = $request->param('from');
	        $data = [
	            'title'=>$title,
	            'content'=>$content,
	            'createtime'=>$createtime,
	            'keys'=>$keys,
	            'from'=>$from
	        ];
	        $res = $image->save($data,['id'=>$id]);
	        if($res){
	            $this->success('幻灯片信息修改成功','admin/em/closes');
	    	
	        }else{
	            $this->error('幻灯片信息修改失败');
	        }
        }   
	}
	//幻灯片关闭
	public function imageStop(){
		header("Content-type:application/json;charset=utf-8");
		$request = Request::instance();
		$id = $request->param('id');
	    $img = Images::get($id);
	    $res = $img->save(['type'=>0]);
        if($res){
            $data = ['msg'=>'已关闭','status'=>1];
			echo json_encode($data);
        }else{
        	$data = ['msg'=>'关闭失败','status'=>2];
			echo json_encode($data);
        }   
	}
	//幻灯片开启
	public function imageStart(){
		header("Content-type:application/json;charset=utf-8");
        $request = Request::instance();
		$id = $request->param('id');
	    $img = Images::get($id);
	    $res = $img->save(['type'=>1]);
        if($res){
            $data = ['msg'=>'已开启','status'=>1];
			echo json_encode($data);
        }else{
        	$data = ['msg'=>'开启失败','status'=>2];
			echo json_encode($data);
        }   
	}
}