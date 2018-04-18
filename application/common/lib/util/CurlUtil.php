<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 23:24
 */
namespace app\common\lib\util;
class CurlUtil
{

    /**
     * get请求
     * @param $url  请求地址
     * @return mixed 返回请求结果
     */
    public static function get($url)
    {
        $curl = curl_init();
        curl_setopt ($curl, CURLOPT_URL, $url);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT,5);
        $info = curl_exec($curl);
        curl_close($curl);
        return $info;
    }

    /**
     * POST方式请求抓取页面数据
     * @param $url
     * @param array $data  数据
     * @param array $header
     * @return mixed
     */
    public static function post($url, $data = array(), $header = array())
    {
        $curl = curl_init();
//        $data=array(
//            'name'=>'2.jpeg',
//            'passed'=>'dwedefrf'
//        );
        $header = array(
            'Host: www.maiziedu.com',//这个也要变
            'Origin:http://www.maiziedu.com',//这个也要变
            'Referer:http://www.maiziedu.com/',//上级来源，这个需要变的
            'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36'
        );
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5); // 设置超时限制防止死循环
        //设置发起连接前的等待时间，如果设置为0，则无限等待。
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//跳过证书检查，访问htpps需要设置此项
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);//设置CURLOPT_PORT 跟表单提交一样
//     curl_setopt($curl, CURLOPT_HTTPHEADER, $header);//设置头部

        //$cookiefile=dirname(__FILE__).'/maizuCookie.txt';
        //curl_setopt($curl, CURLOPT_COOKIESESSION, true);//启用cookie
        //curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiefile);//包含cookie文件
        //curl_setopt($curl, CURLOPT_COOKIEJAR, session_name()."=".session_id());
        //设置支持跳转
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
//        curl_setopt($curl,CURLOPT_POSTFIELDS,array('users'=>$data));//POST只能用数组形式数据，数组会以表单格式
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $info = curl_exec($curl);//运行curl
        if (false === $info) {
            curl_close($curl);
            return "curl执行失败，详细信息：" . curl_error($curl) . "/" . curl_errno($curl);
        }
        curl_close($curl);
        return $info;
    }

    /**
     * 上传文件
     * @param $url  上传地址
     * @param $upfile  上传文件绝对路径
     * @return bool
     */
    public static function uploadFile($url, $upfile)
    {
        $filename =pathinfo($upfile,PATHINFO_BASENAME);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$url);
      //注意文件名前要加@符号，而且要使用绝对路径
        $data=array(
            'name'=>urlencode($filename),
            'file'=>"@".$upfile//需要完成的绝对路径
        );
        curl_setopt($curl, CURLOPT_POST, 1);//设置CURLOPT_PORT 跟表单提交一样
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);//只能用数组形式数据，数组会以表单格式
        $res = curl_exec($curl);
        if(false ===$res)
        {
            echo "-->CURL ERROR".curl_error($curl)."/".curl_errno($curl);
            curl_close($curl);
            return false;
        }
        curl_close($curl);
        return true;
    }


}
