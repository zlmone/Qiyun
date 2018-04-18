<?php
/**
 * 文件操作类
 */
namespace app\common\lib\util;
class FileUtil
{
    public static $DIR_LOG = "acces_log";
    public static $DIR_ERROR_LOG = "acces_error_log";

    /**
     * 写入日志文件
     * @param $content
     * @param string $filename 文件名
     * @param null $dir
     */
    public static function writeAccessLog($content, $filename = 'access.log', $dir = null)
    {
        $time = date("Y-m-d H", time());
        $dirname = ROOT_PATH ."public/". (empty($dir) ? self::$DIR_ERROR_LOG : $dir);
        if (!file_exists($dirname)) {
            mkdir($dirname, 0777, true);
        }
        $filename = $dirname ."/".$time ."_".$filename;
        $myfile = fopen($filename, "a+") or die("Unable to open file!");
        fwrite($myfile, $content."\n");
        fclose($myfile);
    }
}
