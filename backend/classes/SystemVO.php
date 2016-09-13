<?php
class SystemVO
{
	function serializeObj( $name )
	{
		$configSerialize = serialize( $this );
		file_put_contents( $name , $configSerialize);
	}

	function unserializeObj( $name )
	{
		$configSerialize = file_get_contents( $name );
		$obj = unserialize($configSerialize);

		return $obj;
	}
}
?>