<?php
//防止攻击的方法
function removeXss($val){
    static $obj=null;
    if($obj===null){
        require './HTMLPurifier/HTMLPurifier.includes.php';
        $obj  = new HTMLPurifier();
    }
    return $obj->purify($val);
}
//定义单个文件上传的函数function
//参数1：上传文件文件域的名称
//参数2：保存上传文件的目录
//参数3：生成缩略图的大小和数量
//返回值是：返回是二维数组,上传图片的路径,以及生成缩略图的路径
function uploadOneImage($imageName,$saveDir,$thumb=array()) {
	$rootPath=C('UPLOAD_ROOT_PATH');//C函数是获取配置文件信息
	$ext=C('UPLOAD_ALLOW_EXT');//配置文件定义上传文件的扩展
        //取出php.ini里面配置允许单个上传文件的大小
	$upload_max_filesize=(int)ini_get('upload_max_filesize');
        //取出配置文件里面设置的大小
	$upload_file_size=(int)C('UPLOAD_FILE_SIZE');
        //取出两者的最小值
	$upload_maxfile=min($upload_max_filesize,$upload_file_size);
	$upload=new \Think\Upload();
	$upload->maxSize=$upload_maxfile*1024*1024;//设置附件上传的大小
	$upload->exts=$ext;//设置附件上传的类型
	$upload->rootPath=$rootPath;//文件上传保存的根路径
	$upload->savePath=$saveDir;//文件上传的保存的路径
	$info=$upload->upload();
	if($info){
            //上传成功，上传的原图的路径
	$img[0]=$info[$imageName]['savepath'].$info[$imageName]['savename'];
	//判断是否生成缩略图
        if($thumb){
            //要生成缩略图
	$image=new \Think\Image();
        //因为返回的是数组，要遍历生成
	foreach($thumb as $k=>$v){
	$image->open($rootPath.$img[0]);
        //定义生成缩略图的地址
	$addr=$info[$imageName]['savepath'].'thumb_'.$k.$info[$imageName]['savename'];
	$image->thumb($v[0],$v[1])->save($rootPath.$addr);//保存生成缩略图的
	$img[]=$addr;//把生成的缩略图的地址存储到数组里面
	}
	}
        //返回的数组
	return array(
	'ok'=>1,
	'img'=>$img	
	);
	}else{
	return array(
	'ok'=>0,
	'error'=>$upload->getError()	
	);
	}
}
//完成多文件上传
//参数1:上传文件域的名称
//参数2：相册存储的位置，相对于根目录
//参数3：生成缩略图的个数以及大小。
function uploadMoreImage($imageName,$saveDir,$thumb=array()){
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
            $upload->savePath  =    $saveDir.'/'; // 文件上传的保存路径（相对于根路径）
            $info   =   $upload->upload(array($imageName=>$_FILES[$imageName]));
           if($info){
                //上传成功
                $img =array();//定义一个数组，用于存储返回的数据路径
                foreach($info as $k=>$v){
                        $singleimg=array();//定义一个数组，用于存储每张图片原图地址，以及缩略图的地址
                        //存储原图的路径
                        $singleimg[0]= $v['savepath'].$v['savename'];
                        //要判断是否要生成缩略图
                        if($thumb){
                             $image = new \Think\Image();
                                foreach($thumb as $k1=>$v1){
                                        //开始生成缩略图了
                                         $image->open($rootPath.$singleimg[0]);
                                         //定义缩略图的地址
                                          $a = $v['savepath'].'thumb_'.$k1.$v['savename'];
                                          $image->thumb($v1[0], $v1[1])->save($rootPath.$a);
                                          $singleimg[]=$a;
                                }
                        }
                        $img[] = $singleimg;
                }
                return array(
                    'ok'=>1,
                    'img'=>$img
                );

           }else{
                return array(
                        'ok'=>0,
                        'error'=>$upload->getError()
                );
           }
}
function hasImage($imageName){
        $imgs = $_FILES[$imageName]['error'];//返回的是一个数组
        foreach($imgs as $v){
                if($v==0){
                        return true;
                }
        }   
}
 function deleteImages($imgs){
            $rootPath=C('UPLOAD_ROOT_PATH');
            foreach($imgs as $v){
                @unlink($rootPath.$v);
            }
        }
        function sendEmail($address,$title,$content){
            require './PHPMailer/class.phpmailer.php';
                        $mail             = new PHPMailer();
                        /*服务器相关信息*/
                        $mail->IsSMTP();                        //设置使用SMTP服务器发送
                        $mail->SMTPAuth   = true;               //开启SMTP认证
                        $mail->Host       = 'smtp.163.com';   	    //设置 SMTP 服务器,自己注册邮箱服务器地址
                        $mail->Username   = '15656189809';  		//发信人的邮箱用户名
                        $mail->Password   = 'oewgwnaoimwiitws';          //发信人的邮箱密码
                        /*内容信息*/
                        $mail->IsHTML(true); 			         //指定邮件内容格式为：html
                        $mail->CharSet    ="UTF-8";			     //编码
                        $mail->From       = '15656189809@163.com';	 		 //发件人完整的邮箱名称
                        $mail->FromName   ="中国商城营销部";			 //发信人署名
                        $mail->Subject    =$title;  			 //信的标题
                        $mail->MsgHTML($content);  				 //发信主体内容
                        //$mail->AddAttachment("shuiguo.jpg");	     //附件
                        /*发送邮件*/
                        $mail->AddAddress($address);  			 //收件人地址
                        //使用send函数进行发送
                        if($mail->Send()) {
                          return true;
                        } else {
                           return false;
                        } 
        }
?>