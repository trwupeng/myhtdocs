<?php
namespace Home\Controller;
use Think\Controller;
class MyController extends Controller{
        public function _initialize(){
                //取出购物车里面的数量以及金额
                $cartmodel = D('Cart');
                $total = $cartmodel->getCartTotal();
                $this->assign('total',$total);
                //取出导航栏目的数据
                // $catemodel = D('Admin/Category');//跨模块调用模型
                //$navdata = $catemodel->getNav();
                //$this->assign('navdata',$navdata);

        }
}
?>