<?php
$method = $_POST["method"];

$operation = new DbOperation();

$insert_id = 0;
tracefile_debug("transaction_process.php" , "Method >> $method");
if ($method == "save")
{
	try
	{
        tracefile_debug("transaction_process.php" , "Table Name >> ".$_POST["TABLENAME"]);
        tracefile_debug("transaction_process.php" , "PARAMS >> ".$_POST["PARAMS"]);
        tracefile_debug("transaction_process.php" , "PARAMSTYPE >> ".$_POST["PARAMSTYPE"]);
        tracefile_debug("transaction_process.php" , "PARAMSLANG >> ".$_POST["PARAMSLANG"]);
		$result = $operation->insert( $db , $_POST["TABLENAME"], $_POST["PARAMS"]  , $_POST["PARAMSTYPE"]  , $_POST["PARAMSLANG"] );
        tracefile_debug("transaction_process.php" , "Insert result >> $result");
		$processResult = $result > 0 ? 1 : 8;
        $insert_id = $operation->get_insertid();
        tracefile_debug("transaction_process.php" , "Insert id >> $insert_id");
	}
	catch(Exception $e)
	{
		$errorMsg = $e->getMessage();
		$processResult = 8;
	}

}
else if ($method == "delete")
{
	$deleteType = $_REQUEST["deleteType"];
	try
	{
		if ( empty($deleteType) ||  $deleteType == "permanent")
		{
			$result = $operation->deletePermanent( $db , $_POST["TABLENAME"] , $_POST["deleteId"] );
		}
		else if ( $deleteType == "temp")
		{
			$result = $operation->deleteTemp( $db , $_POST["TABLENAME"] , $_POST["deleteId"] );
		}
		$processResult = $result > 0 ? 1 : 8;
	}
	catch(Exception $e)
	{
		$errorMsg = $e->getMessage();
		$processResult = 8;
	}

}
else if ($method == "edit")
{

	tracefile_debug("news_init.php" , "Parameter is >> ".$_POST["PARAMS"]);
	tracefile_debug("news_init.php" , "Type is >> ".$_POST["PARAMSTYPE"]);
	tracefile_debug("news_init.php" , "Language is >> ".$_POST["PARAMSLANG"]);
	try
	{
		$result = $operation->update( $db ,$_POST["TABLENAME"], $_POST["editId"] , $_POST["PARAMS"]  , $_POST["PARAMSTYPE"]   , $_POST["PARAMSLANG"] );
		$processResult = $result > 0 ? 1 : 8;
	}
	catch(Exception $e)
	{
		$errorMsg = $e->getMessage();
		$processResult = 8;
	}

}

?>