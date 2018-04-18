<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"D:\phpspace\learning\phpweb\thinkphp\public/../application/admin\view\index\index.html";i:1522371303;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
欢迎来到百度商城管理后台
<!--<form method="post" enctype="multipart/form-data" action="<?php echo url('admin/req/test'); ?>">-->
<form method="post" enctype="multipart/form-data" action="<?php echo url('admin/up/up'); ?>">
    文件<input type="file" name="file2">
    用戶名<input type="text" name="name">
    <select name="type">
        <option value="1" selected>图片剪裁</option>
        <option value="2">图片缩略图</option>
        <option value="3">图片翻转</option>

    </select>

    <input type="submit">
</form>
</body>
</html>
