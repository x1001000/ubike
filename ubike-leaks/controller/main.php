<?php
session_start();
if(isset($_REQUEST['eng'])){$_SESSION['eng']=$_REQUEST['eng'];}
if(!isset($_SESSION['eng'])){$_SESSION['eng']=0;}
require_once("controller/db.php");
require_once("libs/Smarty.class.php");
$tpl = new Smarty;
$tpl->template_dir = "templates";
$tpl->compile_dir = "templates_c";
$tpl->cache_dir = "cache";
$tpl->config_dir = "configs";
$tpl->left_delimiter = "<{";
$tpl->right_delimiter = "}>";
$para = explode("/",$_SERVER['SCRIPT_FILENAME']);
$len = count($para)-1;
if(isset($_SESSION['member'])){$tpl->assign("member",$_SESSION['member']);}
$tpl->assign("self",$para[$len]);
$tpl->assign("lan",$_SESSION['eng']);
$curNav = chkNav($para[$len]);
$tpl->assign("curNav",$curNav);
$top_tpl = $tpl->fetch("top.htm");
$footer_tpl = $tpl->fetch("footer.htm");
$tpl->assign("top_tpl",$top_tpl);
$tpl->assign("footer_tpl",$footer_tpl);



function chkNav($url)
{
	$className="";
	if(strpos($url,"#")>-1){$tmp=explode("#",$url);$url=$tmp[0];}
	switch($url)
	{
		case 'about.php':
		$className = "nav1";
		break;
		case 'about02.php':
		$className = "nav1";
		break;
		case 'about03.php':
		$className = "nav1";
		break;
		
		case 'news.php':
		$className = "nav2";
		break;
		case 'detail.php':
		$className = "nav2";
		break;
		
		case 'guide.php':
		$className = "nav3";
		break;
		case 'guide02.php':
		$className = "nav3";
		break;
		case 'guide03.php':
		$className = "nav3";
		break;
		case 'guide04.php':
		$className = "nav3";
		break;
		case 'guide_1.php':
		$className = "nav3";
		break;
		
		case 'info.php':
		$className = "nav4";
		break;
		case 'info02.php':
		$className = "nav4";
		break;
		case 'download.php':
		$className = "nav5";
		break;
		case 'download.php':
		$className = "nav6";
		break;
		case 'member_login01.php':
		$className = "nav7";
		break;
		
	}
	return $className;
}



function getCSPID()
{
	$ch = curl_init();
			//$url = "https://60.249.48.85/Service1.asmx/apiLogin";
			$url = "https://192.168.0.1/Service1.asmx/apiLogin";
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array("userid" => "ryukyu@mid.com.tw","passwd"=>"80408228"));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
			$content=curl_exec($ch);
			
			$a=explode(",",$content);
			$b0=explode(":",$a['0']);	//retcode
			$b1=explode("\"",$a['1']);	//token
			$c0=substr($b0['1'],1,strlen($b0['1'])-2);
			$c1=$b1['3'];
			$_SESSION['cpsid']=$c1;
			
}

function getCPSAPI($api,$para)
{
		if(!$_SESSION['cpsid']){getCSPID();}
		$ch = curl_init();
		//$url = "https://60.249.48.85/Service1.asmx/".$api;
		$url = "https://192.168.0.1/Service1.asmx/".$api;
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array("sid" => $_SESSION['cpsid'],"data"=>$para));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content=curl_exec($ch);
		return $content;
}




//站點資訊
function getStation()
{
			$data = array();
			//$cmd = array();
			
			//echo $content2;
			$content2 = getCPSAPI("sparaGet","[{\"vtyp\":'1'}]");
			
			$d=explode("\"iid\":",$content2);
			$w=1;
			$content="'0',";
			while($d[$w]!=''){
				${"e".$w}=explode(",",$d[$w]);
				for($q=4;$q<=30;$q++){
					${"f".$w.$q}=explode(":",${"e".$w}[$q]);
					if($q!=30){
						${"g".$w.$q}=substr(${"f".$w.$q}['1'],1,(strlen(${"f".$w.$q}['1'])-2));
						if($q=='21'){
							if(${"g".$w.$q}=='1'){
								${"g".$w.$q}="images/map03.png";
							}else{
								${"g".$w.$q}="images/map02.png";
							}
						}
					}else{
						$tail=explode('"',${"f".$w.$q}['1']);
						${"g".$w.$q}=$tail['1'];
						/*echo (${"g".$w.$q});
						echo "<br>";*/
					}
				}
				
			
				$row = array();
				foreach(${"e".$w} as $tmp)
				{
					$tmp = str_replace('"','',$tmp);
					$arr = explode(":",$tmp);
					$k = $arr[0];
					$v = $arr[1];
					//if($k=="sd"){ echo $k.":".$v."<br>";}
					if(($k=="sst")||($k=="scl"))
					{
						if($v!="")
						{
					 		$v = substr($v,0,2).":".substr($v,2,2);
						}
					 }
					
					$row[$k]=$v;
					//echo $k.":".$v."<br>";
					
				}
				$data[]=$row;
				
				
				
				$w++;
			}
			
			$table = "`station`";
			//更新db
			for($i=0;$i<count($data);$i++)
			{
				
				$chk = getNum("select count(*) from $table where `sna`='".$data[$i]['sna']."'");
				$info = array();
				
				$info['sd']=$data[$i]['sd'];
				$info['sno']=$data[$i]['sno'];
				$info['sna']=$data[$i]['sna'];
				$info['sip']=$data[$i]['sip'];
				$info['adr']=$data[$i]['ar'];
				$info['spl']=$data[$i]['snaen'];
				$info['sph']=$data[$i]['sareaen'];
				$info['sst']=$data[$i]['mday'];
				$info['scl']=$data[$i]['aren'];
				$info['tot']=$data[$i]['sbi'];
				$info['sus']=$data[$i]['tot'] - $data[$i]['sbi'];
				$info['lat']=$data[$i]['lat'];
				$info['sarea']=$data[$i]['sarea'];
				$info['lng']=$data[$i]['lng'];
				if($chk==0)
				{
					$cmd[] = addData($table,$info);
					
				}
				else
				{
					
					//$info['fm_id']=$data[$i]['id'];
					$cmd[] = updateData($table,$info,'station');
				}
				
			}
			return $data;
			//return $cmd;
		}
 
 
 
 		
function getSid()
{
		$ch = curl_init();
		//$url = "https://60.249.48.84/api/adminV2/apiLogin";
		$url = "https://192.168.0.3/api/adminV2/apiLogin";
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,false);
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ("userid=ubike_web@ubike.com.tw&passwd=#we%b!@#"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html","Content-length:45")); //43為userid=ubike@program.com.tw&passwd=ubike!@#，這一串的長度，記得改


		$content = curl_exec($ch);
		
		curl_close($ch);

		//echo $content; //回傳值
		
		$a=explode(",",$content);
		$b=explode(":\"",$a['1']);
		$c=explode("\"",$b['1']);
		$sid=$c['0'];
		$_SESSION['sid']=$sid;
		//return $sid;
}

function getAPI($dir,$api,$para,$bak_type='')
{
	getSid();
		$sid = $_SESSION['sid'];
		$ch = curl_init();
		//$url = "https://192.168.0.3/api/cloudV2/memberFind_by_phone";
		//$url = "https://https://60.249.48.84/api/ubikeV2/".$api;
		$url = "https://192.168.0.3/api/".$dir."/".$api;
		
		//api/後面接的adminV2(目錄)/apiLogin(函數)
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER,false);
		curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$para = 'sid='.$sid.'&data='.$para;
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($para));
		
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html","Content-length:".strlen($para))); 
		$bak = curl_exec($ch);
		curl_close($ch);
		//echo $bak;
		//return $bak;
		if($bak_type=='str')
		{
			return $bak;
		}
		else
		{
			$arr = pharsePara($bak);
			return $arr;
		}
}	

		
function pharsePara($str)
{
	$str = str_replace(array("[","]","{","}","\""), array("","","","",""), $str);
	$tmp = explode(",",$str);
	$dat = array();
	foreach($tmp as $item)
	{
		$nn = explode(":",$item);
		$nk = $nn[0];
		$dat[$nk]=$nn[1];
	}
		return $dat;
}

function parseCardCheckRet($str)//cardno_check呼叫返回值處理
{
	$ret = array();
	$n = explode("},{",$str);
	for($i=0;$i<count($n);$i++)
	{
		$arr = explode(",",$n[$i]);
		$arr[0]=str_replace(array('"','{','}','[',']'),array('','','','',''),$arr[0]);
		$arr[1]=str_replace(array('"','{','}','[',']'),array('','','','',''),$arr[1]);
		$a = explode(':',$arr[0]);
		$retCode = $a[1];
		$b = explode(':',$arr[1]);
		$len = count($b)-1;
		$retVal = $b[$len];
		$dat = array("retCode"=>$retCode,"retVal"=>$retVal);
		$ret[]=$dat;
		
	}
	return $ret;
}
?>