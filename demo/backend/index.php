<?php
session_start();
$loginflag = $_REQUEST["loginflag"];

function chkBrowser($nameBroser){  
    return preg_match("/".$nameBroser."/",$_SERVER['HTTP_USER_AGENT']);  
}

$browserError = false;
if(chkBrowser("MSIE")!=1)
{  
	$browserError = true;
}
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<title>TV - Dashboard I Admin Panel</title>
	
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
	<script src="js/hideshow.js" type="text/javascript"></script>
	<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.equalHeight.js"></script>
	<script type="text/javascript">
	$(document).ready(function() 
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

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });


	function login()
	{
		document.forms[0].submit();
	}
</script>

</head>


<body>

	<header id="header">
		<hgroup>
			<h1 class="site_title">TV</h1>
		</hgroup>
	</header>
		<form method = "post" action = "loginprocess.php">
			<article class="module width_full">
				<header><h3>&nbsp;&nbsp;Login</h3></header>
				<div >
					<article class="stats_graph">
						
						<div id="tab1" >
							<table cellspacing="0" align = "center" width = "100%"> 
							
							<tbody> 
								<?php
								if ($loginflag=="n")
								{
								?>
								<tr> 
									<td align = "center"><h1><font color= "red">Login Failed</font></h1></td> 
								</tr>
								<?php
								}
								else if ($_REQUEST["sessiontimeout"]=="y")
								{
								?>
								<tr> 
									<td align = "center"><h1><font color= "red">Session timeout</font></h1></td> 
								</tr>
								<?php
								}
								?>
								<tr> 
									<td align = "center">&nbsp;</td> 
								</tr>
								
								<tr> 
									<td align = "center">&nbsp;</td> 
								</tr>
								<tr> 
									<td align = "center">&nbsp;</td> 
								</tr>
								<tr> 
									<td align = "center"><input type="text" name= "username" value="Username" size = "20" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;"></td> 
								</tr> 
								<tr> 
									<td align = "center">&nbsp;</td> 
								</tr>
								<tr> 
									<td align = "center"><input type="password" name = "password" value="Password" size = "21" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;"></td> 
								</tr>
								<tr> 
									<td align = "center">&nbsp;</td> 
								</tr>
								<tr> 
									<td align = "center"><input type="button" value = "Login" onclick = "login()">&nbsp;&nbsp;<input type="reset" value = "Cancel"></td> 
								</tr> 
								<tr> 
									<td align = "center">&nbsp;</td> 
								</tr>
								
							</tbody> 
							</table>
						</div>
					</article>
					<div class="clear"></div>
				</div>
			</article>
		</form>
		<hr/>
		
    <div class="spacer"></div>


</body>

</html>
<?php
session_destroy();
?>