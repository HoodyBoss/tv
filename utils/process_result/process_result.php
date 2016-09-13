<link rel='stylesheet' id='processresult-css'  href='utils/process_result/css/style.css' type='text/css' media='all' />

<?php
class Alerts
{
	function Alerts()
	{
		//No need to even initialize me, just use Scope Resolution Operator to use me.
	}
	
	function info($msg)
	{
		return '<div class="info">'.$msg.'</div>';
	}
	
	function success($msg)
	{
		return '<div class="success">'.$msg.'</div>';
	}
	
	function warning($msg)
	{
		return '<div class="warning">'.$msg.'</div>';
	}
	
	function error($msg)
	{
		return '<div class="error">'.$msg.'</div>';
	}
}
?>