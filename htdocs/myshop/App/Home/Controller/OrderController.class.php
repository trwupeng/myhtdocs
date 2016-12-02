<?php

namespace Home\Controller;

use Think\Controller;

class OrderController extends MyController {

    public function checkout() {
        //提交到这一步：
        //(1)判断购物车里面是否有商品
        $cartmodel = D('Cart');
        $total = $cartmodel->getCartTotal();
        if ($total['total_count'] == 0) {
            //没有商品，
            $this->success('没有商品，无法下单', U("Index/index"));
            exit;
        }
        //(2)判断用户是否登录，
        //如果用户没有登录，则跳转到登录页面，登录完成后，再跳回来。
        $user_id = $_SESSION['user_id'];
        if (!$user_id) {
            //没有登录，跳转到登录页面 
            //把当前的地址存储到 session里面，方便调回来
            $_SESSION['return_url'] = 'Order/checkout';
            $this->redirect("User/login");
        }
        //(3)判断是否填写收货人信息。
        //根据user_id查找it_address表里面的数据，如果有，则说明已经填写收货人信息。
        $info = M("Address")->where("user_id=$user_id")->find();
        if (!$info) {
            //没有填写收货人信息，
            //跳转到填写收货人信息的页面
            $this->redirect("Order/writeAddress");
        }
        //购物车列表数据
        $cartlist = $cartmodel->cartList();
        $this->assign('cartlist', $cartlist);
        //展示收货人的信息。
        $this->assign('consigneeinfo', $info);
        //购物金额
        $this->assign('total', $total);
        $this->display();
    }

    public function writeAddress() {
        if (IS_POST) {
            $consignee = I("post.consignee");
            $mobile = I('post.mobile');
            $address = I('post.address');
            $post = I('post.post');
            $user_id = $_SESSION['user_id'];
            $res = M("Address")->add(array(
                'consignee' => $consignee,
                'mobile' => $mobile,
                'address' => $address,
                'post' => $post,
                'user_id' => $user_id
            ));
            if ($res) {
                //添加成功，跳转到checkout页面
                $this->success("添加成功", U('checkout'));
                exit;
            } else {
                $this->error('添加失败');
            }
        }
        //填写收货人信息
        $this->display();
    }

    //开始入库
    public function flow() {
        //接收传递的数据
        $user_id = $_SESSION['user_id'];
        $order_sn = 'sn_' . uniqid();
        $cartmodel = D('Cart');
        $total = $cartmodel->getCartTotal();
        $goods_amount = $total['total_price'];
        $addtime = time();
        $consignee = I('post.consignee');
        $address = I('post.address');
        $mobile = I('post.mobile');
        $payment = I("post.payment");
        $shipping = I('post.shipping');
        //订单信息表入库
        $order_id = M("OrderInfo")->add(array(
            'user_id' => $user_id,
            'order_sn' => $order_sn,
            'goods_amount' => $goods_amount,
            'addtime' => $addtime,
            'consginee' => $consignee,
            'address' => $address,
            'mobile' => $mobile,
            'payment' => $payment,
            'shipping' => $shipping
        ));
        //购物车里面的数据
        $cartlist = $cartmodel->cartList();
        $this->assign('cartlist', $cartlist);
        //入库订单与商品的关联表
        foreach ($cartlist as $v) {
            M("OrderGoods")->add(array(
                'order_id' => $order_id,
                'goods_id' => $v['goods_id'],
                'goods_name' => $v['info']['goods_name'],
                'goods_attr_id' => $v['goods_attr_id'],
                'shop_price' => $v['info']['shop_price'],
                'goods_number' => $v['goods_count']
            ));
        }
        //订单成功，要清空购物车
        $cartmodel->clearCart();
        $this->redirect("Order/done", array('order_sn' => $order_sn));
    }

    //完成下定义的一个提示页面
    public function done() {
        //接收传递的订单号
        $order_sn = $_GET['order_sn'];
        $this->assign('order_sn', $order_sn);
        $this->display();
    }

}

?>