<?php

    $config	= require './config.php';
    $array=array(
        'SHOW_PAGE_TRACE'=>false,//显示调试信息
		'DEFAULT_THEME'    => 'default',
		'SESSION_AUTO_START'=>true,
		'URL_CASE_INSENSITIVE'=>true, //默认false 表示URL区分大小写 true则表示不区分大小写		
		
		/* URL设置 */
		'URL_CASE_INSENSITIVE'  => false, 	
		'TMPL_CACHE_ON'			=> true, 		//开启模板缓存
		'URL_CASE_INSENSITIVE'  => true, 		//URL不区分大小写
		'URL_MODEL'=>0,
		'URL_PATHINFO_MODEL'=>2,
		'TMPL_STRIP_SPACE'=>false,

		'DEFAULT_MODULE'            =>    'Public', // 默认模块名称
		'DEFAULT_ACTION'            =>    'Login', // 默认操作名称
		'USER_AUTH_MODEL'           =>'User',	// 默认验证数据表模型
		'USER_AUTH_KEY'             =>'authId',	// 用户认证SESSION标记
        'USER_AUTH_TYPE'			=>1,		// 默认认证类型 1 登录认证 2 实时认证
    );
    return array_merge($config,$array);
?>