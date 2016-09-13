<?php
function DateIntervalFromSec($sec_time){ // as datetime object returns difference in seconds
    $date_str = "";
	$sec_time = empty($sec_time) ? 0 : $sec_time;
	$sec_in = array( 
			"year" => (365*24*60*60)
			,"month" => (30*24*60*60)
			,"week" => (7*24*60*60)
			,"day" => (24*60*60)
			,"hour" => (60*60)
			,"minute" => 60
			);
	
	$year = $sec_time/$sec_in["year"];
	if ($year > 1)
	{
		$sec_time = $sec_time - (floor($year) * $sec_in["year"]);
		$date_str .= floor($year)."Y ";
	}

	$month = $sec_time/$sec_in["month"];
	if ($month > 1)
	{
		$sec_time =  $sec_time - (floor($month) * $sec_in["month"]);
		$date_str .= floor($month)."M ";
	}

	$week = $sec_time/$sec_in["week"];
	if ($week > 1)
	{
		$sec_time =  $sec_time - (floor($week) * $sec_in["week"]);
		$date_str .= floor($week)."W ";
	}

	$day = $sec_time/$sec_in["day"];
	if ($day > 1)
	{
		$sec_time =  $sec_time - (floor($day) * $sec_in["day"]);
		$date_str .= floor($day)."D ";
	}

	$hour = $sec_time/$sec_in["hour"];
	if ($hour > 1)
	{
		$sec_time = $sec_time - (floor($hour) * $sec_in["hour"]);
		$date_str .= floor($hour)."H ";
	}

	$minute = $sec_time/$sec_in["minute"];
	if ($minute > 1)
	{
		$sec_time =  $sec_time - (floor($minute) * $sec_in["minute"]);
		$date_str .= floor($minute)."min. ";
	}

	$sec = $sec_time;
	if ($sec > 1)
	{
		$date_str .= $sec."sec. ";
	}
	
    return $date_str;
}
?>