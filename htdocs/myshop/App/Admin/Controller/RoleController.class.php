<?php

namespace Admin\Controller;

use Think\Controller;

class RoleController extends MyController {

    //添加角色方法
    public function add() {
        if (IS_POST) {
            $rolemodel = D('Role');
            if ($rolemodel->create()) {
                if ($rolemodel->add()) {
                    $this->success('添加成功', U('lst'));
                } else {
                    $this->error('添加失败');
                }
            } else {
                $this->error($rolemodel->getError());
            }
        }
        //取出权限列表
        $privmodel = D('Privilege');
        $privdata = $privmodel->getTree();
        $this->assign('privdata', $privdata);
        $this->display();
    }

    public function lst() {
        $rolemodel = D('Role');
        $roledata = $rolemodel->field("a.id,a.role_name,group_concat(c.priv_name) priv_list")->join("a left join it_role_privilege b on a.id=b.role_id left join it_privilege c on b.priv_id=c.id")->group("a.id")->select();
        $this->assign('roledata', $roledata);
        $this->display();
    }

    public function del() {
        $id = $_GET['id'] + 0;
        //判断当前是否有管理员
        $info = M('AdminRole')->where("role_id=$id")->find();
        if ($info) {
            $this->error('该角色不能删除');
        }
        $rolemodel = D('Role');
        if ($rolemodel->delete($id) !== false) {
            $this->success('删除成功', U('lst'));
            exit;
        } else {
            $error = $rolemodel->getError();
            if (empty($error)) {
                $error = '删除失败';
            }
            $this->error($error);
        }
    }

}

?>