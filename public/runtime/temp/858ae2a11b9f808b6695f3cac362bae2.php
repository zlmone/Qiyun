<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"D:\phpspace\learning\phpweb\thinkphp\public/../application/index\view\index\index.html";i:1522341901;s:77:"D:\phpspace\learning\phpweb\thinkphp\application\index\view\index\header.html";i:1522244639;s:77:"D:\phpspace\learning\phpweb\thinkphp\application\index\view\index\footer.html";i:1522244579;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<div class="content_header">
   我是页面头部
</div>

<link rel="stylesheet" type="text/css" href="/static/css/css1.css" />
首页<?php echo $username; ?><br/>
首页<?php echo substr($username,0,3); ?><br/>
<?php echo \think\Session::get('sess'); ?><br/>
<?php echo date('Y-m-d g:i a',time()); ?><br/>
<?php echo $test; ?><br/>
<?php echo (isset($tu) && ($tu !== '')?$tu:'麦子学院'); ?>
<br/>
请求参数：<?php echo \think\Request::instance()->get('id'); ?>
<br/>
<?php if($test>5): ?>
大于5
<?php else: ?>
小于5
<?php endif; if(is_array($arr)): foreach($arr as $k=>$v): ?>

<br/>键值：<?php echo $k; ?>--键名<?php echo $v; endforeach; endif; if(is_array($arr)): foreach($arr2 as $k=>$v): ?>

<br/>键值：<?php echo $k; ?>--键名<?php echo $v['username']; endforeach; endif; ?>

<p>
    <?php echo $username; ?>
</p>


<br/>
<?php echo $per->name; ?>
<br/>
三目运算符：<?php echo !empty($p)?"存在":"不存在"; ?>
<br/>
time=<?php echo date('y-m-d',$time); ?>

<br/>
<?php $var = '123'; ?>
自定义变量：<?php echo $var; if($var == '1234'): ?>
相等
<?php else: ?>
不相等
<?php endif; ?>
<br/>
<?php if(in_array(($var), explode(',',"1234,123"))): ?>
包含
<?php else: ?>
不包含
<?php endif; ?>
<br/>
<?php if(is_array($arr) || $arr instanceof \think\Collection || $arr instanceof \think\Paginator): $i = 0; $__LIST__ = $arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <br/>属性：<?php echo $vo; endforeach; endif; else: echo "" ;endif; ?>
<hr/>
传入的用户名<?php echo $name; ?>
数据库<?php echo $data['address']; ?>


<div class="content_foot">
  我的页脚部分
</div>

</body>
</html>

