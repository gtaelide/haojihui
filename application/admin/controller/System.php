<?php
/*
 * 系统管理
 */
namespace app\admin\controller;
use app\admin\common\Base;
use app\admin\model\System as systems;
use think\Session;
use think\Request;
class System extends Base{
	//系统查看
	public function systemBase(){
	    $this->isLogin();
	    $sys = Systems::get('1');
	    $this->assign('show',$sys);
		return $this->fetch();
	}
	//系统修改
	public function systemUpdate(){
	    $this->isLogin();
        $sys = new Systems();
        $request = Request::instance();
        //图片类
        $img =  request()->file('img');
        $logo =  request()->file('logo');
        $ico = request()->file('ico');
        //信息类
        $short = $request->param('short');
        $name = $request->param('name');
        $keys = $request->param('keys');
        $desc = $request->param('desc');
        $uploads = $request->param('uploads');
        $footersize = $request->param('footersize');
        $icp = $request->param('icp');
        $tel = $request->param('tel');
        $qqs = $request->param('qqs');
        $domian = $request->param('domian');
        $zhifubao = $request->param('zhifubao');
        $weixin = $request->param('weixin');
        $principal = $request->param('principal');
        $integral = $request->param('integral');
        if($img != '' && $logo != '' && $ico != ''){
        	//微信图片上传
            $info1 = $img->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info1){
                $path1 =  $info1->getSaveName();
            }else{
                $this->error($img->getError(),'systemBase');
            }
            $img = strtr($path1,'\\','/');
            //logo图片处理
            $info2 = $logo->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info2){
                $path2 =  $info2->getSaveName();
            }else{
                $this->error($logo->getError(),'systemBase');
            }
            $logo = strtr($path2,'\\','/');
            //图标上传
            $info3 = $ico->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info3){
                $path3 =  $info3->getSaveName();
            }else{
                $this->error($ico->getError(),'systemBase');
            }
            $ico = strtr($path3,'\\','/');
            $data = [
                'img'=>$img,'logo'=>$logo,'ico'=>$ico,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,
                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }elseif ($img != '' && $logo != '') {
        	//微信图片上传
            $info1 = $img->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info1){
                $path1 =  $info1->getSaveName();
            }else{
                $this->error($img->getError(),'systemBase');
            }
            $img = strtr($path1,'\\','/');
            //logo图片处理
            $info2 = $logo->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info2){
                $path2 =  $info2->getSaveName();
            }else{
                $this->error($logo->getError(),'systemBase');
            }
            $logo = strtr($path2,'\\','/');
            $data = [
                'img'=>$img,'logo'=>$logo,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,
                                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }elseif ($img != '' && $ico != ''){
            //微信图片上传
            $info1 = $img->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info1){
                $path1 =  $info1->getSaveName();
            }else{
                $this->error($img->getError(),'systemBase');
            }
            $img = strtr($path1,'\\','/');
             //图标上传
            $info3 = $ico->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info3){
                $path3 =  $info3->getSaveName();
            }else{
                $this->error($ico->getError(),'systemBase');
            }
            $ico = strtr($path3,'\\','/');
            $data = [
                'img'=>$img,'ico'=>$ico,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }elseif ($logo != '' && $ico != '') {
            //logo图片处理
            $info2 = $logo->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info2){
                $path2 =  $info2->getSaveName();
            }else{
                $this->error($logo->getError(),'systemBase');
            }
            $logo = strtr($path2,'\\','/');
            //图标上传
            $info3 = $ico->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info3){
                $path3 =  $info3->getSaveName();
            }else{
                $this->error($ico->getError(),'systemBase');
            }
            $ico = strtr($path3,'\\','/');
            $data = [
                'logo'=>$logo,'ico'=>$ico,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }elseif ($img != '') {
        	//微信图片上传
            $info1 = $img->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info1){
                $path1 =  $info1->getSaveName();
            }else{
                $this->error($img->getError(),'systemBase');
            }
            $img = strtr($path1,'\\','/');
            $data = [
                'img'=>$img,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }elseif ($logo != '') {
            //logo图片处理
            $info2 = $logo->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info2){
                $path2 =  $info2->getSaveName();
            }else{
                $this->error($logo->getError(),'systemBase');
            }
            $logo = strtr($path2,'\\','/');
            $data = [
                'logo'=>$logo,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }elseif ($ico != '') {
            //图标上传
            $info3 = $ico->validate(['size'=>3000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info3){
                $path3 =  $info3->getSaveName();
            }else{
                $this->error($ico->getError(),'systemBase');
            }
            $ico = strtr($path3,'\\','/');
            $data = [
                'ico'=>$ico,'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }
        }else{
            $data = [
                'name'=>$name,'keys'=>$keys,'uploads'=>$uploads,'footersize'=>$footersize,'icp'=>$icp,'tel'=>$tel,'qqs'=>$qqs,'domian'=>$domian,'zhifubao'=>$zhifubao,
                'weixin'=>$weixin,'principal'=>$principal,'desc'=>$desc,'short'=>$short,'integral'=>$integral,                'qqs2'=>$request->param('qqs2'),'tel2'=>$request->param('tel2'),'qqs3'=>$request->param('qqs3'),'tel3'=>$request->param('tel3'),
                'qqs4'=>$request->param('qqs4'),'tel4'=>$request->param('tel4'),'qqs5'=>$request->param('qqs5'),'tel5'=>$request->param('tel5'),
                'qqs6'=>$request->param('qqs6'),'tel6'=>$request->param('tel6')
            ];
            $res = $sys->save($data,['id'=>1]);
            if($res){
                 $this->success('系统设置成功','admin/system/systemBase');
            }else{
                 $this->error('系统设置失败','admin/system/systemBase');
            }

        }
	}
	//屏蔽词
	public function systemfont(){
		return $this->fetch();
	}
	//系统折线图
	public function charts1(){
		return $this->fetch();
	}
	//时间曲线图
	public function charts2(){
		return $this->fetch();
	}
	//区域图
	public function charts3(){
		return $this->fetch();
	}
	//柱状图
	public function charts4(){
		return $this->fetch();
	}
	//饼状图
	public function charts5(){
		return $this->fetch();
	}
	//栏目设置
	public function column(){
		return "该功能模块正在开发中...敬请期待";
	}
	//系统日志
	public function logs(){
        return "该功能模块正在开发中...敬请期待";
	}
}