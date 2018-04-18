<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
header("Content-type: text/html;charset=utf-8");

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('ROOT_PATH', __DIR__ . '/../');
define('SITE_URL', "http://cphone.qicloud.com");
// 加载框架引导文件
require __DIR__ .'/../thinkphp/start.php';

//开启调试模式
//define('APP_DEBUG',true);
session_start();
if(version_compare(PHP_VERSION,'5.3.0','<')) die('require PHP > 5.3.0');


//后端框架http://www.h-ui.net/Hui-notes-menu.shtml  hui-admin

//如果出现No input file specilfiled

//路由规则
//echo url('url2', ['a' => 1, 'b' => 3]);
//echo "<br/>";
//echo url('/admin/index/url2', 'name=xiaomingming&sex=男');
