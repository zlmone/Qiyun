<?php
namespace app\swoole\controller;

use think\Controller;
use app\common\lib\util\RedisUtil;

class Index extends Controller
{

    public function index()
    {
        return "";
    }

    public function redis()
    {
        $data =[
            'username'=>'liuqiang',
            'age'=>26
        ];
        $res = RedisUtil::getInstance()->setkey("users",$data, 80);
        echo "执行结果：".$res;
        echo "查询结果：".RedisUtil::getInstance()->getVal('uses');
    }
}
