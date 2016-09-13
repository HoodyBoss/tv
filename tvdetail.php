<?php
include "backend/includes/connectdb.inc.php";
$id = $_GET["id"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>

 <body>
<?php
	$id = $_GET["id"];
	$sql = "select * from tb_b_hotspot a , tb_b_tv_channel b where a.tv_id = b.id and a.id = '$id' ";
	$db->send_cmd($sql);
	$row = $db->get_result();

	$tvurl = $row["tv_url"];
?>
 <iframe width = "100%" height = "630" src="<?=$tvurl?>" frameborder="0" scrolling="No" marginheight="0" marginwidth="0" valign = "middle" align = "center"></iframe>
 </body>
</html>
