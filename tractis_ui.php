<?php
/*
 * Tractis Identity Verifications
 * User interface functions
 */
 
 class tractis_ui {
 	
	 function show_admin_options() {
		global $tractis_auth_settings;
		
		$message = "";

		// Review default role on user creation to show a warning to the blog-admin
		$default_role = get_option('default_role');
		
		if ($default_role != "subscriber")
		{
			$message .= __("Warning: The default role for new users in your Wordpress config is: ", "tractis_auth").$default_role."<br /><br />"; 
			$message .= __(" * We recommend that you use the suscriber role or other with read permissions (Settings->New User Default Role), <a href='http://codex.wordpress.org/Roles_and_Capabilities'>read more here</a>.", "tractis_auth")."<br />";
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
	        	$message .= __("Settings Updated. (Warning, the api key must be filled to work LINK A LA HELP)", "tractis_auth");
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