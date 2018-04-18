<?php
namespace app\common\lib\ali;

use app\common\lib\util\CurlUtil;
use app\common\lib\util\FileUtil;
/**
 * 发送消息类工具类
 * Class SmsUtil
 */
class SmsUtil
{
    /**
     * 发送短信
     * @return stdClass
     */
    public static function sendSms($phone, $code)
    {
        //手机验证码接口调用网址
        $url = "http://send.18sms.com/msg/HttpBatchSendSM?account=qdj449&pswd=69gj2Z2M&mobile=" . $phone . "&msg=主子，你的验证是" . $code . ",验证码打死也不要告诉其他人~&needstatus=true&product=48091587";
        $res = CurlUtil::get($url);
        try {
            $ff = strpos($res, ',');
            $bs = $ff + 1;
            $verify_fanhui = substr($res, $bs, 1);
            if($verify_fanhui == '0')
            {
                return 'ok';
            }
        } catch (Exception $e) {
            FileUtil::writeAccessLog(get_class()."---->".$e->getMessage());
            return false;
        }
        return false;
    }

}
