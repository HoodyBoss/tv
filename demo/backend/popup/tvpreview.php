﻿<?php
include "../includes/connectdb.inc.php";
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
<body>
	<div>
	<?php
		$curLang = $_REQUEST["language"];
		$id = $_REQUEST["id"];
		$sql = "select tv_url  FROM tb_b_tv_channel where id = '$id' ";
		//echo $sql;
		$db->send_cmd($sql);
		while ($row=$db->get_result())
		{
			echo $row["tv_url"];
	?>
		
	<?php
		}
	?>
	</div>
<body>
</body>
</html>
<?php
$db->free_result();
$db->close();
?>