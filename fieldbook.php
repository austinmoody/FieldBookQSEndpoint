<?php

	define("__USERFILE__","/home/amoody/.fieldbook_username");
	define("__APIFILE__","/home/amoody/.fieldbook_api");
        
	$possible_actions = array("coffee");

	// Read correct user_name from file
	$file_user_name = fopen(__USERFILE__,"r") or die("Unable to open username file.");
	$user_name = rtrim(fread($file_user_name,filesize(__USERFILE__)));
	fclose($file_user_name);

	// Read correct api key from file
	$file_api = fopen(__APIFILE__,"r") or die("Uble to open api file.");
	$api_key = rtrim(fread($file_api,filesize(__APIFILE__)));
	fclose($file_api);

	$return_value = array(array("Status" => "FAIL","Response" => ""));
    
    if ( isset($_GET["action"]) && in_array($_GET["action"],$possible_actions) ) 
    {
	// Action is good, now check user and api_key

	if ( (isset($_GET["user"]) && $_GET["user"] == $user_name) && (isset($_GET["api"]) && $_GET["api"] == $api_key) ) {
		// User & API good - get down to other business
		$return_value[0]["DEBUG"] = "Username Good";
	}
	else {
		$return_value[0]["Response"] = "INVALID CREDENTIALS";
		$return_value[0]["Status"] = $user_name;
	}
    } 
    else 
    {
       $return_value[0]["Response"] = "INVALID ACTION";
    }
    
   echo json_encode($return_value);

?>
