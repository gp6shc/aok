<div id="footer"><div id="bottom"><p class="copy"><?php echo custom_footer_text();?><br /><?php _e('&copy; Copyright','themefurnace') ?> <?php echo date('Y'); ?> <?php bloginfo('name'); ?><?php if ( is_user_logged_in() ) : ?>		<?php 		global $current_user;		get_currentuserinfo(); 		$usersName = $current_user->user_firstname . ' ' . $current_user->user_lastname;	?>		<p class="loggedinauthor">Logged in as: <?php echo $usersName; ?> - <a href="<?php echo wp_logout_url(); ?>" title="Logout"><?php _e('Logout','wp-answers') ?></a></p><?php endif; ?></p><?php echo custom_footer_scripts(); ?></div><!-- End Bottom --></div><!-- End Footer--><?php wp_footer(); ?></body></html>