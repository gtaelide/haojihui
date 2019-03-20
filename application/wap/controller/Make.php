<?php
namespace app\wap\controller;
use app\wap\common\Base;
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
use think\Session;
use think\Request;

class Make extends Base{
    public function lists(){
	//会员
	    $user_name = Session::get('name') ? Session::get('name') : '';
        $user_time = Session::get('time') ? Session::get('time') : '';
        $user_uid = Session::get('uid') ? Session::get('uid') : '';
        $this->assign('user_name',$user_name);
        $this->assign('user_time',$user_time);
        $this->assign('user_uid',$user_uid);
        $users = Users::get($user_uid);
        $this->assign('users',$users);
		return $this->fetch();
    }
    //article信息发布
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
        $type_list = $type->where('pid',0)->where('id','<>',4)->where('id','<>',5)->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }
    //invite信息发布
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
        $type_list = $type->where('pid',5)->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }
    //engineer工程信息
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
        $type = new Enginertype();
        $type_list = $type->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
        $this->assign('type_id',$type_id);
        //地区分类
        $address = new Address();
        $adda = $address->order('id','ASC')->select();
        $this->assign('adda',$adda);
        return $this->fetch();
    }
    //brand商家
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
        $type = new Enginertype();
        $type_list = $type->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //供求信息发布
        $type_id = $type->where('id','<>',4)->where('id','<>',5)->order('id','DESC')->select();
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
        if($choose == 1){
            $typeidd = $type->where('id',$typeid)->find();
            $sys = System::get('1');
            $ints = $sys->integral;
            $user = Users::get($user_uid);
            $user->setInc('integral',$ints);
            $price = $request->param('price');
            $file = request()->file('img');
            if(!empty($file)){
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->validate(['size'=>30000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
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
                $this->success('供求信息发布成功','wap/index/index');
            }else{
                 $this->error('发布失败');
            }
        }else if($choose == 2){
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
                $this->success('招聘求职信息发布成功','wap/index/index');
            }else{
                 $this->error('发布失败');
            }
        }else if($choose == 3){
            $from = $request->param('from');
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
                $this->success('工程信息发布成功','wap/index/index');
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
                $this->success('申请成功，请等待客服联系','wap/index/index');
            }else{
                $this->error('申请失败');
            }
        }
    }
}