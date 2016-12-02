<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model{
    protected  $_validate=array(
        array('role_name','require','角色名称不能为空')
    );
    //钩子函数,用于完成中间表的入库
    
    protected  function  _after_insert($data,$options) {
        $role_id=$data['id'];//获取角色的id;
        $priv_id=I('post.priv_id');//是一个一维数组
        $model=M('RolePrivilege');
        foreach($priv_id as $v){
        $model->add(array(
           'role_id' =>$role_id,
             'priv_id'=>$v
        
                ));
        }
    }
    protected function _after_delete($data, $options) {
     //删除角色与权限的中间表的内容
        $id=$options['where']['id'];
        if(M('RolePrivilege')->where("role_id=$id")->delete()===false){
            $this->error='删除中间表失败';
            return false;
        }
        
    }
}
?>