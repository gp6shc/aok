<?php
/*
Twitter API settings
*/

echo '
To allow twitter Logins, follow these steps :<br/><br/>

<ol>
<li><a href="http://dev.twitter.com/apps/new">Create a Twitter App</a></li>
<li>Fill Out Application details with URL to your WP-Answers site</li>
<li>Callback url should be your WP-Answers url</li>
<li>Copy Consumer Key and Consumer Secret and add below</li>
<li>Click "Create my Access Token"</li>
<li>Enter Access Token and Access Token Secret below</li>
</ol>
';

$options = array (

    array(  "name" => "Consumer Key",
            "desc" => "Set Twitter Consumer Key",
            "id" => "twitter_consumer_key",
            "type" => "text",
			"value" => "",
    ),
    
    array(  "name" => "Consumer Secret",
            "desc" => "Set Twitter Consumer Secret",
            "id" => "twitter_consumer_secret",
            "type" => "text",
			"value" => "",
    ),
    
    array(  "name" => "Access Token",
            "desc" => "Set Twitter Access Token",
            "id" => "twitter_access_token",
            "type" => "text",
			"value" => "",
    ),
    
    array(  "name" => "Access Token Secret",
            "desc" => "Set Twitter Access Token Secret",
            "id" => "twitter_access_token_secret",
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