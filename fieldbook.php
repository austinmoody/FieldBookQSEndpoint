<?php

	require __DIR__ . '/vendor/autoload.php';

	define("__SETTINGSFILE__","/home/amoody/.fieldbook.json");
        
	$possible_actions = array("coffee");

	// Read settings
	$settings_file = fopen(__SETTINGSFILE__,"r") or die ("Unable to open settings file.");
	$fieldbook_settings = json_decode(fread($settings_file,filesize(__SETTINGSFILE__)),true);
	fclose($settings_file);

	$user_name = $fieldbook_settings["username"];
	$api_key = $fieldbook_settings["api"];
	$fieldbook_username = $fieldbook_settings["fieldbook_username"];
	$fieldbook_key = $fieldbook_settings["fieldbook_key"];

	$return_value = array(array("Status" => "FAIL","Response" => ""));
    
    if ( isset($_GET["action"]) && in_array($_GET["action"],$possible_actions) ) 
    {
	// Action is good, now check user and api_key

	if ( (isset($_GET["user"]) && $_GET["user"] == $user_name) && (isset($_GET["api"]) && $_GET["api"] == $api_key) ) {
		// User & API good - get down to other business
		$return_value[0]["DEBUG"] = "Username Good";

		// Httpful testing
		$url = "https://api.fieldbook.com/v1/5681f3c36b1eca03000a12c2/coffee";

		$response = \Httpful\Request::get($url)
				->expectsJson()
				->authenticateWith($fieldbook_username,$fieldbook_key)
				->send();
		echo $response;

	}
	else {
		$return_value[0]["Response"] = "INVALID CREDENTIALS";
	}
    } 
    else 
    {
       $return_value[0]["Response"] = "INVALID ACTION";
    }
    
   //echo json_encode($return_value);

?>
