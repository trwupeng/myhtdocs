<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
<title>新建网页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<script type="text/javascript">

</script>

<style type="text/css">
</style>
</head>
    <body>
   <h1>修改密码</h1>
    <form action="/index.php/Home/User/update" method="post"/>
    输入密码：<input type="text" name="password"/><br/>
    确认密码：<input type="text" name="rpassword"/><br/>
    <input type="submit" value="修改"/>
    </form>
    </body>
</html>