<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('RUNTIME_ALLINONE', true);  // 开启ALLINONE运行模式
define('APP_NAME','Admin');      // 定义项目名称
/**
 * 应用目录设置
 * 安全期间，建议安装调试完成后移动到非WEB目录
 */
define('APP_PATH','./Admin/');	//定义项目目录

/**
 * 系统调试设置
 * 项目正式部署后请设置为false
 */
define('APP_DEBUG', false);
//加载框架入口文件
require './ThinkPHP/ThinkPHP.php';?>