<?php
require './init.php';
//接收提交的表单数据，
$order_amount = $_POST['money'];
$goods_name = $_POST['goods_name'];
//入库操作，入订单表
$order_sn = 'sn_'.time();
$sql="insert into order_info(order_sn,order_amount) values('$order_sn','$order_amount')";
$res = mysql_query($sql);
$id = mysql_insert_id($conn);//返回自增的id号
if(!$id){
    echo '对不起，你提交的订单失败';exit;
}
echo "你提交的订单成功，订单号为：".$order_sn.'订单金额为：'.$order_amount;

//'1009001'=>'#(%#WU)(UFGDKJGNDFG',
$v_mid = '1009001';//商户号
$v_oid = $order_sn;//订单编号
$v_amount = $order_amount;//订单金额
$v_moneytype = 'CNY';//人民币类型
$v_url = 'http://www.lianxi.com/access.php';//告诉第三方支付平台，把支付结果返回到该页面。
$key = '#(%#WU)(UFGDKJGNDFG';
//v_amount v_moneytype v_oid v_mid v_url key
$v_md5info = strtoupper(md5($v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key));
//如下的表单是准备提交到第三方支付平台的数据
?>
<form action="http://www.lianxi.com/index.php" method="post" >
<input type='hidden' name='v_mid' value="<?php echo $v_mid?>">
<input type='hidden' name='v_oid' value="<?php echo $v_oid?>">
<input type='hidden' name='v_amount' value="<?php echo $v_amount?>">  
<input type='hidden' name='v_moneytype' value="<?php echo $v_moneytype?>"> 
<input type='hidden' name='v_url' value="<?php echo $v_url;?>">
<input type='hidden' name='v_md5info' value="<?php echo $v_md5info?>">   
<input type="submit" value="在线支付"/>
</form>