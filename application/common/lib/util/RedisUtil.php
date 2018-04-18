<?php

namespace app\common\lib\util;

require_once ROOT_PATH . 'extend/predis-1.1/autoload.php';
/**
 *redis操作单例模式
 */
class RedisUtil
{
    public static $instance;
    public $redis;
    public static $KEY_SMS = "sms_";
    public static $KEY_TOKEN = "token_";
    public static $KEY_USER = "user_name";

    private function __clone()
    {
    }

    private function __construct()
    {
        //得到客户端对象
        $config = array(
            'host' => '127.0.0.1',
            'port' => '6379'
        );
        $this->redis = new \Predis\Client($config);
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof Redis) {
            self::$instance = new RedisUtil();
        }
        return self::$instance;
    }

    /**
     * @param $phone
     * @return string
     */
    public function getSmsKey($phone)
    {
        return self::$KEY_SMS . $phone;
    }

    /**
     * @param $token
     * @return string
     */
    public function getTokenKey($token)
    {
        return self::$KEY_TOKEN . $token;
    }

    /**
     * 存储数据
     * @param $key
     * @param $val
     * @param null $ttl
     * @return bool
     */
    public function setkey($key, $val, $ttl = null)
    {
        if (!$key) return false;
        if (is_array($val)) {
            $this->redis->set($key, json_encode($val));
        } else {
            $this->redis->set($key, $val);
        }
        if (isset($ttl) && intval($ttl) > 0)
            $this->redis->expire($key, $ttl);
        return true;
    }

    /**
     * 获得键值
     * @param $key
     * @return string
     */
    public function getVal($key)
    {
        if (!$key) return false;
        return $this->redis->get($key);
    }

    /**
     * 删除
     * @param $key
     * @return bool|int
     */
    public function delKey($key)
    {
        $res = $this->redis->exists($key);
        if ($res) {
            return $this->redis->del($key);
        }
        return false;
    }


    /**
     * 添加用户到队列
     * @param $key
     * @param $value
     */
    public function lpush($key, $value)
    {
        return $this->redis->lpush($key,array($value));
    }

    /**
     * 删除队列中指定元素
     * @param $key
     * @param $value
     */
    public function ldel($key, $value)
    {
        return $this->redis->lrem($key, 0, $value);
    }

    /**
     * 获取队列中元素
     * @param $key
     */
    public function lrange($key)
    {
        return $this->redis->lrange($key, 0, -1);
    }

    /**
     * 清空队列
     * @param $key
     */
    public function lreset($key)
    {
        if($this->redis->exists($key))
        {
            return $this->redis->del($key);
        }
        return true;
    }

    function __call($name, $arguments)
    {
        if (count($arguments) == 1) {
            $this->$name($arguments[0]);
        } elseif (count($arguments) == 2) {
            $this->$name($arguments[0], $arguments[1]);
        } else{
            return "参数错误";
        }
    }
    /**
     * 检测是否存在
     * @param $key
     * @param $val
     * @return int
     */
    public function exists($key){
        return $res = $this->redis->exists($key);
    }
}
