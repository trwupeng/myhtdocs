<?php if (!defined('THINK_PATH')) exit();?><table>
<?php  foreach($attrdata as $v){ if($v['attr_type']==0){ if($v['attr_input_type']==0){ echo "<tr><td>".$v['attr_name'].":</td><td>"; echo "<input type='text' name='attr[".$v['id']."]'/>"; echo "</td></tr>"; }else{ echo "<tr><td>".$v['attr_name'].":</td><td>"; $attrs = $v['attr_value']; $attrs = str_replace('，',',',$attrs); $attrarray = explode(',',$attrs); echo "<select name='attr[".$v['id']."]'>"; foreach($attrarray as $k1=>$v1){ echo "<option value='".$v1."'>".$v1."</option>"; } echo "</select></td></tr>"; } }else{ if($v['attr_input_type']==0){ echo "<tr><td>".$v['attr_name'].":</td><td>"; echo "<input type='text' name=''/>"; echo "</td></tr>"; }else{ echo "<tr><td><a href='javascript:' onclick='copytr(this)'>[+]</a>".$v['attr_name'].":</td><td>"; $attrs = $v['attr_value']; $attrs = str_replace('，',',',$attrs); $attrarray = explode(',',$attrs); echo "<select name='attr[".$v['id']."][]'>"; foreach($attrarray as $k1=>$v1){ echo "<option value='".$v1."'>".$v1."</option>"; } echo "</select></td></tr>"; } } } ?>
</table>
<script>
function copytr(o){
    //取出当前行
    var trs=$(o).parent().parent();
    //判断a标签的内容是否是[+]
    if($(o).html()=='[+]'){
                //开始复制
                var new_trs = trs.clone();//克隆当前行
                //把克隆的新行里面的a标签里面的内容变成[-]
                new_trs.find('a').html('[-]');
                //把新行放到当前行的后面
                trs.after(new_trs);
    }else{
        //如果 a标签里面没有“[+]”则就删除当前行。
        trs.remove();
    }
}
</script>