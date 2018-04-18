<?php
namespace app\common;

use think\Controller;
use app\common\lib\util\UserUtil;

class Base extends Controller
{
    protected function _initialize()
     {
         $username = $_COOKIE['username'];
         $token = $_COOKIE['token'];
         $is_ok_Token =UserUtil::getUserToken($username);
         if (($token != $is_ok_Token) || empty($token) || empty($is_ok_Token)) {
             $this->loginOut();
         }
     }

    /**
     * 退出登录
     */
    public function loginOut()
    {

        setcookie('username', '', -1);
        setcookie('token', '', -1);
        $this->redirect('admin/login/login');
    }

    /**
     * 计算MD5
     * @param $data
     * @param $key
     * @return string
     */
    public function hmac($data, $key)
    {
        if (function_exists('hash_hmac')) {
            return hash_hmac('md5', $data, $key);
        }

        $key = (strlen($key) > 64) ? pack('H32', 'md5') : str_pad($key, 64, chr(0));
        $ipad = substr($key, 0, 64) ^ str_repeat(chr(0x36), 64);
        $opad = substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64);
        return md5($opad . pack('H32', md5($ipad . $data)));
    }

}
