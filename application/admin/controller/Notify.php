<?php
namespace app\admin\controller;
// 指定允许其他域名访问
use think\Controller;
header('Access-Control-Allow-Origin:*');
/**
 * 安装应用
 */
class Notify extends Controller
{
    public static $app_key = "133f4a3b67859d89824aa560685a4713";
    public static $app_secret = "cd064fe38ed4923375de616231c71146";

    /**
     * 安装应用回掉地址
     * @return string
     */
    public function notify()
    {
        $json = file_get_contents("php://input");
        \app\common\lib\util\FileUtil::writeAccessLog("保存回调--->".$json);
        $data= ['rtn'=>0];
        return json_encode($data);
    }

}
