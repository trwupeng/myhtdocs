<!-- <html> -->
<!-- <body> -->
<!-- <a href="./dz/upload/forum.php">我的论坛</a> -->
<!-- </body> -->
<!-- </html> -->
<?php 
$request=$_SERVER;
$url=$request['HTTP_HOST'];
if($url=="bxu2359170698.my3w.com" || $url=="bbs.trwupeng.com"){
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=./dz/upload/forum.php">';
}elseif($url=="www.1212shopping" ||$url=="1212shopping.com"){
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=./myshop">';
}elseif($url=="www.trwupeng.com" ||$url=="trwupeng.com"){
    echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=./kaifa/demo/index.html">';
}
//echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=./dz/upload/forum.php">';
?>