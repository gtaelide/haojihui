<?php
/*
 * 产品租赁买卖
 */
namespace app\admin\controller;
use app\admin\model\Article;
use app\admin\model\Articletype;
use app\admin\model\Address;
use app\admin\common\Base;
use think\Request;
use think\Session;
use think\Db;
class Product extends Base{
	//产品列表
	public function productList(){
	    $this->isLogin();
	    $article = new Article();
	    $type = new Articletype();
	    $res = $type->where('pid','<>',0)->where('allow',1)->order('id','DESC')->select();
	    $this->assign('type',$res);
	    $request = Request::instance();
	    $name = $request->param('name');
	    $typeid = $request->param('typeid');
	    $before = $request->param('before');
	    $after = $request->param('after');
	    if($name != ''){
	        $res = $article->where('title','like','%'.$name.'%')->where('types',2)->order('id','DESC')->paginate(7,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $this->assign('list',$res);
	        $num = count($res);
            $this->assign('num',$num);
	        return $this->fetch();
	    }else if($typeid != ''){
	        $res = $article->where('typeid',$typeid)->where('types',2)->order('id','DESC')->paginate(7,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
	        $this->assign('list',$res);
	         $num = count($res);
            $this->assign('num',$num);
	        return $this->fetch();
	    }else if($before != '' && $after != ''){
	        $res = $article->where('createtime','between time',[$before,$after])->where('types',2)->order('id','DESC')->paginate(7,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
	         $num = count($res);
            $this->assign('num',$num);
	        return $this->fetch();
	    }else{
	        $res = $article->where('types',2)->order('id','desc')->paginate(7,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	        $num = count($res);
            $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }
	}
	//分类删除
	public function productTypeDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    if( $id == 1 || $id == 2 || $id == 3|| $id == 4|| $id == 5 || $id == 6 || $id == 7){
	        $data = ['msg'=>'对不起，顶级分类不可删除','stuats'=>0];
	        echo json_encode($data);
	    }else{
	        $res = Articletype::get($id);
	        $resu = $res->delete();
	        if($resu){
	            $data = ['msg'=>'删除成功','stuats'=>1];
	            echo json_encode($data);
	        }else{
	            echo false;
	        }
	    }
	}
	//产品分类
	public function productType(){
	    $this->isLogin();
	    $list = new Articletype();
	    $res = $list->whereOr('allow',1)->whereOr('allow',3)->order('path','asc')->select();
	    $type = $list->whereOr('allow',1)->whereOr('allow',3)->where('pid',0)->select();
	    $this->assign('type',$type);
	    $this->assign('list',$res);
		return $this->fetch();
	}
	//分类添加
	public function productTypeAdd(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('typeid');
	    $content = $request->param('content');
	    $type = new Articletype();
	    $data = [
	        'pid'=>$id,
	        'content'=>$content,
	        'allow'=>1
	    ];
	    $type->save($data);
	    $res = $type->order('id','desc')->limit(1)->find();
	    $data = [
	        'path'=>$id.';'.$res->id.';',
	        'allow'=>$res->allow,
	    ];
	    $resu = $type->save($data,['id',$res->id]);
	    if($resu){
	        return true;
	    }else{
	        return false;
	    }
	}
	//分类
	public function makeType(){
        //header("Content-Type:application/json;charset=utf-8");
        $request = Request::instance();
        $type = $request->param('id');
        $types = new Articletype();
        $res = $types->where('pid',$type)->order('id','ASC')->select();
        echo json_encode($res);
    }
	//产品添加
	public function productAdd(){
	    $this->isLogin();
	    $request = Request::instance();
	    $type = new Articletype();
	    $list = $type->whereOr('id',1)->whereOr('id',2)->whereOr('id',3)->whereOr('id',7)->order('id','DESC')->select();
	    $this->assign('list',$list);
	    $address = new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
	    return $this->fetch();
	}
	//产品添加处理
	public function productAddOk(){
	    $this->isLogin();
	    $file = request()->file('img');
	    $request = Request::instance();
	    $article = new Article();
	    $content = $request->param('content');
	    $title = $request->param('title');
	    $sort = $request->param('sort');
	    $price = $request->param('price')? $request->param('price'): '';
	    $filled = $request->param('filled')? $request->param('filled'): '';
	    $brand = $request->param('brand');
	    $desc = $request->param('desc');
	    $keys = $request->param('keys');
	    $typeid = $request->param('typeidd');
	    $typeid = $request->param('typeid');
	    $long = $request->param('long');
	    $type = new Articletype();
	    $typeidd = $type->where('id',$typeid)->find();
	    $adda = $request->param('adda'); 
        // 移动到框架应用根目录/public/uploads/ 目录下
        if(!empty($file)){
        	$info = $file->validate(['size'=>30000000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        	if($info){
            	// 成功上传后 获取上传信息
            	$path =  $info->getSaveName();
       		 }else{
            	// 上传失败获取错误信息
           	 	$this->error($file->getError(),'productAdd');
       		}
        	//数据更新
        	$img = strtr($path,'\\','/');
	    	$data = [
	        		'content'=>$content,
	        		'title'=>$title,
	        		'desc'=>$desc,
	        		'typeid'=>$typeid,
	        		'createtime'=> date('Y-m-d H:i:s'),
	        		'price'=> intval($price),
	        		'filled'=>intval($filled),
	        		'typeidd'=>$typeidd,
	        		'brand'=> $brand,
	        		'sort'=>$sort,
	        		'keys'=>$keys,
	        		'adda'=>$adda,
	        		'img'=>$img,
	        		'style'=>1,
	        		'types'=>2,
	        		'nums'=>0,
	        		'long'=>$long,
	        		'typeidd'=>$typeidd->pid,
	        		'asid'=>'P'.date('YmdHis'),
	    	];
	   		$res = $article->save($data);
	    	if($res){
	        	$this->success('添加产品成功','admin/em/closes');
	    	}else{
	        	$this->error('添加产品失败');
	    	}
        }else{
 			$data = [
	        	'content'=>$content,
	        	'title'=>$title,
	        	'desc'=>$desc,
	        	'typeid'=>$typeid,
	        	'createtime'=> date('Y-m-d H:i:s'),
	        	'price'=> $price,
	        	'brand'=> $brand,
	        	'filled'=>intval($filled),
	        	'typeidd'=>$typeidd,
	        	'sort'=>$sort,
	        	'keys'=>$keys,
	        	'adda'=>$adda,
	        	'nums'=>0,
	        	'style'=>1,
	        	'types'=>2,
	        	'long'=>$long,
	        	'typeidd'=>$typeidd->pid,
	        	'asid'=>'P'.date('YmdHis'),
	    	];
	    	$res = $article->save($data);
	    	if($res){
	        	$this->success('添加产品成功','admin/em/closes');
	    	}else{
	        	$this->error('添加产品失败');
	    	}
        }
       
	}
	//产品删除
	public function productDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$del = Article::get($id);
		$res = $del->delete();
		if($res){
		    $data = ['msg'=>'该信息已删除'];
		    echo json_encode($data);
		}else{
		    $data = ['msg'=>'删除失败请检查'];
		    echo json_encode($data);
		}
	}
	//产品查看
	public function productShow(){
	    $this->isLogin();
	    $request = Request::instance();
        $id = $request->param('id');
        $type = new Articletype();
        $typeList = $type->where('allow',1)->order('path','ASC')->select();
        $this->assign('list',$typeList);
	    $article = Article::get($id);
	    $this->assign('show',$article);
	    $address=new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
		return $this->fetch();
	}
	//产品修改
	public function productShowOk(){
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $article = new Article();
	    $file = request()->file('img');
	    if(!empty($file)){
            //移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size'=>30000000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                //成功上传后 获取上传信息
                $path =  $info->getSaveName();
            }else{
                //上传失败获取错误信息
                $this->error($file->getError(),'productAdd');
            }
            //数据更新
            $img = strtr($path,'\\','/');
	        $content = $request->param('content');
	        $title = $request->param('title');
	        $sort = $request->param('sort');
	        $price = intval($request->param('price'));
	        $brand = $request->param('brand');
	        $desc = $request->param('desc');
	        $keys = $request->param('keys');
	        $typeid = $request->param('typeid');
	        $long = $request->param('long');
	        $adda = $request->param('adda'); 
	        $data = [
	           'content'=>$content,
	           'title'=>$title,
	           'desc'=>$desc,
	           'typeid'=>$typeid,
	           'price'=> $price,
	           'brand'=> $brand,
	           'sort'=>$sort,
	           'adda'=>$adda,
	           'keys'=>$keys,
	           'long'=>$long,
	           'img'=>$img,
	        ];
	        $res = $article->save($data,['id'=>$id]);
	        if($res){
	            $this->success('修改产品成功','admin/em/closes');
	        }else{
	            $this->error('修改产品失败');
	        }
        }else{	       
	        $content = $request->param('content');
	        $title = $request->param('title');
	        $sort = $request->param('sort');
	        $price = intval($request->param('price'));
	        $brand = $request->param('brand');
	        $desc = $request->param('desc');
	        $keys = $request->param('keys');
	        $typeid = $request->param('typeid');
	        $long = $request->param('long');
	        $data = [
	           'content'=>$content,
	           'title'=>$title,
	           'desc'=>$desc,
	           'typeid'=>$typeid,
	           'price'=> $price,
	           'brand'=> $brand,
	           'sort'=>$sort,
	           'long'=>$long,
	           'keys'=>$keys,
	        ];
	        $res = $article->save($data,['id'=>$id]);
	        if($res){
	           $this->success('修改产品成功','admin/em/closes');
	        }else{
	           $this->error('修改产品失败');
	        }
        }
        
	}
}
