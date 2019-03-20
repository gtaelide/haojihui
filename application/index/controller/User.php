<?php
/*
 * 前台文章
 */
namespace app\index\controller;
use app\index\common\Base;
use app\index\model\System;
use app\index\model\Articletype;
use app\index\model\User as Users;
use app\index\model\Address;
use app\index\model\Article;
use app\index\model\Brand;
use app\index\model\Engineering;
use app\index\model\Enginertype;
use app\index\model\Catid;
use app\index\model\Advert;
use app\index\model\Test;
use think\Session;
use think\Request;
class User extends Base{
    //会员登录
    public function login(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
    //登录处理
    public function loginOK(){
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);

        $name = trim($_POST['username']);
        $passwords = md5(md5(trim($_POST['password'])));
        if( $name=='' || $passwords=='' ){
            $this->error('账号或者密码不能为空');
        }
        $code = trim($_POST['code']);
        if(!captcha_check($code)){
            $this->error('验证码错误,请重新登录','index/user/login');
        }else{
            $table = new users();
            $res = $table->where(['username'=>$name,'password'=>$passwords])->find();
            if($res){
                Session::set('uid',$res->id);
                Session::set('name',$res->username);
                Session::set('time',date('Y-m-d H:i:s'));
                $this->success("登录成功！","index/index/index");
            }else{
                $this->error("账号或密码错误！登录失败！");
            }
        }
    } 
    //退出登录
    public function loginOut(){
        Session::delete('uid');
        Session::delete('name');
        Session::delete('time');
        $this->success('退出成功','index/index/index');
    }
    //会员发信息
    //会员发信息 -- 供求信息
    public function make1(){
        $this->isLogin();
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('id','<>',5)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }
    //处理分类
    public function makeType(){
        //header("Content-Type:application/json;charset=utf-8");
        $request = Request::instance();
        $type = $request->param('id');
        $types = new Articletype();
        $res = $types->where('pid',$type)->order('id','ASC')->select();
        echo json_encode($res);
    }
    public function mmm(){
        header("Content-Type:application/json;charset=utf-8");
        $type = intval($_POST['id']);
        $types = new Articletype();
        $res = $types->where('pid',$type)->order('id','ASC')->select();
        echo json_encode($res);
    }
    //会员发信息 -- 招聘信息
    public function make2(){
        $this->isLogin();
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('allow',2)->where('pid',5)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }
    //会员发信息 -- 工程信息
    public function make3(){
        $this->isLogin();
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('allow',0)->where('pid','<>',0)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        //栏目分类
        $enginer = new Enginertype();
        $type_enginer = $enginer->order('id','ASC')->select();
        $this->assign('type_enginer',$type_enginer);
        return $this->fetch();
    }
    //会员发信息 -- 商家信息
    public function make4(){
        $this->isLogin();
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('allow',0)->where('pid','<>',0)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }
    //会员发信息 --  -- 处理
    public function makeOk(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //信息处理
        $request = Request::instance();
        $choose = $request->param('choose');
        $art = new Article();
        $brand = new Brand();
        $engineer = new Engineering();
        if($choose == 1){
            $title = $request->param('title')?$request->param('title'):'';
            $typeid = $request->param('typeid')?$request->param('typeid'):'';
            $author = $request->param('author')? $request->param('author'):'';
            $email = $request->param('email')?$request->param('email'):'';
            $tel = $request->param('tel')?$request->param('tel'):'';
            $qqs = $request->param('qqs')?$request->param('qqs'):'';
            $adda = $request->param('adda')?$request->param('adda'):'';
            $content = $request->param('content')?$request->param('content'):'';
            $brand = $request->param('brand')?$request->param("brand") : '';
            $filled = $request->param('filled')?$request->param('filled') : '';
            $typeidd = $type->where('id',$typeid)->find();
            $sys = System::get('1');
            $ints = $sys->integral;
            $user = Users::get($user_uid);
            $user->setInc('integral',$ints);
            $price = $request->param('price')?$request->param('price'):'';
            $file = request()->file('imgs');
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
                $data = [
                'title'=>$title,
                'typeid'=>$typeid,
                'typeidd'=>$typeidd->pid,
                'author'=>$author,
                'email'=>$email,
                'tel'=>$tel,
                'price'=>$price,
                'brand'=>$brand,
                'img'=>$img,    
                'qqs'=>$qqs,
                'adda'=>$adda,
                'filled'=>$filled,
                'content'=>$content,
                'createtime'=> date('Y-m-d H:i:s'),
                'style'=>0,
                'types'=>1,
                'asid'=>'E'.date('YmdHis'),
                'uid'=>Session::get('uid')
                ];
            }else{
                $data = [
                'title'=>$title,
                'typeid'=>$typeid,
                'typeidd'=>$typeidd->pid,
                'author'=>$author,
                'email'=>$email,
                'tel'=>$tel,
                'price'=>$price,
                'qqs'=>$qqs,
                'brand'=>$brand,
                'adda'=>$adda,
                'content'=>$content,
                'createtime'=> date('Y-m-d H:i:s'),
                'style'=>0,
                'types'=>1,
                'asid'=>'E'.date('YmdHis'),
                'uid'=>Session::get('uid')
                ];
            }   
            $res = $art->save($data);
            if($res){
                $this->success('供求信息发布成功','index/index/index');
            }else{
                 $this->error('发布失败');
            }
        }else if($choose == 2){
            $title = $request->param('title')?$request->param('title'):'';
            $typeid = $request->param('typeid')?$request->param('typeid'):'';
            $author = $request->param('author')? $request->param('author'):'';
            $email = $request->param('email')?$request->param('email'):'';
            $tel = $request->param('tel')?$request->param('tel'):'';
            $qqs = $request->param('qqs')?$request->param('qqs'):'';
            $adda = $request->param('adda')?$request->param('adda'):'';
            $content = $request->param('content')?$request->param('content'):'';
            $brand = $request->param('brand')?$request->param("brand") : '';
            $filled = $request->param('filled')?$request->param('filled') : '';
            $typeidd = $type->where('id',$typeid)->find();
            $from = $request->param('from') ? $request->param('from') : '';
            $typeidd = $type->where('id',$typeid)->find();
            $sys = System::get('1');
            $ints = $sys->integral;
            $user = Users::get($user_uid);
            $user->setInc('integral',$ints);
            $data = [
                'title'=>$title,
                'typeid'=>$typeid,
                'typeidd'=>$typeidd->pid,
                'author'=>$author,
                'email'=>$email,
                'city'=>$request->param('city'),
                'salary'=>$request->param('salary'),
                'tel'=>$tel,
                'qqs'=>$qqs,
                'adda'=>$adda,
                'content'=>$content,
                'createtime'=> date('Y-m-d H:i:s'),
                'filled'=>$request->param('filled'),
                'types'=>3,
                'uid'=>Session::get('uid')
            ];
            $res = $art->save($data);
            if($res){
                $this->success('招聘求职信息发布成功','index/index/index');
            }else{
                 $this->error('发布失败');
            }
        }else if($choose == 3){
            $title = $request->param('title')?$request->param('title'):'';
            $typeid = $request->param('typeid')?$request->param('typeid'):'';
            $author = $request->param('author')? $request->param('author'):'';
            $email = $request->param('email')?$request->param('email'):'';
            $tel = $request->param('tel')?$request->param('tel'):'';
            $qqs = $request->param('qqs')?$request->param('qqs'):'';
            $adda = $request->param('adda')?$request->param('adda'):'';
            $content = $request->param('content')?$request->param('content'):'';
            $brand = $request->param('brand')?$request->param("brand") : '';
            $filled = $request->param('filled')?$request->param('filled') : '';
            $typeidd = $type->where('id',$typeid)->find();
            $from = $request->param('from') ? $request->param('from') : '';
            $sys = System::get('1');
            $ints = $sys->integral;
            $user = Users::get($user_uid);
            $user->setInc('integral',$ints);
            $data = [
                'from'=>$from,
                'title'=>$title,
                'typeid'=>$typeid,
                'adda'=>$adda,
                'author'=>$author,
                'tel'=>$tel,
                'qqs'=>$qqs,
                'content'=>$content,
                'createtime'=> date('Y-m-d H:i:s'),
                'uid'=>Session::get('uid')
            ];
           $datas = [
                'from'=>$from,
                'title'=>$title,
                'typeidd'=>4,
                'typeid'=>100,
                'adda'=>$adda,
                'author'=>$author,
                'tel'=>$tel,
                'qqs'=>$qqs,
                'content'=>$content,
                'createtime'=> date('Y-m-d H:i:s'),
                'uid'=>Session::get('uid')
            ];
            $arts = $art->save($datas);
            $res = $engineer->save($data);
            if($res){
                $this->success('工程信息发布成功','index/index/index');
            }else{
                 $this->error('发布失败');
            }
        }else if($choose == 4){
            $name = $request->param('name');
            $catid = $request->param('catid');
            $href = $request->param('href');
            $yin = $request->param('yin');
            $desc = $request->param('desc');
            $address = $request->param('address');
            $file = request()->file('logo');
            $tel = request()->param('tel');
            $qqs = request()->param('qqs');
            $adda = request()->param('adda');
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
                $data = [
                    'name'=>$name,
                    'catid'=>$catid,
                    'href'=>$href,
                    'yin'=>$yin,
                    'desc'=>$desc,
                    'address'=>$address,
                    'tel'=>$tel,
                    'qqs'=>$qqs,
                    'adda'=>$adda,
                    
                    'createtime'=> date('Y-m-d H:i:s'),
                    'uid'=>Session::get('uid'),
                    'logo'=>$img,
                    'allow'=>0
                ];
                $res = $brand->save($data);
                if($res){
                    $this->success('申请成功，请等待客服联系','index/index/index');
                }else{
                    $this->error('申请失败');
                }
            }else{
                $data = [
                    'name'=>$name,
                    'catid'=>$catid,
                    'href'=>$href,
                    'yin'=>$yin,
                    'desc'=>$desc,
                    'address'=>$address,
                    'tel'=>$tel,
                    'qqs'=>$qqs,
                    'adda'=>$adda,
                   
                    'createtime'=> date('Y-m-d H:i:s'),
                    'uid'=>Session::get('uid'),
                    'allow'=>0
                ];
                $res = $brand->save($data);
                if($res){
                    $this->success('申请成功，请等待客服联系','index/index/index');
                }else{
                    $this->error('申请失败');
                }
            } 
        }
    }
    //会员注册
    public function register(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //处理
        return $this->fetch();

    }
    //会员注册处理
    public function registerOk(){
       
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        $user = new Users();
        $request = Request::instance();
        $username = $request->param('username');
        $pwd1 = $request->param('password1');
        $pwd2 = $request->param('password2');
        if($pwd1 != $pwd2){
            $this->error('两次输入的密码不一致,请检查');
        }else if($pwd1 == '' && $username == ''){
            $this->error('账号或者密码不能为空,请检查');
        }else{
            $pwd1 = md5(md5(trim($pwd1)));
            $res = $user->where('username',$username)->find();
            if($res){
                $this->error('该账号已经存在,请重新注册');
            }else{
                $data = ['username'=>$username,'password'=>$pwd1];
                $resu = $user->save($data);
                if($resu){
                    $this->success('注册成功,请登录','index/user/login');
                }else{
                    $this->error('注册失败');
                }
            }
        }
      
    }
    //会员修改
    public function update(){
        $this->isLogin();
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        $user = new Users();
        $request = Request::instance();
        $password = $request->param('password');
        $password2 = $request->param('password2');
        $name = $request->param('name');
        $sex = $request->param('sex');
        $address = $request->param('address');
        $birthday = $request->param('birthday');
        $tel = $request->param('tel');
        $email = $request->param('email');
        $qqs = $request->param('qqs');
        if($password != ''){
            if($password == $password2){
                $password = md5(md5(trim($password)));
                $data = [
                   'password'=>$password,
                   'name'=>$name,
                   'sex'=>$sex,
                   'address'=>$address,
                   'birthday'=>$birthday,
                   'tel'=>$tel,
                   'email'=>$email,
                   'qqs'=>$qqs,
                ];
                $res = $user->save($data,['id'=>Session::get('uid')]);
                if($res){
                    $this->success('修改成功','index/user/login');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error('两次输入的密码不一致,请检查');
            }
        }else{
            $data = [
                'name'=>$name,
                'sex'=>$sex,
                'address'=>$address,
                'birthday'=>$birthday,
                'tel'=>$tel,
                'email'=>$email,
                'qqs'=>$qqs,
            ];
            $res = $user->save($data,['id'=>Session::get('uid')]);
            if($res){
                $this->success('修改成功','index/user/show');
            }else{
                $this->error('修改失败，请检查');
            }
        }
    }
    //会员查看
    public function show(){
        $this->isLogin();
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //会员展示
        $id = Session::get('uid');
        $user = Users::get($id);
        $this->assign('show',$user);
        return $this->fetch();
    }
    //查看订单
    public function showCatid(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        $catid = new Catid();
        $catids = $catid->where('uid',$user_uid)->order('id','DESC')->select();
        
        $this->assign('list',$catids);
        return $this->fetch();
    }
    //确认收货
    public function showCatidOk(){
        
    }
    //x修改密码
    public function userMima(){
          //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        return $this->fetch();
    }
    //查看发布
    public function showMake(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //查询信息
        $request = Request::instance();
        $choose = !empty($request->param('choose')) ? $request->param('choose') : 1;
        if($choose == 1 || $choose == ''){
            $article = new Article();
            $list = $article->field('id,title,createtime')->where('uid',$user_uid)->where('types','<>',3)->order('id','DESC')->select();
            $this->assign('list',$list);
            $info = 1;
        }elseif($choose == 2){
            $Engineering = new Engineering();
            $list = $Engineering->field('id,title,createtime')->where('uid',$user_uid)->order('id','DESC')->select();
            $this->assign('list',$list);
            $info = 2;
        }elseif ($choose == 3) {
            $article = new Article();
            $list = $article->field('id,title,createtime')->where('uid',$user_uid)->where('types',3)->order('id','DESC')->select();
            $this->assign('list',$list);
            $info = 3;
        }
        $this->assign("choose",$choose);
        $this->assign("info",$info);
        return $this->fetch();     
    }
    //支付回调信息
    public function paybefore(){
        $this->success('购买成功,请返回用户订单页面查看',"index/index/index");
    }
    //测试

    //异步回调支付
    public function payback(){
        $post = input();
        $arr = explode("&&", $post['subject']);
        $pid = $arr[1];
        $tel = $arr[2];
        $address = $arr[3];
        $name = $arr[4];
        $uid = $arr[5];
        $mid = $arr[6];
        $createtime = date("Y-m-d H:i:s");
        $pay = 1;
        $bian = $post['out_trade_no'];
        $test = new Catid();
        $data = [
            'price'=>$post['total_amount'],
            'tel'=>$tel,
            'address'=>$address,
            'pid'=>$pid,
            'name'=>$name,
            'uid'=>$uid,
            'createtime'=>$createtime,
            'pay'=>$pay,
            'bian'=>$bian,
            'mid'=>$mid,
            ];
        $resu = $test->where('bian',$bian)->find();
        if(!$resu){
            $res = $test->save($data);
        }
        return 'SUCCESS';   
    }
        //异步回调支付
    public function payOk3(){
        header("Content-Type:text/html;charset=utf-8");
        $post = input();
        if($post['trade_status'] == "WAIT_BUYER_PAY"){
            return "SUCCESS";exit();
        }
        else if($post['trade_status'] == "TRADE_SUCCESS"){
            $arr = explode("&&", $post['subject']);
            $pid = $arr[1];
            $tel = $arr[2];
            $address = $arr[3];
            $name = $arr[4];
            $uid = $arr[5];
            $createtime = date("Y-m-d H:i:s");
            $pay = 1;
            $bian = time().rand(000,999);
            $test = new Catid();
            $data = [
                'price'=>$post['total_amount'],
                'tel'=>$tel,
                'address'=>$address,
                'pid'=>$pid,
                'name'=>$name,
                'uid'=>$uid,
                'createtime'=>$createtime,
                'pay'=>$pay,
                'bian'=>$bian,
            ];
            $res = $test->save($data);
            return "SUCCESS";
        }
    }
    //去除重复
    protected function assoc_unique($arr, $key)
    {
        $tmp_arr = array();
        foreach($arr as $k => $v)
        {
            if(in_array($v[$key], $tmp_arr))//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
            {
                unset($arr[$k]);
            }
            else 
            {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }
    //更改
    public function showMake1(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        $request=Request::instance();
        $choose = $request->param('choose');
        $id = $request->param('id');
        if($choose == 1){
            $res = Article::get($id);
            //信息分类
            $type = new Articletype();
            $type_list = $type->order('id','DESC')->select();
            $this->assign('type',$type_list);
            //供求信息发布
            $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
            $this->assign('type_id',$type_id);
            //地区分类
            $address = new Address();
            $adda = $address->order('id','ASC')->select();
            $this->assign('adda',$adda);
            $this->assign('show',$res);
            return $this->fetch('make_update1'); 
        }else if($choose == 2){
            //修改工程信息
            //信息分类
            $type = new Articletype();
            $type_list = $type->order('id','DESC')->select();
            $this->assign('type',$type_list);
            //供求信息发布
            $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
            $this->assign('type_id',$type_id);
            $engineer = Engineering::get($id);
            $type = new Enginertype();
            $types = $type->order('id','ASC')->select();
            $address = new Address();
            $adda = $address->order('id','ASC')->select();
            $this->assign('types',$types);
            $this->assign('adda',$adda);
            $this->assign('show',$engineer);
            return $this->fetch('make_update2');
        }else if($choose == 3){
            //修改人员信息
            //会员
            $user_name = Session::get('name') ? Session::get('name') : '';
            $user_time = Session::get('time') ? Session::get('time') : '';
            $user_uid = Session::get('uid') ? Session::get('uid') : '';
            $this->assign('user_name',$user_name);
            $this->assign('user_time',$user_time);
            $this->assign('user_uid',$user_uid);
            //系统类设置
            $sys = System::get('1');
            $this->assign('system',$sys);
            //信息分类
            $type = new Articletype();
            $type_list = $type->order('id','DESC')->select();
            $this->assign('type',$type_list);
            //供求信息发布
            $type_id = $type->where('allow',2)->where('pid',5)->order('id','DESC')->select();
            $this->assign('type_id',$type_id);
            //地区分类
            $address = new Address();
            $adda = $address->order('id','ASC')->select();
            $this->assign('adda',$adda);
            $invite = Article::get($id);
            $this->assign('show',$invite);
            return $this->fetch("make_update3");
        }  
    }
    //处理个供求信息发布
    public function makeUpdateOk1(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //信息处理
        $request = Request::instance();
        $choose = $request->param('choose');
        $art = new Article();
        $brand = new Brand();
        $engineer = new Engineering();
        $title = $request->param('title')?$request->param('title'):'';
        $typeid = $request->param('typeid')?$request->param('typeid'):'';
        $author = $request->param('author')? $request->param('author'):'';
        $email = $request->param('email')?$request->param('email'):'';
        $tel = $request->param('tel')?$request->param('tel'):'';
        $qqs = $request->param('qqs')?$request->param('qqs'):'';
        $adda = $request->param('adda')?$request->param('adda'):'';
        $content = $request->param('content')?$request->param('content'):'';
        $brand = $request->param('brand')?$request->param("brand") : '';
        $filled = $request->param('filled')?$request->param('filled') : '';
        $typeidd = $type->where('id',$typeid)->find();
        $id = $request->param('id');
        $price = $request->param('price');
        $file = request()->file('imgs');
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
            $data = [
                'title'=>$title,
                'typeid'=>$typeid,
                'typeidd'=>$typeidd->pid,
                'author'=>$author,
                'email'=>$email,
                'tel'=>$tel,
                'price'=>$price,
                'brand'=>$brand,
                'img'=>$img,    
                'qqs'=>$qqs,
                'adda'=>$adda,
                'filled'=>$filled,
                'content'=>$content,
            ];
        }else{
            $data = [
                'title'=>$title,
                'typeid'=>$typeid,
                'typeidd'=>$typeidd->pid,
                'author'=>$author,
                'email'=>$email,
                'tel'=>$tel,
                'price'=>$price,
                'qqs'=>$qqs,
                'brand'=>$brand,
                'adda'=>$adda,
                'content'=>$content,         
            ];
        }   
        $res = $art->save($data,['id'=>$id]);
        if($res){
            $this->success('供求信息修改成功','index/user/showMake');
        }else{
            $this->error('修改失败');
        }   
    }
    //工程信息修改
        //会员发信息 --  -- 处理
    public function makeUpdateOk2(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //信息处理
        $request = Request::instance();
        $choose = $request->param('choose');
        $art = new Article();
        $brand = new Brand();
        $engineer = new Engineering();
        $id = $request->param('id');
        $title = $request->param('title')?$request->param('title'):'';
        $typeid = $request->param('typeid')?$request->param('typeid'):'';
        $adda = $request->param('adda')?$request->param('adda'):'';
        $content = $request->param('content')?$request->param('content'):'';
        $typeidd = $type->where('id',$typeid)->find();
        $from = $request->param('from');
        $data = [
            'from'=>$from,
            'title'=>$title,
            'typeid'=>$typeid,
            'adda'=>$adda,
            'content'=>$content, 
        ];
        $res = $engineer->save($data,['id'=>$id]);
        if($res){
            $this->success('工程信息修改成功','index/user/showmake');
        }else{
            $this->error('修改失败');
        }  
    }
    //
   //会员发信息 --  -- 处理
    public function makeUpdateOk3(){
        //会员
        $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        //系统类设置
        $sys = System::get('1');
        $this->assign('system',$sys);
        //信息分类
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //信息处理
        $request = Request::instance();
        $choose = $request->param('choose');
        $art = new Article();
        $brand = new Brand();
        $engineer = new Engineering();
        $title = $request->param('title')?$request->param('title'):'';
        $typeid = $request->param('typeid')?$request->param('typeid'):'';
        $author = $request->param('author')? $request->param('author'):'';
        $email = $request->param('email')?$request->param('email'):'';
        $tel = $request->param('tel')?$request->param('tel'):'';
        $qqs = $request->param('qqs')?$request->param('qqs'):'';
        $adda = $request->param('adda')?$request->param('adda'):'';
        $content = $request->param('content')?$request->param('content'):'';
        $filled = $request->param('filled')?$request->param('filled') : '';
        $typeidd = $type->where('id',$typeid)->find();
        $id = $request->param('id');
        $data = [
            'title'=>$title,
            'typeid'=>$typeid,
            'typeidd'=>$typeidd->pid,
            'author'=>$author,
            'email'=>$email,
            'city'=>$request->param('city'),
            'salary'=>$request->param('salary'),
            'tel'=>$tel,
            'qqs'=>$qqs,
            'adda'=>$adda,
            'content'=>$content,
            'filled'=>$request->param('filled'),
        ];
        $res = $art->save($data,['id'=>$id]);
        if($res){
            $this->success('招聘求职信息修改成功','index/index/index');
        }else{
            $this->error('修改失败');
        }
    }
    //确认订单
    public function enterOk(){
        $request = Request::instance();
        $id = $request->param('id');
        $catid = new Catid();
        $data = ['enter'=>1];
        $res = $catid->save($data,['id'=>$id]);
        if($res){
            $this->success("收货成功！",'index/user/showCatid');
        }else{
            $this->error("收货失败！");
        }
    }
}