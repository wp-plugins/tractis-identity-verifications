<?php
/*
 Plugin Name: Tractis Identity Verifications
 Plugin URI: http://wordpress.org/extend/plugins/tractis-identity-verifications/
 Description: Allow your users to proof their real identity in your blog. Your users will be able to identify in your blog using their electronic ID and they will show their verified identity in their comments.
 Author: Tractis
 Author URI: https://www.tractis.com/identity_verifications
 Version: 1.4.3
 License: MIT
 */

// Includes
 
set_include_path( dirname(__FILE__) . PATH_SEPARATOR . dirname(__FILE__).'/inc' . PATH_SEPARATOR . get_include_path() );

require_once('tractis_ui.php');
require_once('tractis_user.php');
require_once('tractis_model.php');
require_once('tractis_wigdet.php');
require_once('tractis_comment.php');
require_once('httplib.php');
 
restore_include_path();

@session_start();

// Constants definition

if (! defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');

if (! defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');

if (! defined('WP_PLUGIN_DIR'))
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

if (! defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');

define ('TRACTIS_AUTH_PLUGIN_BASENAME', basename(plugin_basename(dirname(__FILE__))));
define ('TRACTIS_AUTH_PLUGIN_PATH', WP_PLUGIN_DIR."/".TRACTIS_AUTH_PLUGIN_BASENAME);
define ('TRACTIS_AUTH_PLUGIN_URL', WP_PLUGIN_URL."/".TRACTIS_AUTH_PLUGIN_BASENAME);
define ('TRACTIS_AUTH_PLUGIN_LANG', TRACTIS_AUTH_PLUGIN_BASENAME."/lang");
define ('TRACTIS_AUTH_PLUGIN_IMAGES', TRACTIS_AUTH_PLUGIN_URL."/images");
define ('TRACTIS_AUTH_PLUGIN_CSS', TRACTIS_AUTH_PLUGIN_URL."/css");
define ('TRACTIS_AUTH_PLUGIN_VIEWS', TRACTIS_AUTH_PLUGIN_PATH."/views");
define ('TRACTIS_AUTH_PLUGIN_REVISION', '1.4.3');

// Main class 

if (!class_exists("tractis_auth"))
{
    class tractis_auth {
    	var $ui;
    	var $available_settings = array(
			'tractis_auth_auto_aprove_comments' => 'false', 
			'tractis_auth_api_key'				=> '',
			'tractis_auth_button'				=> 'trac_but_bg_lrg_b_es.png',
		);
		var $available_widget_settings = array(
			'tractis_auth_widget_show_help' => 'default',
			'tractis_auth_widget_button_size' => 'medium', 
		);
        var $check_url = "https://www.tractis.com/data_verification";
        var $check_params = array(
            'tractis:attribute:name',
			'tractis:attribute:dni',
			'tractis:attribute:issuer',
			'token',
			'verification_code',
			'verification_url',
        );
    		
    	// Constructor
    	function tractis_auth() {
    		global $tractis_user;
    		$this->ui = new tractis_ui();
    		$this->settings = $this->get_settings();
    	}
    	
    	// Load internalization
		function set_textdomain() {
			load_plugin_textdomain('tractis_auth', PLUGINDIR ."/".TRACTIS_AUTH_PLUGIN_LANG);
		}   
		
		function get_settings() {
			global $tractis_auth_settings;
			global $tractis_auth_widget_settings;
			
			// Global Settings
			foreach ($this->available_settings as $setting => $default_value) {
				if ($value = get_option($setting)) {
					$tractis_auth_settings[$setting] = $value;
				} else {
					$tractis_auth_settings[$setting] = $default_value;
				}
			}
			
			// Widget Settings
			foreach ($this->available_widget_settings as $setting => $default_value) {
				if ($value = get_option($setting)) {
					$tractis_auth_widget_settings[$setting] = $value;
				} else {
					$tractis_auth_widget_settings[$setting] = $default_value;
				}
			}			
		}
			
		function show_settings() {
			// TODO: Internationalize plugin settings name
			add_options_page('Tractis Identity Verifications', 'Tractis Identity Verifications', 9, basename(__FILE__), array(&$this->ui, 'show_admin_options'));
		}	

		/**
		 * Called on plugin activation.
		 *
		 * Add the columns needed to the wordpress tables
		 */
		function activate_plugin() {
			$model = new tractis_model();
			$model->create_tables();
		}
	
		/**
		 * Called on plugin deactivation.  Cleanup tables.
		 *
		 * @see register_deactivation_hook
		 */
		function deactivate_plugin() {
			//@TODO: On deactivate cleanup tables ????
			// Make this as preference default NO
	    }
	    
		/**
		 * Link for setting in plugin list page
		 */
		function add_plugin_action_settings($links, $file) {
			if ($file == plugin_basename(dirname(__FILE__).'/tractis_auth.php')) {
				$settings_link[] = "<a href='options-general.php?page=tractis_auth.php'><b>" . __('Settings', 'tractis_auth') . "</b></a>";
				$links = array_merge($settings_link, $links);
			}
			return $links;
		} 	  
	    
	    function register_widget() {
			if (!function_exists('register_sidebar_widget')) return;		
			global $tracis_auth_widget;
			
			$tracis_auth_widget = new tractis_widget();
			
			function widget_TractisAuth() {
				global $tracis_auth_widget;
				
				$tracis_auth_widget->show(array());			
			}
						
			register_sidebar_widget('Tractis Identity Verifications', array(&$tracis_auth_widget, 'show'));
	    }
	    
	    function check_auth() {
	    	global $tractis_user;
	    	
	    	if (!is_user_logged_in()) {
                $params = array();
                $from_auth = true;
                foreach ($this->check_params as $getParams) {
                    if (!$_GET[$getParams]) {
                        $from_auth = false;
                    }
                    else {
                        $params[$getParams] = $_GET[$getParams];
                    }
                } 
                
                if ($from_auth == true && $this->check_auth_response($params))
                {
                    $tractis_user = new tractis_user($params);
                    $tractis_user->login();
                }                          	    		
	    	}	
	    }
	    
        function check_auth_response($params = array())
        {
            global $tractis_auth_settings;
            
            $httpclient = new HTTPRequest($this->check_url);
            // Add Api key to response
            $params['api_key'] = $tractis_auth_settings['tractis_auth_api_key'];
            $res = $httpclient->Post($params, true);

            if ($res['http']['code'] == 200 && $res['body'] == $params['verification_code']) {
                return true;
            }
            else {
                return false;
            }
        }
        	    
		function get_comment_author_url($url){
			global $comment;
			
			if (isset($comment->tractis_auth_user) && $comment->tractis_auth_user != "" && $comment->tractis_auth_user != "0"){
				return get_usermeta($comment->user_id,'verification_url');			
			}
			return $url;
		}    
		    
		function get_comment_author_link($html) {
			global $comment;
			
			if (isset($comment->tractis_auth_user) && $comment->tractis_auth_user != "" && $comment->tractis_auth_user != "0"){ 
				$html = '<img src="'.TRACTIS_AUTH_PLUGIN_IMAGES.'/tractis_icon_16x16.png" />'.$html;
			}
			return $html;	
		}	
		
		function set_comment_tractis($comment_ID) {
			global $tractis_user;
			
			$tractis_user = new tractis_user();
			if (is_user_logged_in() && $tractis_user->initialize()) {
				$tractis_comment = new tractis_comment();
				$comment = $tractis_comment->set($comment_ID, $tractis_user->get_user_login());				
			}
		}
		
		function pre_comment_approved($approved) {			
			$tractis_user = new tractis_user();
			$auto_aprove = get_option('tractis_auth_auto_aprove_comments');

			if ($auto_aprove == "true" && $tractis_user->is_tractis_user()) {
				$res = 1;				
			} else {
				$res = $approved;
			}
			return $res;
		}		
		
		function show_user_profile() {
			if (!$this->is_user_admin()) {
				require_once(TRACTIS_AUTH_PLUGIN_VIEWS . '/edit_wp_profile.php');
			}
		}
		
		function personal_options_update() {
			if (!$this->is_user_admin()) {
				$disabled_fields = array (
					'display_name', 'pass1', 'pass2', 'first_name', 'last_name', 'nickname'
				);
				foreach ($disabled_fields as $field) {
					if ($_POST[$field]) {
						unset($GLOBALS['_POST'][$field]);
					}
				}
			}	
		}
		
		function is_user_admin() {
			$user = wp_get_current_user();
			$capabilities = $user->wp_capabilities;		
			
			if(!$capabilities['administrator']) {
				return false;
			} else {
				return true;
			}	
		}		
    }	    
}
// Create main instance
if (class_exists("tractis_auth")) {
    $tractis_auth = new tractis_auth();
    $tractis_auth->tractis_auth();
}

// Hooks

	// Register action in order to install/deinstall plugin database changes on activation/deactivation hoowk
	register_activation_hook(TRACTIS_AUTH_PLUGIN_BASENAME.'/tractis_auth.php', array(&$tractis_auth, 'activate_plugin'));
	register_deactivation_hook(TRACTIS_AUTH_PLUGIN_BASENAME.'/tractis_auth.php', array(&$tractis_auth, 'deactivate_plugin'));

    // Register Admin Page Settings (showed in the admin menu)
    add_action('admin_menu', array(&$tractis_auth, 'show_settings'));
    
    // Register the main widget
    add_action('plugins_loaded', array(&$tractis_auth, 'register_widget'));
    
    // include tractis_auth stylesheet
	add_action( 'wp_head', array(&$tractis_auth->ui, 'insert_css'));

	// Load internalization
	add_action('init', array(&$tractis_auth,'set_textdomain'), 100);
		
	// Check if returned from tractis for auth and auth process
	add_action('init', array(&$tractis_auth,'check_auth'), 101);
	
	// Change the autor url and content if tractis comment enabled
	add_filter('get_comment_author_url', array(&$tractis_auth, 'get_comment_author_url'));
	add_filter('get_comment_author_link', array(&$tractis_auth, 'get_comment_author_link'));
	
	// Mark tractis-auth comments
	add_action('comment_post', array(&$tractis_auth, 'set_comment_tractis'), 5);
	
	// If setting enabled, autoaprove comments with tractis-auth
	add_filter('pre_comment_approved', array(&$tractis_auth, 'pre_comment_approved'));
	
	// Prevent the tractis-auth-users change the Display Name and the password
	// Client Side (disabled by javascript)
	add_action('show_user_profile', array(&$tractis_auth, 'show_user_profile'));
	// Server Side (Recheck on Post for security)
	add_action('personal_options_update',array(&$tractis_auth, 'personal_options_update'),1);
	
	// Register Plugin action for the settings in the plugin list
	add_filter('plugin_action_links', array(&$tractis_auth, 'add_plugin_action_settings'), -10, 2);
	
?>