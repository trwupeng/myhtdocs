<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    protected $_validate=array(
        array('cat_name','require','栏目名称不能为空')    
    );
    //取出栏目数据的一个方法
    public function getTree(){
        $arr = $this->select();
        return $this->_getTree($arr,$parent_id=0,$lev=0);
    }
    //递归遍历输出树型结构，返回数组树型结构
    public function _getTree($arr,$parent_id=0,$lev=0){
            static $list=array();
            foreach($arr as $v){
                    if($v['parent_id']==$parent_id){
                            $v['lev']=$lev;
                            $list[]=$v;
                            $this->_getTree($arr,$v['id'],$lev+1);
                    }
            }
            return $list;
    }
    //创建显示自己，和自己子级的方法,和树型结构一样设计
	public function getChild($id) {
		$arr=$this->select();
		return $this->_getChild($arr,$id);
	}
	public function _getChild($arr,$id) {
		static $ids=array();
		foreach($arr as $v){
		if($v['parent_id']==$id){
		$ids[]=$v['id'];
		$this->_getChild($arr,$v['id']);
		}
		}
		return $ids;
	}
         public function getNav(){
            return $this->where("parent_id=0")->select();
        }
        public function  getFamily($cat_id){
            $arr=$this->select();
            return array_reverse($this->_getFamily($arr,$cat_id));
        }
        public function _getFamily($arr,$cat_id){
            static $data=array();
            foreach ($arr as $v){
                if($v['id']==$cat_id){
                    $data[]=$v;
                    $this->_getFamily($arr, $v['parent_id']);
                }
            }
            return $data;
        }
}
?>