<?php
/*
 * Tractis Identity Verifications
 * Widget functions
 */
 
 class tractis_widget {
	function show($args) {
		global $tractis_auth_widget_settings;
		
		extract($args);
		
		$tractis_user = new tractis_user();
		$is_tractis_user = $tractis_user->is_tractis_user();
		
		require_once (TRACTIS_AUTH_PLUGIN_VIEWS . '/widget.php');
		
	}
 }
?>