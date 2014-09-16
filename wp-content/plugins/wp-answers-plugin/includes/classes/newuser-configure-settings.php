<?php

class WPANSWER_Configure_Settings
{    
    function __construct(){
        
    }
    
    static function set_default_settings()
    {
        global $wpanswer_user_approve;
        
        //User registration
        $wpanswer_user_approve->configs->set_value('wpanswer_enable_manual_registration_approval','');//Checkbox
     
        $wpanswer_user_approve->configs->save_config();
    }
 
}
