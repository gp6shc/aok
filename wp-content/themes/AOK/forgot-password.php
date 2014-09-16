<?php
/*
Template Name: Forgot Password
*/
?>
<?php get_header(); ?>
<div id="content">

<?php the_post(); ?>
<h1 class="questiontitle"><?php the_title(); ?></h1>
<?php 
    if(isset($_GET['success'])) {
        _e("Please check your email for further instructions.", 'wp-answers');
    }
?>
<form name="lostpasswordform" class="userinfo" action="http://wp-answers.com/dev/wp-login.php?action=retrievepassword" method="post">
	<p>
		<label class="formlabel">Username or E-mail:<br />
		<input type="text" name="user_login" id="user_login" class="input" value="" size="20" tabindex="10" />
		</label>
	</p>
	<input type="hidden" name="redirect_to" value="<?php echo get_permalink(get_the_id()).'/?success';?>" />
	<input type="hidden" name="action" value="retrievepassword" />
	<p>
	<input type="submit" name="wp-submit" class="loginbutton white" value="Get New Password" tabindex="100" />
	</p>
</form>


</div><!-- End Content-->

<?php get_sidebar('Questions'); ?>
<?php get_footer(); ?>