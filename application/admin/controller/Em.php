<?php
/*
 * 控制器
 */
namespace app\admin\controller;
use app\admin\common\Base;
use think\Request;
use think\Session;
use app\admin\model\Admin as Admins;

/**
* 
*/
class Em extends Base
{
	//闭关闭该页面
	public function closes()
	{
		return "<script type='text/javascript'>
                        var index = parent.layer.getFrameIndex(window.name);
        		        parent.$('.btn-refresh').click();
        		        parent.layer.close(index);
		        </script>";
	}
}