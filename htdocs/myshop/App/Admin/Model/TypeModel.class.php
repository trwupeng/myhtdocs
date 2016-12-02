<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model {
	//添加数据验证
	protected $_validate=array(
	array('type_name','require','商品类型名不能为空')
	);
	protected $insertFields=array('type_name');
}

?>