<?php
namespace app\common\lib\util;
use Memcache;
/**
 * 数据库操作类
 * Class SqlUtil
 * @package app\common\lib\util
 */
class SqlUtil
{
    public static $_instance;
    private $mobj;
    private $mysqli;
    private function __construct()
    {
        //连接缓存
        $this->mobj = new Memcache();
        $this->mobj->connect('127.0.0.1', 11211);

        $this->mysqli = mysqli_init();
        $this->mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);//设置超时时间
        $this->mysqli->real_connect('39.108.226.88:3306', 'root', 'liu#*@123456', 'qiyun');
    }

    private  function __clone()
    {
    }
    public static function getInstance()
    {
        if (!self::$_instance instanceof SqlUtil) {
            self::$_instance = new SqlUtil();
        }
        return self::$_instance;
    }

    /**
     * 带缓存查询操作
     * @param $sql
     * @param int $ttl
     * @return array|bool|mixed
     */
    public function queryCache($sql, $ttl = 300)
    {
    $key = md5($sql);
    //判断是否已经缓存了
    if (!$this->mobj->get($key)) {//没有缓存的情况
        $res = $this->mysqli->query($sql);
        if ($res && $this->mysqli->affected_rows > 0) {
            if ($res->num_rows > 1) {
                $data = $res->fetch_all(MYSQLI_ASSOC);
            } else {
                $data = $res->fetch_assoc();
            }
            $this->mobj->add($key, serialize($data), 0, $ttl);//30=过期时间
            return $data;
        } else {
            return false;
        }
    } else {
        //有缓存的情况下
        $data = $data = unserialize($this->mobj->get($key));
        return $data;
    }
}

    /**
     * 不带缓存查询操作
     * @param $sql
     * @return array|bool|mixed
     */
    public function query($sql)
    {
        $res = $this->mysqli->query($sql);
        if ($res && $this->mysqli->affected_rows > 0)
        {
            if ($res->num_rows > 1) {
                $data = $res->fetch_all(MYSQLI_ASSOC);
            } else {
                $data = $res->fetch_assoc();
            }
            return $data;
        } else {
            return false;
        }
    }

    /**
     * sql执行操作
     * @param $sql
     * @return int
     */
    public function excute($sql){
        $res = $this->mysqli->query($sql);
        if ($res && $this->mysqli->affected_rows > 0)
        {
            return $this->mysqli->affected_rows;
        }
        return 0;
    }
}
