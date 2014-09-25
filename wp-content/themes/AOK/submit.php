<?php/*Template Name: SubmitDisplays the form for "ask a question"*/?><?php get_header(); ?><?php global $_user_data, $_user_meta, $up_options, $wpdb, $table_prefix;?><div class="content"><h1 class="questiontitle">Submit an Idea</h1><?php if ( is_user_logged_in() ) : ?>	<p>We're looking for ideas that are consensus-oriented, attainable, and help a broad range of citizens in Okaloosa County.</p><form action="" method="POST"><label for="post_category" class="formlabel">Idea Category:</label><?php $categories = get_terms('question_category', array('hide_empty' => false));  ?>    <select name='question_category' id='post_category' class='postform' >    <?php    	foreach ($categories as $category) {    		echo '<option value="'.$category->term_id.'">'.$category->name.'</option>';       }?>    </select><input name="post_title" type="hidden" class="input" value="<?php echo date('l F jS, Y h:i:s A'); ?>"/><p><label class="formlabel">My Idea is...</label>	<?php if( !empty($_GET['e']) ):?>	<span class="error"><b> Please enter an idea below.</b></span>	<?php endif; ?><br /><textarea name="content"  value="" type="text" class="questionarea" /><?php echo isset($_SESSION['post_content'])?$_SESSION['post_content']:'';?></textarea></p><p><label class="formlabel"><?php _e('Your Home Address','wp-answers') ?><i> (will not be published)</i></label><br /><input name="op_address" type="text" class="input" value="" /><?php echo isset($_SESSION['tag'])?$_SESSION['tag']:'';?></input></p><?phpglobal $up_options;if($up_options->recaptcha_new_question == 'true' && !empty($up_options->recaptcha_public_key) && !empty($up_options->recaptcha_private_key)) {    global $error, $publickey;    echo '<div id="recaptcha">'.recaptcha_get_html($up_options->recaptcha_public_key, $_SESSION['recaptcha_error']).'</div>';    if(isset($_SESSION['recaptcha_error'])) {        unset($_SESSION['recaptcha_error']);    }    echo '<input type="hidden" name="post_recaptcha" value="1">';}?><?php      if(isset($up_options->require_payment) && $up_options->require_payment == 'yes') {        echo '<p>'.$up_options->payment_disclaimer.'</p>';    }?><p><input type="hidden" name="ask_a_question" value="1"><input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI'];?>"><input type="hidden" name="up" value="<?php echo $up_options->points_per_question; ?>">    <input type="submit" name="Submit" value="Submit" class="topbutton submit" /></p></form><p><i>Comments will be reviewed and published only if they do not contain personal attacks or offensive language.</i></p><?php else : ?>	           	<p>To submit an idea, please login with Facebook. Once logged in, you will be able to submit and comment on ideas.</p>	<p style="text-align: center;"><fb:login-button scope="offline_access,publish_stream" onlogin="location.href='<?php echo home_url().'/submit-idea/?l=fb'; ?>';">Log in with Facebook</fb:login-button></p><?php endif; ?></div><!-- End Content--><?php get_sidebar('question'); ?><?php get_footer(); ?>