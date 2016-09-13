<?php
require "backend/includes/connectdb.inc.php"; 
$sql = "select id,short_msg_th from tb_b_shortmsg where status = 'Y' order by id desc limit 0,5";
$db->send_cmd($sql);
while ($row = $db->get_result())
{
	$str .= $row["id"];
	$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;".$row["short_msg_th"];
}
echo "<ID>".$str."</ID>";
echo "<MSG>".$msg."</MSG>";
?>