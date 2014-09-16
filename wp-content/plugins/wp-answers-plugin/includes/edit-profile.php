<?php
/**
 * Handle edit profile page (form)
 */

if(!is_user_logged_in()) return;

if(!empty($_POST['editprofile']) && $_POST['editprofile'] == '1' && !empty($_POST['current_user'])) {
    
    // security check - updating own profile
    $user = wp_get_current_user();
    $userID = $user->ID;
    if($userID == $_POST['current_user']) {
        $userdata = array();
        $userdata['ID'] = $userID;
        $userdata['user_login'] = $_POST['username'];
        $userdata['user_email'] = $_POST['email'];
        $userdata['user_url'] = $_POST['url'];
        
        if(!empty($_POST['pass1']) && !empty($_POST['pass2']) && $_POST['pass1'] == $_POST['pass2']) {
            $userdata['user_pass'] = $_POST['pass1'];
        }
        $id = wp_update_user($userdata);
        // when user updates password, WP clears authorization cookie
        wp_set_auth_cookie($id, true, false);
        wp_set_current_user($id);
        
        if($id == $userID) {
            // update user meta values
            if(!empty($_POST['location'])) {
                $location = strip_tags($_POST['location']);
                update_user_meta($userID, 'location', $location);
            }
            if(!empty($_POST['occupation'])) {
                $occupation = strip_tags($_POST['occupation']);
                update_user_meta($userID, 'occupation', $occupation);
            }
            if(!empty($_POST['interests'])) {
                $interests = strip_tags($_POST['interests']);
                update_user_meta($userID, 'interests', $interests);
            }
            
            // handle avatar
            if(!empty($_FILES['avatar']) && $_FILES['avatar']['size'] > 1) {
                $upload_dir = wp_upload_dir();
                $upload_to = $upload_dir['basedir'].'/avatars/';
                if(!is_dir($upload_to)) {
                    @mkdir($upload_to, 0755);
                }
                
                // Resample
                $image_p = imagecreatetruecolor(160, 160);
                $type = $_FILES['avatar']['type'];
                if(strpos($type, 'jpg') !== false || strpos($type, 'jpeg') !== false) {
                    $image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
                }
                elseif (strpos($type, 'png') !== false) {
                    $image = imagecreatefrompng($_FILES['avatar']['tmp_name']);
                }
                elseif (strpos($type, 'gif') !== false) {
                    $image = imagecreatefromgif($_FILES['avatar']['tmp_name']);
                }
                else {
                    // unsupported type
                    $_SESSION['editprofile_errors'][] = "Unsupported avatar image type. Supported types: jpeg, png, gif";
                    return;
                }
                list($width, $height) = getimagesize($_FILES['avatar']['tmp_name']);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, 160, 160, $width, $height);

                // get latest userdata (after update)
                $user = wp_get_current_user();
                // store avatar
                $avatar_name = strtolower($user->user_login).'.avatar.jpg';
                if(is_file($upload_to.$avatar_name)) {
                    unlink($upload_to.$avatar_name);
                }
                imagejpeg($image_p, $upload_to . $avatar_name, 100);
                update_user_meta($userID, 'avatar', $avatar_name);
            }
            wp_safe_redirect($_POST['redirect_to']);
            exit;
        }
        
    }
    
}