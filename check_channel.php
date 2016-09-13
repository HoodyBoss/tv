<?php
require "backend/includes/connectdb.inc.php"; 
$id = $_POST["id"];
$tvid = $_POST["tvid"];
$sql = "select a.id,a.tv_id,tv_url from tb_b_hotspot a , tb_b_tv_channel b where a.tv_id = b.id and a.id = '$id' and a.tv_id != '$tvid' ";
$db->send_cmd($sql);
$row = $db->get_result();
$str = "<ID>".$row["id"]."</ID>";
$str .= "<TVID>".$row["tv_id"]."</TVID>";
$str .= "<TVURL>".$row["tv_url"]."</TVURL>";
echo $str;
?>