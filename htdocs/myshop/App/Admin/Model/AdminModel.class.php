<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model{
    public  $_validate=array(
        array('admin_name','require','管理员名称不能为空'),
        array('password','require','密码不能为空'),
        array('admin_name','','管理员名称已存在',1,'unique'),
        array('password','6,12','密码长度要是6-12位',1,'length',1),
        array('password','6,12','密码长度要是6-12位',2,'length',2),
        array('rpassword','password','两次输入密码不一致',1,'confirm'),
        
    );
    //定义一个属性，用于设置验证规则
    public $_login_validate=array(
            array('admin_name','require','管理员名称不能为空'),
            array('password','require','密码不能为空'),
            array('checkCode','require','验证码不能为空'),
            array('checkCode','checkAuthCode','验证码输入错误',1,'callback')
    );
    //验证验证码是否正确的一个方法。
    protected function checkAuthCode($code, $id = ''){
             $verify = new \Think\Verify();    
             return $verify->check($code, $id);
    }
    //验证登录是否成功
    public function login(){
            //接收传递的用户名与密码
            $admin_name = I('post.admin_name');
            $password = I('post.password');
            //思路：根据输入的用户名找出密码后，与输入的密码进行比较
            $info = $this->where("admin_name='$admin_name'")->find();//返回的是一个一维数组
            if($info){
                //已经查到，还要验证密码是否正确
                if(md5(md5($password).$info['salt'])==$info['password']){
                            //用户名与密码正确，登录成功
                            //登录成功后，把用户名和用户的id存储到session里面
                            $_SESSION['admin_name']=$admin_name;
                            $_SESSION['admin_id']=$info['id'];
                            return true;
                }
            }
            //没有查到，
            $this->error='用户名或密码错误';
            return false;
    }
    protected function _after_insert($data, $options) {
       $id=$data['id'];
       //接收传递的角色id
       $role_id=$_POST['role_id']+0;
       M('AdminRole')->add(
               array(
                   'admin_id'=>$id,
                   'role_id'=>$role_id
               )
               );
    }
    protected function _after_delete($data, $options) {
        $id=$options['where']['id'];
        if(M('AdminRole')->where("admin_id=$id")->delete()===false){
            $this->error='删除中间表失败';
            return false;
        }
    }
     protected function _after_update($data,$options){
           $id = $options['where']['id'];
           $model = M("AdminRole");
           $model->where("admin_id=$id")->delete();
           $model->add(array(
                'admin_id'=>$id,
                 'role_id'=>I('post.role_id'),
           ));
    }
   //取出权限按钮
    public function getButtons(){
        //根据登录管理员的id
       // $admin_id = $_SESSION['admin_id'];
        $admin_id = $_SESSION['admin_id'];
        if($admin_id==1){
                //超级管理员
                //(1)取出顶级权限
                 $sql="select * from it_privilege where parent_id=0";
                 $arr = M()->query($sql);//模型里面的query方法是取出查询的数据，execute是操作（增删该）的语句
                //(2)根据取出的顶级权限，再取出子级权限
                foreach($arr as $k=>$v){
                        $sql="select * from it_privilege where parent_id=".$v['id'];
                        $arr[$k]['child']=M()->query($sql);
                }
        }else{
                //普通的管理员,要根据管理员的id,找出角色，找出角色所属的权限，
                $sql="select c.* from it_admin_role  a left join it_role_privilege b on a.role_id=b.role_id left join it_privilege c on b.priv_id=c.id  where a.admin_id=$admin_id and c.parent_id=0";
                $arr = M()->query($sql);
                foreach($arr as $k=>$v){
                        $sql="select c.* from it_admin_role  a left join it_role_privilege b on a.role_id=b.role_id left join it_privilege c on b.priv_id=c.id  where a.admin_id=$admin_id and c.parent_id=".$v['id'];
                        $arr[$k]['child']=M()->query($sql);
                }

        }
        return $arr;
    }
  
}
?>