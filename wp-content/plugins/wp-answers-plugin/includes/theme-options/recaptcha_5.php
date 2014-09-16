<?php
/*
Recaptcha API settings
*/

echo '
To get Recaptcha private and public keys, go to <a href="https://www.google.com/recaptcha/admin">https://www.google.com/recaptcha/admin</a>
';
if(!empty($_POST['recaptcha_private_key'])) {
    update_option('recaptcha_private_key', $_POST['recaptcha_private_key']);
}
$options = array (

    array(  "name" => "Recaptcha private key",
            "desc" => "Set Recaptcha private key",
            "id" => "recaptcha_private_key",
            "type" => "text",
			"value" => "",
    ),
    
    array(  "name" => "Recaptcha public key",
            "desc" => "Set Recaptcha public key",
            "id" => "recaptcha_public_key",
            "type" => "text",
			"value" => "",
    ),
    
    array(  "name" => "Show Recaptcha in signup page",
            "desc" => "Select whether you want to display recaptcha in signup page",
            "id" => "recaptcha_signup",
            "type" => "select",
			"value" => "",
			"default_text" => 'No',    		    		"default_value" => 'false',			            "options" => array(                'Yes' => 'true',                )
    ),

    array(  "name" => "Show Recaptcha in \"submit new question\" page",
            "desc" => "Select whether you want to display recaptcha in \"submit new question\" page",
            "id" => "recaptcha_new_question",
            "type" => "select",
			"value" => "",
			"default_text" => 'No',    		    		"default_value" => 'false',			            "options" => array(                'Yes' => 'true',                )
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

?>