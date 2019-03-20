<?php
/*
广告模型
 */
namespace app\admin\controller;
use app\admin\common\Base;
use think\Request;
use think\Session;
use app\admin\model\Admin as Admins;
use app\admin\model\Advert;
/**
* 广告控制器
*/
class Ad extends Base
{
	//广告列表
	public function adList()
	{
	    $this->isLogin();
	    $ad = new Advert();
	    $request = Request::instance();
	    $res = $ad->order('id','desc')->paginate(10);
	    $num = count($res);
	    $this->assign('num',$num);
	    $this->assign('list',$res);
		return $this->fetch(); 
	}
	//广告删除
	public function adDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$del = Advert::get($id);
		$res = $del->delete();
		if($res){
		    $data = ["msg"=>"该广告位已删除","status"=>1];
		    echo json_encode($data);
		}else{
		    $data = ["msg"=>"删除广告位失败请检查","status"=>2];
		    echo json_encode($data);
		}
	}
	//广告添加
	public function adAdd(){
	    $this->isLogin();
	    $request = Request::instance();
	    return $this->fetch();
	}
	//添加处理
	public function adAddOk(){
	    $this->isLogin();
	    $advert = new Advert();
	    $file = request()->file('img');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            $path =  $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            $this->error($file->getError(),'productAdd');
        }
       //数据更新
        $img = strtr($path,'\\','/');
	    $request = Request::instance();
	    $advert = new Advert();
	    $title = $request->param('title');
	    $href = $request->param('href');
	    $data = [
	        'title'=>$title,
	        'createtime'=> date('Y-m-d H:i:s'),
	        'href'=>$href,
	        'img'=>$img,
	    ];
	    $res = $advert->save($data);
	    if($res){
	        $this->success('添加广告成功','admin/em/closes');

	    }else{
	        $this->error('添加广告失败');
	    }
	}
	//查看
	public function adShow(){
	    $this->isLogin();
	    $request = Request::instance();
        $id = $request->param('id');
	    $advert = Advert::get($id);
	    $this->assign('show',$advert);
		return $this->fetch();
	}
	//产品修改
	public function adShowOk(){
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $advert = new Advert();
	    $file = request()->file('img');
	    if(!empty($file)){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                $path =  $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError(),'productAdd');
            }
            //数据更新
            $img = strtr($path,'\\','/');
	        $title = $request->param('title');
	        $href = $request->param('href');
	        $data = [
	           'title'=>$title,
	           'href'=>$href,
	           'img'=>$img,
	        ];
	        $res = $advert->save($data,['id'=>$id]);
	        if($res){
	           $this->success('修改广告成功','admin/em/closes');
	        }else{
	           $this->error('修改广告失败');
	        }
        }else{	       
	        $title = $request->param('title');
	        $href = $request->param('href');
	        $data = [
	           'href'=>$href,
	           'title'=>$title,
	        ];
	        $res = $advert->save($data,['id'=>$id]);
	        if($res){
	           $this->success('修改广告成功','admin/em/closes');
	        }else{
	           $this->error('修改广告失败');
	        }
        }
        
	}
}