<div id="comments">

<div class="commentstop">
<div class="questionnumber"><p><a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' . __('0', 'wp-answers') . '', '' . __('1', 'wp-answers') . '', '' . __('%', 'wp-answers') . '' ); ?></a></p>
</div>
<h2 class="commentheading">Answers</h2>
</div>

<br class="clear" />

<?php if ( post_password_required() ) : ?>
<p><?php _e('This post is password protected. Enter the password to view any comments.','wp-answers') ?></p>
<?php
return;
endif;
?>

<?php if ( have_comments() ) : ?>         


<ol>
<?php 
    // functions.php: display_best_answer. It's theme (not plugin) function - display several comments in a different manner.
    display_best_answer(get_the_ID()); 
    wp_list_comments( array( 'callback' => 'capiton_comment' ) ); 
?>
</ol>

<?php else : if ( ! comments_open() ) : ?>
<p><?php _e( 'Comments are closed.', 'wp-answers' ); ?></p>
<?php endif; // end ! comments_open() ?>
<?php endif; // end have_comments() ?>


<a name="leaveyourcomment"></a>
<?php if ( comments_open() && check_wp_answers_user_settings() ) : ?>
  

<div id="respond">

<div class="cancelcomment">
<p><?php cancel_comment_reply_link(); ?><p>
</div>
	
<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php printf(__('You must be %1$slogged in%2$s to post a comment.', 'wp-answers'), '<a href="'.get_option('siteurl').'/wp-login.php?redirect_to='.urlencode(get_permalink()).'">', '</a>') ?></p>

<?php else : ?>

<?php if ( is_user_logged_in() ) : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentsform">
<p class="loggedinauthor"><?php _e('Logged in as','wp-answers') ?> <?php global $current_user; get_currentuserinfo(); echo '' . $current_user->user_login . "\n";?> - <a href="<?php echo wp_logout_url(); ?>" title="Logout"><?php _e('Logout','wp-answers') ?></a></p>
<h2 class="leavecomment"><?php _e('Leave Your Answer','wp-answers') ?></h2>
<div class="answerarea">
<textarea name="comment" class="commentbox" id="comment" tabindex="4"></textarea><br />
<input name="submit" type="submit" id="submit" tabindex="5" class="topbutton topblue" value="<?php _e('Submit', 'themefurnace') ?>" />
<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>
</form>
</div>
		
<?php else : ?>	
<div class="inputBox">
<?php _e('Please signup or login to answer this question.','wp-answers') ?>
</div>
<?php get_template_part('signup', 'form'); ?>
		
<?php endif; ?>
<?php endif; ?>

</div>

	
<?php else: ?>

<ul class="commentsbot">
<li><?php _e('Comments are Closed','themefurnace') ?></li>
</ul>
		
<?php endif; ?>
<?php paginate_comments_links(); ?> 
</div><!--End Comments-->