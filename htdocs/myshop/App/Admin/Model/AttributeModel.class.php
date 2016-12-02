<?php
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model{
    //添加数据验证
    protected $_validate=array(
        //array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
        array('attr_name','require','属性名称不能为空'),
        array('type_id','number','商品类型不合法'),
        array('attr_type',array(0,1),'属性类型不合法',1,'in'),
        array('attr_input_type',array(0,1),'属性值录入方式不合法',1,'in')
    );
}
?>