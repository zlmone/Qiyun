<?php

namespace app\common\lib\util;
use app\common\lib\util\CurlUtil;
class StringUtil
{
    /**
     * 获取随机验证码
     * @param int $num
     * @return string
     */
    public static function getRangeCode($num=4)
    {
        return join(array_rand(array_flip(array_merge(range(0,9)+range('a','z'))),$num));
    }

    /**
     * 生成唯一token值
     * @return string
     */
   public static function getToken()
    {
        $str = md5(uniqid(md5(microtime(true)),true));  //生成一个不会重复的字符串
        $str = sha1($str);  //加密
        return $str;
    }

    /**
     * 获取ip对应地址
     * @param $ip
     * @return null|string
     */
     public static function getIPaddress($ip)
    {
        $address=null;
        $ip_url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
        $json_data =json_decode(CurlUtil::get($ip_url),true);
        $status=$json_data['code'];
        if($status==0)
        {
            $address=$json_data['data']['country'].$json_data['data']['region'].$json_data['data']['city'].$json_data['data']['isp'];
        }
        $address=empty($address)?"未知":$address;
        return $address;
    }

    private static function header_nginx()
    {
        if (!function_exists('getallheaders')) {
            function getallheaders()
            {
                $headers = array();
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
            }
        }
    }

    /**
     * 获取头部token
     * @return string
     */
    public static function getHeaderToken()
    {
        self::header_nginx();
        $headers = getallheaders();
        $token = isset($headers['Token']) ? $headers['Token'] : '';
        return $token;
    }
}
