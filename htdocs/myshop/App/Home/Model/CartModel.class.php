<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model{
    //添加商品到购物车
    //参数1：商品的id
    //参数2：属性的id,是一个字符串，也就是it_goods_attr表里面的id,多个用逗号隔开。
    //参数3：是购买数量
    public function addCart($goods_id,$goods_attr_id,$goods_count){
            //判断用户是否登录，
            $user_id = $_SESSION['user_id'];
            if($user_id>0){
                    //已经登录，入库操作
                    //判断该商品是否已经加入到购物车，如果已经加入则，修改数量，如果没有加入则添加商品
                    $info = $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->select();
                    if($info){
                            //已经存在，则修改数量
                            $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->setInc('goods_count',$goods_count);
                    }else{
                            //不存在，则添加
                            $this->add(array(
                                'goods_id'=>$goods_id,
                                'goods_attr_id'=>$goods_attr_id,
                                'goods_count'=>$goods_count,
                                'user_id'=>$user_id
                            ));
                    }
            }else{
                //没有登录，入cookie操作。
                $cartdata = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
                //判断是否已经添加
                //构造键
                $key = $goods_id.'-'.$goods_attr_id;
                if(isset($cartdata[$key])){
                        //已经存在，则修改购买数量
                        $cartdata[$key]=$cartdata[$key]+$goods_count;
                }else{
                        $cartdata[$key]=$goods_count;
                }
                //完成后，要重新存储到cookie里面
                setcookie('cart',serialize($cartdata),time()+3600*24*7,'/');
            }
    }
    //购物车列表的一个方法
    public function CartList(){
            //查看用户是否登录，如果登录则从数据库里面获取 ，如果没有登录则从cookie里面获取
            $user_id = $_SESSION['user_id'];
            if($user_id>0){
                    //已经登录，直接从数据库里面获取
                    $cartdata = $this->where("user_id=$user_id")->select();//获取购物车里面的数据
                    //返回 的数据是二维数组
            }else{
                    //没有登录，从cookie里面获取数据
                     $cart = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
                     //返回是一维数组，为了便于显示，需哟把一维数组转换成二维数组
                     /*
                     $arr=array(
                        ‘1-5,7’=>12,
                        ‘4-47,48’=>8
                    )
                     */
                     $cartdata = array();
                     foreach($cart as $k=>$v ){
                         $a = explode('-',$k);
                         $cartdata[]=array(
                                'goods_id'=>$a[0],
                                'goods_attr_id'=>$a[1],
                                'goods_count'=>$v
                         );   
                     }

            }
            //拿到一个二维数组,当前的二维数据，是不能直接遍历的，原因是没有商品的信息，和属性信息。
            //重新组装数组，添加商品的基本信息，属性信息，
            $list=array();
            foreach($cartdata as $k=>$v){
                    $v['info']=M('Goods')->field("goods_name,goods_thumb,shop_price")->find($v['goods_id']);
                    $v['attrs']=$this->getAttrs($v['goods_attr_id']);
                    $list[]=$v;
                    
            }
            return $list;

    }
    //参数就是： $goods_attr_id  
    public function getAttrs($goods_attr_id){
                if(empty($goods_attr_id)){
                        //如果传递的值为空，则说明没有属性，则直接返回空字符串
                        return '';
                }
                $sql="select group_concat(concat(b.attr_name,':',a.attr_value)  separator '<br/>')attrs  from it_goods_attr a left join it_attribute b on a.attr_id = b.id where a.id in($goods_attr_id)";
               $data = M()->query($sql);
               return $data[0]['attrs'];
    }
    //取出购买数量以及金额
    public function getCartTotal(){
            //取出购物车里面的商品，如果有商品我们才需要计算
            $cartdata = $this->cartList();//返回购物车里面的商品数量
            $total_count=0;//定义一个变量用于存储总的购买数量
            $total_price = 0;//定义一个变量用于存储总的的金额
            if(!empty($cartdata)){
                    //需要计算
                    foreach($cartdata as $v){
                            $total_count+=$v['goods_count'];
                            $total_price +=$v['info']['shop_price']*$v['goods_count'];
                    }
            }
            return array('total_count'=>$total_count,'total_price'=>$total_price);
    }
    //从cookie移动到数据库
    public function cookie2db(){
            //取出cookie里面的数据
             $cartdata = isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
             //如果cookie里面有数据才移动
             if($cartdata){
                  $user_id = $_SESSION['user_id'];
                    //开始移动
                   foreach($cartdata as $k=>$v){
                            $a = explode('-',$k);
                            $goods_id = $a[0];
                            $goods_attr_id = $a[1];
                            //要判断数据库里面是否存在该商品，如果存在则修改购买数量，如果不存储则添加
                             $info = $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->select();//查询是否存在，
                             if($info){
                                    //修改数量
                                    $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->setInc('goods_count',$v);
                             }else{
                                    //添加新的数据
                                    $this->add(array(
                                            'goods_id'=>$goods_id,
                                            'goods_attr_id'=>$goods_attr_id,
                                            'goods_count'=>$v,
                                            'user_id'=>$user_id
                                    ));
                             }
                   }
                   //要清除cookie
                   setcookie('cart','',time()-1,'/');
             }
        
    }
    public function updateCart($goods_id,$goods_attr_id,$goods_count){
        //判断用户是否登录，已经登录，修改数据库，没有登录，修改cookie
        $user_id=$_SESSION['user_id'];
        if($user_id>0){
            $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->setInc('goods_count',$goods_count);
        }else{
            //没有登录
            $cartdata= isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
            $key=$goods_id.'-'.$goods_attr_id;
            $cartdata[$key]=$cartdata[$key]+$goods_count;
            setcookie('cart',  serialize($cartdata),time()+3600*24*7,'/');
        }
    }
    public function  delCart($goods_id,$goods_attr_id){
        //判断是否登录，登陆从数据删，没有登陆，cookie删
        $user_id=$_SESSION['user_id'];
        if($user_id>0){
            //已经登陆
            $this->where("goods_id=$goods_id and goods_attr_id='$goods_attr_id' and user_id=$user_id")->delete();
            
        }else{
            //没有登录
            $cartdata= isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
            $key=$goods_id.'-'.$goods_attr_id;
            unset($cartdata[$key]);
            setcookie('cart',$cartdata,time()+3600*24*7,'/');
        }    
    }
    public function clearCart(){
        //判断是否登录
        $user_id=$_SESSION['user_id'];
        if($user_id>0){
            //删除数据库数据
            $this->where("user_id=$user_id")->delete();
        }else{
            //清空cookie
            setcookie('cart','',time()-1,'/');
        }
    }
}

?>