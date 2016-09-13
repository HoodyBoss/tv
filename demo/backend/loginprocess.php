<?php
session_start();
require "includes/connectdb.inc.php"; 
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "select * from tb_b_user where 0=0 and username = '$username' and password = md5('".$username.$password."')";
//tracefile_debug("loginprocess.php" , "Login query : ".$sql );
//logs( $db,  "Login backend process - Query " , $sql , "admin" );

$success = false;

$db->send_cmd($sql);
while ($row=$db->get_result())
{
	$_SESSION["login_username"] = $row["username"];
	$_SESSION["login_firstname"] = $row["firstname"];
	$_SESSION["login_lastname"] = $row["lastname"];
	$_SESSION["login_email"] = $row["email"];
	$_SESSION["login_telno"] = $row["telno"];
	$_SESSION["login_hotspot"] = $row["hotspot_id"];
	$_SESSION["login_user_type"] = $row["user_type"];
	
	$success = true;
}
$db->free_result();
$db->close();
//echo "xxx :: ".$success;
if ($success)
{
	$user_type = $_SESSION["user_type"];
	header("Location: adminhome.php");
}
else
{
	header("Location: index.php?loginflag=n");
}
?>
