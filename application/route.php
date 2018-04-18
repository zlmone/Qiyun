<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]' => [
        ':id' => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    //hello开头 是否传了参数
    /* 'hello/[:name]'=>['index/index/hello',['method'=>'get','ext'=>'html']],
     'test'=>['admin/req/test',['method'=>'post']],
     'up'=>['admin/up/up',['method'=>'post']],
     'today/:year/:month'=>['index/index/today',['method'=>'get'],['year'=>'\d{4}','month'=>'\d{2}']],*/
     /*******************接口路由******************************/
    'action_login' => ['admin/login/action_login'],
    'action_register' => ['admin/login/action_register'],
    'sign' => ['admin/QyApi/sign'],
    'install' => ['admin/QyApi/install'],
    'notify' => ['admin/Notify/notify'],
    'start' => ['admin/QyApi/start'],
    'close' => ['admin/QyApi/close'],//关闭应用

    /******************视图view*************************/
    'admin' => ['admin/login/login'],//入口
    'login' => ['admin/login/login'],//登录
    'signin' => ['admin/login/signin'],//注册
    'home' => ['admin/menu/home'],//首页
    'showTopContent' => ['admin/menu/showTopContent'],//顶部导航栏
    'showMenuDevice' => ['admin/menu/showMenuDevice'],//设备中心
    'showMenuAppStore' => ['admin/menu/showMenuAppStore'],//应用市场
    'showMenuAuto' => ['admin/menu/showMenuAuto'],//自动化
    'showContentView' => ['admin/menu/showContentView'],//右边内容显示区


];

