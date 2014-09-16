<?php
/*
Template Name: Edit Profile
*/
?>
<?php get_header(); ?>
<div id="content">


<h1 class="questiontitle"><?php the_title(); ?></h1>
<?php the_post(); ?>

<?php _e('Edit your profile details','wp-answers') ?>
<?php 
global $current_user;
get_currentuserinfo();
$location = get_user_meta($current_user->ID, 'location');
$location = isset($location[0])?$location[0]:'';
$occupation = get_user_meta($current_user->ID, 'occupation');
$occupation = isset($occupation[0])?$occupation[0]:'';
$interests = get_user_meta($current_user->ID, 'interests');
$interests = isset($interests[0])?$interests[0]:'';
    
?>
<form action="<?php echo get_option('home'); ?>/?edit-profile" name="userinfo" class="userinfo" enctype="multipart/form-data" method="POST">

<p>
<label class="formlabel"><?php _e('Username:','wp-answers') ?></label><br />
<input name="username" size="30" maxlength="140" id="username" value="<?php echo $current_user->user_login;?>" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Email:','wp-answers') ?></label><br />
<input name="email" size="30" maxlength="140" id="user_email" value="<?php echo $current_user->user_email;?>" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Website:','wp-answers') ?></label><br />
<input name="url" size="30" maxlength="140" id="user_url" value="<?php echo $current_user->user_url; ?>" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Location:','wp-answers') ?></label><br />
<input name="location" size="30" maxlength="140" id="from" value="<?php echo $location;?>" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Occupation:','wp-answers') ?></label><br />
<input name="occupation" size="30" maxlength="140" id="occ" value="<?php echo $occupation;?>" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Interests:','wp-answers') ?></label><br />
<input name="interests" size="30" maxlength="140" id="interests" value="<?php echo $interests;?>" type="text" class="input">
</p>

<p>
<label class="formlabel"><?php _e('Avatar:','wp-answers') ?></label><br />

<?php echo get_user_avatar($current_user->ID); ?><br />
<input name="avatar"type="file" class="input">
<input type="hidden" name="MAX_FILE_SIZE" value="10" />
</p>


<h2 class="formtitle"><?php _e('Change Password','wp-answers') ?></h2>


<p><?php _e('To change your password, enter a new password twice below:','wp-answers') ?></p>

<p>
<label class="formlabel"><?php _e('New password:','wp-answers') ?></label><br /><input name="pass1" type="password" id="pass1"   />
</p>

<p>
<label class="formlabel"><?php _e('Enter it again:','wp-answers') ?></label><br /><input name="pass2" type="password" id="pass2"  />
</p>

<p>
<input type="hidden" name="editprofile" value="1">
<input type="hidden" name="current_user" value="<?php echo $current_user->ID;?>">
<input type="hidden" name="redirect_to" value="<?php the_permalink(); ?>">
<input type="submit" name="Submit" value="Update Profile &raquo;" class="loginbutton white" />
</p>
</form>


</div><!-- End Content -->


<?php get_sidebar('Page'); ?>

<?php wpanswers_pagination(); ?>

<?php get_footer(); ?>