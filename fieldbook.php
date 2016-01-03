<?php

	require __DIR__ . '/vendor/autoload.php';

    // TODO - need to come up with a standard place to store this file.
	define("__SETTINGSFILE__","/mnt/user/.fieldbook.json");

	$possible_actions = array("coffee");

	// Read settings file
	$settings_file = fopen(__SETTINGSFILE__,"r") or die ("Unable to open settings file.");
	$fieldbook_settings = json_decode(fread($settings_file,filesize(__SETTINGSFILE__)),true);
	fclose($settings_file);

	$user_name = $fieldbook_settings["username"];
	$api_key = $fieldbook_settings["api"];
	$fieldbook_username = $fieldbook_settings["fieldbook_username"];
	$fieldbook_key = $fieldbook_settings["fieldbook_key"];
    $baseUrl = $fieldbook_settings["base_url"];

    $currentFullDate = date('m/d/Y h:i:s a', time());
    $currentShortDate = date('m/d/Y', time());

	$return_value = array(array("Status" => "FAIL","Response" => ""));

    if ( isset($_GET["action"]) && in_array($_GET["action"],$possible_actions) )
    {
	    // Action is good, now check user and api_key

	    if ( (isset($_GET["user"]) && $_GET["user"] == $user_name) && (isset($_GET["api"]) && $_GET["api"] == $api_key) ) {
		    // User & API good - get down to other business
            switch (strtoupper($_GET["action"])) {
                case "COFFEE":
                    $jsonBody = '{"count":1,"datetime":"' . $currentFullDate . '","date":"' . $currentShortDate . '"}';
                    $coffeeUrl = $baseUrl . "coffee";
                    $response = \Httpful\Request::post($coffeeUrl)
            		            ->sendsJson()
            		            ->authenticateWith($fieldbook_username,$fieldbook_key)
                                ->body($jsonBody)
            		            ->send();
                    $return_value[0]["Status"] = "Success";
                    $return_value[0]["Response"] = "Coffee added";
                    break;
            }
	    }
	    else {
		    $return_value[0]["Response"] = "INVALID CREDENTIALS";
	    }
    }
    else
    {
       $return_value[0]["Response"] = "INVALID ACTION";
    }

   echo json_encode($return_value);

?>
