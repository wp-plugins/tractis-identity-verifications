<?php
/*
 * Tractis Identity Verifications
 * Database functions
 */
 
 class tractis_model {
	var $comments_table_name;
	var $usermeta_table_name;
	var $users_table_name; 	
	
	/*
	 * Constructor
	 * Initialize table names
	 */
	function tractis_model()
	{
		global $wpdb;

		$table_prefix = isset($wpdb->base_prefix) ? $wpdb->base_prefix : $wpdb->prefix;

		$this->comments_table_name =  $table_prefix . 'comments';
		$this->users_table_name =  $wpdb->prefix . 'users';
		$this->usermeta_table_name = $table_prefix . 'usermeta';
	}
	
	function create_tables()
	{
		global $wp_version, $wpdb;

		if ($wp_version >= '2.3') {
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		} else {
			require_once(ABSPATH . 'wp-admin/admin-db.php');
			require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
		}

		// add column to comments table
		$result = maybe_add_column($this->comments_table_name, 'tractis_auth_user',
				"ALTER TABLE $this->comments_table_name ADD `tractis_auth_user` varchar(50) NOT NULL DEFAULT '0'");

		// add column to users table
		$result = maybe_add_column($this->users_table_name, 'tractis_auth_lastlogin',
				"ALTER TABLE $this->users_table_name ADD `tractis_auth_lastlogin` int(14) NOT NULL DEFAULT '0'");

		// add column to users table
		$result = maybe_add_column($this->users_table_name, 'tractis_auth_userid',
				"ALTER TABLE $this->users_table_name ADD `tractis_auth_userid` varchar(250) NOT NULL DEFAULT '0'");
	}	
	
	function get_users_table_name() {
		return $this->users_table_name;
	}
	
	function get_comments_table_name() {
		return $this->comments_table_name;
	}
	
	function get_usermeta_table_name() {
		return $this->usermeta_table_name;
	}
 }
?>