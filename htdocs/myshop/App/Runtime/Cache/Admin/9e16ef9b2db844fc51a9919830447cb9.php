<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0053)http://www.myecshop.com/admin/privilege.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><HTML 
xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>ECSHOP 管理中心</TITLE>
<META content="text/html; charset=utf-8" http-equiv="Content-Type"><LINK rel="stylesheet" 
type="text/css" href="/myshop/Public/Admin/styles/general.css"><LINK rel="stylesheet" 
type="text/css" href="/myshop/Public/Admin/styles/main.css">
<STYLE type="text/css">
body {
  color: white;
}
</STYLE>

<SCRIPT type="text/javascript" src="/myshop/Public/Admin/utils.js"></SCRIPT>

<SCRIPT type="text/javascript" src="/myshop/Public/Admin/validator.js"></SCRIPT>

<SCRIPT language="JavaScript">
<!--
// 这里把JS用到的所有语言都赋值到这里
var process_request = "正在处理您的请求...";
var todolist_caption = "记事本";
var todolist_autosave = "自动保存";
var todolist_save = "保存";
var todolist_clear = "清除";
var todolist_confirm_save = "是否将更改保存到记事本？";
var todolist_confirm_clear = "是否清空内容？";
var user_name_empty = "管理员用户名不能为空!";
var password_invaild = "密码必须同时包含字母及数字且长度不能小于6!";
var email_empty = "Email地址不能为空!";
var email_error = "Email地址格式不正确!";
var password_error = "两次输入的密码不一致!";
var captcha_empty = "您没有输入验证码!";

if (window.parent != window)
{
  window.top.location.href = location.href;
}

//-->
</SCRIPT>

<META name="GENERATOR" content="MSHTML 9.00.8112.16609"></HEAD>
<BODY style="background: rgb(39, 130, 150);">
<FORM method="post" name="theForm" action="/myshop/index.php/Admin/Login/login">
<TABLE style="margin-top: 100px;" cellSpacing="0" cellPadding="0" 
align="center">
  <TBODY>
  <TR>
    <TD><IMG border="0" alt="ECSHOP" src="/myshop/Public/Admin/images/login.png" 
      width="178" height="256"></TD>
    <TD style="padding-left: 50px;">
      <TABLE>
        <TBODY>
        <TR>
          <TD>管理员姓名：</TD>
          <TD><INPUT name="admin_name" type="text"></TD></TR>
        <TR>
          <TD>管理员密码：</TD>
          <TD><INPUT name="password" type="password"></TD></TR>
        <TR>
          <TD>验证码：</TD>
          <TD><INPUT class="capital" name="checkCode" type="text"></TD></TR>
        <TR>
          <TD colSpan="2" align="right"><IMG style="cursor: pointer;" title="看不清？点击更换另一个验证码。" 
            onclick="this.src='/myshop/index.php/Admin/Login/autoCode/'+Math.random()"
            border="1" alt="CAPTCHA" src="/myshop/index.php/Admin/Login/autoCode" 
            width="145" height="20"></TD></TR>
        <TR>
          <TD colSpan="2"><INPUT id="remember" name="remember" value="1" type="checkbox"><LABEL 
            for="remember">请保存我这次的登录信息。</LABEL></TD></TR>
        <TR>
          <TD>&nbsp;</TD>
          <TD><INPUT class="button" value="进入管理中心" type="submit"></TD></TR>
        <TR>
          <TD colSpan="2" align="right">» <A style="color: white;" href="http://www.myecshop.com/">返回首页</A> 
            » <A style="color: white;" href="http://www.myecshop.com/admin/get_password.php?act=forget_pwd">您忘记了密码吗?</A></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><INPUT 
name="act" value="signin" type="hidden"></FORM>
</BODY></HTML>