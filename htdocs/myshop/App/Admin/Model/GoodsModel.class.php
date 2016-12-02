<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
        //_before_insert该函数是add方法自动调用的，我们自己无需干预
       /* protected  function _before_insert(&$data,$options){
            //执行开始上传
            //取出允许文件大小，保存路径，文件类型
            $rootPath = C('UPLOAD_ROOT_PATH');//C函数是获取配置文件信息的
            $ext = C('UPLOAD_ALLOW_EXT');
            //取出php.ini 里面配置的允许单个上传文件的大小
            $upload_max_filesize = (int)ini_get('upload_max_filesize');
            //取出配置文件里面设置大小
            $upload_file_size = (int)C('UPLOAD_FILE_SIZE');
            $upload_maxfile = min($upload_max_filesize, $upload_file_size);
            $upload = new \Think\Upload();// 实例化上传类    
            $upload->maxSize   =     $upload_maxfile*1024*1024 ;// 设置附件上传大小    
            $upload->exts      =     $ext;// 设置附件上传类型    
            $upload->rootPath  =     $rootPath; // 文件上传保存的根路径
            $upload->savePath  =    'Goods/'; // 文件上传的保存路径（相对于根路径）
            $info   =   $upload->upload();
            if($info){
                //上传成功
                //上传的原图的路径
                $goods_ori = $info['goods_img']['savepath'].$info['goods_img']['savename'];
                //要生成缩略图
                $image = new \Think\Image();
                $image->open($rootPath.$goods_ori);// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
                //给生成的的缩略图命名
                $goods_img = $info['goods_img']['savepath'].'img_'.$info['goods_img']['savename'];
                $goods_thumb = $info['goods_img']['savepath'].'thumb_'.$info['goods_img']['savename'];
               //注意：在生成多张缩略图时，要先生成大图，再生成小图。
                $image->thumb(230, 230,1)->save($rootPath.$goods_img);
                $image->thumb(100, 100,1)->save($rootPath.$goods_thumb);
                //把需要入库的数据给封装到&$data参数里面
                $data['goods_ori']=$goods_ori;
                $data['goods_thumb']=$goods_thumb;
                $data['goods_img']=$goods_img;
            }else{
                $this->error=$upload->getError();//把上传失败的原因赋予error属性
                return false;
            }
            
        }*/

        protected  function _before_insert(&$data,$options){
                if($_FILES['goods_img']['error']==0){
                        $res  = uploadOneImage('goods_img','Goods/',$thumb=array(array(100,100),array(230,230)));
                        if($res['ok']==1){
                                //上传成功
                                $data['goods_ori']=$res['img'][0];
                                $data['goods_thumb']=$res['img'][1];
                                $data['goods_img']=$res['img'][2];
                        }else{
                            //上传失败
                            $this->error= $res['error'];
                            return false;
                        }
                }
               
        }

        protected function _after_insert($data,$options){
           
           
           $goods_id = $data['id'];
           $attr = I('post.attr');//返回属性值内容的一个数组
           if($attr){
                        foreach($attr as $k=>$v){
                            if(is_array($v)){
                                    //是数组
                                    foreach($v as $v1){
                                            //实例化it_goods_attr模型
                                            M("GoodsAttr")->add(array(
                                                'goods_id'=>$goods_id,
                                                'attr_id'=>$k,
                                                'attr_value'=>$v1
                                            ));
                                    }
                            }else{
                                    // 不是数组
                                     M("GoodsAttr")->add(array(
                                                'goods_id'=>$goods_id,
                                                'attr_id'=>$k,
                                                'attr_value'=>$v
                                    ));
                            }
                    }
                }
                if(hasImage('goods_album')){
                    $result = uploadMoreImage('goods_album','Album/',$thumb=array(array(150,150)));
                    //入库，入库it_goods_album数据库
                    if($result['ok']==1){
                            //上传成功，完成入库
                             foreach($result['img'] as $v){
                                    M("GoodsAlbum")->add(array(
                                            'goods_id'=>$goods_id,
                                            'album_ori'=>$v[0],
                                            'album_thumb'=>$v[1]
                                    ));
                            }
                    }
                 }
                
               
           }
            //删除商品的钩子函数
           protected function  _before_delete($data,$options) {
            
         $goods_id=$data['where']['id'];
         //删除缩略图
         $imgs=$this->field("goods_ori,goods_thumb,goods_img")->find($goods_id);
         if(($imgs['goods_ori'])){
             deleteImages($imgs);
         }
         //删除属性的数据
         $attr=M('GoodsAttr')->where("goods_id=$goods_id")->delete();
         //删除相册的数据
         $album_imgs=M('GoodsAlbum')->field("album_ori,album_thumb")->where("goods_id=$goods_id")->select();
         if($album_imgs){
             foreach ($album_imgs as $v){
                 deleteImages($v);
             }
         }
         //把相册的记录删除
         M("GoodsAlbum")->where("goods_id=$goods_id")->delete();
           }
           public function getByGoods($type,$number){
               //$type只接受new hot best
               if($type=='hot'||$type=='new'||$type=='best'){
                   //执行取出数据
                   return $this->where("is_".$type.'=1')->limit($number)->select();
               }
           }
           public function  getRadio($goods_id){
               $sql="select a.*,b.attr_name from it_goods_attr a left join it_attribute b on a.attr_id=b.id where goods_id=$goods_id and attr_id in(select attr_id from it_goods_attr where goods_id=$goods_id group by attr_id having count(*)>1)";
                return $this->query($sql);           
                
           }
}

?>