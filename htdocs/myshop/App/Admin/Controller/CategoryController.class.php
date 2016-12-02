<?php
namespace Admin\Controller;
use Think\Controller;
class CategoryController extends  MyController {
	public function add() {
		$catemodel=D('Category');
		if(IS_POST){
		if($catemodel->create()){
		if($catemodel->add()){
		$this->success('添加栏目成功',U('lst'));
		exit;
		}else{
		$this->error('添加栏目失败');
		}
		}
		else{
		$this->error($catemodel->getError());
		}
		}
		//添加栏目
		$catedata=$catemodel->getTree();
		$this->assign('catedata',$catedata);
		$this->display();
		
	}
	public function lst() {
		//栏目列表页面
		$catemodel=D('Category');
		$catedata=$catemodel->getTree();
		$this->assign('catedata',$catedata);
		$this->display();
	}
	public function del() {
		$id=$_GET['id']+0;
		$catemodel=D('Category');
		//如果有子栏目不能删除
		$info=$catemodel->where("parent_id=$id")->select();
		if($info){
		$this->error('不能删除有子栏目的栏目');
		}
		if($catemodel->delete($id)){
		$this->success('删除成功',U('lst'));
		}
		else{
		$this->success('删除失败',U('lst'));
		}
	}
	public function update() {
		$id=$_GET['id']+0;
		$catemodel=D('Category');
		//find返回一维数组
		$info=$catemodel->find($id);
		if(IS_POST){
		if($catemodel->create()){
			//判断提交的父id是否在自己和自己的子栏目中
			$id=I('post.id')+0;
            //取出要修改的栏目数据
		$ids=$catemodel->getChild($id);
		//把自己的id添加到子栏目id中
		$ids[]=$id;
		if(in_array($parent_id,$ids)){
		$this->error('不能把自己和自己的子孙栏目当做父级');
		}
		if($catemodel->save()!==false){
		$this->success('修改成功',U('lst'));
		exit;
		}else{
		$this->error('修改失败');
		}
		}else{
		$this->error($catemodel->getError());
		}
		}
		$this->assign('ids',$ids);
		$this->assign('info',$info);
		$catedata=$catemodel->getTree();
		$this->assign('catedata',$catedata);
		$this->display();
	}
        //定义一个方法取出导航信息
       
}

?>