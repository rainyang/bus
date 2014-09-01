<?php
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $sec = 0, $http_response_code = 302)
	{
		switch($method)
		{
			case 'refresh'	: header("Refresh:{$sec};url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}

function addslashes_deep($value)
{
    return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
}

function debug($param){
    echo "<pre>";
    print_r($param);
    echo "</pre>";
}
