<?php
return [
	//定义模板常量路径
	'view_replace_str' => [
		'PUBLIC'=>'/public',
		'ROOT' => '/',
		'APP' => '/app/admin/',
		'__STATIC__'=>'/static',
		'__ADMIN__' => 'static/admin',
		'__ROUTE__'=> '/public/static/admin',
	    '__BOOT__'=> '/public/static/boot',
	    '__LOGIN__'=> '/public/static/login',
	    '__INDEX__'=> '/public/static/index',
	    '__UPLOAD__'=> '/public/uploads'
	],
	'template'  => [
	    // 模板引擎
	    // 普通标签开始标记
	    'tpl_begin' =>    '({',
		// 普通标签结束标记
		'tpl_end'   =>    '})'
	],
    // 应用调试模式
    'app_debug'              => true,
    //验证码
    'captcha'  => [
        // 验证码字符集合
        'codeSet'  => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
        // 验证码字体大小(px)，根据所需进行设置验证码字体大小
        'fontSize' => 18,
        // 是否画混淆曲线
        'useCurve' => true,
        // 验证码图片高度，根据所需进行设置高度
        'imageH'   => '35',
        // 验证码图片宽度，根据所需进行设置宽度
        'imageW'   => '120',
        // 验证码位数，根据所需设置验证码位数
        'length'   => 4,
        // 验证成功后是否重置
        'reset'    => true
    ],	
	'URL_MODEL' => 2,//REWRITE模式,
	'app_multi_module' => true,
];