<?php
namespace app\admin\controller;

use app\common\lib\util\RedisUtil;
use think\Controller;
use app\common\lib\util\StringUtil;
use app\common\lib\util\UserUtil;
use think\Loader;
use think\Db;
use app\common\lib\util\SqlUtil;

// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
//// 响应类型
//header('Access-Control-Allow-Methods:*');
//// 响应头设置
//header('Access-Control-Allow-Headers:x-requested-with,content-type');
/**
 * 登录操作
 */
class Login extends Controller
{
    public $validate;
    /**
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->validate = Loader::validate('Admin');
    }

    public function login()
    {
        return $this->fetch('admin@index/login');
    }

    public function signin()
    {
        return $this->fetch('admin@index/register');
    }

    /**
     * 登录请求
     */
    public function action_login()
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        $username = isset($data['username']) ? $data['username'] : "";
        $pwd = isset($data['pwd']) ? $data['pwd'] : "";
        if (!UserUtil::isUserRegister($username)) {
            //用户不存在
            $data = [
                'status' => 0,
                'msg' => '用户名不存在'
            ];
            $header = ['Content-Type' => 'text/html; charset=utf-8'];
            return json($data, 200, $header);
        }
        //存在继续往下走
        $sql_user = "SELECT userid,pwd,username,token from qy_user where username='{$username}'";
        $res = SqlUtil::getInstance()->query($sql_user);
        if ($res) {
            $sql_pwd = $res['pwd'];
            $in_pwd = "qy_" . md5($pwd);
            if ($sql_pwd === $in_pwd) {
                $abc = array(
                    'userid' => $res['userid'],
                    'username' => $res['username']
                );
                $token = StringUtil::getToken();
                UserUtil::saveUserToken($res['username'], $token);
//                $token =StringUtil::getHeaderToken(); //获取头部token
                header("Set-Cookie:token=" . $token);
                header("Token:" . $token);
                $header = ['Content-Type' => 'text/html; charset=utf-8',
                    'Set-Cookie' => $token,
                    'Token' => $token
                ];
                $data = [
                    'status' => 1,
                    'msg' => '登录成功',
                    'token' => $token,
                    'data' => $abc
                ];
            } else {
                $header = ['Content-Type' => 'text/html; charset=utf-8'];
                $data = [
                    'status' => 0,
                    'msg' => '用户名或密码错误'
                ];
            }
        } else {
            $header = ['Content-Type' => 'text/html; charset=utf-8'];
            $data = [
                'status' => 0,
                'msg' => '用户名或密码错误500'
            ];
        }
        return json($data, 200, $header);
    }

    /**
     * 注册请求
     * @return
     */
    public function action_register()
    {
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);
        $username = isset($data['username']) ? $data['username'] : "";
        $pwd = isset($data['pwd']) ? $data['pwd'] : "";
        $confir_pwd = isset($data['confir_pwd']) ? $data['confir_pwd'] : "";
        $params = [
            'username' => $username,
            'pwd' => $pwd,
            'confir_pwd' => $confir_pwd
        ];
        if ($this->validate->scene('register')->check($params)) {
            //判断是否已经注册了
            if (UserUtil::isUserRegister($username)) {//用户存在
                $data = [
                    'status' => 0,
                    'msg' => '此用户名已注册'
                ];
                $header = ['Content-Type' => 'text/html; charset=utf-8'];
                return json($data, 200, $header);
            }
            $reIP = $_SERVER["REMOTE_ADDR"];
            $address = StringUtil::getIPaddress($reIP);
            $token = StringUtil::getToken();
            $time = time();
            $md5pwd = "qy_" . md5($pwd);
            $sql = "insert qy_user(username,userid,pwd,ip,address,create_time) values('{$username}','qy_{$token}','{$md5pwd}','{$reIP}','{$address}','{$time}')";
            $result = DB::execute($sql);
            if ($result) {
                $data = [
                    'status' => 1,
                    'msg' => '注册成功'
                ];
                RedisUtil::getInstance()->lpush(RedisUtil::$KEY_USER, $username);
                $header = ['Content-Type' => 'text/html; charset=utf-8'];
                return json($data, 200, $header);
            } else {
                $data = [
                    'status' => 0,
                    'msg' => '注册失败'
                ];
                $header = ['Content-Type' => 'text/html; charset=utf-8'];
                return json($data, 200, $header);
            }
        } else {
            $msg = $this->validate->getError();
            $data = [
                'status' => 0,
                'msg' => $msg
            ];
            $header = ['Content-Type' => 'text/html; charset=utf-8'];
            return json($data, 200, $header);
        }
    }


    public function sendSmsCode()
    {
        $phone = intval($_GET['phone']);
        $params = [
            'phone' => $phone
        ];
        if ($this->validate->scene('login')->check($params)) {
//            $this->success('验证通过');
            $code = StringUtil::getRangeCode();
            $data = [
                'status' => 1,
                'code' => $code,
                'phone' => $phone,
                'msg' => '发送成功！'
            ];
            $taskdata = [
                'method' => 'sendSmsCode',
                'data' => [
                    'phone' => $phone,
                    'code' => $code
                ]
            ];
            $_POST['http_server']->task($taskdata);
            $header = ['token' => 'PHPSESSION25545454511'];
            return json($data, 200, $header);
        } else {
            $msg = $this->validate->getError();
            $data = [
                'status' => 0,
                'phone' => $phone,
                'msg' => $msg
            ];
            $header = ['Content-Type' => 'text/html; charset=utf-8'];
            return json($data, 200, $header);
        }
    }


}
