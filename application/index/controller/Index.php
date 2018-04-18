<?php
namespace app\index\controller;

use \think\Controller;
use \think\Db;
use \think\Request;
use \think\Url;

class Index extends Controller
{
    public function index()
    {
//        print_r($_GET);
//        print_r($_POST);
//        print_r($this->request->param());
//        $data = Db::name('user')->find();
//        var_dump($data);
//        $this->assign('data', $data);
//        $this->assign('name', $name);
//
//        return $this->fetch('index');
//        return "niha ";
        $this->success("地址不对，正在帮你跳转",'admin/login/login');
    }

    public function index3($name = '张三', $sex = '女')
    {
        echo 'hello' . $name . " " . $sex;
    }

    public function hello($name = 'word')
    {
        echo 'Hello' . $name;
        echo '<br/>';
        print_r($this->request->param());
    }

    public function today($year, $month)
    {
        echo '今年是' . $year . "年" . $month . "月";
        echo '<br/>';
//        print_r($this->request->param());
    }

    //生成URL方法
    public function url()
    {
        echo Url::build('url2', 'a=1&b=3');
        echo "<br/>";
        echo url('url2', 'a=2&b=4');
        echo "<br/>";
        echo url('url2', ['a' => 1, 'b' => 3]);
        echo "<br/>";
        echo url('/admin/index/url2', 'name=xiaomingming&sex=男');
        echo "<br/>";
        echo url('index/index/hello');//自动切换
        echo "<br/>";
        echo url('today/2018/05');//路由器规则
    }

    public function url2()
    {
        echo $this->request->param();
    }

    /**
     * REQUEST请求
     * _GET
     * _POST
     * _REQUEST
     * _COOKIE
     * _FILES
     *
     * response响应
     * json
     * xml
     * redirect
     * view
     * this->success
     * this->error
     *
     */
    public function req()
    {

    }


}

//  return $this->fetch('admin@login:index/index');  加载视图view
//$this->success('新增成功', '/app_extend/miaosha.index/say/?id=2345');重定向
//$this->error('新增失败');
