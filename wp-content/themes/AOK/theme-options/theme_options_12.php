<?php
$options = array (


    array(  "name" => "Text logo or image",
            "desc" => "Choose between image or text logo",
            "id" => "logo_type",
            "type" => "select",
			"value" => "",
			"default_text" => 'Image',
			"default_value" => 'image',
            "options" => array(
                'Text' => 'text',
                )
    ),
    
    array(  "name" => "Text logo content",
            "desc" => "Put your logo text here",
            "id" => "logo_text",
            "type" => "text",
			"value" => "Company name",
     ),
    
    array(  "name" => "Logo Image",
            "desc" => "Upload your image, Preferred size: 214px x 45px",
            "id" => "logo",
            "type" => "image",
            "value" => "Upload Your Logo",
            "url" => get_template_directory_uri()."/img/logo.png"
    ),
    
    array(  "name" => "Footer Logo Image",
            "desc" => "Upload your footer image, Preferred size: 130px x 46px",
            "id" => "footerLogo",
            "type" => "image",
            "value" => "Upload Your Footer Logo",
            "url" => get_template_directory_uri()."/img/logo-footer.png"
    ),
    
    
    array(  "name" => "Footer text",
            "desc" => "Add your footer text",
            "id" => "footer_text",
            "type" => "textarea",
            "value" => "Footer text",
    ),
    
    array(  "name" => "Footer scripts",
            "desc" => "Add your footer scripts",
            "id" => "footer_scripts",
            "type" => "textarea",
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