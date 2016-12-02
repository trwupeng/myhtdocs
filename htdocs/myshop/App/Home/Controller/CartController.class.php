<?php

namespace Home\Controller;

use Think\Controller;

class CartController extends MyController {

    public function addCart() {
        //接收提交的数据
        $goods_id = I("post.goods_id");
        $attr = I('post.attr'); //返回的是一个一维数组
        //把属性拼接成一个用逗号隔开的字符串
        $goods_attr_id = '';
        if ($attr) {
            $goods_attr_id = implode(',', $attr);
        }
        //接收提交的购买数量
        $goods_count = I('post.goods_count');
        $cartmodel = D('Cart');
        $cartmodel->addCart($goods_id, $goods_attr_id, $goods_count);
        $this->success('添加购物车成功', U('cartList'));
    }

    public function cartList() {
        // 取出导航信息
        $catemodel = D('Admin/Category'); //跨模块调用模型
        $navdata = $catemodel->getNav();
        $this->assign('navdata', $navdata);
        $cartmodel = D('Cart');

        $cartdata = $cartmodel->CartList();
        //p($cartdata);exit;
        $this->assign('cartdata', $cartdata);
        $this->display();
    }

    public function updateCart($goods_id, $goods_attr_id, $goods_count = 1) {
        //接收传送的数据
        $goods_id = $_GET['goods_id'] + 0;
        $goods_attr_id = $_GET['goods_attr_id'];
        $cartmodel = D('Cart');
        $cartmodel->updateCart($goods_id, $goods_attr_id, $goods_count = 1);
        echo 'ok';
    }

    public function delCart() {
        $goods_id = $_GET['goods_id'] + 0;
        $goods_attr_id = $_GET['goods_attr_id'];
        $cartmodel = D('Cart');
        $cartmodel->delCart($goods_id, $goods_attr_id);
        $this->success("删除购物车成功", U('cartList'));
    }

    public function clearCart() {
        $cartmodel = D('Cart');
        $total = $cartmodel->getCartTotal();
        if ($total['total_count'] > 0) {
            $cartmodel->clearCart();
            $this->success("清空购物车成功", U('Index/index'));
        }
        $this->error('亲,你的购物车空空如也,购物去吧！');
    }

}

?>