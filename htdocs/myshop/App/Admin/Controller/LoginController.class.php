<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {

    public function login() {
        if (IS_POST) {

            $adminmodel = D('Admin');

            if ($adminmodel->validate($adminmodel->_login_validate)->create()) {
                if ($adminmodel->login()) {
                    $this->success('登陆成功', U('Index/index'));
                    exit;
                }
            }
            $this->error($adminmodel->getError());
        }
        $this->display();
    }

    public function autoCode() {
        $config = array(
            'fontSize' => 16,
            'imageW' => 145,
            'imageH' => 28,
            'length' => 4,
            'useNoise' => false,
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

}

?>
