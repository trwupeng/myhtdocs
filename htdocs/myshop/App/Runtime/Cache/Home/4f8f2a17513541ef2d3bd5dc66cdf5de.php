<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 </head>
 <body>
     <h1>找回密码:</h1>
     <form action="<?php echo U('User/findPass2')?>" method="post">
         请输入用户名:<input type="text" name='username'/><br/>
         <input type="submit" value="下一步"/>
     </form>
 </body>
</html>