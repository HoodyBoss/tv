<?php
session_start();
require "includes/application.inc"; 
include "utils/process_result/process_result.php";

if (!isset($_SESSION['login_username'])) {
	Header("Location: index.php?sessiontimeout=y");
}

$processResult = 9;
tracefile_debug("adminhome.php" , "after initial >> ".$_REQEUST["menu"]);
include "transaction_process.php";
tracefile_debug("adminhome.php" , "after call transaction process >> ".$_REQEUST["menu"]);
$dataTable = new GenerateDataList();

$curFile = "adminhome.php";

$menu = $_POST["menu"];
$status = $_POST["status"];
$desc = $_POST["desc"];



$recordPerPage = empty($_POST["recordPerPage"]) ? 10 : $_POST["recordPerPage"];
$pageNumber = empty($_POST["pageNumber"]) ? 1 : $_POST["pageNumber"];
$groupPage = empty($_POST["groupPage"]) ? 0 : $_POST["groupPage"];

$login_username = $_SESSION["login_username"];
$login_firstname = $_SESSION["login_firstname"];
$login_lastname =	$_SESSION["login_lastname"];
$login_mobile = $_SESSION["login_mobile"];
$login_email = $_SESSION["login_email"];
$login_user_group = $_SESSION["login_user_group"];
$login_user_type = $_SESSION["login_user_type"];

$fullname = $login_firstname." ".$login_lastname;

$hotspot = $_POST["hotspot"];

//Get hotspot list
$sql = "select id , hotspot_name from tb_b_hotspot where hotspot_status='Y' ";
//echo $sql;
$db->send_cmd($sql);
$hotspotid_array = array();
$hotspotname_array = array();
$ii=0;
while ($row=$db->get_result())
{
	$hotspotid_array[$ii] = $row["id"];
	$hotspotname_array[$ii] = $row["hotspot_name"];
	$ii++;
}
$db->free_result();
//echo "Hostpot id >>> ".count($hotspotid_array);

$sql = "select id , hotspot_name from tb_b_hotspot where hotspot_status = 'Y' ";
//echo $sql;
$db->send_cmd($sql);
$user_hotspotid_array = array();
$user_hotspotname_array = array();
$ii=0;
while ($row=$db->get_result())
{
	$user_hotspotid_array[$ii] = $row["id"];
	$user_hotspotname_array[$ii] = $row["hotspot_name"];
	$ii++;
}
$db->free_result();

$hotspot_flag="";
if ($login_user_type!="ADMIN_SUPER")
{
	$hotspot_flag="Y";
	$hotspot_clause = " and hotspot_id = '$hotspot' ";
}

$env_var = array();
$sql = "select * from tb_b_env_var";
$db->send_cmd($sql);
while ($row=$db->get_result())
{
	$env_var["boardingpasscode_length"] = $row["boardingpasscode_length"];
	$env_var["username_length"] = $row["username_length"];
	$env_var["password_length"] = $row["password_length"];
}

//Get hotspot list
$sql = "select id , tv_name,tv_url , tv_desc,image from tb_b_tv_channel where status='Y' ";
//echo $sql;
$db->send_cmd($sql);
$tvidarray = array();
$tvnamearray = array();
$tvurlarray = array();
$tvimgarray = array();
$ii=0;
while ($row=$db->get_result())
{
	$tvidarray[$ii] = $row["id"];
	$tvnamearray[$ii] = $row["tv_name"];
	$tvurlarray[$ii] = $row["tv_url"];
	$tvimgarray[$ii] = $row["image"];
	$ii++;
}
$db->free_result();

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>Dashboard I Admin Panel</title>
	
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="js/calendar/tcal.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="js/common_utils.js" type="text/javascript"></script>
	<script src="js/calendar/tcal.js" type="text/javascript"></script>
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
	<script type="text/javascript">
	/*$(document).ready(function() 
    	{ 
			  $(".tablesorter").tablesorter(); 
		 } 
		);
		$(document).ready(function() {

		//When page loads...
		$(".tab_content").hide(); //Hide all content
		$("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(".tab_content:first").show(); //Show first tab content

		//On Click Event
		$("ul.tabs li").click(function() {

			$("ul.tabs li").removeClass("active"); //Remove any "active" class
			$(this).addClass("active"); //Add "active" class to selected tab
			$(".tab_content").hide(); //Hide all tab content

			var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
			$(activeTab).fadeIn(); //Fade in the active ID content
			return false;
		});

	});*/
    </script>
    <script type="text/javascript">
   /*$(function(){
        $('.column').equalHeight();
    });
*/
	function localSubmitForm(  varName ,itemVal )
	{//alert(document.getElementById("menu").value);alert(document.getElementById("status").value);
		for (ii=0;ii<varName.length;ii++)
		{
			var obj = document.getElementById(varName[ii]);
			obj.value = itemVal[ii];
		}
		

		document.forms[0].submit();
	}

	function enterKey()
	{
		//alert(window.event.keyCode);
		var keyCode = window.event.keyCode;
		if (keyCode==13)
		{
			localSubmitForm(new Array(),new Array());
		}
	}

	function checkAll(allItem)
	{
		var obj_arr = document.forms[0].elements["select_user[]"];
		if (allItem.checked)
		{
			for (var ii=0;ii<obj_arr.length ;ii++ )
			{
				obj_arr[ii].checked = true;
			}
		}
		else
		{
			for (var ii=0;ii<obj_arr.length ;ii++ )
			{
				obj_arr[ii].checked = false;
			}
		}
	}

</script>
<style type="text/css">

    #printable { display: none;background-color:white;  }
	#breakhere {page-break-after: always}

    @media print
    {
    	#non-printable { display: none; }
    	#printable { display: block;background-color:white; }
		#breakhere {page-break-after: always}
    }

	.hsonuc {
		position: absolute;  
		top: 280px; 
		right:20%;
		margin-left:420px;
		
	}
	.breakhere {page-break-after: always}
</style>
</head>


<body>
	<div id = "non-printable">
	<?php
	include "utils/progress/progress.php";
	?>
	<form name = "mainFrm" method= "post" enctype="multipart/form-data" action = "adminhome.php">
		<header id="header">
			<hgroup>
				<h1 class="site_title"><a href="index.php">Website Admin</a></h1>
				<h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="index.php">Log Out</a></div>
			</hgroup>
		</header> <!-- end of header bar -->
		
		<section id="secondary_bar">
			<div class="user">
				<p><?=$fullname?></p>
				<a class="logout_user" href="index.php" title="Logout">Logout</a>
			</div>
			<div class="breadcrumbs_container">
				<article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
			</div>
		</section><!-- end of secondary bar -->
		
		<aside id="sidebar" class="column">
			<?php
			include "leftside.php";
			?>
		</aside><!-- end of sidebar -->
		
		<section id="main" class="column">
			
			<h4 class="alert_info"></h4>
			
			<article class="module width_full">
				<header><h3><?=$desc?></h3></header>
				<div class="module_content">
					<?php
						$menu = empty($menu) ? "hotspot" : $menu;
						$status = empty($status) ? "init" : $status;
						$desc = empty($desc) ? "TV Station" : $desc;
						if (isset($_SESSION["login_user_type"]) && $_SESSION["login_user_type"]=="LANGUAGE")
						{
							$menu = empty($menu) ? "multilanguage" : $menu;
							$status = empty($status) ? "init" : $status;
							$desc = empty($desc) ? "ภาษา" : $desc;
						}
						include $menu."_".$status.".php";
					?>
					
					<div class="clear"></div>
				</div>
			</article><!-- end of stats article -->
			
			
			<div class="spacer"></div>
		</section>


		<input type = "hidden" name = "recPerPage" id = "recPerPage" value = "<?=$recPerPage?>">
		<input type = "hidden" name = "page" id = "page" value = "<?=$page?>">
		<input type = "hidden" name = "menu" id = "menu" value = "<?=$menu?>">
		<input type = "hidden" name = "status" id = "status" value = "<?=$status?>">
		<input type = "hidden" name = "desc" id = "desc" value = "<?=$desc?>">
		<input type = "hidden" name = "method" id = "method" >
		<input type = "hidden" name = "hotspot" id = "hotspot" value = "<?=empty($hotspot) ? $default_hostpot : $hotspot?>">
</form>
</div>
<div id="printable" >
	<?php
	for ($ii=0;$ii<count($userforprint);$ii++)
	{
		$userinfo = $userforprint[$ii];
	?>
		<table width = "100%" align = "left"   >
			<tr>
				<td>
					<table width = "100%">
						<tr>
							<td><font size="2">Username : <?=$userinfo["username"]?></font></td>
						</tr>
						<tr>
							<td><font size="2">Password : <?=$userinfo["password"]?></font></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan = "2"><font size="2">Expire in <?=$userinfo["expiredate"]?></font></td>
			</tr>
		</table>
		<hr class="breakhere"/>
	<?php
	}
	?>
	<!-- <iframe name = "frame<?=$ii?>" id = "frame<?=$ii?>" src="print_user.php?username=<?=$userinfo["username"]?>&password=<?=$userinfo["password"]?>&expiredate=<?=$userinfo["expiredate"]?>" frameborder="0"></iframe> -->
		<script type="text/javascript">
		<!--
			//document.frame<?=$ii?>.printMe();
			//$('#<?=$ii?>')[0].focus();
			//$('#<?=$ii?>')[0].contentWindow.print();
			//var iframe = document.frames ? document.frames["frame<?=$ii?>"] : document.getElementById("frame<?=$ii?>");
			//var ifWin = iframe.contentWindow || iframe;
			//iframe.focus();
			//ifWin.printMe();
		//-->
		</script>
</div>
<script type="text/javascript">
<!--
	//window.print();
//-->
</script>
</body>

</html>
<?php
$db->free_result();
$db->close();
?>