<?php

namespace Home\Controller;

use Think\Controller;

class UserController extends MyController {

    //完成用户的注册 
    public function register() {
        if (IS_POST) {
            $usermodel = D('User');
            if ($usermodel->create()) {
                $validate = uniqid();
                $usermodel->validate = $validate;
                if ($usermodel->add()) {
                    //成功,发送邮件
                    $email = I('post.email');
                    $title = '注册用户，完成激活';
                    $url = 'http://www.myshop.com/index.php/Home/User/active/key/' . $validate . '/email/' . $email;
                    $content = "亲爱的用户，你注册成功：请<br/><a href='$url'>单击激活</a>";
                    if (sendEmail($email, $title, $content)) {
                        $this->success("注册成功,赶紧进入邮箱激活", U('login'));
                        exit;
                    } else {
                        $this->error("发送邮件失败，请重新注册");
                    }
                } else {
                    //失败
                    $this->error('注册失败');
                }
            } else {
                $this->error($usermodel->getError());
            }
        }
        //取出头部的导航信息
        $catemodel = D('Admin/Category'); //跨模块调用模型
        $navdata = $catemodel->getNav();
        $this->assign('navdata', $navdata);
        $this->display();
    }

    //激活用户的方法
    public function active() {
        //接收传递的key 和email
        $key = $_GET['key'];
        $email = $_GET['email'];
        //思路：根据email找出用户的数据，取出用户的validate内容与传递的key进行比较。
        $usermodel = D('User');
        $info = $usermodel->where("email='$email'")->find();
        if (!$info) {
            $this->error("激活失败");
        }
        //验证连接是否有效
        if ($info['validate'] != $key) {
            $this->error('链接无效');
        }
        //如果已经激活，就无需激活
        if ($info['active'] == 1) {
            $this->success('已经激活，无需激活', U('login'));
        }
        //开始激活
        $res = $usermodel->where("email='$email'")->setField('active', 1);
        if ($res) {
            //提交激活成功，开始跳转
            $this->success("激活成功", U('login'));
            exit;
        } else {
            $this->error('激活失败，请重新激活');
        }
    }

    public function login() {
        if (IS_POST) {
            $usermodel = D('User');
            if ($usermodel->login()) {
                //调用
                $cartmodel = D('Cart');
                $cartmodel->cookie2db();
                if (!empty($_SESSION['return_url'])) {
                    $url = $_SESSION['return_url'];
                } else {
                    $url = 'Index/index';
                }
                $this->success('登陆成功', U($url));
                exit;
            } else {
                $this->error($usermodel->getError());
            }
        }
        $this->display();
    }

    public function findPass1() {
        $this->display();
    }

    public function findPass2() {
        $username = I('post.username');
        $usermodel = D('User');
        $info = $usermodel->field('id,question')->where("username='$username'")->find();
        if (!$info) {
            $this->error('用户名输入错误');
        }
        $this->assign('info', $info);
        $this->display();
    }

    public function findPass3() {
        //接收传递过来的id与答案
        $id = I("post.id");
        $answer = I("post.answer");
        $usermodel = D('User');
        $info = $usermodel->field("id,answer,email,validate")->where("id=$id")->find();
        if (!$info) {
            $this->error('参数错误');
        }
        //要判断答案是否正确
        if ($info['answer'] == $answer) {
            //答案正确，开始发送邮件
            //邮件的链接是修改密码的页面，要重新设置密码
            $title = '找回密码';
            $email = $info['email'];
            $key = $info['validate'];
            $url = 'http://www.myshop.com/index.php/Home/User/update/key/' . $key . '/email/' . $email;
            $content = "亲爱的用户，请单击链接修改密码<br/><a href='$url'>单击修改密码</a>";
            if (sendEmail($email, $title, $content)) {
                $this->success("去邮箱修改密码", U('User/login'));
                exit;
            } else {
                $this->error("发送邮件失败，请重新找回");
            }
        } else {
            $this->error('答案错误');
        }
    }

//     public function update(){
//         $key=$_GET['key'];
//         $email=$_GET['email'];
//         $usermodel=D('User');
//         $info=$usermodel->where("email='$email'")->find();
//         if(!$info){
//             $this->error('链接失败');
//         }
//         $_SESSION['id']=$info['id'];
//         $this->display();
//     }
    public function update() {
        $usermodel = D('User');
        if (IS_POST) {
            $id = $_SESSION['id'];
            $password = I('post.password');
            $res = $usermodel->where("id=$id")->setField('password', $password);
            if ($res) {
                //修改成功
                $this->success("修改密码成功");
                exit;
            } else {
                //修改失败
                $this->error('修改失败，请重新找回');
            }
        }
        //接收传递的key 与邮箱
        //接收传递的key 和email
        $key = $_GET['key'];
        $email = $_GET['email'];
        //思路：根据email找出用户的数据，取出用户的validate内容与传递的key进行比较。

        $info = $usermodel->where("email='$email'")->find();
        if (!$info) {
            $this->error("链接失败");
        }
        //展示一个表单，修改密码的一个表单
        //把要修改用户的id存储到session里面。
        $_SESSION['id'] = $info['id'];
        $this->display();
    }

    public function logout() {
        if (IS_POST) {
            $usermodel = D('User');
            if ($usermodel->logout()) {
                $this->success('退出成功', U('logout'));
                exit;
            } else {
                $this->error($usermodel->getError());
            }
        }
        $this->display();
    }

}

?>