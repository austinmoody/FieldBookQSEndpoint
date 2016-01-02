<?php
        
	$possible_actions = array("mood");
    	$user_name = "austinqs";
    	$api_key = "xxxyyy";
    
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
	}
    } 
    else 
    {
       $return_value[0]["Response"] = "INVALID ACTION";
    }
    
   echo json_encode($return_value);

?>
