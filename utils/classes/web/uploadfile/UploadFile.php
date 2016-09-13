<?php
class UploadFile()
{
	function upload(  $srcFile , $destFile , $path )
	{
		$image =  $srcFile["name"];
		if (!empty($image))
		{
			

			if ($srcFile["error"] > 0)
			{
				
			}
			else
			{
					$attachFile = move_uploaded_file($srcFile["tmp_name"],
					  $path.$destFile );
			}
		}
	}
}
?>