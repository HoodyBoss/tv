<?php

$fileUploadPath =  "attachfiles/";

require ('connectdb.inc.php');
require ('utils/dateutil.php');
require ('utils/utils.php');
require ('utils/tracelog.php');

//Import classes

require ('classes/SystemVO.php');
require ('classes/SystemConfig.php');
require ('classes/ParamOperation.php');
require ('classes/DbOperation.php');
require ('classes/GenerateDataList.php');

if ($_POST['locale']!="")
{
	$_SESSION['locale'] = $_POST['locale'];
}



$username = $_SESSION["username"];
$fullname = $_SESSION["fullname"];
$usertype = $_SESSION["usertype"];

$hdrBgColor = "#2998f5";
$labelBgColor = "#cccccc";

$recPerPage = 10;

$noDateAlert = 0;

$pageNo = empty( $_POST["page"] ) || $_POST["page"]==1  ? 0*$recPerPage : ($_POST["page"]*$recPerPage) - $recPerPage;

$config = new SystemConfig();
$config->setUploadPath( $fileUploadPath );
$config->setRecPerPage( $recPerPage );
$config->serializeObj( "SystemConfig" );

tracefile_debug("application.inc" , "getUploadPath >> ".$config->getUploadPath());
?>