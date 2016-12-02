<?php
namespace Admin\Controller;
use Think\Controller;
class MyController extends Controller{
        //写一个构造函数，用于完成是否登录验证，
        //_initialize()该方法是在构造函数里面执行的。
        public function  _initialize(){
               //判断session里面的id是否存在
               $admin_id = $_SESSION['admin_id'];
               if($admin_id>0){
                    return true;
               }else{
                    $this->success('必须登录',U('Login/login'));
               }
        }
}
?>