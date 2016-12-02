<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends MyController {

    public function index() {
        //取出导航信息
        $catemodel = D('Admin/Category'); //跨模块调用模型
        $navdata = $catemodel->getNav();
        $this->assign('navdata', $navdata);
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        //取出热卖商品
        $goodsmodel = D('Admin/Goods');
        $this->bestdata = $goodsmodel->getByGoods('best', 3);
        $this->newdata = $goodsmodel->getByGoods('new', 3);
        $this->hotdata = $goodsmodel->getByGoods('hot', 3);
        $this->display();
    }

    //栏目页面的数据内容
    public function category() {
        $catemodel = D('Admin/Category'); //跨模块调用模型
        $navdata = $catemodel->getNav();
        $this->assign('navdata', $navdata);
        //接受传递的栏目id
        $cat_id = $_GET['id'] + 0;
        //判断是有子孙栏目，
        $ids = $catemodel->getChild($cat_id); //返回的是一个一维数组
        //p($ids);exit;
        if (empty($ids)) {
            //为空，则说明没有子孙栏目，说明自己就是一个子栏目
            $ids[] = $cat_id;
        }
        //根据栏目的id取出商品的数据
        //把$ids一维数组，转换成一个用逗号分割的字符串。
        $ids = implode(',', $ids);
        //取出商品数据
        $goodsmodel = D('Admin/Goods');
        $goodsdata = $goodsmodel->where("cat_id in ($ids)")->select();
        $this->assign('goodsdata', $goodsdata);
        $this->display();
    }

    // 取出商品的详情数据
    public function detail() {
        $catemodel = D('Admin/Category'); //跨模块调用模型
        $navdata = $catemodel->getNav();
        $this->assign('navdata', $navdata);
        //接收传递商品的id,
        $goods_id = $_GET['id'] + 0;
        //根据goods_id取出商品数据
        $goodsmodel = D('Admin/Goods');
        $goodsinfo = $goodsmodel->find($goods_id);
        //如果没有商品，则跳转到首页
        if (empty($goodsinfo)) {
            //跳转到首页
            header("location:/index.php");
        }
        //p($goodsinfo);exit;
        $sql = "select a.id,a.attr_id,a.attr_value,b.attr_name,b.attr_type from it_goods_attr a left join it_attribute b on a.attr_id=b.id where a.goods_id=$goods_id ";
        $attrdata = $goodsmodel->query($sql);
        //var_dump($attrdata);
        //exit;
        $radiodata = array();
        foreach ($attrdata as $v) {
            if ($v['attr_type'] == 1) {
                $radiodata[$v['attr_id']][] = $v;
            }
        }
        $familydata = $catemodel->getFamily($goodsinfo['cat_id']);
        //var_dump($familydata);
        //exit;
        $this->assign('familydata', $familydata);
        $this->assign('radiodata', $radiodata);
        $this->assign('goodsinfo', $goodsinfo);
        $this->display();
    }

}
