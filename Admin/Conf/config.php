<?php

    $config	= require './config.php';
    $array=array(
        //'SHOW_PAGE_TRACE'=>1,//显示调试信息
		'DEFAULT_THEME'    => 'default',
		'SESSION_AUTO_START'=>true,
        'USER_AUTH_ON'              =>true,
        'USER_AUTH_TYPE'			=>1,		// 默认认证类型 1 登录认证 2 实时认证
        'USER_AUTH_KEY'             =>'authId',	// 用户认证SESSION标记
        'ADMIN_AUTH_KEY'			=>'administrator',
        'USER_AUTH_MODEL'           =>'Admin',	// 默认验证数据表模型
		'AUTH_PWD_ENCODER'          =>'md5',	// 用户认证密码加密方式
        'USER_AUTH_GATEWAY'         =>'/Public/login',// 默认认证网关
		'DEFAULT_GROUP'         => 'Admin',  // 默认分组
		'DEFAULT_MODULE'        => 'Public', // 默认模块名称
		'DEFAULT_ACTION'        => 'Login', // 默认操作名称
		/* URL设置 */
		'URL_CASE_INSENSITIVE'  => false, 	
		'TMPL_CACHE_ON'			=> true, 		//开启模板缓存
		'URL_CASE_INSENSITIVE'  => true, 		//URL不区分大小写
		'URL_MODEL'=>0,
		'URL_PATHINFO_MODEL'=>2,
		'TMPL_STRIP_SPACE'=>false,
    );
    return array_merge($config,$array);
?>