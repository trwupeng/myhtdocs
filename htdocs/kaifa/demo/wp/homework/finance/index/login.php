<?php
$echo=$_REQUEST;
print_r($echo);
$phone=$_REQUEST['phone'];
$pwd=$_REQUEST['pwd'];
echo $phone.'</br>';
echo $pwd;
if(!empty($_REQUEST['phone'])&&!empty($_REQUEST['pwd'])){
	if($_REQUEST['phone']=='13916697284' && $_REQUEST['pwd']=='123456'){
		return 0;
		}
	}
?>