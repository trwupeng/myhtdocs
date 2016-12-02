<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta name="robots" c>
<meta http-equiv="Content-Type" c />
<link href="/Public/Admin/styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/Js/jquery.js"></script>
<script>
$(function(){
        //
        $(":button").click(function(){
                //取出当前行
                var trs = $(this).parent().parent();
                //判断$(this)里面的内容，根据内容触发事件，如果是+则自我复制，如果是-则删除
                if($(this).val()=='+'){
                        //完成自我复制
                        var new_trs = trs.clone(true);//深层克隆，包含事件一块被克隆。
                        //把新行里面的内容变成-号
                        new_trs.find(":button").val('-');
                        //把新行放到前面
                        trs.before(new_trs);
                }else{
                        //删除当前行
                        trs.remove();
                }
        });

});
</script>
</head>
<body>

<h1>
<span class="action-span"><a href="goodsadd.html">添加新商品</a></span>
<span class="action-span1"><a href="#">ECSHOP 管理中心</a> </span><span id="search_id" class="action-span1"> - 商品列表 </span>
<div style="clear:both"></div>
</h1>

<div class="form-div">

</div>
<form method="post" action="/admin.php/Admin/Goods/product" name="listForm" >

  <div class="list-div" id="listDiv">
<table cellpadding="3" cellspacing="1">
  <tr>
         <?php foreach($radiodata as $v){?>
                    <th><?php echo $v[0]['attr_name']?></th>
         <?php  }?>
        <th>库存</th>
        <th>操作</th>
  </tr>
<?php foreach($kcdata as $v0){?>
<tr>
         <?php foreach($radiodata as $k=>$v){?>
                    <td>
                        <select name="attr[<?php echo $k?>][]">
                                <option>请选择......</option> 
                                <?php foreach($v as $v1){ if(strpos(','.$v0['goods_attr_id'].',',','.$v1['id'].',')!==false){ $sel = "selected='selected'"; }else{ $sel=''; } ?>
                                <option <?php echo $sel?> value="<?php echo $v1['id']?>"><?php echo $v1['attr_value']?></option> 
                                <?php }?>
                        </select>
                    </td>
         <?php  }?>
        <td><input type="text" name="goods_number[]" value="<?php echo $v0['goods_number']?>"/></td>
        <td><input type="button" value="-"/></td>
</tr>

<?php }?>




<tr>
         <?php foreach($radiodata as $k=>$v){?>
                    <td>
                        <select name="attr[<?php echo $k?>][]">
                                <option>请选择......</option> 
                                <?php foreach($v as $v1){?>
                                <option value="<?php echo $v1['id']?>"><?php echo $v1['attr_value']?></option> 
                                <?php }?>
                        </select>
                    </td>
         <?php  }?>
        <td><input type="text" name="goods_number[]"/></td>
        <td><input type="button" value="+"/></td>
</tr>
<input type="hidden" name="goods_id" value="<?php echo $goods_id?>">
<tr>
    <td colspan="<?php echo (count($radiodata)+2)?>" align="center"><input type="submit" value="保存"/></td>
</tr>
</table>

<table id="page-table" cellspacing="0">
  <tr>
    <td align="right" nowrap="true">
      
        
          上页&nbsp;&nbsp;1</b>&lt;&lt; [1]&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=2& title='第2页'>[2]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=3& title='第3页'>[3]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=4& title='第4页'>[4]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=5& title='第5页'>[5]</a>&nbsp;&nbsp;<a href=admin.php?c=goods&a=goodsList&page=8& title='第8页'>&gt;&gt;8</a>&nbsp;<a href=admin.php?c=goods&a=goodsList&page=2&  title='下一页'>[下一页]</a>
    
    </td>
  </tr>

</table>

</div>
</form>

<div id="footer">
共执行 7 个查询，用时 0.112141 秒，Gzip 已禁用，内存占用 3.085 MB<br />
版权所有 &copy; 2005-2010 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>