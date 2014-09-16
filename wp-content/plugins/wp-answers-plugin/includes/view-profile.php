<?php
/**
 * Handles "view profile" page
 */

if(!empty($_GET['profile'])) {
    $user_login = $_GET['profile'];
    $user_info = get_user_by('login', $user_login);
    
    // not found - redirect to home
    if($user_info === false) {
        wp_safe_redirect(get_bloginfo('url'));
        exit;
    }
    global $_user_data, $_user_meta;
    $_user_data = $user_info;
    $_user_meta = get_user_meta($user_info->ID);
    // for some weird reason load_template breaks with lots of errors, causing default template to be 
    // displayed at the end. F*ck it, include the get_template_part in index.php for profile page.
}