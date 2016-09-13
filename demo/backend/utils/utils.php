<?php
function ByteUsed($byte){ 
    $byte_str = "";
	$byte = empty($byte) ? 0 : $byte;
	$byte_in = array( 
			"GB" => ( 1000 * 1000 * 1000 )
			,"MB" => (1000 * 1000)
			,"KB" => 1000
			);
	
	$gb = $byte/$byte_in["GB"];
	$mb = $byte/$byte_in["MB"];
	$kb = $byte/$byte_in["KB"];
	if ($gb > 1)
	{
		$byte_str = round($gb,2)."GB ";
	}
	else if ($mb > 1)
	{
		$byte_str = round($mb,2)."MB ";
	}
	else if ($kb > 1)
	{
		$byte_str = round($kb,2)."KB ";
	}
	else
	{
		$byte_str = $byte."Bytes. ";
	}
	
    return $byte_str;
}

function extractArrayToString( $inArray , $delim )
{
	$outStr = "";
	if (empty( $delim ))
		$delim = ",";
	for ($ii=0;$ii<count( $inArray ); $ii++)
	{
		$outStr .= empty( $outStr ) ? $inArray[$ii] : $delim.$inArray[$ii];
	}
	return $outStr;
}

?>