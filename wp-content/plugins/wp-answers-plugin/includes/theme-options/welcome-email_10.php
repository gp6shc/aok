<?php
/**
* Custom welcome email text
*/

if(!empty($_POST['welcome_email'])) {
    update_option('welcome_email_text', $_POST['welcome_email']);
}

$options = array (

    array(  "name" => "Welcome email text",
            "desc" => "Customize your welcome email text. Use the following codes :<br/>
{%username%}<br/>
{%sitename%}<br/>
{%password%}<br/>
",
            "id" => "welcome_email",
            "type" => "textarea",
			"value" => "{%username%}

Welcome to {%sitename%},

Your username is, {%username%} and your password is {%password%},

Regards, {%sitename%}
			",
			
    ),
    
    
     
);


/* ------------ Do not edit below this line ----------- */

//Check if theme options set
global $default_check;
global $default_options;

if(!$default_check):
    foreach($options as $option):
        if($option['type'] != 'image'):
            $default_options[$option['id']] = $option['value'];
        else:
            $default_options[$option['id']] = $option['url'];
        endif;
    endforeach;
    $update_option = get_option('up_themes_'.UPTHEMES_SHORT_NAME);
    if(is_array($update_option)):
        $update_option = array_merge($update_option, $default_options);
        update_option('up_themes_'.UPTHEMES_SHORT_NAME, $update_option);
    else:
        update_option('up_themes_'.UPTHEMES_SHORT_NAME, $default_options);
    endif;
endif;

render_options($options); 