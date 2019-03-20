<?php
/*
 * 招聘管理
 */
namespace app\admin\controller;
use app\admin\common\Base;
use think\Session;
use think\Request;
use app\admin\model\Article;
use app\admin\model\Articletype;
use app\admin\model\Address;
class Invite extends Base{
    //查看招聘
    public function inviteList(){
        $this->isLogin();
        $article = new Article();
        $type = new Articletype();
        $res = $type->where('pid','<>',0)->where('allow',2)->order('id','DESC')->select();
        $this->assign('type',$res);
        $request = Request::instance();
        $name = $request->param('name');
        $typeid = $request->param('typeid');
        $before = $request->param('before');
        $after = $request->param('after');
        if($name != ''){
            $res = $article->where('title','like','%'.$name.'%')->where('types',3)->order('id','DESC')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['name'=>$name],]
                );
            $this->assign('list',$res);
             $num = count($res);
            $this->assign('num',$num);
            return $this->fetch();
        }else if($typeid != ''){
            $res = $article->where('typeid',$typeid)->where('types',3)->order('id','DESC')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['typeid'=>$typeid],]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }else if($before != '' && $after != ''){
            $res = $article->where('createtime','between time',[$before,$after])->where('types',3)->order('id','DESC')->paginate(15,false,['type'=>'bootstrap','var_page'=>'page','query'=>['before'=>$before,'after'=>$after],]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }else{
            $res = $article->where('types',3)->order('id','desc')->paginate(15,false,
                ['type'=>'bootstrap','var_page'=>'page',]
                );
            $num = count($res);
            $this->assign('num',$num);
            $this->assign('list',$res);
            return $this->fetch();
        }
    }
    //分类管理
    public function inviteType(){
        $this->isLogin();
        $list = new Articletype();
        $res = $list->where('allow',2)->order('path','asc')->paginate(7);
        $this->assign('list',$res);
        return $this->fetch();
    }
    //分类删除
    public function inviteTypeDel(){
        header("Content-Type:application/json;charset=utf-8");
        $this->isLogin();
        $request = Request::instance();
        $id = $request->param('id');
        if( $id == 1 || $id == 2 || $id == 3|| $id == 4|| $id == 5 || $id == 6 || $id == 7){
            $data = ['msg'=>'对不起，顶级分类不可删除','stuats'=>0];
            return json_encode($data);
        }else{
            $res = Articletype::get($id);
            $resu = $res->delete();
            if($resu){
                $data = ['msg'=>'删除成功','stuats'=>1];
                return json_encode($data);
            }else{
                return false;
            }
        }
    }
    //分类添加
    public function inviteTypeAdd(){
        header("Content-Type:application;charset=utf-8");
        $this->isLogin();
        $request = Request::instance();
        $id = $request->param('typeid');
        $content = $request->param('content');
        $type = new Articletype();
        $res = $type->where('content',$content)->find();
        if($res){
            $data = ['msg'=>'职位已经存在，请不要重复添加','stuats'=>'2'];
            echo json_encode($data);
        }else{
            $data = [
               'pid'=>5,
               'content'=>$content,
               'allow'=>2,
            ];
            $resu = $type->save($data);
            if($resu){
                $data = ['msg'=>'职位添加成功','stuats'=>'1'];
                echo json_encode($data);
            }else{
                $data = ['msg'=>'职位添加失败','stuats'=>'2'];
                echo json_encode($data);
            }
        }
    }
    // 招聘删除
    public function inviteDel(){
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
    //招聘添加
    public function inviteAdd(){
        $this->isLogin();
        $request = Request::instance();
        $type = new Articletype();
        $list = $type->where('allow',2)->order('id','DESC')->select();
        $this->assign('list',$list);
        $address = new Address();
        $add = $address->where('type',1)->order('id','ASC')->select();
        $this->assign('address',$add);
        return $this->fetch();
    }
    //招聘增加处理
    public function inviteAddOk(){
        header("Content-Type:application/json;charset=utf-8");
        $this->isLogin();
        $request = Request::instance();
        $article = new Article();
        $content = $request->param('content');
        $title = $request->param('title');
        $author = $request->param('author');
        $salary = intval($request->param('salary'));
        $city = $request->param('city');
        $tel = $request->param('tel');
        $email = $request->param('email');
        $sort = $request->param('sort');
        $filled = $request->param('filled');
        $qqs = $request->param('qqs');
        $typeid = $request->param('typeid');
        $adda = $request->param('adda');
        $number = $request->param('number');
        $data = [
            'content'=>$content,
            'title'=>$title,
            'typeid'=>$typeid,
            'createtime'=> date('Y-m-d H:i:s'),
            'author'=>$author,
            'tel'=>$tel,
            'email'=>$email,
            'filled'=>$filled,
            'qqs'=>$qqs,
            'sort'=>$sort,
            'adda'=>$adda,
            'salary'=>$salary,
            'city'=>$city,
            'number'=>$number,
            'style'=>0,
            'types'=>3,
            'asid'=>time(),
            'typeidd'=>5,
            'asid'=>'I'.date('YmdHis'),
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
    //招聘查看
    public function inviteShow(){
        $this->isLogin();
        $request = Request::instance();
        $id = $request->param('id');
        $type = new Articletype();
        $typeList = $type->where('allow',2)->order('path','ASC')->select();
        $this->assign('list',$typeList);
        $article = Article::get($id);
        $this->assign('show',$article);
        $address=new Address();
        $add = $address->where('type',1)->order('id','ASC')->select();
        $this->assign('address',$add);
        return $this->fetch();
    }
    //查看修改
    public function inviteUpdate(){
        header("Content-Type:application/json;charset=utf-8");
        $this->isLogin();
        $request = Request::instance();
        $id = $request->param('id');
        $article = new Article();
        $content = $request->param('content');
        $title = $request->param('title');
        $author = $request->param('author');
        $salary = intval($request->param('salary'));
        $city = $request->param('city');
        $tel = $request->param('tel');
        $email = $request->param('email');
        $sort = $request->param('sort');
        $filled = $request->param('filled');
        $qqs = $request->param('qqs');
        $typeid = $request->param('typeid');
        $adda = $request->param('adda');
        $number = $request->param('number');
        $data = [
            'content'=>$content,
            'title'=>$title,
            'typeid'=>$typeid,
            'author'=>$author,
            'tel'=>$tel,
            'email'=>$email,
            'filled'=>$filled,
            'qqs'=>$qqs,
            'sort'=>$sort,
            'adda'=>$adda,
            'salary'=>$salary,
            'number'=>$number,
            'city'=>$city,         
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
}