<?php 
/*
*
*
*后台入口文件
***
 */
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//自定义配置文件

define('BIND_MODULE','admin');
define('CONF_PATH', __DIR__ . '/../config/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';