<div id="footer"><div id="bottom"><p class="copy"><?php echo custom_footer_text();?><br /><?php _e('&copy; Copyright','themefurnace') ?> <?php echo date('Y'); ?> <?php bloginfo('name'); ?><?php if ( is_user_logged_in() ) : ?>		<?php 		global $current_user;		get_currentuserinfo(); 		$usersName = $current_user->user_firstname . ' ' . $current_user->user_lastname;	?>		<p class="loggedinauthor">Logged in as: <?php echo $usersName; ?> - <a href="<?php echo wp_logout_url(); ?>" title="Logout"><?php _e('Logout','wp-answers') ?></a></p><?php endif; ?></p><script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-55309110-1', 'auto');  ga('send', 'pageview');</script><?php echo custom_footer_scripts(); ?></div><!-- End Bottom --></div><!-- End Footer--><?php wp_footer(); ?></body></html>