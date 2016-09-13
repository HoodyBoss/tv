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


?>