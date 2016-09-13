<?php
require "backend/includes/connectdb.inc.php"; 
$sql = "select id from tb_b_news where status = 'Y' and show_date is not null order by show_date desc limit 0,4";
$db->send_cmd($sql);
while ($row = $db->get_result())
{
	$str .= $row["id"];
}
echo "<ID>".$str."</ID>";
?>