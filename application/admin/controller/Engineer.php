<?php
/*
*工程项目
 */
namespace app\admin\controller;
use app\admin\model\Engineering;
use app\admin\model\Enginertype;
use app\admin\common\Base;
use app\admin\model\Address;
use think\Request;
use think\Session;
class Engineer extends Base{
	//列表
	public function engineerList(){
	    $this->isLogin();
	    $article = new Engineering();
	    $type = new Enginertype();
	    $res = $type->order('id','DESC')->select();
	    $this->assign('type',$res);
	    $request = Request::instance();
	    $name = $request->param('name');
	    $typeid = $request->param('typeid');
	    $before = $request->param('before');
	    $after = $request->param('after');
	    if($name != ''){
	        $res = $article->where('title','like','%'.$name.'%')->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $this->assign('list',$res);
	        $num = count($res);
	        $this->assign('num',$num);
	        return $this->fetch();
	    }else if($typeid != ''){
	        $res = $article->where('typeid',$typeid)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else if($before != '' && $after != ''){ 
	        $res = $article->where('createtime','between time',[$before,$after])->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
	        return $this->fetch();
	    }else{
	        $res = $article->order('id','desc')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
	        $num = count($res);
	        $this->assign('num',$num);
	        $this->assign('list',$res);
		    return $this->fetch();
	    }   
	}
	//工程分类
	public function engineerType(){
	    $this->isLogin();
	    $list = new Enginertype();
	    $res = $list->order('id','ASC')->select();
	    $this->assign('list',$res);
		return $this->fetch();
	}
	//工程分类删除
	public function engineerTypeDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $res = Enginertype::get($id);
	    $resu = $res->delete();
	    if($resu){
	        $data = ['msg'=>'删除成功','stuats'=>1];
	        echo json_encode($data);
	    }else{
	    	$data = ['msg'=>'删除失败','stuats'=>2];
	        echo false;
	    }
	}
	//工程分类添加 
	public function engineerTypeAdd(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $content = $request->param('content');
	    $type = new Enginertype();
	    $res = $type->where('name',$content)->find();
	    if($res){
            $data = ['msg'=>'该分类已经存在！请检查','status'=>0];
            echo json_encode($data);
	    }else{
	    	$data = [
	            'name'=>$content,
	        ];
	        $res = $type->save($data);
	        if($res){
	            $data = ['msg'=>'添加成功','status'=>1];
                echo json_encode($data);
	        }else{
	            $data = ['msg'=>'添加失败','status'=>2];
                echo json_encode($data);
	        }
	    } 
	}
    //工程增加
	public function engineerAdd(){
	    $this->isLogin();
	    $request = Request::instance();
	    $type = new Enginertype();
	    $list = $type->order('id','ASC')->select();
	    $this->assign('list',$list);
	    $address = new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
		return $this->fetch();
	}
	//工程增加处理
	public function engineerAddOk(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $engineer = new Engineering();
	    $content = $request->param('content');
	    $title = $request->param('title');
	    $sort = $request->param('sort');
	    $from = $request->param('from');
	    $keys = $request->param('keys');
	    $typeid = $request->param('typeid');
	    $adda = $request->param('adda');
	    $data = [
	        'content'=>$content,
	        'title'=>$title,
	        'typeid'=>$typeid,
	        'createtime'=> date('Y-m-d H:i:s'),
	        'sort'=>$sort,
	        'adda'=>$adda,
	        'from'=>$from,
	        'keys'=>$keys,
	    ];
	    $res = $engineer->save($data);
	    if($res){
	        $data = ['msg'=>'添加成功','status'=>1];
	        echo json_encode($data);
	    }else{
	        $data = ['msg'=>'添加失败!请检查','status'=>2];
	        echo json_encode($data);
	    }
	}
	//工程删除
	public function engineerDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$del = Engineering::get($id);
		$res = $del->delete();
		if($res){
		    $data = ['msg'=>'该信息已删除','status'=>1];
		    echo json_encode($data);
		}else{
		    $data = ['msg'=>'删除失败请检查','status'=>2];
		    echo json_encode($data);
		}
	}
	//工程查看
	public function engineerShow(){
	    $this->isLogin();
	    $request = Request::instance();
        $id = $request->param('id');
        $type = new Enginertype();
        $typeList = $type->order('id','ASC')->select();
        $this->assign('list',$typeList);
	    $article = Engineering::get($id);
	    $this->assign('show',$article);
	    $address=new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
		return $this->fetch();
	}
    //修改
	public function engineerUpdate(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $content = $request->param('content');
	    $title = $request->param('title');
	    $typeid = $request->param('typeid');
        $adda = $request->param('adda');
	    $from = $request->param('from');
	    $sort = $request->param('sort');
	    $keys = $request->param('keys');
	    $engineer = new Engineering();
	    $data = [
	        'content'=>$content,
	        'title'=>$title,
	        'typeid'=>$typeid,
	        'from'=>$from,
	        'sort'=>$sort,
	        'adda'=>$adda,
	        'keys'=>$keys,
	    ];
	    $res = $engineer->save($data,['id'=>$id]);
	    if($res){
	        $data = ['msg'=>'修改成功','status'=>1];
	        echo json_encode($data);
	    }else{
	        $data = ['msg'=>'修改失败，请检查','status'=>2];
	        echo json_encode($data);
	    }
	}
}