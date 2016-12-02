<?php

namespace Admin\Controller;

use Think\Controller;

class OrderController extends MyController {

    public function orderList() {
        //定单列表
        //取出订单数据，
        $orderinfo = M('OrderInfo')->order("id desc ")->select();
        $this->assign('orderinfo', $orderinfo);
        $this->display();
    }

    public function showGoods() {
        $order_id = $_GET['order_id'] + 0;
        //根据order_id取出商品的数据
        $data = M('OrderGoods')->where("order_id=$order_id")->select();
        //构建数组，取出商品的缩略图，属性内容
        $goodsdata = array();
        foreach ($data as $v) {
            $v['info'] = D('Goods')->field("goods_thumb,goods_sn,goods_number")->find($v['goods_id']);
            $v['attrs'] = D('Home/Cart')->getAttrs($v['goods_attr_id']);
            $goodsdata[] = $v;
        }
        $this->assign('goodsdata', $goodsdata);
        $this->display();
    }

}

?>