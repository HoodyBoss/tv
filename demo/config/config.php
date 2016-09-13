<?php
//session_start();
//Connect db
include "backend/includes/connectdb.inc.php";
require "utils/tracelog.php";
$fileUploadPath =  "backend/attachfiles";
$defaultLang = "th";

$curLang = !empty( $_REQUEST["curLang"] ) ? $_REQUEST["curLang"] : $defaultLang ;

include "multilanguage/multilanguage.php";

//Bit.ly info for generate short url function
//$login = "uddu";
//$appkey = "R_0cce69a05fec4bc188b380385faa5d8e";

$host = "118.175.48.147:8225/";
$http_port = "";
$app_name = "";
$authenLink = "validateqr.php";
$param_name = "extauth.php?auth=";
$host_url = "http://".$host."".(!empty($http_port) ? ":".$http_port : "").(!empty($app_name) ? "/".$app_name : "")."/";
//$config["domain"] = $host_url;
$msg .= "\n[".date('m/d/Y h:i:s a', time())."] config.php >> host_url : ".$host_url;

include "utils/generate_shorturl.php";
//include "utils/general_util.php";
include "utils/autogenerate.php";

$env_var = array();
$sql = "select * from tb_b_env_var";
$db->send_cmd($sql);
while ($row=$db->get_result())
{
	$env_var["boardingpasscode_length"] = $row["boardingpasscode_length"];
}


?>  