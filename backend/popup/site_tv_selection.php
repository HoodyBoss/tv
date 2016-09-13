<?php
include "../includes/connectdb.inc.php";
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
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title></title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel='stylesheet' id='MainStyle-css'  href='css/style.css' type='text/css' media='all' />
</head>
<script type="text/javascript">
<!--
	function assignChannel(tv_id)
	{
		window.parent.document.getElementById("tvchannel").innerHTML = tv_id;
	}
//-->
</script>
<body>
	<div>
	<?php

		$id = $_REQUEST["id"];
		$sql = "select a.id,b.image tv_image, tv_url  FROM tb_b_hotspot  a,tb_b_tv_channel b where a.tv_id = b.id and a.id = '$id' ";
		//echo $sql;
		$db->send_cmd($sql);
		while ($row=$db->get_result())
		{
			 echo $row["tv_url"];
		}
	?>
	</div>
	<table width = "96%" align = "center">
		<?php
		//Generate hotspot list into select list
		for ($ii=0;$ii<count($tvidarray);$ii++)
		{
			if ($ii==0 || $ii%4==0)
				echo "<tr>";
		?>
			<td width = "25%" align = "center"><!--class="fancybox fancybox.iframe"   href="tvpreview.php?id=<?=$tvidarray[$ii]?>" -->
				<a href = "javascript: assignChannel('<?=$tvidarray[$ii]?>')" title = "<?=$tvnamearray[$ii]?>" >
					<img src="../attachfiles/<?=$tvimgarray[$ii]?>" width = "150" height = "150">
				</a>
			</td>
		<?php
			if ($ii%4==3)
				echo "</tr>";
		}//Close generate hotspot list
		?>
		
	</table>
<body>
</body>
</html>
<?php
$db->free_result();
$db->close();
?>