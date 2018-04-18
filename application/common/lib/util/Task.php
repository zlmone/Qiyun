<?php
namespace app\common\lib\util;

use app\common\lib\ali\SmsUtil;
use app\common\lib\util\RedisUtil;

class Task
{
    public $ws;

    /**
     * Task constructor.
     * @param $ws
     */
    public function __construct($ws)
    {
        $this->ws = $ws;
    }
    public function sendSmsCode($data, $callback)
    {
        $res = SmsUtil::sendSms($data['phone'], $data['code']);
        if ("ok" == $res) {
            call_user_func($callback, 'ok');
            return true;
        } else {
            call_user_func($callback, 'fail');
            return false;
        }
    }

    public function pushMsg($data)
    {
        $res = RedisUtil::getInstance()->lrange('userlist');
        print_r($res);
        $msg = $data['fd'] . "回复：" . $data['data'];

        if ($res && is_array($res)) {
            foreach ($res as $vo) {
                if ($vo == $data['fd']) continue;
                $this->ws->push($vo, $msg);
            }
        }
    }
}
