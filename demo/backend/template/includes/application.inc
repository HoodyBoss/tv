<?

require ('connectdb.inc.php');

if ($_REQUEST['locale']!="")
{
	$_SESSION['locale'] = $_REQUEST['locale'];
}

$languageFile = $_SESSION['locale'];

//if ($languageFile == "")
//  $languageFile = $includeDir."includes/appresource_EN.php";
//else
//  $languageFile = $includeDir."includes/appresource_".$languageFile.".php";
  
  
$hdrBgColor = "#2998f5";
$labelBgColor = "#cccccc";

$recPerPage = 10;

$noDateAlert = 0;

$pageNo = empty( $_POST["page"] ) || $_POST["page"]==1  ? 0*$recPerPage : ($_POST["page"]*$recPerPage) - $recPerPage;

?>