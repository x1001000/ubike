<?php require_once('controller/main.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41591387-1', 'youbike.com.tw');
  ga('send', 'pageview');

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>歡迎光臨Youbike</title>
<link href="css/home.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript">
		$(document).ready(function() {
			
			$(".various3").fancybox({
				'width'				: '80%',
				'height'			: '90%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			
		});
	</script>
</head>
<script>
$(document).ready(function(){
	
	
		$(document).bind("contextmenu",function(e){
		return false;
		});
		document.ondragstart=addInterdict
		document.oncontextmenu=addInterdict;
		document.onkeydown=DisableKeys;
	   
		var nodes = $("input,textarea");
	   
		for (var i=0,L=nodes.length; i<L; i++)  
		{
			var node = nodes[i];
			node.onmouseover = function()
			{
				document.onkeydown=AbleKeys;
			}
			node.onmouseout = function()
			{
				document.onkeydown=DisableKeys;
			}
		}  
	$("body").addClass("bodyclass");

	
	});
</script>
<body>
<div id="WRAPPER">
<?php
$top = $tpl->fetch("top.htm");
echo $top;
$sapoint = "";
if($_POST['sapoint']!=""){$sapoint=$_POST['sapoint'];}
?>
<div id="MAIN">
<div id="INFO_MAP">
  <div class="result1020">
	<?php 
		if($_SESSION['eng']!="1"){
	?>
	<table id="top1020" name="top1020">
		<tr><td  colspan="2" align="center"><font size="5">臺北市公共自行車租賃系統</font></td></tr>
		<tr><td colspan="2"  align="center"><font size="5">失物招領作業</font></td></tr>
		<tr><td align="right" valign="top">一、</td><td>本作業悉依「臺北市公共自行車租賃系統YouBike服務條款」 4.使用服務及騎乘注意事項之規定管理之。</td></tr>
		<tr><td align="right" valign="top">二、</td><td>消費者於微笑單車車輛、場站內拾得遺失物，可送交警方或微笑單車任一服務中心，由服務人員點驗處理並定時公告官網供查詢。</td></tr>
		<tr><td align="right" valign="top">三、</td><td>消費者遺失物品時，可親臨、電洽、傳送電子郵件或官網查詢。確認遺失物後，可至指定服務中心填寫遺失物登記表領回物品。</td></tr>
		<tr><td align="right" valign="top">四、</td><td>依民法規定，遺失物品經公告招領六個月後仍無人認領時，由拾得人取得所有權或由營運單位代為處理之(拾獲人需於Youbike遺失物登記表(拾獲聯)勾選須通知領回)</td></tr>
	</table>
	<?php }else{?>
	<table>
		<tr> <td colspan="2" align="center"> <font size="5"> Taipei public bicycle rental system </font> </td> </tr>
		<tr> <td colspan="2" align="center"> <font size="5"> Lost jobs </font> </td> </tr>
		<tr> <td align="right" valign="top"> one、 </td> <td> learned the job by "Taipei City public bicycle rental system YouBike Terms of Service" 4. use of services and riding Precautions requirements management. </td> </tr>
		<tr> <td align="right" valign="top"> two、 </td> <td> consumers on bicycles smiling vehicles, field station Lost Property, may be sent to either the police or the smile bicycle service center, by service personnel inventory and future treatment and regularly announcement official website for the query. </td> </tr>
		<tr> <td align="right" valign="top"> three、 </td> <td> consumers lost items, you can visit, call, send an email or official website. Lost confirmation, you can fill out to the designated service center registration form to reclaim lost property items. </td> </tr>
		<tr> <td align="right" valign="top"> four、 </td> <td> according to civil law, the missing items after announcement claiming unclaimed after six months, by the finders obtain ownership or operating units to act on behalf of (people need to Youbike Found Lost registration Form (Found Union) check shall notify reclaim) </td> </tr>
	</table>
	<?php }?>
	<br><br>
    <p>
    
     <?php 	
	 

		$tmp = getData("select title from `lost_category` where eng='{$_SESSION['eng']}'order by title");
		for($a=0;$a<count($tmp);$a++)
	        { 
				if($a>0){ echo " / ";}
				if($sapoint==$tmp[$a]['title'])
				{
					echo '<a href="#" class="area">'.$tmp[$a]['title'].'</a>';
				}
				else
				{
					echo '<a href="#" onclick="srhArea(\''.$tmp[$a]['title'].'\')">'.$tmp[$a]['title'].'</a>';
				}
			}
			 echo " / ";
			 if($sapoint=="")
			 {
			 	if($_SESSION['eng']==1)
				{
			 		echo '<a href="#" class="area">ALL</a>';
				}
				else
				{
					echo '<a href="#" class="area">顯示全部</a>';
				}
			 }
			 else
			 {
			 	if($_SESSION['eng']==1)
				{
					echo '<a href="#" onclick="srhArea(\'\')">ALL</a>';
				}
				else
				{
			 		echo '<a href="#" onclick="srhArea(\'\')">顯示全部</a>';
				}
			 }
	?>
    </p>
  </div>
		

 <?php 
 
	if($sapoint!=""){
		$searchstr=" and  a.title='".$sapoint."'";
	}
	if($_SESSION['eng']==1){
		$searchstr.=" and a.eng='{$_SESSION['eng']}'";
	}else{
		$searchstr.=" and a.eng='{$_SESSION['eng']}'";
	}
	$str="select a.title as at,color,getarea,getdate,number from `lost_category` a left join `lost` b on a.id=b.cat_id where 1=1 {$searchstr} order by at,number,getdate";
	$all= getData($str);
	$dst="";
	$i=0;
	for($d=0;$d<count($all);$d++){ 
		if(strpos($dst,$all[$d]['at'].",")===false){
			$alldata[$all[$d]['at']][0][0]=$all[$d]['color'];
			$alldata[$all[$d]['at']][0][1]=$all[$d]['getdate'];
			$alldata[$all[$d]['at']][0][2]=$all[$d]['getarea'];
			$alldata[$all[$d]['at']][0][3]=$all[$d]['number'];
			$dst.="".$all[$d]['at'].",";
			$i=1;
		}else{
			$alldata[$all[$d]['at']][$i][0]=$all[$d]['color'];
			$alldata[$all[$d]['at']][$i][1]=$all[$d]['getdate'];
			$alldata[$all[$d]['at']][$i][2]=$all[$d]['getarea'];
			$alldata[$all[$d]['at']][$i][3]=$all[$d]['number'];
			$i++;
		}
	}
	$adst=explode(",",$dst);
	for($d=0;$d < count($alldata);$d++){
	?>
				
		<div id="AREA">
  <div id="top"><a href="#top1020">TOP</a></div>
  <div id="area1020"><img src="images/banban.png" width="49" height="50" />
  <?php
  $len = strlen($adst[$d]);
  for($t=0;$t<$len;$t++)
  {
  	if($t>0){echo "<br>";}
	echo mb_substr($adst[$d],$t,1,"utf-8");
  }
  ?>
  </div>
  <table width="645" border="0" cellspacing="0" cellpadding="0" class="area01" >
  <tr align="center">
    <td class="blue01">&nbsp;</td>
    <td class="grey04"><?php if($_SESSION['eng']==1){echo "Number";}else{ echo "編號";}?></td>
    <td class="grey05"><?php if($_SESSION['eng']==1){echo "Lost Property Color";}else{ echo "遺失物品顏色";}?></td>
    <td class="grey02"><?php if($_SESSION['eng']==1){ echo "Found date";}else{ echo "拾獲日期";}?></td>
    <td class="grey03"><?php if($_SESSION['eng']==1){ echo "Found Area";}else{ echo "拾獲地點";}?></td>
  </tr>
  <?php 
		$less=count($alldata[$adst[$d]]);
		if($less!=0 and $alldata[$adst[$d]][0][2]!=""){
			if($less < 3){$less=3;}
			for($c=0;$c<$less;$c++){
	 ?>
	  <tr align="center">
		<td class="blue02">&nbsp;</td>
		<td class="point01"><?php if($alldata[$adst[$d]][$c][0]!=""){echo $alldata[$adst[$d]][$c][3];}?></td>
		<td class="point02"><?php if($alldata[$adst[$d]][$c][1]!=""){echo $alldata[$adst[$d]][$c][0];}?></td>
		<td class="point01"><?php if($alldata[$adst[$d]][$c][2]!=""){echo $alldata[$adst[$d]][$c][1];}?></td>
		<td class="point02"><?php if($alldata[$adst[$d]][$c][3]!=""){echo $alldata[$adst[$d]][$c][2];}?></td>
	  </tr>
	<?php 		
			}
		}else{?>
		 <tr  rowspan="3">
			<td class="blue02">&nbsp;</td>
			<td class="point01" colspan="4" rowspan="3" align="center">查無資料</td>
		</tr>
		 <tr  rowspan="3">
			<td class="blue02">&nbsp;</td>
		</tr>
		 <tr  rowspan="3">
			<td class="blue02">&nbsp;</td>
		</tr>
<?php  }
 ?>
   
</table>

   <!--<p>若需更多詳細訊息與站點地圖，可點選欲預覽之站點名稱即可。</p>-->
  </div>		
  <?php
	}//show by flag end if
?>
</div>
<br class="CLEAR">
</div>
<div id="FOOTER"><p><a href="contact.php">聯絡我們</a>│Copyright 2012 GIANT Sales Company 請尊重智慧財產權，勿任意轉載，違者依法必究 </p></div>
</div>

<form name="f2" method="post" action="lost.php">
<input type="hidden" name="srh_type" />
<input type="hidden" name="sapoint" />
</form>
  
</body>
</html>
<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script>

    var curWin;
	var curInfo;
	var contents=[];
    var map;
    var markers = [];
    var infoWindow;
    var locationSelect;
	var default_center;
	var icon = "images/marker.png";
	var geocoder;
    var map;
 function load() {
	
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(25.040838, 25.040838),
        zoom: 17,
        mapTypeId: 'roadmap',
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
      });
      infoWindow = new google.maps.InfoWindow();

      locationSelect = document.getElementById("locationSelect");
      locationSelect.onchange = function() {
        var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
        if (markerNum != "none"){
          google.maps.event.trigger(markers[markerNum], 'click');
        }
      };
	  searchLocations();
      
   }
   
function goPage(p)
{
	document.n1.page.value=p;
	document.n1.submit();
}
function goPrev()
{
	 var f = document.n1;
	 var op = f.page.value;
	 op = parseInt(op);
	 var np;
	 if(op>1){	np-=1;}else{np = 1;}
	 f.page.value = np;
	 f.submit();
}

function goNext()
{
	 var f = document.n1;
	 var op = f.page.value;
	 var tp = f.totalPages.value;
	 op = parseInt(np);
	 tp = parseInt(tp);
	 var np;
	 if(op<tp){	np+=1;}else{np = tp;}
	 f.page.value = np;
	 f.submit();
}

var mH = document.body.clientHeight;
var nn = window.screen.height;
var obj = document.getElementById("MAIN");
var nH = nn-(420);
var ua = navigator.userAgent.toLowerCase();
if(ua.indexOf("msie")>-1)
{
	nH = nn-420;
}
else if(ua.indexOf("firefox")>-1)
{
	nH = nn-440;
}
else if(ua.indexOf("chrome")>-1)
{
	nH = nn-400;
	
	
}
var dH = $("#MAIN").height();
$("#WRAPPER").css('minHeight',mH);
var n1=(mH-190);

if(dH<n1)
{


var fh = mH-250;
$("#MAIN").css('height',fh);
$("#FOOTER").css('bottom',0);
$("#FOOTER").css('position','absolute');
}


 
 function srhArea(area)
 {
 	var f = document.f2;
	 f.srh_type.value="area";
	  f.sapoint.value=area;
	 f.submit();
 }
 
</script>