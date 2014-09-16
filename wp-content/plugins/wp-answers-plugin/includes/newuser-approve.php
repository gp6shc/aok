<?php 
class WPANSWER_USER_APPROVE{
    var $admin_init;
    var $user_registration_obj;

    function __construct()
    {
        $this->load_configs();
      
        $this->includes();
    	

        add_action('init', array(&$this, 'wpanswer_userapprove_init'), 0);
       }
       function load_configs()
    {
        include_once('classes/newuser_config.php');
        $this->configs = WPANSWER_USER_Config::get_instance();
    }
    
    function includes()
    {
      include_once('classes/newuser-login.php');
        include_once('classes/newuser-registration.php');
        
        if (is_admin()){ //Load admin side only files
            include_once('classes/newuser-configure-settings.php');
         
            include_once('admin/userapprove_display-table.php');
            
        }
        else{ 
        	//Load front end side only files
        }
    }

  

    function wpanswer_userapprove_init()
    {
        $this->user_login_obj = new WPANSWER_User_Login();//Do the user login operation tasks
        $this->user_registration_obj = new WPANSWER_User_Registration();//Do the user login operation tasks
      
    }
    
}//End of class

$GLOBALS['wpanswer_user_approve'] = new WPANSWER_USER_APPROVE();
