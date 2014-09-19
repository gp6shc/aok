   <script type="text/javascript">
jQuery(document).ready(function(){
	
	jQuery('#userreg').submit(function(event){
		jQuery( ".wpaRecaptchaError" ).remove();
				var invalid=false;
				var username = jQuery('#user_name').val();
				var email = jQuery('#user_email').val();
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				
				var password = jQuery('#pass1').val();
				if (username == '') {
					var userNameErrorHTML='<br class="wpaRecaptchaError"><span class="wpaRecaptchaError" style="color:red;">*Required</span>';
					jQuery('#user_name').parent().append(userNameErrorHTML);
					invalid=true;
				}
				if (email == '') {
					var userEmailErrorHTML='<br class="wpaRecaptchaError"><span class="wpaRecaptchaError" style="color:red;">*Required</span>';
					jQuery('#user_email').parent().append(userEmailErrorHTML);
					invalid=true;
				}

				if(!emailReg.test(email)) {

					var userEmailErrorHTML='<br class="wpaRecaptchaError"><span class="wpaRecaptchaError" style="color:red;">*Invalid Email ID</span>';
					jQuery('#user_email').parent().append(userEmailErrorHTML);
					
		            invalid=true;
			          
		        }
				if (password == '') {
					var userPasswordErrorHTML='<br class="wpaRecaptchaError"><span class="wpaRecaptchaError" style="color:red;">*Required</span>';
					jQuery('#pass1').parent().append(userPasswordErrorHTML);
					invalid=true;
				}
				
				if(invalid){
					event.preventDefault();
				}
			
		
	});
});
</script>
<?php

/**
 * Signup form, for use in other templates (not widget)
 */

if ( get_option('users_can_register') == false ) {
	
	return;
}

echo '<p>'; _e('Signup for an account and start participating in our site today!','wp-answers'); echo '</p>';

?>
<div class="errors">
<?php 
if(!empty($_SESSION['_errors'])) {
    echo implode('<br/>', $_SESSION['_errors']);
    unset($_SESSION['_errors']);
}
?>
</div>

<form name="userinfo" class="userinfo" id="userreg" method="POST" action="<?php echo get_option('home')."/?page_id=".get_option('thankyou_id').'/?l=sf'; ?>">

<p>
<label class="formlabel"><?php _e('Username:','wp-answers') ?></label><br />
    <input name="log" size="30" maxlength="140" id="user_name" placeholder="Username" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Email:','wp-answers') ?></label><br />
    <input name="email" size="30" maxlength="140" id="user_email" placeholder="your@email.here" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Password:','wp-answers') ?></label><br />
<input name="pass" type="password" id="pass1" />
</p>

<p>
<input type="hidden" name="signup" value="1" />
<input type="hidden" name="redirect_to" value="<?php echo get_permalink(get_the_id()); ?>" />
<?php
global $up_options;
if($up_options->recaptcha_signup == 'true' && !empty($up_options->recaptcha_public_key) && !empty($up_options->recaptcha_private_key)) {
    global $error, $publickey;
    echo '<div id="recaptcha">'.recaptcha_get_html($up_options->recaptcha_public_key, $_SESSION['recaptcha_error']).'</div>';
    if(isset($_SESSION['recaptcha_error'])) {
        unset($_SESSION['recaptcha_error']);
    }
    echo '<input type="hidden" name="post_recaptcha" value="1">';
}
?>

<input type="submit" name="Submit" value="Signup &raquo;" class="loginbutton white" />
</p>
</form>

<h2 class="formtitle"><?php _e('Social Signup','wp-answers') ?></h2>

<p><?php _e('You can also login with your Facebook or Twitter account','wp-answers') ?></p>

<a href="<?php echo get_option('home').'/?l=tw';?>"><img src="<?php echo get_template_directory_uri() .'/img/twitter-button.png'; ?>" width="133" height="24" class="twitterbutton"/></a>
<div id="fbconnect">
    <fb:login-button scope="offline_access,publish_stream" onlogin="location.href='<?php echo get_option('home').'/?l=fb'; ?>';">Log in with Facebook</fb:login-button>
</div>