<?php
/*
 * 前台文章
 */
namespace app\index\controller;
use app\wap\common\Base;
use app\index\model\Article as Articles;
use app\index\model\Articletype;
use app\index\model\System;
use app\index\model\News;
use app\index\model\Engineering;
use app\index\model\Advert;
use app\index\model\Brand;
use app\index\model\Image;
use app\index\model\User;
use app\index\model\Address;
use think\Request;
use think\Session;
class Article extends Base{
    //文章列表
    public function articleList(){
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
        //按分类查找
        $art = new Articles();
        $type = new Articletype();
        $type_list = $type->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //右侧
        $right = $art->where('types',1)->order('nums','DESC')->limit(20)->select();
        $this->assign('right',$right);
        //地区分类
        $adda = new Address();
        $adda_list = $adda->order('id','ASC')->select();
        $this->assign('address',$adda_list);
        //查询
        $request = Request::instance();
        $pid = $request->param('pid') ? $request->param('pid') : '';
        $this->assign('pid',$pid);
        $address = $request->param('address') ? $request->param('address') : '';
        $this->assign('url_address',$address);
        $date = $request->param('date') ? $request->param('date') : '';
        $this->assign('date',$date);
        $type_art = $request->param('type') ? $request->param('type') : '';
        if($pid != ''){
            if($pid == 1){
                if($address != '' && $date != ''){
                    $list = $art->where('typeidd',1)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'date'=>$date,'pid'=>1],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else if($address != ''){
                    $list = $art->where('typeidd',1)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>1],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else{
                    $list = $art->where('typeidd',1)->order('id','DESC')->paginate(20,false,
                    ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>1],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }
            }elseif ($pid == 2) {
                 if($address != '' && $date != ''){
                    $list = $art->where('typeidd',2)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'date'=>$date,'pid'=>2],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else if($address != ''){
                    $list = $art->where('typeidd',2)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>2],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else{
                    $list = $art->where('typeidd',2)->order('id','DESC')->paginate(20,false,
                    ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>2],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }
            }elseif ($pid == 3) {
                if($address != '' && $date != ''){
                    $list = $art->where('typeidd',3)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'date'=>$date,'pid'=>3],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else if($address != ''){
                    $list = $art->where('typeidd',3)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>3],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else{
                    $list = $art->where('typeidd',3)->order('id','DESC')->paginate(20,false,
                    ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>3],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }
            }elseif ($pid == 4) {
                if($address != '' && $date != ''){
                    $list = $art->where('typeidd',4)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'date'=>$date,'pid'=>4],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else if($address != ''){
                    $list = $art->where('typeidd',4)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>4],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else{
                    $list = $art->where('typeidd',4)->order('id','DESC')->paginate(20,false,
                    ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>4],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }
            }elseif ($pid == 5) {
                $this->redirect('index/invite/inviteList');
            }elseif ($pid == 6) {
                if($address != '' && $date != ''){
                    $list = $art->where('typeidd',6)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>6,'address'=>$address,'date'=>$date],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else if($address != ''){
                    $list = $art->where('typeidd',6)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>6],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else{
                    $list = $art->where('typeidd',6)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>6],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }
            }elseif ($pid == 7) {
                if($address != '' && $date != ''){
                    $list = $art->where('typeidd',7)->where('adda',$address)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>7,'date'=>$date],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else if($address != ''){
                    $list = $art->where('typeidd',7)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address,'pid'=>7],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }else{
                    $list = $art->where('typeidd',7)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['pid'=>7],]
                );
                    $this->assign('list',$list);
                    return $this->fetch();
                }
            }
        }else if($address != ''){
            $list = $art->where('types','<>',3)->where('adda',$address)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['address'=>$address],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else if($date != ''){
            $list = $art->where('types','<>',3)->whereTime('createtime',$date)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['date'=>$date],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else if($type_art != ''){
            $list = $art->where('types','<>',3)->where('typeid',$type_art)->order('id','DESC')->paginate(20,false,
                ['type'=>'bootstrap','var_page'=>'page','query'=>['type'=>$type_art],]
                );
            $this->assign('list',$list);
            return $this->fetch();
        }else{
            $list = $art->where('types','<>',3)->order('id','DESC')->paginate(20);
            $this->assign('list',$list);
            return $this->fetch();
        }
    }
    //文章展示
    public function articleShow(){
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
        $request = Request::instance();
        $id = $request->param('id');
        $art = Articles::get($id);
        $this->assign('show',$art);
        $art->setInc('nums',1);
        $type = new Articletype();
        $type_list = $type->order('id','DESC')->select();
        $this->assign('type',$type_list);
        //右侧信息  1
        $art_right = new Articles();
        $art_right1 = $art_right->where('types',1)->order('createtime','DESC')->limit(10)->select();
        $this->assign('right1',$art_right1);
        //右侧信息  2
        $art_right2 = $art_right->where('types',3)->where('filled',1)->order('createtime','DESC')->limit(10)->select();
        $this->assign('right2',$art_right2);
        //右侧信息  3
        $art_right3 = $art_right->where('types',3)->where('filled',0)->order('createtime','DESC')->limit(10)->select();
        $this->assign('right3',$art_right3);
        return $this->fetch();
    }
    //搜索
    public function search(){
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
        //按分类查找
        $art = new Articles();
        $type = new Articletype();
        $type_list = $type->order('id','ASC')->select();
        $this->assign('type',$type_list);
        //右侧
        $right = $art->where('types',1)->order('nums','DESC')->limit(20)->select();
        $this->assign('right',$right);
        //地区分类
        $adda = new Address();
        $adda_list = $adda->order('id','ASC')->select();
        $this->assign('address',$adda_list);
        //查询
        $request = Request::instance();
        $pid = $request->param('pid') ? $request->param('pid') : '';
        $this->assign('pid',$pid);
        $address = $request->param('address') ? $request->param('address') : '';
        $this->assign('url_address',$address);
        $date = $request->param('date') ? $request->param('date') : '';
        $this->assign('date',$date);
        $keys = $request->param('keys');
        $list = $art->where('types',1)->where('title','like','%'.$keys.'%')->order('id','DESC')->paginate(20);
        $this->assign('list',$list);
        return $this->fetch();
    }
}