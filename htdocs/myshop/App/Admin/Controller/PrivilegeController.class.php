<?php

namespace Admin\Controller;

use Think\Controller;

class PrivilegeController extends MyController {

    public function add() {
        $privmodel = D('Privilege');
        if (IS_POST) {
            if ($privmodel->create()) {
                if ($privmodel->add()) {
                    $this->success('添加成功', U('lst'));
                    exit;
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($privmodel->getError());
            }
        }
        $privdata = $privmodel->getTree();
        $this->assign('privdata', $privdata);
        $this->display();
    }

    public function lst() {
        $privmodel = D('Privilege');
        $privdata = $privmodel->getTree();
        $this->assign('privdata', $privdata);
        $this->display();
    }

    public function del() {
        $priv_id = $_GET['id'] + 0;
        $privmodel = D('Privilege');
        if ($privmodel->delete($priv_id)) {
            $this->success('删除成功', U('lst'));
        } else {
            $this->error('删除失败');
        }
    }

}

?>