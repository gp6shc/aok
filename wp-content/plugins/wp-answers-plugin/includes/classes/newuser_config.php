<?php

class WPANSWER_USER_Config{
    var $configs;
    var $message_stack;
    static $_this;
   function load_config(){	
	$this->configs = get_option('wpanswer_userapprove_configs');
    }
	
    function get_value($key){
    	return isset($this->configs[$key])?$this->configs[$key] : '';    	
    }
    
    function set_value($key, $value){
    	$this->configs[$key] = $value;
    }
    
  
    function save_config(){
    	update_option('wpanswer_userapprove_configs', $this->configs);
    }

    static function get_instance(){
    	if(empty(self::$_this)){
            self::$_this = new WPANSWER_USER_Config();
            self::$_this->load_config();
            return self::$_this;
    	}
    	return self::$_this;
    }
}
