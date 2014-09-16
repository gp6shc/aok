<?php

/*

Plugin Name: WP-Answers

Description: Adds Question and Answer functionality

Version: 4.0

License: GPL

Author: WP-Answers

Author URI: http://wp-answers.com

*/

if ( is_multisite() )
{
	if ( function_exists('wp_cookie_constants') ) {
		wp_cookie_constants();
	}
}

include("includes/admin/admin.php");

include("includes/recaptcha.php");

include("includes/question-post-type.php");

include("includes/question-pages.php");

include("includes/user-points.php");

include("includes/report-comment.php");

include("includes/twitter-new.php");

include("includes/facebook.php");

include("includes/submit-question.php");

include("includes/user-register.php");

include("includes/user-functions.php");

include("includes/edit-profile.php");

include("includes/view-profile.php");

include("includes/comment-points.php");

include("includes/ask-widget.php");

include("includes/shortcodes.php");

include("includes/stackapps-api.php");

include("includes/pagination.php");

include("includes/admin/limit-comments.php");

include("includes/admin/wordlimit.php");

include("includes/newuser-approve.php");


// widgets

// add Login / Signup widget

include_once('includes/widgets/signup-widget.php');



// add Category widget

include_once('includes/widgets/category-widget.php');



// add Popular Questions widget

include_once('includes/widgets/popular-questions-widget.php');



// add Top Users widget

include_once('includes/widgets/top-users-widget.php');



// add stylesheets

include_once('includes/style.php');
add_option('dashboardsetting','false');
$setting=get_option('dashboardsetting');

if($setting=="false")
{
 include("includes/hide-dashboard.php");
}
?>
