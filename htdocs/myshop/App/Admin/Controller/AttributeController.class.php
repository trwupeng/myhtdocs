<?php
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends  MyController{
    //添加属性
    public function add(){
        if(IS_POST){
                $attrmodel = D('Attribute');
                //接收传递的商品类型的 id
                $type_id = I("post.type_id");
                if($attrmodel->create()){
                    if($attrmodel->add()){
                        //添加属性成功
                        $this->success("添加属性成功",U('lst',array('type_id'=>$type_id)));
                        exit;
                    }else{
                        $this->error('添加失败');
                    }
                }else{
                    //$attrmodel->getError()方法是获取验证失败后的错误提示
                    $this->error($attrmodel->getError());
                }
        }
        //取出商品的类型
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('typedata',$typedata);
        $this->display();
    }
    //属性列表页面
    public function lst(){
        //接收表单提交的type_id的值
        $type_id = $_GET['type_id']+0;
        if($type_id==0){
                $where=1;
        }else{
              //$where['type_id']=array('eq',$type_id);
          $where="type_id=$type_id";
        }
        //取出商品，类型
        $typemodel = D('Type');
        $typedata = $typemodel->select();
        $this->assign('typedata',$typedata);
        $attrmodel = D('Attribute');
        //计算总的记录数
        $count      = $attrmodel->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(2)
        //格式化输出页
		
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);
		
        $attrdata =  $attrmodel->field("a.*,b.type_name")->join("a left join it_type b on a.type_id=b.id")->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('type_id',$type_id);
        $this->assign('attrdata',$attrdata);
//		print_r($Page);
//		exit;
        $this->display();
    }
    public function del(){
        $id=$_GET['id']+0;
        $attrmodel=D('Attribute');
        if($attrmodel->delete($id)){
           $this->success('删除成功',U('lst'));
        }else{
           $this->error('删除失败',U('lst'));
        }
    }
}
?>