<?php
namespace app\common\lib\util;
use app\common\lib\util\RedisUtil;
use app\common\lib\util\SqlUtil;
/**
 *会员操作信息类
 */
class UserUtil{
    /**
     * 检测用户是否存在  true=存在 false=不存在
     * @param $username
     */
    public static function isUserRegister($username)
    {
        //先从缓存查找
        $res = RedisUtil::getInstance()->exists(RedisUtil::$KEY_USER.$username);
        if(!$res)
        {
            $sql = "select username from qy_user where username='{$username}' limit 1";
            $res =SqlUtil::getInstance()->query($sql);
        }
        return ($res==true)?true:false;
    }

    /**
     * 保存用户token,最大时间一星期
     * @param $key
     * @param $val
     * @return bool
     */
    public static function saveUserToken($key,$val)
    {
       return RedisUtil::getInstance()->setkey($key,$val,7*24*3600);
    }

    public static function getUserToken($key)
    {
        return RedisUtil::getInstance()->getVal($key);
    }

}