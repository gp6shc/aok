<?php

function hide_dashboard() {
	global $blog, $current_user, $id, $parent_file, $wphd_user_capability;

	  if ((!current_user_can(''.$wphd_user_capability.'')) ) {

		/* First, let's get rid of the Help menu, Update nag, Personal Options section */
		echo "\n" . '<style type="text/css" media="screen">#your-profile { display: none; } .update-nag, #contextual-help-wrap, #contextual-help-link-wrap { display: none !important; }</style>';
		echo "\n" . '<script type="text/javascript">jQuery(document).ready(function($) { $(\'form#your-profile > h3:first\').hide(); $(\'form#your-profile > table:first\').hide(); $(\'form#your-profile\').show(); });</script>' . "\n";

		/* Now, let's fix the sidebar admin menu - go away, Dashboard link. */

		/* If Multisite, check whether they are in the User Dashboard before removing links */

		$user_id = get_current_user_id();
		$blogs = get_blogs_of_user($user_id);

		if (is_multisite() && is_admin() && empty($blogs)) {
			return;
		} else {
			remove_menu_page('index.php');		/* Hides Dashboard menu */
			remove_menu_page('separator1');		/* Hides separator under Dashboard menu*/
		}


		/* Last, but not least, let's redirect folks to their profile when they login or if they try to access the Dashboard via direct URL */

		if (is_multisite() && is_admin() && empty($blogs)) {
			return;
		} else if ($parent_file == 'index.php') {
			if (headers_sent()) {
				echo '<meta http-equiv="refresh" content="0;url='.admin_url('profile.php').'">';
				echo '<script type="text/javascript">document.location.href="'.admin_url('profile.php').'"</script>';
			} else {
				wp_redirect(admin_url('profile.php'));
				exit();
			}
		}

	}

}

add_action('admin_head', 'hide_dashboard', 0);

/* That's all folks. You were expecting more? */

?>
