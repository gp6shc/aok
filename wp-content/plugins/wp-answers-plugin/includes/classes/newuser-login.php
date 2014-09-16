<?php
class WPANSWER_User_Login
{
    function __construct() 
    {
      
        remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
        add_filter('authenticate', array(&$this, 'wpanswer_auth_login'), 10, 3);
     }

    function wpanswer_auth_login($user, $username, $password)
    {
    	
        global $wpdb, $wpanswer_user_approve;
   
        if ( is_a($user, 'WP_User') ) { return $user; } //Existing WP core code
       
        $userdata = get_user_by('login',$username);
        if (!$userdata) 
        {
               return new WP_Error('invalid_username', __('<strong>ERROR</strong>: Invalid username.', 'wpanswer'));
            
	   }
        
        $userdata = apply_filters('wp_authenticate_user', $userdata, $password); //Existing WP core code
        if ( is_wp_error($userdata) ) { //Existing WP core code
                return $userdata;
        }

        if ( !wp_check_password($password, $userdata->user_pass, $userdata->ID) ) 
        {
           
           
                return new WP_Error('incorrect_password', sprintf(__('<strong>ERROR</strong>: Incorrect password. <a href="%s" title="Password Lost and Found">Lost your password</a>?', 'wpanswer'), site_url('wp-login.php?action=lostpassword', 'login')));
            
        }
        
        //Check if auto pending new account status feature is enabled
        if ($wpanswer_user_approve->configs->get_value('wpanswer_enable_manual_registration_approval') == '1')
        {
                $cap_key_name = $wpdb->prefix.'capabilities';
                $user_meta_info = get_user_meta($userdata->ID, 'wpanswer_account_status', TRUE);
                if ($user_meta_info == 'pending'){
                   
                    return new WP_Error('authentication_failed', __('<strong>ACCOUNT PENDING</strong>: Your account is currently not active. An administrator needs to activate your account before you can login.', 'wpanswer'));
                }
        }
        $user =  new WP_User($userdata->ID);
        return $user;
    }

}