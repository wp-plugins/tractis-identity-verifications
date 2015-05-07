<?php
/*
 * Tractis Identity Verifications
 * User integrate functions
 */

 class tractis_user {
		
		var $prefix = 'tractis_';
		var $default_url = 'http://www.tractis.com';
		var $user_login;
		var $user_pass;
		var $user_nicename;
		var $display_name;
		var $user_url;
		var $issuer;
		var $verification_url;
		var $model;
		
		function tractis_user($params = array()) {
			if (!empty($params)) {
				$this->user_login = $this->prefix . hash('md5', $params['tractis:attribute:dni'].$params['tractis:attribute:name']);
				$this->user_pass = substr( md5( uniqid( microtime() ).$_SERVER["REMOTE_ADDR"] ), 0, 15);
				$this->user_nicename = $this->display_name = ucwords(strtolower($params['tractis:attribute:name']));
				$this->user_url = $this->default_url;
				$this->issuer = $params['tractis:attribute:issuer'];
				$this->verification_url = $params['verification_url'];			
			}
			$this->model = new tractis_model();
		}
		
		function initialize() {
			$user = wp_get_current_user();
			if (!$user->tractis_auth_userid || $user->tractis_auth_userid = 0 || $user->tractis_auth_userid == "") {
				// Not a tractis user
				return false;
			} else {
				$this->user_login = $user->user_login;
				$this->user_pass = $user->user_pass;
				$this->user_nicename = $user->user_nicename;
				$this->user_url = $user->user_url;
				return true;					
			}
		}
		
		function login() {
			global $wp_version;
			$self = basename( $GLOBALS['pagenow'] );
			
			$user = wp_get_current_user();
			
			if ((!is_user_logged_in() || $user->tractis_auth_userid != $this->user_login)) {
				// Tractis Logued - to - Wordpress Logued
				require_once(ABSPATH . WPINC . '/registration.php');
				//$usersinfo = fb_user_getInfo($tractis_user);
				//$wpid = "";
				$tractis_wp_user = $this->get_user($this->user_login);
				$wpid = "";
				if (!is_user_logged_in() && !$tractis_wp_user){
					$userdata = get_userdatabylogin($this->user_login);	
					if(!$userdata || $userdata == ""){
						$user_data = array();
						$user_data['user_login'] = $this->user_login;
						$user_data['user_pass'] = $this->user_pass;
						$user_data['user_nicename'] = $this->user_nicename;
						$user_data['display_name'] = $this->display_name;
						$user_data['user_url'] = $this->user_url;
						$user_data['user_email'] = $this->user_login."@".$this->user_login.".com";
						
						$wpid = wp_insert_user($user_data);
						$this->set_userid($wpid, $this->user_login);
						
						// Set the issuer in the usermeta table
						update_usermeta($wpid, "tractis_auth_issuer", $this->issuer);
						update_usermeta($wpid, "verification_url", $this->verification_url);
						update_usermeta($wpid, "first_name", $this->display_name);
					}
				}elseif(is_user_logged_in() && $user->fbconnect_userid != $this->user_login){ // El usuario WP no está asociado al de FB
					$this->set_userid($user->ID, $this->user_login);
					$wpid = $user->ID;
				}else{
					$wpid = $user->ID;
				}
	
				$userdata = $this->get_user($this->user_login);
				
				$this->set_lastlogin($userdata->ID);
				
				global $current_user;
				$current_user = null;

				$this->set_tractis_current_user($userdata);

				global $userdata;
				
				if (isset($userdata) && $userdata != "") {
					$userdata->tractis_auth_userid = $this->user_login;
				}
			}						
		}

		/**
		 * Get user by Tractis id
		 *
		 */
		function get_user($id) {
			global $wpdb;
			
			$users_table = $this->model->get_users_table_name();
			
			$users = $wpdb->get_results("SELECT * FROM $users_table WHERE tractis_auth_userid = '$id'");
			if (count($users)>0){
				return $users[0];
			}else{
				return null;
			}
		}
		
		/**
		 * Get user by Wordpress id
		 *
		 */		
		function get_user_by_id($id) {
			global $wpdb;

			$users_table = $this->model->get_users_table_name();
			$usermeta_table = $this->model->get_usermeta_table_name();
			
			$users = $wpdb->get_results("SELECT * FROM $users_table WHERE ID = $id");
			
			if (count($users)>0){
				$issuer = get_usermeta($id,'tractis_auth_issuer');
				$verification_url = get_usermeta($id,'verification_url');
				return array(
					'user' => $users[0], 
					'issuer' => $issuer,
					'verification_url' => $verification_url,
				);
			}else{
				return null;
			}
		}
		
		function is_tractis_user() {
			if (is_user_logged_in()) {
				$user = wp_get_current_user();

				if ($user->tractis_auth_userid == "0" || $user->tractis_auth_userid == "") {
					// Not a tractis user
					return false;
				} else {
					return true;					
				}				
			}			
		}
		
		function set_userid($id,$tractis_user_id) {
			global $wpdb;

			$users_table = $this->model->get_users_table_name();			

			$wpdb->query("UPDATE $users_table SET tractis_auth_userid='".$tractis_user_id."' WHERE ID=$id LIMIT 1");
		}
	
		function set_lastlogin($id) {
			global $wpdb;
			
			$users_table = $this->model->get_users_table_name();
			
			$wpdb->query("UPDATE $users_table SET tractis_auth_lastlogin=".date("U")." WHERE ID=$id LIMIT 1");
		}
		
		function set_tractis_current_user($userdata, $remember = true) {
			$user = set_current_user($userdata->ID);
				
			if (function_exists('wp_set_auth_cookie')) {
				wp_set_auth_cookie($userdata->ID, $remember);
			} else {
				wp_setcookie($userdata->user_login, md5($userdata->user_pass), true, '', '', $remember);
			}
		}	
		
		function get_user_login() {
			return $this->user_login;
		}				
 }
