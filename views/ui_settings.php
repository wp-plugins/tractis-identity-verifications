<!-- Tractis Identity Verifications settings user interface -->

<?php 
	global $tractis_auth_settings;
	if ($message) { 
?>
	<div class="updated"><p><strong><?php _e($message, "tractis_auth"); ?></strong></p></div>
<?php } ?>

<div class=wrap>
    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
        <h2><?php _e("Tractis Identity Verifications Settings", "tractis_auth"); ?></h2>

        <h3><?php _e("Plugin setup", "tractis_auth"); ?></h3>
        
        <table class="form-table">
          <tr valign="top">
            <th scope="row">
              <label for="tractis_api_key"><?php _e("Tractis API Key", "tractis_auth"); ?></label>
            </th>
            <td>
              <input type="text" id="tractis_api_key" name="tractis_auth_api_key" value="<?php echo $tractis_auth_settings['tractis_auth_api_key']; ?>" size="40" />
              <span class="setting-description"><a href="https://www.tractis.com/identity_verifications"><?php _e("Get your API Key from Tractis", "tractis_auth"); ?></a></span>
            </td>
            </tr>
        </table>

        <table class="form-table">
          <tr valign="top">
            <th scope="row"><?php _e("Plugin Button", "tractis_auth"); ?></th>
            <td><fieldset><legend class="hidden"><?php _e("Tractis Plugin Button", "tractis_auth"); ?></legend>
              <label for="tractis_auth_button_1"><input type="radio" id="tractis_auth_button_1" name="tractis_auth_button" value="trac_but_bg_lrg_b_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_bg_lrg_b_es.png') { echo 'checked'; }?> /> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_bg_lrg_b_es.png" width="195" height="27" alt="Tractis Button B ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_2" style="padding-top: 5px; display: block"><input type="radio" id="tractis_auth_button_2" name="tractis_auth_button" value="trac_but_bg_lrg_w_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_bg_lrg_w_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_bg_lrg_w_es.png" width="195" height="27" alt="Tractis Button W ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_5"><input type="radio" id="tractis_auth_button_5" name="tractis_auth_button" value="trac_but_sm_lrg_b_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_sm_lrg_b_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_sm_lrg_b_es.png" alt="Tractis Button B ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_6" style="padding-top: 5px; display: block"><input type="radio" id="tractis_auth_button_6" name="tractis_auth_button" value="trac_but_sm_lrg_w_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_sm_lrg_w_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_sm_lrg_w_es.png" alt="Tractis Button W ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_3"><input type="radio" id="tractis_auth_button_3" name="tractis_auth_button" value="trac_but_bg_shrt_b_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_bg_shrt_b_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_bg_shrt_b_es.png" alt="Tractis Button B ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_4" style="padding-top: 5px; display: block"><input type="radio" id="tractis_auth_button_4" name="tractis_auth_button" value="trac_but_bg_shrt_w_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_bg_shrt_w_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_bg_shrt_w_es.png" alt="Tractis Button W ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_7"><input type="radio" id="tractis_auth_button_7" name="tractis_auth_button" value="trac_but_sm_shrt_b_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_sm_shrt_b_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_sm_shrt_b_es.png" alt="Tractis Button B ES" style="vertical-align: middle" /></label>
              <br />
              <label for="tractis_auth_button_8" style="padding-top: 5px; display: block"><input type="radio" id="tractis_auth_button_8" name="tractis_auth_button" value="trac_but_sm_shrt_w_es.png" <?php if ($tractis_auth_settings['tractis_auth_button'] == 'trac_but_sm_shrt_w_es.png') { echo 'checked'; }?>/> <img src="<?php echo TRACTIS_AUTH_PLUGIN_IMAGES; ?>/trac_but_sm_shrt_w_es.png" alt="Tractis Button W ES" style="vertical-align: middle" /></label>
            </td>
          </tr>
        </table>

        <h3><?php _e("Discussion Settings", "tractis_auth"); ?></h3> 

        <table class="form-table">
          <tr valign="top">
            <th scope="row"><?php _e("Comment Aproval", "tractis_auth"); ?></th>
            <td><fieldset><legend class="hidden"><?php _e("Comment Aproval", "tractis_auth"); ?></legend>
              <label for="auto_aprove_comments_yes"><input type="radio" id="auto_aprove_comments_yes" name="tractis_auth_auto_aprove_comments" value="true" <?php if ($tractis_auth_settings['tractis_auth_auto_aprove_comments'] == 'true') { echo 'checked'; }?> /> <?php _e("Comments from users with verified identities will be aprooved automatically.", "tractis_auth"); ?></label>
              <br />
              <label for="auto_aprove_comments_no"><input type="radio" id="auto_aprove_comments_no" name="tractis_auth_auto_aprove_comments" value="false" <?php if ($tractis_auth_settings['tractis_auth_auto_aprove_comments'] == 'false') { echo 'checked'; }?>/> <?php _e("Comments from users with verified identities will require aprooval according to the blog configuration.", "tractis_auth"); ?></label></td>
            </tr>
        </table>

        <div class="submit">
            <input type="submit" name="tractis_auth_updateSettings" value="<?php _e("Update Settings", "tractis_auth") ?>" class="button-primary" />
        </div>        
        
     </form>
 </div>
 
<!-- /Tractis Identity Verifications settings user interface -->