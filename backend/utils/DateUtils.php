<?php
class DateUtils
{
	function getNow()
	{
		date("d/m/Y H:i:s", mktime( date("H") , date("i"),  date("s") , date("m")  , date("d"), date("Y")));
	}

	function addDateFromNow( $interval , $type )
	{
		$dd = date("d");
		$mm = date("m");
		$yy = date("Y");
		$hh = date("H");
		$ii = date("i");
		$ss = date("s");

		if ($type=="DATE")
 			$dd = $dd + $interval;
		if ($type=="MONTH")
 			$mm = $mm + $interval;
		if ($type=="YEAR")
 			$yy = $yy + $interval;
		if ($type=="HOUR")
 			$hh = $hh+ $interval;
		if ($type=="MINUTE")
 			$ii = $ii+ $interval;
		if ($type=="SECOND")
 			$ss = $ss + $interval;

		return date("d/m/Y H:i:s", mktime( $hh , $ii ,  $ss , $mm  , $dd , $yy ));

	}

}
?>