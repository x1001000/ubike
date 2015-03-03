<?php
require_once('inc/main.php');
$table = "`ad_account`";
$data = array();
$filter="";
if(isset($_POST['fm_action'])&&$_POST['fm_action']!=""){$action = $_POST['fm_action'];} 
if(isset($_POST['action'])&&$_POST['action']!=""){$action = $_POST['action'];}


if($action=="add")
{	
	$user = array();
	$user['account']=trim($_POST['account']);
	$user['user_name']=trim($_POST['user_name']);
	$user['password']=trim($_POST['password']);
	$user['status']=trim($_POST['status']);
	$user['islost']=trim($_POST['islost']);
	$user_id=addData($table,$user);
	
}
else if($action=="edit")
{
	$user = array();
	$user['account']=trim($_POST['account']);
	$user['user_name']=trim($_POST['user_name']);
	$user['password']=trim($_POST['password']);
	$user['status']=trim($_POST['status']);
	$user['islost']=$_POST['islost'];
	$user['fm_id']=$_POST['fm_id'];
	updateData($table,$user);
	
			
}
else if($action=="del")
{
	$cmd = qry("delete from $table where `id`='".$_POST['id']."'");
}
$data = getData("select * from $table".$filter." order by `id` desc".$limit);
for($i=0;$i<count($data);$i++){$data[$i]['pid']=$pstart+($i+1);}
$pageSize = 30;
for($p=0;$p<count($data);$p++){ $str="";for($j=0;$j<strlen($data[$p]['password']);$j++){$str.="*";}$data[$p]['pwdstr']=$str;}
$totalRows = getNum("select count(*) from ".$table.$filter);
$totalPage = ceil($totalRows/$pageSize);
$pages=array();
for($p=1;$p<=$totalPage;$p++){ $pages[]=$p;}
$ad->assign("titlename","系統帳號管理");
$ad->assign("totalRows",$totalRows);
$ad->assign("data",$data);
$ad->assign("totalPage",$totalPage);
$ad->assign("pages",$pages);
$ad->assign("page",$page);
$ad->display("index.htm");	

?>
