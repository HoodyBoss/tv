<?php
//DAO class
class DbOperation
{
	function query( $dbcon , $sql )
	{
		$dbcon->send_cmd($sql);
		return $dbcon;
	}

	function insert( $dbcon , $tableName , $params , $type , $lang )
	{
		$paramOper = new ParamOperation();
		$langValue = $paramOper->getLang();
		try
		{
			tracefile_debug("DbOperation.php" , "Parameter is >> ".$params);
			tracefile_debug("DbOperation.php" , "Type is >> ".$type);
			tracefile_debug("DbOperation.php" , "Lang is >> ".$lang);
			$paramArray = $paramOper->extractParam( $params , $type , $lang );
			
			$paramName = $paramArray["NAME"];
			$paramValue = $paramArray["VALUE"];
			$paramLang = $paramArray["LANG"];
			
			$qry = "insert into ".$tableName;
			for ($ii=0;$ii<count($paramName);$ii++)
			{
				if ($ii==0)
					$qry .= "(".$paramName[$ii].($paramLang[$ii]=="Y" ? "_".$langValue : "" );
				else
					$qry .= ",".$paramName[$ii].($paramLang[$ii]=="Y" ? "_".$langValue : "" );
			}
			$qry .= ") ";

			$qry .= " values ";
			for ($ii=0;$ii<count($paramValue);$ii++)
			{
				if ($ii==0)
					$qry .= "('".$paramValue[$ii]."'";
				else
					$qry .= ",'".$paramValue[$ii]."'";
			}
			$qry .= ") ";
			tracefile_debug("DbOperation.php" , "Insert query >> ".$qry);
			$dbcon->send_cmd($qry);
			return $dbcon->affected_rows();
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

	function update( $dbcon , $tableName , $id , $params , $type  , $lang)
	{
		$paramOper = new ParamOperation();
		$langValue = $paramOper->getLang();
		try
		{
			tracefile_debug("DbOperation.php" , "Parameter is >> ".$params);
			tracefile_debug("DbOperation.php" , "Type is >> ".$type);
			$paramArray = $paramOper->extractParam( $params , $type  , $lang );
			
			$paramName = $paramArray["NAME"];
			$paramValue = $paramArray["VALUE"];
			$paramLang = $paramArray["LANG"];
			
			$qry = "update ".$tableName." set ";
			$updQry = "";
			for ($ii=0;$ii<count($paramName);$ii++)
			{
				if (empty($updQry))
				{
					if ( !empty($paramValue[$ii]) )
						$updQry .= "".$paramName[$ii].($paramLang[$ii]=="Y" ? "_".$langValue : "" )." = '".$paramValue[$ii]."'";
				}
				else
				{
					if ( !empty($paramValue[$ii]) )
						$updQry .= ",".$paramName[$ii].($paramLang[$ii]=="Y" ? "_".$langValue : "" )." = '".$paramValue[$ii]."'";
				}
			}
			$qry .= $updQry." where id = '$id' ";

			tracefile_debug("DbOperation.php" , "Update query >> ".$qry);
			$dbcon->send_cmd($qry);
			return $dbcon->affected_rows();
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

	function deletePermanent( $dbcon , $tableName , $id )
	{
		try
		{
			$qry = "delete from $tableName where id = '$id' ";

			tracefile_debug("DbOperation.php" , "Delete permanent query >> ".$qry);
			$dbcon->send_cmd($qry);
			return $dbcon->affected_rows();
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}

	function deleteTemp( $dbcon , $tableName , $id )
	{
		try
		{
			$qry = "update $tableName set status = 'N' where id = '$id' ";

			tracefile_debug("DbOperation.php" , "Delete temp query >> ".$qry);
			$dbcon->send_cmd($qry);
			return $dbcon->affected_rows();
		}
		catch (Exception $e)
		{
			throw $e;
		}

	}
}
?>