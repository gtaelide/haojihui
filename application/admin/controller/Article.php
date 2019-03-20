<?php
/*
 * 资讯信息管理
 */
namespace app\admin\controller;
use app\admin\model\Article as Articles;
use app\admin\model\Articletype;
use app\admin\model\Address;
use app\admin\common\Base;
use think\Request;
use think\Session;
use think\Db;
class Article extends Base{
	//资讯列表
	public function articleList(){
	    $this->isLogin();
	    $article = new Articles();
	    $type = new Articletype();
	    $res = $type->where('pid','<>',0)->where('allow',0)->order('id','DESC')->select();
	    $this->assign('type',$res);
	    $request = Request::instance();
	    $name = $request->param('name');
	    $typeid = $request->param('typeid');
	    $before = $request->param('before');
	    $after = $request->param('after');
	    if($name != ''){
	        $res = $article->where('title','like','%'.$name.'%')->where('types',1)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
	        $this->assign('list',$res);
	        $num = count($res);
            $this->assign('num',$num);
	        return $this->fetch();
	    }else if($typeid != ''){
	        $res = $article->where('typeid',$typeid)->where('types',1)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
	        $this->assign('list',$res);
	        $num = count($res);
            $this->assign('num',$num);
	        return $this->fetch();
	    }else if($before != '' && $after != ''){ 
	        $res = $article->where('createtime','between time',[$before,$after])->where('types',1)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
	        $this->assign('list',$res);
	        $num = count($res);
            $this->assign('num',$num);
	        return $this->fetch();
	    }else{
	        $res = $article->where('types',1)->order('id','desc')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page']
                );
	        $this->assign('list',$res);
	        $num = count($res);
            $this->assign('num',$num);
		    return $this->fetch();
	    }   
	}
	//资讯分类
	public function articleType(){
	    $this->isLogin();
	    $list = new Articletype();
	    $res = $list->where('allow',0)->order('path','asc')->select();
	    $this->assign('list',$res);
		return $this->fetch();
	}
	//分类删除
	public function articleTypeDel(){
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
	       		$data = ['msg'=>'删除成功','stuats'=>2];
	           	echo json_encode($data);
	       }
	    }
	}
	//分类添加 
	public function articleTypeAdd(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('typeid');
	    $content = $request->param('content');
	    $type = new Articletype();
	    $data = [
	        'pid'=>$id,
	        'content'=>$content,
	        'allow'=>0
	    ];
	    $type->save($data);
	    $res = $type->order('id','desc')->limit(1)->find();
	    $data = [
	        'path'=>$id.';'.$res->id.';',
	    ];
	    $resu = $type->save($data,['id',$res->id]);
	    if($resu){
	    	$data = ['mag'=>'成功','status'=>1];
	        echo json_encode($data);
	    }else{
	    	$data = ['mag'=>'失败','status'=>0];
	        echo json_encode($data);
	    }
	}
	//资讯增加
	public function articleAdd(){
	    $this->isLogin();
	    $request = Request::instance();
	    $type = new Articletype();
	    $list = $type->where('allow',0)->order('id','DESC')->select();
	    $this->assign('list',$list);
	    $address = new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
		return $this->fetch();
	}
	//资讯增加处理
	public function articleAddOk(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $article = new Articles();
	    $content = $request->param('content');
	    $title = $request->param('title');
	    $author = $request->param('author');
	    $tel = $request->param('tel');
	    $email = $request->param('email');
	    $sort = $request->param('sort');
	    $from = $request->param('from');
	    $desc = $request->param('desc');
	    $keys = $request->param('keys');
	    $typeid = $request->param('typeid');
	    $type = new Articletype();
	    $typeidd = $type->where('id',$typeid)->find();
	    $data = [
	        'content'=>$content,
	        'title'=>$title,
	        'desc'=>$desc,
	        'typeid'=>$typeid,
	        'createtime'=> date('Y-m-d H:i:s'),
	        'author'=>$author,
	        'tel'=>$tel,
	        'email'=>$email,
	        'sort'=>$sort,
	        'adda'=>$from,
	        'keys'=>$keys,
	        'style'=>0,
	        'types'=>1,
	        'typeidd'=>$typeidd->pid,
	        'asid'=>'E'.date('YmdHis'),
	    ];
	    $res = $article->save($data);
	    if($res){
	        $data = ['msg'=>'添加成功'];
	        echo json_encode($data);
	    }else{
	        $data = ['msg'=>'添加失败'];
	        echo json_encode($data);
	    }
	}
	//资讯删除
	public function articleDel(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
		$request = Request::instance();
		$id = $request->param('id');
		$del = Articles::get($id);
		$res = $del->delete();
		if($res){
		    $data = ['msg'=>'该信息已删除'];
		    echo json_encode($data);
		}else{
		    $data = ['msg'=>'删除失败请检查'];
		    echo json_encode($data);
		}
	}
	//资讯审核
	public function articleShen(){
	    $this->isLogin();
		return $this->fetch();
	}
	//资讯查看
	public function articleShow(){
	    $this->isLogin();
	    $request = Request::instance();
        $id = $request->param('id');
        $type = new Articletype();
        $typeList = $type->where('allow',0)->order('path','ASC')->select();
        $this->assign('list',$typeList);
	    $article = Articles::get($id);
	    $this->assign('show',$article);
	    $address=new Address();
	    $add = $address->where('type',1)->order('id','ASC')->select();
	    $this->assign('address',$add);
		return $this->fetch();
	}
	//资讯修改
	public function articleUpdate(){
		header("Content-Type:application/json;charset=utf-8");
	    $this->isLogin();
	    $request = Request::instance();
	    $id = $request->param('id');
	    $content = $request->param('content');
	    $title = $request->param('title');
	    $desc = $request->param('desc');
	    $typeid = $request->param('typeid');
	    $author = $request->param('author');
	    $tel = $request->param('tel');
	    $email = $request->param('email');
	    $from = $request->param('from');
	    $sort = $request->param('sort');
	    $keys = $request->param('keys');
	    $article = new Articles();
	    $data = [
	        'content'=>$content,
	        'title'=>$title,
	        'desc'=>$desc,
	        'typeid'=>$typeid,
	        'author'=>$author,
	        'tel'=>$tel,
	        'email'=>$email,
	        'sort'=>$sort,
	        'adda'=>$from,
	        'keys'=>$keys,
	    ];
	    $res = $article->save($data,['id'=>$id]);
	    if($res){
	        $data = ['msg'=>'修改成功,请刷新页面'];
	        echo json_encode($data);
	    }else{
	        $data = ['msg'=>'修改失败，请检查'];
	        echo json_encode($data);
	    }
	}
	//测试数据
	///测试数据(该测试是论坛回溯的)
	public function test(){
		$result = Db::query('select type1,type2,type3,type4 from test where uid=1');
        dump($result[0]);
        $max = 0;
        for($i=1;$i<=count($result[0]);$i++){
            if($result[0]['type'.$i] > $max){
                $max=$result[0]['type'.$i];
            }
         }
        $hui = array_keys($result[0],$max);
        echo $hui[0];
        @$ke = Db::query("select * from `test_type` where `type`= '$hui[0]';");
        $gai = $ke[0]['name'];
        echo "<h1>您最喜欢的专题是：".$gai."</h1>";
  	}
}