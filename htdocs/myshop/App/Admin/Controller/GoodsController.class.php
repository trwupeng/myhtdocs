<?php

namespace Admin\Controller;

use Think\Controller;

class GoodsController extends MyController {

    public function add() {
        if (IS_POST) {
            // p($_FILES);exit;
            $goodsmodel = D('Goods');
            if ($goodsmodel->create()) {
                if ($goodsmodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                }
            }
            $error = $goodsmodel->getError(); //获取模型里面error属性的内容。
            if (empty($error)) {
                $error = '添加失败';
            }
            $this->error($error);
        }
        //取出商品的栏目信息
        $catemodel = D('Category');
        $catedata = $catemodel->getTree();
        $this->assign('catedata', $catedata);
        //获取商品的类型
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('typedata', $typedata);
        $this->display();
    }

    public function lst() {
        $cat_id = $_GET['cat_id'] + 0;
        if ($cat_id == 0) {
            $where = 1;
        } else {
            $where = "cat_id=$cat_id";
        }
        $catemodel = D('Category');
        $catedata = $catemodel->getTree();
        //$catedata=$catemodel->select();
        $this->assign('catedata', $catedata);
        $goodsmodel = D('Goods');
        //计算总的记录数
        $count = $goodsmodel->where($where)->count(); // 查询满足要求的总记录数
        $Page = new \Think\Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数(2)
        //格式化输出页
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $show = $Page->show(); // 分页显示输出
        $this->assign('page', $show);

        $goodsdata = $goodsmodel->field("a.*,b.cat_name")->join("a left join it_category b on a.cat_id=b.id")->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('cat_id', $cat_id);
        //$goodsdata=$goodsmodel->select();
        $this->assign('goodsdata', $goodsdata);

        $this->display();
    }

    public function del() {
        $goods_id = $_GET['id'] + 0;
        $goodsmodel = D('Goods');
        $goodsmodel->delete($goods_id);
        $this->redirect('lst');
    }

    //根据商品类型取出属性,该方法用于返回已经生成好的属性表单
    public function showAttr() {
        //接收传递的商品类型的id
        $type_id = $_GET['goods_type_id'] + 0;
        $attrmodel = D("Attribute");
        $attrdata = $attrmodel->where("type_id=$type_id")->select();
        $this->assign('attrdata', $attrdata);
        $this->display();
    }

    public function product() {
        $goods_id = $_GET['id'] + 0;
        $goodsmodel = D('Goods');
        //入库
        if (IS_POST) {
            $goods_id = I('post.goods_id');
            $attr = I('post.attr');
            $goods_number = I('post.goods_number');
            //计算总的库存量
            $kcdata = M('Product')->where("goods_id=$goods_id")->select();
            if ($kcdata) {
                M('Product')->where("goods_id=$goods_id")->delete();
            }
            $kc = 0;
            foreach ($goods_number as $k => $v) {
                $a = array();
                foreach ($attr as $k1 => $v1) {
                    $a[] = $v1[$k];
                }
                M('Product')->add(
                        array(
                            'goods_id' => $goods_id,
                            'goods_number' => $goods_number,
                            'goods_attr_id' => implode(',', $a)
                        )
                );
                $kc+=$v;
            }
            //要修改的库存量

            $goodsmodel->where("id=$goods_id")->setField('goods_number', $kc);
            $this->success('添加库存完成', U('Goods/lst'));
            exit;
        }
        //把之前的库存显示出来
        $kcdata = M('Product')->where("goods_id=$goods_id")->select();
        $this->assign('kcdata', $kcdata);
        $data = $goodsmodel->getRadio($goods_id);
        $radiodata = array();
        foreach ($data as $v) {
            $radiodata[$v['attr_id']][] = $v;
        }
        $this->assign('goods_id', $goods_id);
        $this->assign('radiodata', $radiodata);
        $this->display();
    }

}

?>