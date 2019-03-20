<?php 
/*
新闻资讯管理
 */
namespace app\admin\controller;
use app\admin\common\Base;
use app\admin\model\Address;
use think\Request;
use think\Session;
use app\admin\model\News as Newss;
class News extends Base{
	//新闻资讯列表
	public function newsLista(){
        $this->isLogin();
        $news = new Newss();
        $request = Request::instance();
        $name = $request->param('name');
        $before = $request->param('before');
        $after = $request->param('after');
        if($name != ''){
            $res = $news->where('title','like','%'.$name.'%')->where('type',1)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }else if($before != '' && $after != ''){ 
             $res = $news->where('createtime','between time',[$before,$after])->where('type',1)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }else{
             $res = $news->where('type',1)->order('id','desc')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }   
	}
	//新闻公告列表
	public function newsListb(){
        $this->isLogin();
        $news = new Newss();
        $request = Request::instance();
        $name = $request->param('name');
        $before = $request->param('before');
        $after = $request->param('after');
        if($name != ''){
            $res = $news->where('title','like','%'.$name.'%')->where('type',2)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }else if($before != '' && $after != ''){ 
            $res = $news->where('createtime','between time',[$before,$after])->where('type',2)->order('id','DESC')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }else{
            $res = $news->where('type',2)->order('id','desc')->paginate(10,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        } 
	}

	//添加新闻
	public function newsAdda(){
		return $this->fetch();
	}
	public function newsAddb(){
		return $this->fetch();
	}
	//新闻资讯添加处理
	public function newsAddaOk(){
        header("Content-Type:application/json;charset=utf-8");
        $request = Request::instance();
        $title = $request->param('title');
        $sort = intval($request->param('sort'));
        $keys = $request->param('keys');
        $from = $request->param('from');
        $desc = $request->param('desc');
        $content = $request->param('content');
        $news = new Newss();
        $data = ['title'=>$title,'sort'=>$sort,'keys'=>$keys,'from'=>$from,'desc'=>$desc,'content'=>$content,'type'=>1,'createtime'=>date("Y-m-d H:i:s")];
        $res = $news->save($data);
        if($res){
        	$data = ['msg'=>'新闻资讯添加成功'];
        	echo json_encode($data);
        }else{
        	$data = ['msg'=>'新闻资讯添加失败'];
        	echo json_encode($data);
        }
	}
	//企业公告添加处理
	public function newsAddbOk(){
        header("Content-Type:application/json;charset=utf-8");
        $request = Request::instance();
        $title = $request->param('title');
        $sort = intval($request->param('sort'));
        $keys = $request->param('keys');
        $from = $request->param('from');
        $desc = $request->param('desc');
        $content = $request->param('content');
        $news = new Newss();
        $data = ['title'=>$title,'sort'=>$sort,'keys'=>$keys,'from'=>$from,'desc'=>$desc,'content'=>$content,'type'=>2,'createtime'=>date("Y-m-d H:i:s")];
        $res = $news->save($data);
        if($res){
        	$data = ['msg'=>'企业公告添加成功'];
        	echo json_encode($data);
        }else{
        	$data = ['msg'=>'企业公告添加失败'];
        	echo json_encode($data);
        }
	}
    //查看新闻
    public function newsShow(){
        $this->isLogin();
        $request = Request::instance();
        $id = $request->param('id');
        $new = Newss::get($id);
        $this->assign('show',$new);
        return $this->fetch();
    }
    //新闻修改
    public function newsShowOk(){
        header("Content-Type:application/json;charset=utf-8");
        $request = Request::instance();
        $id = $request->param('id');
        $title = $request->param('title');
        $sort = intval($request->param('sort'));
        $keys = $request->param('keys');
        $from = $request->param('from');
        $desc = $request->param('desc');
        $content = $request->param('content');
        $news = new Newss();
        $data = ['title'=>$title,'sort'=>$sort,'keys'=>$keys,'from'=>$from,'desc'=>$desc,'content'=>$content,];
        $res = $news->save($data,['id'=>$id]);
        if($res){
            $data = ['msg'=>'文章修改成功'];
            echo json_encode($data);
        }else{
            $data = ['msg'=>'文章修改失败'];
            echo json_encode($data);
        }
    }
	//新闻删除
	public function newsDel(){
        header("Content-Type:application/json;charset=utf-8");
		$request = Request::instance();
		$id = $request->param('id');
		$news = Newss::get($id);
		$res = $news->delete();
        if($res){
            $data = ['msg'=>'该条信息删除成功'];
            echo json_encode($data);
        }else{
            $data = ['msg'=>'该条信息删除失败'];
            echo json_encode($data);
        }
	}
    //新闻公告修改
    public function newsUpdate(){
        header("Content-Type:application/json;charset=utf-8");
        $request = Request::instance();
        $id = $request->param('id');
        $title = $request->param('title');
        $sort = intval($request->param('sort'));
        $keys = $request->param('keys');
        $from = $request->param('from');
        $desc = $request->param('desc');
        $content = $request->param('content');
        $news = new Newss();
        $data = ['title'=>$title,'sort'=>$sort,'keys'=>$keys,'from'=>$from,'desc'=>$desc,'content'=>$content,];
        $res = $news->save($data,['id'=>$id]);
        if($res){
            $data = ['msg'=>'修改成功'];
            echo json_encode($data);
        }else{
            $data = ['msg'=>'修改失败'];
            echo json_encode($data);
        }
    }
}