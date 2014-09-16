<?php
/*
Facebook API settings
*/

echo '

To allow Facebook Logins, follow these steps :
<ol>
<li><a href="http://www.facebook.com/developers/createapp.php?version=new">Create a Facebook Application</a></li>
<li>Give your app a name and namespace</li>
<li>Enter your App Domain  (without http://) &amp; choose "Website with Facebook Login" and enter the URL to your WP-Answers</li>
<li>Enter your domain name</li>
<li>Click "Save Changes"</li>
<li>Copy the displayed APP ID (API Key) and Secret into this form.</li>
</ol>
';

$options = array (

    array(  "name" => "Facebook APP ID",
            "desc" => "Set Facebook APP ID / API Key",
            "id" => "facebook_app_id",
            "type" => "text",
			"value" => "",
    ),
    
    array(  "name" => "APP Secret",
            "desc" => "Set Facebook APP secret",
            "id" => "facebook_app_secret",
            "type" => "text",
			"value" => "",
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