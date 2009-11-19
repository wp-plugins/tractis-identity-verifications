<?php
/*
 * Tractis Identity Verifications
 * User interface functions
 */
 
 class tractis_ui {
 	
	 function show_admin_options() {
		global $tractis_auth_settings;
		
		$message = "";
		
		// Check for openssl extension enabled in PHP
		if (!extension_loaded('openssl')) {
			$message .= __("Problem: Your PHP installation doesn't have the openssl module enabled. Is required for communicate with Tractis in https (secure mode), see the <a href='http://php.net/manual/en/book.openssl.php'>php manual</a> to get more info.", "tractis_auth")."<br /><br />";
		}
		
		// Review default role on user creation to show a warning to the blog-admin
		$default_role = get_option('default_role');
		
		if ($default_role != "subscriber")
		{
			$message .= __("Warning: The default role for new users in your WordPress config is: ", "tractis_auth").$default_role."<br /><br />"; 
			$message .= __("Set your blog's default role for users to \"subscriber\" (Settings->New User Default Role) unless you want identifed users to publish and/or manage content. Read more about roles <a href='http://codex.wordpress.org/Roles_and_Capabilities'>here</a>.", "tractis_auth")."<br />";
		}	
		
	    if (isset($_POST['tractis_auth_updateSettings'])) {
	        foreach ($tractis_auth_settings as $setting => $value) {
	            if (isset($_POST[$setting])) {
	                // @TODO: Check if wordpress filter, if not filter (security check)
	                update_option($setting, $_POST[$setting]);
	                $tractis_auth_settings[$setting] = $_POST[$setting];
	            }
	        }
	        
	        if (!$_POST['tractis_auth_api_key'] || $_POST['tractis_auth_api_key'] == "") {
	        	$message .= __("Settings Updated. (Warning, the api key must be filled to work)", "tractis_auth");
	        } else {
	        	$message .= __("Settings Updated.", "tractis_auth");
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