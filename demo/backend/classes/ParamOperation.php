<?php
class ParamOperation
{
	//private $config = new SystemConfig();

	function extractParam( $_params , $_type , $_lang)
	{
		$errorFlag = false;

		$paramArray = array();
		$paramName = array();
		$paramValue = array();
		$paramLang = array();
		try
		{
			if ( !isset($_params) || empty( $_params ) )
			{
				tracefile_error("ParamOperation.php" , "Parameter is empty" );
				throw new Exception("Parameter is empty");
			}

			if ( !isset($_type) || empty( $_type ) )
			{
				tracefile_error("ParamOperation.php" , "Type is empty" );
				throw new Exception("Type is empty");
			}

			if ( !isset($_lang) || empty( $_lang ) )
			{
				tracefile_error("ParamOperation.php" , "Language is empty" );
				throw new Exception("Language is empty");
			}

			tracefile_debug("ParamOperation.php" , "Parameter is >> ".explode( "|" , $_params));
			tracefile_debug("ParamOperation.php" , "Type is >> ".explode( "|" , $_type));
			tracefile_debug("ParamOperation.php" , "Language is >> ".explode( "|" , $_lang));

			$params = explode( "|" , $_params);
			$type = explode( "|" , $_type);
			$lang = explode( "|" , $_lang);

			if (count( $params ) != count ($type) )
			{
				tracefile_error("ParamOperation.php" , "Parameter and type is compatible. Params is >> ".explode($params)." and Type is ".explode($type) );
				throw new Exception("Parameter and type is not compatible.");
			}

			if (count( $params ) != count ($lang) )
			{
				tracefile_error("ParamOperation.php" , "Parameter and Language is compatible. Params is >> ".explode($params)." and Language is ".explode($lang) );
				throw new Exception("Parameter is not compatible.");
			}

			for ($ii=0;$ii<count($params);$ii++)
			{
				$paramName[$ii] = $params[$ii];
				$paramLang[$ii] = $lang[$ii];
				if ($type[$ii] != "file")
					$paramValue[$ii] = $_POST[$params[$ii]];
				else
					$paramValue[$ii] = $this->uploadImg($paramName[$ii]);
			}

			$paramArray["NAME"] = $paramName;
			$paramArray["VALUE"] = $paramValue;
			$paramArray["LANG"] = $paramLang;
			return $paramArray;
		}
		catch(Exception $e)
		{
			throw $e;
		}

	}

	function uploadImg($paramName)
	{
		$obj = new SystemConfig();
		$config = $obj->unserializeObj( "SystemConfig" );

		tracefile_debug("ParamOperation.php" , "Initial upload Image");
		$image =  $_FILES[$paramName]["name"];
		if (!empty($image))
		{
			$extension = end(explode(".", $_FILES[$paramName]["name"]));
			$attachFileName = rand(1000000,9999999).".".$extension;

			if ($_FILES[$paramName]["error"] > 0)
			{
				tracefile_error("ParamOperation.php" , "File upload is error : ".$_FILES[$paramName]["error"] );
				throw new Exception("File upload is error : ".$_FILES[$paramName]["error"]);
			}
			else
			{
				if (!empty($image))
				{	
					$attachFile = move_uploaded_file($_FILES[$paramName]["tmp_name"],
					$config->getUploadPath().$attachFileName );
				}
			}
			return $attachFileName;
		}
		else
		{
			//tracefile_error("ParamOperation.php" , "File upload is empty : ".$image);
			//throw new Exception("File upload is empty : ".$image);
		}
	}

	function getLang()
	{
		return $_POST["language"];
	}

}
?>