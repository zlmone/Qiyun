<?php
namespace app\admin\controller;

use app\common\lib\util\RedisUtil;
use app\common\lib\util\StringUtil;
use app\common\lib\util\UserUtil;
use app\common\lib\util\SqlUtil;
use app\common\Base;
use think\Loader;

/**
 * 首页
 */
class Menu extends Base
{
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
     * 首页
     * @return mixed
     */
    public function home()
    {
        return $this->fetch('admin@index/admin');
    }

    /**
     * @return mixed
     */
    public function showTopContent()
    {
        $this->assign('username', $_COOKIE['username']);
        return $this->fetch('admin@index/admin_top_nav');
    }
    public function showMenuDevice()
    {
        return $this->fetch('admin@index/admin_device');
    }
    public function showMenuAppStore()
    {
        return $this->fetch('admin@index/admin_app_store');
    }
    public function showMenuAuto()
    {
        return $this->fetch('admin@index/admin_auto');
    }

    /**
     * 内容显示区
     * @return mixed
     */
    public function showContentView()
    {
        return $this->fetch('admin@index/content_container');
    }
}
