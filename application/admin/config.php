<?php
/**
 * 模块配置文件
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 8:19
 */
return [
    'view_replace_str' => [
        '__PUBLIC__' => SITE_URL . '/static/admin/',
        '__URL__' => "http://cphone.qicloud.com/",
        '__SELF__' => "http://web.payfu.store/",
    ],
    'template' => [
        // 模板后缀
        'view_suffix' => 'html',
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}}',
        // 标签库标签开始标记
        'taglib_begin' => '{{',
        // 标签库标签结束标记
        'taglib_end'   => '}}'
    ],
    'url_qy'=>[
        'sign'=>'http://bapi.qicloud.com/0/account/assign',//创建设备post
        'install'=>'http://bapi.qicloud.com/0/app/install',//安装应用GET
        'start'=>'http://bapi.qicloud.com/0/session/start',//启动应用POST
        'close'=>'http://bapi.qicloud.com/0/session/close',//启动应用POST
        'task_stat'=>'http://bapi.qicloud.com/0/session/stat',//查询任务状态 GET
        'task_list'=>'http://bapi.qicloud.com/0/session/list',//查询任务列表 GET
        'task_screen'=>'http://bapi.qicloud.com/0/session/screencap',//获取任务截图 GET
    ]
];
