<?php
header('Content-Type: text/html; charset=utf-8');
require "includes/application.inc"; 
$username = $_POST["username"];
$sql = "select username from tb_b_account where username ='$username' and status = 'Y' ";
$db->send_cmd($sql);
while ($row=$db->get_result())
{
	echo "<br>ผู้ใช้ : \"$username\" ซ้ำ กรุณาลองใหม่อีกครั้ง";
}
$db->free_result();
?>