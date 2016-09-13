<?php

function generate_username()
{

	$characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
	
	return $randomString;
}

function generate_password()
{

	$characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < 6; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
	
	return $randomString;
}
?>