<?php
namespace app\swoole\controller;
use think\Controller;
use app\common\lib\ali\SmsUtil;
use app\common\lib\util\StringUtil;
use think\Loader;

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
        $this->validate = Loader::validate('Index');
    }

    public function login()
    {
        return $this->fetch('swoole@index/login');
    }

    public function hello2($name = 'ThinkPHP5')
    {
        print_r(input());
        return 'hello,' . $name;
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
            $taskdata=[
                'method'=>'sendSmsCode',
                'data'=>[
                  'phone'=>$phone,
                  'code'=>$code
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

    /**
     * 登录操作
     */
    public function sign()
    {
        $phone = intval($_POST['phone']);
        $code = intval($_POST['code']);
        var_dump($phone,$code);
    }
}
