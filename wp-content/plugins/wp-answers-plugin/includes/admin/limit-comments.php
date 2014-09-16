<?php

/* Limit Number of Responses */

global $wpdb;

	define('LIMIT_RESPONSES_DIR', WP_PLUGIN_DIR . '/' . "wp-answers-plugin/");
	
/* Limit the no. of comments as specified by the Admin */
	

    function limit_responses_mod($posts) {
    
    $i = 0;
    foreach ($posts as $post_info) {
      
     
      $get_limit4comment = get_option("limit_comments_{$post_info->ID}");
      
      $get_master_limit_comment = get_option("limit_comments_master");
      
      if($get_master_limit_comment>0)
      {
      if ($get_limit4comment === FALSE || $get_limit4comment < 1) {
      
     
      if (($posts[$i]->comment_count >= $get_master_limit_comment) && ($get_master_limit_comment !== FALSE || $get_master_limit_comment > 0)) {
        $posts[$i]->comment_status = 'closed';
      
        }
      }
       }
        elseif($posts[$i]->comment_count < $get_limit4comment) {
        	
       
        }
        elseif($posts[$i]->comment_count >= $get_limit4comment) {
        
        }
        else {
        	$posts[$i]->comment_status = 'open';
        
        }
        
           $i++;
         
        return $posts;
      
      }
   
    
    }        
      

        
/* Add meta box for Edit post panel */

    function limit_responses_add_custom_box() {
      if (!empty($_GET['post'])) {
      add_meta_box('limit_comments_meta_box', 'Limit Comments', 'limit_comments_meta_box_show', 'post', 'normal', 'high');
      }
    }
  


/* Capture Post Data */

    function limit_responses_save_postdata($post_id) {
      
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { 
      # echo ("doing autosave");
      return;
      }
      
      }
      
add_filter('the_posts', 'limit_responses_mod', 1, 1);
add_action('add_meta_boxes', 'limit_responses_add_custom_box');
add_action('admin_init', 'limit_responses_add_custom_box', 1);
add_action('save_post', 'limit_responses_save_postdata');

?>