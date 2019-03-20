<?php
/*
 * 资讯信息管理
 */
namespace app\admin\controller;
use app\admin\model\Article as Articles;
use app\admin\model\Articletype;
use app\admin\model\Address;
use app\admin\model\Brand as Brands;
use app\admin\common\Base;
use think\Request;
use think\Session;
class Brand extends Base{
	//列表
	public function brandList(){
        $this->isLogin();
        $brand = new Brands();
        $address = new Address();
        $adda = $address->where('type',1)->order('id','ASC')->select();
        $this->assign('adda',$adda);
        $request = Request::instance();
	    $name = $request->param('name');
	    $typeid = $request->param('typeid');
	    $tel = $request->param('tel');
	    $yin = $request->param('yin');
	    if($name != ''){
	        $res = $brand->where('name','like','%'.$name.'%')->where('allow',1)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($typeid != ''){
	        $res = $brand->where('adda',$typeid)->where('allow',1)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($tel != ""){ 
	        $res = $brand->where('tel',$tel)->where('allow',1)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['tel'=>$tel],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($yin != ""){
	        $res = $brand->where('yin','like','%'.$yin.'%')->where('allow',1)->order('createtime','desc')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['yin'=>$yin],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }else{
	    	$res = $brand->where('allow',1)->order('createtime','desc')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	    	$num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }
	}
	//新增
	public function brandAdd(){
	    $this->isLogin();
        $address = new Address();
        $list = $address->order('id','ASC')->select();
        $this->assign('list',$list);
	    return $this->fetch();
	}
	//新增处理
	public function BrandAddOk(){
	    $this->isLogin();
	    $request = Request::instance();
	    $username = trim($request->param('name'));
	    $user = new Brands();
	    $info = $user->where('name',$username)->find();
	    if($info){
	    	$data = ['msg'=>'该商家已经存在，请重新注册','status'=>0];
	    	return json_encode($data);
	    }else{
	    	$file = request()->file('logo');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                $path =  $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError(),'brandAdd');
            }
            $logo = strtr($path,'\\','/');
	    	$name = $request->param('name');
	        $tel = $request->param('tel');
	        $address = $request->param('address');
	        $adda = intval($request->param('adda'));
	        $desc = $request->param('desc');
	        $yin = $request->param('yin');
	        $qqs = $request->param('qqs');
	        $href = $request->param('href');
	        $catid = $request->param('catid');
	        $data = [
	            'name'=>$name,
	            'logo'=>$logo,
	            'tel'=>$tel,
	            'address'=>$address,
	            'adda'=>$adda,
	            'desc'=>$desc,
	            'yin'=>$yin,
	            'qqs'=>$qqs,
	            'href'=>$href,
	            'allow'=>1,
	        ];   
	        $res = $user->save($data);
	        if($res){
	            $this->success('添加商家成功','admin/em/closes');
	        }else{
	            $this->error('添加商家失败','admin/em/closes');
	        }
	    }    
	}
	//删除商家
	public function brandDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$del = Brands::get($id);
		$res = $del->delete();
		if($res){
		    $data = ['msg'=>'该商家已删除','status'=>1];
		    echo json_encode($data);
		}else{
		    $data = ['msg'=>'删除失败请检查','status'=>2];
		    echo json_encode($data);
		}
	}
	//查看
	public function brandShow(){
	    $this->isLogin();
	    $request = Request::instance();
        $id = $request->param('id');
	    $brand = Brands::get($id);
	    $this->assign('show',$brand);
	    $address = new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
		return $this->fetch();
	}
	//修改
	public function brandShowOk(){
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $brand = new Brands();
	    $file = request()->file('logo');
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
            $logo = strtr($path,'\\','/');
	        $name = $request->param('name');
	        $desc = $request->param('desc');
	        $href = $request->param('href');
	        $address = $request->param('address');
	        $tel = $request->param('tel');
	        $yin = $request->param('yin');
	        $adda = $request->param('adda');
	        $qqs = $request->param('qqs');
	        $catid = $request->param('catid');
	        $data = [
	           'name'=>$name,
	           'desc'=>$desc,
	           'href'=>$href,
	           'address'=> $address,
	           'tel'=> $tel,
	           'yin'=>$yin,
	           'adda'=>$adda,
	           'qqs'=>$qqs,
	           'logo'=>$logo,
	           'catid'=>$catid,
	        ];
	        $res = $brand->save($data,['id'=>$id]);
	        if($res){
	            $this->success('修改商家信息成功','admin/em/closes');
	        }else{
	            $this->error('修改商家信息失败');
	        }
        }else{	       
	        $name = $request->param('name');
	        $desc = $request->param('desc');
	        $href = $request->param('href');
	        $address = $request->param('address');
	        $tel = $request->param('tel');
	        $yin = $request->param('yin');
	        $adda = $request->param('adda');
	        $qqs = $request->param('qqs');
	        $data = [
	           'name'=>$name,
	           'desc'=>$desc,
	           'href'=>$href,
	           'address'=> $address,
	           'tel'=> $tel,
	           'yin'=>$yin,
	           'adda'=>$adda,
	           'qqs'=>$qqs
	        ];
	        $res = $brand->save($data,['id'=>$id]);
	        if($res){
	            $this->success('修改商家信息成功','admin/em/closes');
	    	
	        }else{
	            $this->error('修改商家信息失败');
	        }
        }   
	}
	//商家申请列表
	public function brandApply(){
        $this->isLogin();
        $brand = new Brands();
        $address = new Address();
        $adda = $address->where('type',1)->order('id','ASC')->select();
        $this->assign('adda',$adda);
        $request = Request::instance();
	    $name = $request->param('name');
	    $typeid = $request->param('typeid');
	    $tel = $request->param('tel');
	    $yin = $request->param('yin');
	    if($name != ''){
	        $res = $brand->where('name','like','%'.$name.'%')->where('allow',0)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($typeid != ''){
	        $res = $brand->where('adda',$typeid)->where('allow',0)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($tel != ""){ 
	        $res = $brand->where('tel',$tel)->where('allow',0)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['tel'=>$tel],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($yin != ""){
	        $res = $brand->where('yin','like','%'.$yin.'%')->where('allow',0)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['yin'=>$yin],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }else{
	    	$res = $brand->where('allow',0)->order('createtime','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	    	$num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }
	}
	//审核通过
	public function brandApplyOk(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$del = Brands::get($id);
		$res = $del->save(['allow'=>1,'createtime'=>date('Y-m-d H:i:s')]);
		if($res){
		    $data = ['msg'=>'该商家已通过认证','status'=>1];
		    echo json_encode($data);
		}else{
		    $data = ['msg'=>'审核失败，请检查','status'=>2];
		    echo json_encode($data);
		}
	}
}