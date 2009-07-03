<?php
/*
 * Tractis Identity Verifications
 * Comments functions
 */

 class tractis_comment {
	var $model;
	
	function tractis_comment() {
		$this->model = new tractis_model();	
	}
	
	function get($id) {
		global $wpdb;
		
		$comments = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->comments wpcomments, $wpdb->posts posts WHERE wpcomments.comment_post_ID=posts.ID AND wpcomments.comment_ID = %s", $id));
		if ($comments != ""){
			return $comments[0];			
		}
	}
	
	function set($comment_ID,$tractis_user = 0) {
		global $wpdb;
		
		$comments_table = $this->model->get_comments_table_name();
		
		$wpdb->query("UPDATE $comments_table SET tractis_auth_user='".$tractis_user."' WHERE comment_ID='$comment_ID' LIMIT 1");
	}	
 }
?>