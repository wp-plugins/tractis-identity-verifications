<?php 
	global $tractis_auth_widget_settings;
	global $tractis_auth_settings;
	
	if (!$is_tractis_user) {
?>
<!-- Tractis Identity Verifications Connect Button -->
<form action="https://www.tractis.com/verifications" method="post">
	<input id="api_key" name="api_key" type="hidden" value="<?php echo $tractis_auth_settings['tractis_auth_api_key']; ?>" />
	<input id="notification_callback" name="notification_callback" type="hidden" value="<?php echo (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>" />	
	<input id="public_verification" name="public_verification" type="hidden" value="true" />
	<input type="image" src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES.'/'.$tractis_auth_settings['tractis_auth_button']; ?>" name="tractis_icon">
</form>
<!-- /Tractis Identity Verifications Connect Button -->
<?php } ?>