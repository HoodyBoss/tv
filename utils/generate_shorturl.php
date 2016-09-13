<?php

function get_shortURL( $db , $domain , $param , $authenLink )  
{  
	 $url = $domain.$param;
	 $sql = "insert into tb_b_urls (url) values( '$url' )";
	 $db->send_cmd($sql);
	 $id = $db->get_id();
	 $file = 'log.txt';
	$msg = file_get_contents($file);
	$msg .=  "\n[".date('m/d/Y h:i:s a', time())."] generate_shorturl.php >> Short URL : ".$domain.$authenLink."?id=".$id;
	 return  $domain.$authenLink."?id=".$id;
}

?>