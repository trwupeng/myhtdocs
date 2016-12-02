<?php
namespace Admin\Controller;
use Think\Controller;
class TypeController extends  MyController {
	public function add() {
		if(IS_POST){
		$typemodel=D('Type');
		if($typemodel->create(I("post."),1)){
		if($typemodel->add()){
		$this->success('添加商品成功',U('lst'));
		exit;
		}else{
		$this->error('添加商品失败');
		}
		}else{
		 $this->error($typemodel->getError());
		}
		}
		$this->display();
	}
	public function lst() {
		$typemodel=D('Type');
		$typedata=$typemodel->select();
		$this->assign('typedata',$typedata);
		$this->display();
	}
        public function del(){
            $id=$_GET['id']+0;
            $typemodel=D('Type');
            //$info=$typemodel->select();
            if($typemodel->delete($id)){
                $this->success('删除成功',U('lst'));
            }else{
                $this->error('删除失败',U('lst'));
            }
        }
}

?>