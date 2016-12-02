<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    protected  $_validate=array(
        array('username','require','用户名不能为空'),
        array('username','','用户名已存在',1,'unique'),
        array('username','checkName','用户名中有非法字符',1,'callback'),
        array('password','6,12','密码必须是6到12位',1,'length'),
        array('rpassword','password','两次输入的密码不一致',1,'confirm'),
        array('email','email','邮箱格式不正确'),
        array('email','','邮箱已经存在',1,'unique')
    );
    protected function  checkName($name){
        //先排除@，#，*可能
        if(strpos($name,'@')!==false||strpos($name,'*')!==false||strpos($name,'#')!==false){
            return false;
        }
        return true;
    }
    public function login(){
        //接收传递用户名与密码
        $username=I('post.username');
        $password=I('post.password');
        //根据用户名找出密码，匹配后验证
        $info=$this->where("username='$username'")->find();
        if($info){
            if($info['active']==0){
                $this->error='没有激活，无法登陆';
                return false;
            }
            if($info['password']==$password){
                $_SESSION['username']=$username;
                $_SESSION['user_id']=$info['id'];
                return true;
            }
        }
        $this->error='用户名或密码错误';
        return false;
    }
    public function logout() {
		session_start();
		unset($_SESSION['user_id']);
		unset($_SESSION['username']);
		exit;
	} 
}
