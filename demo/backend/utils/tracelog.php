<?php

	function debug( $table , $pk , $actiontype , $actiondetail  )
	{
		if (!empty($this->dbcon))
		{
			$sql = " insert into tb_b_history_log( table_name , primary_key, action_type , action_detail ,created_date, created_by) values( '".$table."' , '".$pk."' , '".$actiontype."' , '".str_replace("'","",$actiondetail)."' , now() , 'acmin' )  ";
			$this->dbcon->send_cmd($sql);
		}
	}

	function logs( $db ,  $module , $msg , $cb  )
	{
		//echo "DB : ".$this->dbcon;
		$sql = " insert into tb_b_logs( module_name , message , cd , cb ) values( '".str_replace("'","",$module)."' , '".str_replace("'","",$msg)."' , now() , '$cb' )  ";
		//echo "Query : ".$sql;
		$db->send_cmd($sql);
		
	}

	function tracefile_debug($logFile , $logMsg)
	{
		$file = 'SystemOut.txt';
		if ( file_exists($file) && filesize($file) > 3000000 )
		{
			copy ( $file , "logs/SystemOut_".date('Ymdhis', time()).".txt");
			unlink ( $file ); 
		}
		$msg = file_get_contents($file);
		$msg .= "\n[".date('m/d/Y h:i:s a', time())."] ] $logFile >> : ".$logMsg;
		file_put_contents($file, $msg);
	}

	function tracefile_error($logFile , $logMsg)
	{
		$file = 'SystemError.txt';
		if ( file_exists($file) && filesize($file) > 3000000 )
		{
			copy ( $file , "logs/SystemError_".date('Ymdhis', time()).".txt");
			unlink ( $file ); 
		}
		$msg = file_get_contents($file);
		$msg .= "\n[".date('m/d/Y h:i:s a', time())."] $logFile >> : ".$logMsg;
		file_put_contents($file, $msg);
	}


?>