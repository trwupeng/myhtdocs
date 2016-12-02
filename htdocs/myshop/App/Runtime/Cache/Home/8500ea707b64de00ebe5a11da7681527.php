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
     <form action="<?php echo U('User/findPass3')?>" method="post">
         问题：<?php echo $info['question']?><br/>
         答案：<input type="text" name='answer'/><br/>
         <input type="hidden" name='id' value="<?php echo $info['id']?>" />
         <input type="submit" value="下一步"/>
     </form>
 </body>
</html>