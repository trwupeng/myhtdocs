<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends MyController{
	public function index() {
		$this->display();
	}
	public function top() {
		$this->display();
	}
	public function drag() {
		$this->display();
	}
	public function left() {
            $model=D('Admin');
            $data=$model->getButtons();
            $this->assign('data',$data);
		$this->display();
	}
	public function main() {
		$this->display();
	}
}
