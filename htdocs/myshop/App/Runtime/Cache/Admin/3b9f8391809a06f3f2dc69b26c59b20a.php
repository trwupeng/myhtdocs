<?php if (!defined('THINK_PATH')) exit();?><table width="800">
<tr>
    <td>商品名称</td>
    <td>商品货号</td>
    <td>商品价格</td>
    <td>商品数量</td>
    <td>商品属性</td>
    <td>商品库存</td>
    <td>商品小计</td>
</tr>
<?php foreach($goodsdata as $v){?>
<tr>
    <td><img src="<?php echo C('IMG_SRC').$v['info']['goods_thumb']?>"/><?php echo $v['goods_name']?></td>
    <td><?php echo $v['info']['goods_sn']?></td>
    <td><?php echo $v['shop_price']?></td>
    <td><?php echo $v['goods_number']?></td>
    <td><?php echo $v['attrs']?></td>
    <td><?php echo $v['info']['goods_number']?></td>
    <td><?php echo $v['shop_price']*$v['goods_number']?></td>
</tr>
<?php }?>
</table>