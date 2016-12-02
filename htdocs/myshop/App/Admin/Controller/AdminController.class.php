<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends MyController{
    public function  add(){
        //添加管理员
        if(IS_POST){
            $adminmodel=D('Admin');
            if($adminmodel->create()){
                $str=  uniqid();
                $salt=  substr($str,-6);
                $password=md5(md5(I('post.password')).$salt);
                //修改create方法建立的数据对象
                $adminmodel->salt=$salt;
                $adminmodel->password=$password;
                if($adminmodel->add()){
                    $this->success('添加成功',U('lst'));
                    exit;
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($adminmodel->getError());
            }
        }
        //取出角色数据
        $rolemodle=D('Role');
        $roledata=$rolemodle->select();
        $this->assign('roledata',$roledata);
        $this->display();
        }
        public function lst(){
            $adminmodel=D('Admin');
            $admindata=$adminmodel->field("a.id,a.admin_name,c.role_name")->join("a left join it_admin_role b on a.id=b.admin_id left join it_role c on c.id=b.role_id ")->select();
            $this->assign('admindata',$admindata);
            $this->display();
        }
        public function del(){
            $admin_id=$_GET['id']+0;
            if($admin_id==1){
                $this->error('页面加载中。。。');
            }
            $adminmodel=D('Admin');
            if($adminmodel->delete($admin_id)!==false){
                $this->success("删除成功");
                exit;
            }else{
                $error=$adminmodel->getError();
                if(empty($error)){
                    $error='删除失败';
                }
                $this->error($error);
            }
        }
            //修改管理员
        public function update(){
            $id = $_GET['id']+0;
            $adminmodel = D('Admin');
            if(IS_POST){
                        if($adminmodel->create()){
                                //开始修改
                                //要判断密码是否提交
                                $password = I('post.password');
                                if(!empty($password)){
                                            //要修改密码
                                            $str = uniqid();
                                            $salt = substr($str,-6);
                                            $password =md5(md5($password).$salt);
                                            //修改create 方法里面建立的数据对象
                                            $adminmodel->salt = $salt;
                                            $adminmodel->password = $password;
                                }else{
                                        //不修改密码  ,去除要修改的密码项
                                        unset($adminmodel->password);
                                }
                                if($adminmodel->save()!==false){
                                            $this->success("修改成功",U('lst'));exit;
                                }else{
                                    $this->error('修改失败');
                                }
                        }else{
                                //修改失败
                                $this->error($adminmodel->getError());
                        }
            }
            //取出要修改的管理员数据 内容
           
            $admininfo = $adminmodel->field("a.*,b.role_id")->join("a left join it_admin_role b  on a.id=b.admin_id")->find($id);
            $this->assign('info',$admininfo);
             //取出角色的数据
            $rolemodel = D('Role');
            $roledata = $rolemodel->select();
            $this->assign('roledata',$roledata);
            $this->display();
        }
}

?>
