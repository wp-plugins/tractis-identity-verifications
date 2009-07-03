<?php
/*
 * Tractis Identity Verifications
 * User interface functions
 */
 
 class tractis_ui {
 	
	 function show_admin_options() {
		global $tractis_auth_settings;
		
		$message = "";
		
	    if (isset($_POST['tractis_auth_updateSettings'])) {
	        foreach ($tractis_auth_settings as $setting => $value) {
	            if (isset($_POST[$setting])) {
	                // @TODO: Check if wordpress filter, if not filter (security check)
	                update_option($setting, $_POST[$setting]);
	                $tractis_auth_settings[$setting] = $_POST[$setting];
	            }
	        }
	        
	        if (!$_POST['tractis_auth_api_key'] || $_POST['tractis_auth_api_key'] == "") {
	        	$message = "Settings Updated. (Warning, the api key must be filled to work LINK A LA HELP)";
	        } else {
	        	$message = "Settings Updated.";
	        }
	    }
	    require_once (TRACTIS_AUTH_PLUGIN_VIEWS . '/ui_settings.php'); 	
	 }
 	 
 	 function insert_css() {
		$css_url = TRACTIS_AUTH_PLUGIN_CSS . "/tractis_auth.css?ver=" . TRACTIS_AUTH_PLUGIN_REVISION;
		echo '<link rel="stylesheet" type="text/css" href="'.clean_url($css_url).'" />'; 	
 	 } 	 
 }
?>