<?php
namespace app\admin\controller;

use app\common\lib\util\RedisUtil;
use app\common\lib\util\StringUtil;
use app\common\lib\util\UserUtil;
use app\common\lib\util\SqlUtil;
use app\common\Base;
use think\Config;
use think\Loader;
use app\common\lib\util\CurlUtil;

/**
 * 服务器接口访问
 */
class QyApi extends Base
{
    public static $app_key = "133f4a3b67859d89824aa560685a4713";
    public static $app_secret = "cd064fe38ed4923375de616231c71146";
    public static $notify_url = "http://cphone.qicloud.com/notify";
    public $validate;

    /**
     * Base constructor.
     * @param $validate
     */
    public function __construct()
    {
        parent::__construct();
        $this->validate = Loader::validate('Admin');
    }

    /**
     * 创建设备
     */
    public function sign()
    {
        $data = array();
        $data["app_key"] = self::$app_key;
        $data["user_id"] = 'ceshi';
        $data["timestamp"] = time();
        $data["proxy"] = "0";
        $json_data = json_encode($data);
        $sign = $this->hmac($json_data, self::$app_secret);
        $url = Config::get('url_qy.sign') . "?sign=" . $sign;
        print_r(CurlUtil::post($url, $data));
    }

    /**
     * @param $client_id 客户端唯一标识
     * @param $apk_url   现在安装包地址
     */
    public function install($client_id='bcea97e40aad32c654e0d3bc8cc13ad3bfd87872', $apk_url='https://xiaoqiang01.oss-cn-beijing.aliyuncs.com/apk/rjxy.apk')
    {
        $data = array();
        $data['app_key'] = self::$app_key;
        $data['client_id'] = $client_id;
//        $data['need_upload'] = false;
//        $data['apk_file_info'] = "";
        $data['apk_url'] = $apk_url;
        $data['callback_url'] = self::$notify_url;
        $data["timestamp"] = time();
        $data["proxy"] = "0";
        $json_data = json_encode($data);
        $sign = $this->hmac($json_data, self::$app_secret);
        $url = Config::get('url_qy.install') . "?sign=" . $sign;
        print_r(CurlUtil::post($url, $data));
    }

    /**
     * 启动应用
     * @param string $userid
     * @param string $pack_name
     * @param int $max_ttl
     */
    public function start($userid='ceshi',$pack_name='learning.com.learning',$max_ttl=3600)
    {
        $data = array();
        $data['app_key'] = self::$app_key;
        $data['client_id'] = $userid;
        $data['target'] = $pack_name;
        $data['quality'] = "low";
        $extends=[
         'max_ttl'=>$max_ttl,
         'ephemeral'=>false
        ];//启动参数
        $data['params'] = $extends;
        $data["timestamp"] = time();
        $json_data = json_encode($data);
        $sign = $this->hmac($json_data, self::$app_secret);
        $url = Config::get('url_qy.start') . "?sign=" . $sign;
        print_r(CurlUtil::post($url, $data));
    }

    /**
     * 关闭应用
     * @param string $client_id
     * @param string $seeeionid  启动应用成功会有这个值
     */
    public function close($client_id='bcea97e40aad32c654e0d3bc8cc13ad3bfd87872',$seeeionid=''){
        $data = array();
        $data['app_key'] = self::$app_key;
        $data['client_id'] = $client_id;
        $data['session_id'] = $seeeionid;
        $json_data = json_encode($data);
        $sign = $this->hmac($json_data, self::$app_secret);
        $url = Config::get('url_qy.start') . "?sign=" . $sign;
        print_r(CurlUtil::post($url, $data));
    }


}
