<?php
/*
 * 后台系统首页
 */
namespace app\admin\controller;
use app\admin\common\Base;
use app\admin\model\Pagetype;
use app\admin\model\System;
use app\admin\model\Admin;
use think\Session;
use think\Db;
class Index extends Base{
	public function index(){
	    $this->isLogin();
	    $admin = Session::get('username');
	    $aid = Session::get('aid');
	    $this->assign('aid',$aid);
	    $this->assign('admin',$admin);
	    $pagetype = new Pagetype();
	    $pagestype=$pagetype->order('id','DESC')->select();
	    $this->assign('pagetype',$pagestype);
	    //系统设置
	    $system = System::get(1);
	    $this->assign('system',$system);
		return $this->fetch();
	}
	public function Welcome(){
	    $this->isLogin();
	    $admin = Session::get('username');
	    $aid = Session::get('aid');
	    $this->assign('aid',$aid);
	    $this->assign('admin',$admin);
	    //系统
	    $system = System::get(1);
	    $this->assign('system',$system);
	    //管理员
            $adminss = Admin::get(Session::get('aid'));
            $this->assign('adminss',$adminss);
            $this->assign('adminss_logintime',$adminss->logintime);
            $adminss->setInc('nums',1);
            $adminss->save(['logintime'=>date('Y-m-d H:i:s')]);
            $this->assign('cip',$_SERVER['REMOTE_ADDR']);
            //客户端  服务端参数
            // 获取今天的
            $art_new_today = count(Db::table('article') ->where('types',1)->whereTime('createtime', 'today')->select());
            $art_pro_today = count(Db::table('article') ->where('types',2)->whereTime('createtime', 'today')->select());
            $engineer_ss_today = count(Db::table('engineering') ->whereTime('createtime', 'today')->select());
            $admin_ss_today = count(Db::table('admin') ->whereTime('createtime', 'today')->select());
            $user_ss_today = count(Db::table('user') ->whereTime('createtime', 'today')->select());
            $this->assign('art_new_today',$art_new_today);
            $this->assign('art_pro_today',$art_pro_today);
            $this->assign('engineer_ss_today',$engineer_ss_today);
            $this->assign('admin_ss_today',$admin_ss_today);        
            $this->assign('user_ss_today',$user_ss_today);
            // 获取昨天的
            $art_new_yes = count(Db::table('article')->where('types',1)->whereTime('createtime', 'yesterday')->select());
            $art_pro_yes = count(Db::table('article') ->where('types',2)->whereTime('createtime', 'yesterday')->select());
            $engineer_ss_yes = count(Db::table('engineering') ->whereTime('createtime', 'yesterday')->select());
            $admin_ss_yes = count(Db::table('admin') ->whereTime('createtime', 'yesterday')->select());
            $user_ss_yes = count(Db::table('user') ->whereTime('createtime', 'yesterday')->select());
            $this->assign('art_new_yes',$art_new_yes);
            $this->assign('art_pro_yes',$art_pro_yes);
            $this->assign('engineer_ss_yes',$engineer_ss_yes);
            $this->assign('admin_ss_yes',$admin_ss_yes);        
            $this->assign('user_ss_yes',$user_ss_yes);
            // 获取本周的
            $art_new_week = count(Db::table('article')->where('types',1)->whereTime('createtime', 'week')->select());
            $art_pro_week = count(Db::table('article') ->where('types',2)->whereTime('createtime', 'week')->select());
            $engineer_ss_week = count(Db::table('engineering') ->whereTime('createtime', 'week')->select());
            $admin_ss_week = count(Db::table('admin') ->whereTime('createtime', 'week')->select());
            $user_ss_week = count(Db::table('user') ->whereTime('createtime', 'week')->select());
            $this->assign('art_new_week',$art_new_week);
            $this->assign('art_pro_week',$art_pro_week);
            $this->assign('engineer_ss_week',$engineer_ss_week);
            $this->assign('admin_ss_week',$admin_ss_week);        
            $this->assign('user_ss_week',$user_ss_week);   
            // 获取本月的
            $art_new_month = count(Db::table('article')->where('types',1)->whereTime('createtime', 'month')->select());
            $art_pro_month = count(Db::table('article') ->where('types',2)->whereTime('createtime', 'month')->select());
            $engineer_ss_month = count(Db::table('engineering') ->whereTime('createtime', 'month')->select());
            $admin_ss_month = count(Db::table('admin') ->whereTime('createtime', 'month')->select());
            $user_ss_month = count(Db::table('user') ->whereTime('createtime', 'month')->select());
            $this->assign('art_new_month',$art_new_month);
            $this->assign('art_pro_month',$art_pro_month);
            $this->assign('engineer_ss_month',$engineer_ss_month);
            $this->assign('admin_ss_month',$admin_ss_month);        
            $this->assign('user_ss_month',$user_ss_month);      
            // 获取今年的
            $art_new_year = count(Db::table('article')->where('types',1)->whereTime('createtime', 'year')->select());
            $art_pro_year = count(Db::table('article') ->where('types',2)->whereTime('createtime', 'year')->select());
            $engineer_ss_year = count(Db::table('engineering') ->whereTime('createtime', 'year')->select());
            $admin_ss_year = count(Db::table('admin') ->whereTime('createtime', 'year')->select());
            $user_ss_year = count(Db::table('user') ->whereTime('createtime', 'year')->select());
            $this->assign('art_new_year',$art_new_year);
            $this->assign('art_pro_year',$art_pro_year);
            $this->assign('engineer_ss_year',$engineer_ss_year);
            $this->assign('admin_ss_year',$admin_ss_year);        
            $this->assign('user_ss_year',$user_ss_year); 
            // 获取全部 
            $art_new_all = count(Db::table('article')->where('types',1)->select());
            $art_pro_all = count(Db::table('article') ->where('types',2)->select());
            $engineer_ss_all = count(Db::table('engineering') ->select());
            $admin_ss_all = count(Db::table('admin') ->select());
            $user_ss_all = count(Db::table('user') ->select());
            $this->assign('art_new_all',$art_new_all);
            $this->assign('art_pro_all',$art_pro_all);
            $this->assign('engineer_ss_all',$engineer_ss_all);
            $this->assign('admin_ss_all',$admin_ss_all);        
            $this->assign('user_ss_all',$user_ss_all); 
	     return $this->fetch();
	}
}
