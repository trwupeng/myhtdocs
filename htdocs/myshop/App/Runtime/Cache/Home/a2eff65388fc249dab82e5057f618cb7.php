<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="Generator" content="YONGDA v1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Keywords" content="YONGDA商城" />
        <meta name="Description" content="YONGDA商城" />
        
        <!--<title>YONGDA商城 - Powered by YongDa</title>-->
         <title>天天购物手机商城 -Powered by WuPeng</title>
        
        <link href="/Public/Home/css/style.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body class="index_body">
            <div class="block clearfix" style="position: relative; height: 98px;">
            <a href="#" name="top"><img class="logo" src="/Public/Home/images/logo.gif"></a>

            <div id="topNav" class="clearfix">
                <div style="float: left;"> 
                    <font id="ECS_MEMBERZONE">
                        <div id="append_parent"></div>
                        欢迎光临本店&nbsp;
                        <?php  if($_SESSION['user_id']){?>
                                     <?php echo $_SESSION['username']?>
                                    <a href="<?php echo U('User/logout')?>">退出</a>
                        <?php }else{?>
                                    <a href="<?php echo U('User/login')?>"> 登录</a>
                                    <a href="<?php echo U('User/register')?>">注册</a>
                        <?php }?>
                    </font>
                </div>
                <div style="float: right;">
                    <a href="#">查看购物车</a>
                    |
                    <a href="#">选购中心</a>
                    |
                    <a href="#">标签云</a>
                    |
                    <a href="#">报价单</a>
                </div>
            </div>
            <div id="mainNav" class="clearfix">
                <a href="/index.php" class="cur">首页<span></span></a>
                <?php foreach($navdata as $v){?>
                <a href="<?php  echo U('Index/category',array('id'=>$v['id']))?>"><?php echo $v['cat_name']?><span></span></a>
                <?php }?>
            </div>
        </div>

        <div class="header_bg">
            <div style="float: left; font-size: 14px; color:white; padding-left: 15px;">
            </div>  

            <form id="searchForm" method="get" action="#">
                <input name="keywords" id="keyword" type="text" />
                <input name="imageField" value=" " class="go" style="cursor: pointer; background: url('/Public/Home/images/sousuo.gif') no-repeat scroll 0% 0% transparent; width: 39px; height: 20px; border: medium none; float: left; margin-right: 15px; vertical-align: middle;" type="submit" />

            </form>
        </div>
        <div class="blank5"></div>
        <div class="header_bg_b">
            <div class="f_l" style="padding-left: 10px;">
                <img src="/Public/Home/images/biao6.gif" />
                    北京市区，现在下单(截至次日00:30已出库)，<b>明天上午(9-14点)</b>送达 <b>免运费火热进行中！</b>
            </div>
            <div class="f_r" style="padding-right: 10px;">
                <img style="vertical-align: middle;" src="/Public/Home/images/biao3.gif">
                    <span class="cart" id="ECS_CARTINFO">
                        <a href="<?php echo U('cart/cartList')?>" title="查看购物车">您的购物车中有 <?php echo $total['total_count'] ?>件商品，总计金额 ￥<?php echo $total['total_price'] ?>元。</a></span>
                    <a href="#"><img style="vertical-align: middle;" src="/Public/Home/images/biao7.gif"></a>

            </div>
        </div>
        <div class="block box">
            <div class="blank"></div>
            <div id="ur_here">
                当前位置: <a href="#">首页</a> <code>&gt;</code> 用户中心 
            </div>
        </div>
        <div class="blank"></div>
        <div class="block box">

        <div class="block clearfix">

            <div class="AreaL">

                <h3><span>商品分类</span></h3> 
                <div id="category_tree" class="box_1">
                <?php foreach($catedata as $v){ if($v['parent_id']==0){ ?>
                    <dl>
                        <dt><a href="<?php  echo U('Index/category',array('id'=>$v['id']))?>"><?php echo $v['cat_name']?></a></dt>
                        <dd>   
                        <?php foreach($catedata as $v1){ if($v1['parent_id']==$v['id']){ ?>
                            <a href="<?php  echo U('Index/category',array('id'=>$v1['id']))?>"><?php echo $v1['cat_name'] ?></a><br/>
                         <?php }}?>
                        </dd>
                    </dl>
                  <?php }}?>  
                </div>
                <div class="blank"></div>
                <div class="box">
                    <h3><span>销售排行榜</span></h3> 
                    <div class="box_1">
                        <div class="top10List clearfix">
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_1.gif" class="iteration">
                                    <li class="topimg">
                                        <a href="#"><img src="/Public/Home/images/3_thumb_G_1241422082679.jpg" alt="" class="samllimg"></a>
                                    </li>

                                    <li class="iteration1">
                                        <a href="#" title="">苹果原装耳机158...</a><br />
                                        本店售价：<font class="f1">￥88元</font><br />
                                    </li>
                            </ul>
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_2.gif" class="iteration">
                                    <li class="topimg">
                                        <a href="#"><img src="/Public/Home/images/17_thumb_G_1241969394587.jpg" alt="" class="samllimg"></a>
                                    </li>

                                    <li class="iteration1">
                                        <a href="#" title="">苹果 6S</a><br />
                                        本店售价：<font class="f1">￥5288元</font><br />
                                    </li>
                            </ul>
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_3.gif" class="iteration">
                                    <li class="topimg">
                                        <a href="#"><img src="/Public/Home/images/9_thumb_G_1241511871555.jpg" alt="" class="samllimg"></a>
                                    </li>

                                    <li class="iteration1">
                                        <a href="#" title="">OPPO R9</a><br />
                                        本店售价：<font class="f1">￥2788元</font><br />
                                    </li>
                            </ul>
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_4.gif" class="iteration">

                                    <li>
                                        <a href="#" title="">VIVO X6PLUS</a><br />
                                        本店售价：<font class="f1">￥2388元</font><br />
                                    </li>
                            </ul>
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_5.gif" class="iteration">

                                    <li>
                                        <a href="#" title="">华为P9</a><br />
                                        本店售价：<font class="f1">￥2988元</font><br />
                                    </li>
                            </ul>
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_6.gif" class="iteration">

                                    <li>
                                        <a href="#" title="">三星Note6</a><br />
                                        本店售价：<font class="f1">￥5588元</font><br />
                                    </li>
                            </ul>
                            <ul class="clearfix">
                                <img src="/Public/Home/images/top_7.gif" class="iteration">

                                    <li>
                                        <a href="#" title="">小米5</a><br />
                                        本店售价：<font class="f1">￥1999元</font><br />
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="blank5"></div><div class="box">  <h3><span>品牌专区</span></h3>
                    <div class="box_1">
                        <div class=" brands clearfix">
                            <a href="#"><img src="/Public/Home/images/1240803062307572427.png" alt="诺基亚 (7)"></a>
                            <a href="#"><img src="/Public/Home/images/1240802922410634065.gif" alt="摩托罗拉 (1)"></a>
                            <a href="#"><img src="/Public/Home/images/1240803144788047486.gif" alt="多普达 (1)"></a>
                             <a href="#"><img src="/Public/Home/images/201641701.gif" alt="华为"></a>
                              <a href="#"><img src="/Public/Home/images/201641702.gif" alt="华为"></a>
                               <a href="#"><img src="/Public/Home/images/201641703.gif" alt="华为"></a>
                                <a href="#"><img src="/Public/Home/images/201641704.gif" alt="华为"></a>
                                <a href="#"><img src="/Public/Home/images/201641705.gif" alt="华为"></a>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <style type="text/css">
*{
	margin: 0px;
	padding: 0px;
}
#focus{
	margin: 0px auto 0px;
	width: 1551px;
	height: 162px;
	overflow: hidden;;
}
#focus ul{
	list-style-type: none;
	overflow: hidden;
	position: relative;
}
#focus li{
	float: left;
}
</style>
<script type="text/javascript">
window.onload=function(){
	var oUl=document.getElementById('focus').getElementsByTagName('ul')[0];
	oUl.innerHTML+=oUl.innerHTML;	//将ul中的内容复制一份
	var aLi=oUl.children;	//所有的li
	oUl.style.width=aLi.length*aLi[0].offsetWidth+'px';	//oUl的宽度

	var left=0;
	var fn=function(){
		id=setInterval(function(){
			left--;
			oUl.style.left=left+'px';
			if(Math.abs(parseInt(oUl.style.left))>oUl.offsetWidth/2){
				left=0;
			}
		},18);
	}
	oUl.onmouseover=function(){
		clearInterval(id)
	}
	oUl.onmouseout=fn;
	fn();
}
</script>
            
            <div class="AreaM">
                <div class="box clearfix">
                    <div id="focus">
                        <ul>
                            <li><img src=" /Public/Home/images/111.jpg" width="515" height="160" alt="" /></li>
                            <li><img src=" /Public/Home/images/222.jpg" width="515" height="160" alt="" /></li>
                            <li><img src=" /Public/Home/images/333.jpg" width="515" height="160" alt="" /></li>
                        </ul>
                    </div>       
                </div>
                <div class="blank"></div>

                <div class="itemTit" id="itemHot">
                    <div class="tit">热卖商品</div>
                    <h2><a href="#" >全部商品</a></h2>
                    <h2 class="h2bg"><a href="#" >3G手机</a></h2>
                    <h2 class="h2bg"><a href="#" >4G手机</a></h2>
                       <h2 class="h2bg"><a href="#" >CDMA手机</a></h2>
                          <h2 class="h2bg"><a href="#" >GSM手机</a></h2>
                             <h2 class="h2bg"><a href="#" >WCDMA手机</a></h2>
                    <!--<h2 class="h2bg"><a href="#" >充值卡</a></h2>
                    <h2 class="h2bg"><a href="#" >小灵通/固话充值卡</a></h2>
                    <h2 class="h2bg"><a href="#" >移动手机充值卡</a></h2>-->
                </div>
                <div id="show_hot_area" class="clearfix">
                <?php foreach($hotdata as $v){?>
                    <div class="goodsItem">
                        <a href="<?php  echo U('Index/detail',array('id'=>$v['id']))?>"><img src="<?php echo C('IMG_SRC').$v['goods_thumb']?>" alt="诺基亚E66" class="goodsimg"></a><br />
                        <p class="f1"><a href="<?php  echo U('Index/detail',array('id'=>$v['id']))?>" title="诺基亚E66"><?php echo $v['goods_name']?></a></p>
                        <font class="market">￥<?php echo $v['shop_price']*1.2;?>元</font><br />
                        <font class="f1">
                            ￥<?php echo $v['shop_price'];?>元                     </font>
                    </div>
               <?php }?>
                </div>
                <div class="blank"></div>

                <div class="itemTit" id="itemBest">

                    <div class="tit">精品推荐</div>
                    <h2><a href="#" >全部商品</a></h2>
                   <h2 class="h2bg"><a href="#" >3G手机</a></h2>
                    <h2 class="h2bg"><a href="#" >4G手机</a></h2>
                       <h2 class="h2bg"><a href="#" >CDMA手机</a></h2>
                          <h2 class="h2bg"><a href="#" >GSM手机</a></h2>
                             <h2 class="h2bg"><a href="#" >WCDMA手机</a></h2>
                </div>
                <div id="show_best_area" class="clearfix">
                    <?php foreach($bestdata as $v){?>
                    <div class="goodsItem">
                        <a href="<?php  echo U('Index/detail',array('id'=>$v['id']))?>"><img src="<?php echo C('IMG_SRC').$v['goods_thumb']?>" alt="诺基亚E66" class="goodsimg"></a><br />
                        <p class="f1"><a href="<?php  echo U('Index/detail',array('id'=>$v['id']))?>" title="诺基亚E66"><?php echo $v['goods_name']?></a></p>
                        <font class="market">￥<?php echo $v['shop_price']*1.2;?>元</font><br />
                        <font class="f1">
                            ￥<?php echo $v['shop_price'];?>元                     </font>
                    </div>
               <?php }?>

                </div>
                <div class="blank"></div>

                <div class="itemTit" id="itemNew">
                    <div class="tit">新品上架</div>
                    <h2><a href="#" >全部商品</a></h2>
                  <h2 class="h2bg"><a href="#" >3G手机</a></h2>
                    <h2 class="h2bg"><a href="#" >4G手机</a></h2>
                       <h2 class="h2bg"><a href="#" >CDMA手机</a></h2>
                          <h2 class="h2bg"><a href="#" >GSM手机</a></h2>
                             <h2 class="h2bg"><a href="#" >WCDMA手机</a></h2>
                </div>
                <div id="show_new_area" class="clearfix">
                    <?php foreach($newdata as $v){?>
                    <div class="goodsItem">
                        <a href="<?php  echo U('Index/detail',array('id'=>$v['id']))?>"><img src="<?php echo C('IMG_SRC').$v['goods_thumb']?>" alt="诺基亚E66" class="goodsimg"></a><br />
                        <p class="f1"><a href="<?php  echo U('Index/detail',array('id'=>$v['id']))?>" title="诺基亚E66"><?php echo $v['goods_name']?></a></p>
                        <font class="market">￥<?php echo $v['shop_price']*1.2;?>元</font><br />
                        <font class="f1">
                            ￥<?php echo $v['shop_price'];?>元                     </font>
                    </div>
               <?php }?>
                </div>
                <div class="blank"></div>

            </div>


            <div class="AreaL" style="float: right;">

                <h3><span>新闻快讯</span></h3> 
                <div class="NewsList tc box_1" style="border-top: medium none;">
                    <ul>
                        <li>
                            <a href="#" title="三星SGHU308说明书下载">iphoneSE市场遇冷,库克表示并不紧张销售</a>
                        </li>
                        <li>
                            <a href="#" title="手机游戏下载">手机游戏下载</a>
                        </li>
                        <li>
                            <a href="#" title="促销诺基亚N96">促销魅族MX5</a>
                        </li>
                        <li>
                            <a href="#" title="诺基亚5320 促销">小米5 节日大促</a>
                        </li>
                        <li>
                            <a href="#" title="3G知识普及">4G知识普及</a>
                        </li>
                        <li>
                            <a href="#" title="诺基亚6681手机广告欣赏">OPPO手机广告欣赏</a>
                        </li>
                        <li>
                            <a href="#" title="飞利浦9@9促销">VIVO促销</a>
                        </li>
                        <li>
                            <a href="#" title="800万像素超强拍照机 LG Viewty Smart再曝光">1300万像素超强拍照机 华为P9...</a>
                        </li>
                    </ul>
                </div>

                <div class="blank"></div>
                <div class="box">  
                    <h3><span>订单查询</span></h3>
                    <div class="box_1">
                        <div class="boxCenterList">
                            <form name="ecsOrderQuery">
                                <input name="order_sn" class="inputBg" type="text" /><br />
                                <div class="blank5"></div>
                                <input value="查询该订单号" class="bnt_blue_2"  type="button" />
                            </form>
                            <div id="ECS_ORDER_QUERY" style="margin-top: 8px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="blank"></div><div class="box">
                    <h3><span>邮件订阅</span></h3>
                    <div class="box_1">

                        <div class="boxCenterList RelaArticle">
                            <input id="user_email" class="inputBg" type="text" /><br />
                            <div class="blank5"></div>
                            <input class="bnt_blue" value="订阅"  type="button" />
                            <input class="bnt_bonus" value="退订"  type="button" />
                        </div>
                    </div>
                </div>
                <div class="blank"></div>
                <div class="box"> 
                    <h3>
                        <span><a href=""></a></span>
                        <a href="">更多</a>
                    </h3>
                    <div class="box_1">

                        <div class="boxCenterList RelaArticle">
                        </div>
                    </div>
                </div>
                <div class="blank5"></div><style type="text/css">
                    .boxCenterList form{display:inline;}
                    .boxCenterList form a{color:#404040; text-decoration:underline;}
                </style>
                <div class="box">  
                    <h3><span>发货查询</span></h3>
                    <div class="box_1">
                        <div class="boxCenterList">
                            订单号 2009061909851<br />
                            发货单 232421   <div class="blank"></div>
                            订单号 2009052224892<br />
                            发货单 1123344   <div class="blank"></div>
                        </div>
                    </div>
                </div>
                <div class="blank"></div>
            </div>
        </div>
        </div>

        <div class="blank"></div>
        <div class="block">
            <a href="#" target="_blank" title="YONGDA商城"><img alt="YONGDA商城" src="/Public/Home/images/di.jpg"></a>
            <div class="blank"></div>
        </div>
        <div class="block">
            <div class="box">
                <div class="helpTitBg" style="clear: both;">
                    <dl>
                        <dt><a href="#" title="新手上路 ">新手上路 </a></dt>
                        <dd><a href="#" title="售后流程">售后流程</a></dd>
                        <dd><a href="#" title="购物流程">购物流程</a></dd>
                        <dd><a href="#" title="订购方式">订购方式</a></dd>
                    </dl>
                    <dl>
                        <dt><a href="#" title="手机常识 ">手机常识 </a></dt>
                        <dd><a href="#" title="如何分辨原装电池">如何分辨原装电池</a></dd>
                        <dd><a href="#" title="如何分辨水货手机 ">如何分辨水货手机</a></dd>
                        <dd><a href="#" title="如何享受全国联保">如何享受全国联保</a></dd>
                    </dl>
                    <dl>
                        <dt><a href="#" title="配送与支付 ">配送与支付 </a></dt>
                        <dd><a href="#" title="货到付款区域">货到付款区域</a></dd>
                        <dd><a href="#" title="配送支付智能查询 ">配送支付智能查询</a></dd>
                        <dd><a href="#" title="支付方式说明">支付方式说明</a></dd>
                    </dl>
                    <dl>
                        <dt><a href="#" title="会员中心">会员中心</a></dt>
                        <dd><a href="#" title="资金管理">资金管理</a></dd>
                        <dd><a href="#" title="我的收藏">我的收藏</a></dd>
                        <dd><a href="#" title="我的订单">我的订单</a></dd>
                    </dl>
                    <dl>
                        <dt><a href="#" title="服务保证 ">服务保证 </a></dt>
                        <dd><a href="#" title="退换货原则">退换货原则</a></dd>
                        <dd><a href="#" title="售后服务保证 ">售后服务保证</a></dd>
                        <dd><a href="#" title="产品质量保证 ">产品质量保证</a></dd>
                    </dl>
                    <dl>
                        <dt><a href="#" title="联系我们 ">联系我们 </a></dt>
                        <dd><a href="#" title="网站故障报告">网站故障报告</a></dd>
                        <dd><a href="#" title="选机咨询 ">选机咨询</a></dd>
                        <dd><a href="#" title="投诉与建议 ">投诉与建议</a></dd>
                    </dl>
                </div>
            </div>


        </div>
        <div class="blank"></div>
        <div id="bottomNav" class="box block">
            <div class="box_1">
                <div class="links clearfix"> 
                    <a href="#" target="_blank" title="YONGDA商城"><img src="/Public/Home/images/ecmoban_link.jpg" alt="YONGDA商城" border="0"></a>

                    <a href="#" target="_blank" title="YONGDA 网上商店管理系统">
                        <img src="/Public/Home/images/yongda_logo.gif" alt="YONGDA 网上商店管理系统" border="0" />
                    </a>


                    [<a href="#" target="_blank" title="免费申请网店">免费申请网店</a>]
                    [<a href="#" target="_blank" title="免费开独立网店">免费开独立网店</a>]


                    [<a href="#" target="_blank" title="免费开独立网店">yongda商城</a>]
                </div>
            </div>
        </div>
        <div class="blank"></div>
        <div id="bottomNav" class="box block">
            <div class="bNavList clearfix">
                <a href="#">免责条款</a>
                |
                <a href="#">隐私保护</a>
                |
                <a href="#">咨询热点</a>
                |
                <a href="#">联系我们</a>
                |
                <a href="#">Powered&nbsp;by&nbsp;<strong><span style="color: rgb(51, 102, 255);">YongDa</span></strong></a>
                |
                <a href="#">批发方案</a>
                |
                <a href="#">配送方式</a>

            </div>
        </div>

        <div id="footer">
            <div class="text">
                © 2005-2016 YONGDA 版权所有，并保留所有权利。<br />
            </div>
        </div>
    </body>
</html>