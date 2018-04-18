<?php
namespace app\admin\validate;

use \think\Validate;

class Admin extends Validate
{
    //规则
    protected $rule = [
        'phone' => 'require|number|max:11|checkPhone:phone',
        'username' => 'require',
        'pwd' => 'require|min:6|max:8',
        'confir_pwd' => 'require|min:6|max:8|confirm:pwd',
    ];
    protected $message = [
        'phone.require' => '手机号不能为空',
        'phone.number' => '手机号必须为数字',
        'phone.max' => '手机号长度必须是11位',
        'phone.checkPhone' => '手机号码不合法',
        'username.require' => '管理员名称不能为空',
        'pwd.require' => '密码不能空',
        'pwd.min' => '密码长度最少6位',
        'pwd.max' => '密码长度最大8位',
        'confir_pwd.require' => '确认密码不能空',
        'confir_pwd.min' => '确认密码长度最少6位',
        'confir_pwd.max' => '确认密码长度最大8位',
        'confir_pwd.confirm' => '两次密码不一致'
    ];
    //应用场景选择
    protected $scene = [
        'add' => ['username', 'pwd', 'confir_pwd'],//如果是添加就验证所有的字段
        'edit' => ['username'],//若果是编辑就只验证用户名
        'modify' => ['username', 'pwd' => 'require|min:6'],//验证pwd部分规则

        'register' => ['username','pwd','confir_pwd']
    ];

    // 自定义验证规则
    protected function checkName($value)
    {
        return strstr($value, 'a') ? true : '名称错误$value-->' . $value;
    }

    /**
     * 验证手机号
     * @param $value
     */
    protected function checkPhone($value)
    {
        $res = preg_match("/^1[34578]{1}\d{9}$/", $value);
        return $res==true?true:false;
    }
}

