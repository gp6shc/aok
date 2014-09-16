<?php
class WPANSWER_User_Registration
{

    function __construct() 
    {
        add_action('user_register', array(&$this, 'wpanswer_user_registration_action_handler'));
     
    }
   
    function wpanswer_user_registration_action_handler($user_id)
    {
        global $wpdb, $wpanswer_user_approve;
       
        
        if ($wpanswer_user_approve->configs->get_value('wpanswer_enable_manual_registration_approval') == '1')
        {
            $res = add_user_meta($user_id, 'wpanswer_account_status', 'pending');
            
        }
    }

}
