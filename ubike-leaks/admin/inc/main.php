<?php
session_start();
require_once("../controller/db.php");
require_once("libs/Smarty.class.php");
$ad = new Smarty;
$ad->template_dir = "templates";
$ad->compile_dir = "templates_c";
$ad->cache_dir = "cache";
$ad->config_dir = "configs";
$ad->left_delimiter = "<{";
$ad->right_delimiter = "}>";
$ad->assign("admin_account",$_SESSION['admin']['account']);
$ad->assign("admin_islost",$_SESSION['admin']['islost']);
$down = $ad->fetch("down.php");
$top = $ad->fetch("top.php");
$AuthIcon = $ad->fetch("AuthIcon.php");
$ad->assign("top",$top);
$ad->assign("down",$down);
$ad->assign("AuthIcon",$AuthIcon);



if(!$_SESSION['admin'])
{
	$URL = explode("/",$_SERVER['REQUEST_URI']);
	$len = count($URL)-1;
	if($URL[$len]!="login.php"){ redirectURL('login.php');}
}




 
 
 function LogoutSys()
 {
	foreach($_SESSION as $k => $v)
	{
		unset($_SESSION[$k]);	
	}
 }
 
?>