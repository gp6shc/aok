<?php/** * Capiton theme functions */// Emable The custom Menuregister_nav_menu( 'primary', __( 'Primary Menu', 'capiton' ) );/* Disable the Admin Bar. */function hide_admin_bar(){ return false; }add_filter( 'show_admin_bar', 'hide_admin_bar' );// Enable Translationload_theme_textdomain( 'wp-answers', TEMPLATEPATH.'/languages' );// Style the Tag Cloudfunction custom_tag_cloud_widget($args) {	$args['largest'] = 12; //largest tag	$args['smallest'] = 12; //smallest tag	$args['unit'] = 'px'; //tag font unit	$args['number'] = '8'; //number of tags	return $args;}add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );/** * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis) and sets character length to 35 */function wp_new_excerpt($text){	if ($text == '')	{		$text = get_the_content('');		$text = strip_shortcodes( $text );		$text = apply_filters('the_content', $text);		$text = str_replace(']]>', ']]>', $text);		$text = strip_tags($text);		$text = nl2br($text);		$excerpt_length = apply_filters('excerpt_length', 20);		$words = explode(' ', $text, $excerpt_length + 1);		if (count($words) > $excerpt_length) {			array_pop($words);			array_push($words, '');			$text = implode(' ', $words);		}	}	return $text;}remove_filter('get_the_excerpt', 'wp_trim_excerpt');add_filter('get_the_excerpt', 'wp_new_excerpt');// Add the Style Dropdown Menu to the second row of visual editor buttonsfunction my_mce_buttons_2($buttons){	array_unshift($buttons, 'styleselect');	return $buttons;}add_filter('mce_buttons_2', 'my_mce_buttons_2');function my_mce_before_init($init_array)	{		// Now we add classes with title and separate them with;	$init_array['theme_advanced_styles'] = "Black Button=button black;Gray Button=button gray;White Button=button white;Orange Button=button orange;Red Button=button red;Blue Button=button blue;Rosy Button=button rosy;Green Button=button green;Pink Button=button pink";	return $init_array;}add_filter('tiny_mce_before_init', 'my_mce_before_init');/** * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link. */function capiton_page_menu_args( $args ) {	$args['show_home'] = true;	return $args;}add_filter( 'wp_page_menu_args', 'capiton_page_menu_args' );/** * Register our sidebars and widgetized areas.  * */function themefurnace_widgets_init() {	register_sidebar(array(		'name' => 'Footer 1',		'before_widget' => '<div class="footerwidget">',		'after_widget' => '</div>',		'before_title' => '<h3 class="sidehead">',		'after_title' => '</h3>',	));	register_sidebar(array(		'name' => 'Footer 2',		'before_widget' => '<div class="footerwidget">',		'after_widget' => '</div>',		'before_title' => '<h3 class="sidehead">',		'after_title' => '</h3>',	));	register_sidebar(array(		'name' => 'Footer 3',		'before_widget' => '<div class="footerwidget">',		'after_widget' => '</div>',		'before_title' => '<h3 class="sidehead">',		'after_title' => '</h3>',	));	register_sidebar(array(		'name' => 'Questions',		'before_widget' => '<div class="sidebarwidget">',		'after_widget' => '</div>',		'before_title' => '<h2 class="sidehead">',		'after_title' => '</h2>',	));	register_sidebar(array(		'name' => 'Blog',		'before_widget' => '<div class="sidebarwidget">',		'after_widget' => '</div>',		'before_title' => '<h2 class="sidehead">',		'after_title' => '</h2>',	));	register_sidebar(array(		'name' => 'Page',		'before_widget' => '<div class="sidebarwidget">',		'after_widget' => '</div>',		'before_title' => '<h2 class="sidehead">',		'after_title' => '</h2>',	));		}add_action( 'widgets_init', 'themefurnace_widgets_init' );/*moved to plugin - see includes/pagination.phpfunction wpanswers_pagination($pages = '', $range = 2, $slug='question'){       $showitems = ($range * 2)+1;       global $paged;     if(empty($paged)) $paged = 1;     if($pages == '')     {         global $wp_query;         $pages = $wp_query->max_num_pages;                  if(!$pages)         {             $pages = 1;         }     }        if(1 != $pages)     {         echo "<div class='pagination'>";         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagination_link(1, $slug)."'>&laquo;</a>";         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagination_link($paged-1, $slug)."'>&lsaquo;</a>";         for ($i=1; $i <= $pages; $i++)         {             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))             {                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagination_link($i, $slug)."' class='inactive' >".$i."</a>";             }         }         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagination_link($paged+1, $slug)."'>&rsaquo;</a>";           if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagination_link($pages, $slug)."'>&raquo;</a>";         echo "</div>\n";     }}function get_wpanswers_pagination($pages = '', $range = 2, $slug='question'){       $showitems = ($range * 2)+1;       global $paged;     if(empty($paged)) $paged = 1;     if($pages == '')     {         global $wp_query;         $pages = $wp_query->max_num_pages;                  if(!$pages)         {             $pages = 1;         }     }          $return = '';        if(1 != $pages)     {         $return .= "<div class='pagination'>";         if($paged > 2 && $paged > $range+1 && $showitems < $pages) {             $return .= "<a href='".get_pagination_link(1, $slug)."'>&laquo;</a>";         }         if($paged > 1 && $showitems < $pages) {             $return .= "<a href='".get_pagination_link($paged-1, $slug)."'>&lsaquo;</a>";         }         for ($i=1; $i <= $pages; $i++)         {             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))             {                 $return .= ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagination_link($i, $slug)."' class='inactive' >".$i."</a>";             }         }         if ($paged < $pages && $showitems < $pages) {             $return .= "<a href='".get_pagination_link($paged+1, $slug)."'>&rsaquo;</a>";           }         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {             $return .= "<a href='".get_pagination_link($pages, $slug)."'>&raquo;</a>";         }         $return .= "</div>\n";     }     return $return;}*//** * Loading jQuery and tabs.js */ function loading_jquery() {    wp_deregister_script( 'jquery' );    if ( is_singular() ) wp_deregister_script( 'comment-reply' );    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');    wp_enqueue_script( 'jquery' );	wp_register_script( 'ie', get_template_directory_uri() . '/js/ie.js');	wp_enqueue_script( 'ie' );}      add_action('wp_enqueue_scripts', 'loading_jquery');function loading_tabs() {   // register your script location, dependencies and version   wp_register_script('custom_script',       get_template_directory_uri() . '/js/tabs.js',       array('jquery'),       '1.0' );   // enqueue the script   wp_enqueue_script('custom_script');   wp_enqueue_style( 'SASS', get_template_directory_uri().'/css/style.css' );}add_action('wp_enqueue_scripts', 'loading_tabs');/** * Template for comments and pingbacks. * * To override this walker in a child theme without modifying the comments template * simply create your own capiton_comment(), and that function will be used instead. * * Used as a callback by wp_list_comments() for displaying the comments. * */ if ( ! function_exists( 'capiton_comment' ) ) : function capiton_comment( $comment, $args, $depth ) {    global $best_answer_id, $wpdb, $table_prefix, $post;    echo '<style>.comment {clear:both}</style>';    $link = '';    if((int)$comment->user_id > 0) {        $user = get_user_by('id', $comment->user_id);        if(is_object($user) && isset($user->data->user_login)) {            $link = '<a href="'.get_bloginfo('url').'/?p='.get_option('viewprofile_page_id').'&profile='.$user->data->user_login.'">'.$user->data->display_name.'</a>';        }        else {            $link = $user->data->display_name;//sprintf(__( get_comment_author_link() ));        }    }    else {        $link = $comment->comment_author; //sprintf(__( get_comment_author_link() ));    }        //var_dump($link);   if(isset($best_answer_id[0])){    if($comment->comment_ID == $best_answer_id[0]) { return; }}    	$GLOBALS['comment'] = $comment;	switch ( $comment->comment_type ) :		case '' :	$classname = '';	if($comment_votes < 0) {	    $classname = 'class="negative"';	}	$table_name = $table_prefix."user_comments";		$hide_voting = 0;		if(!is_user_logged_in()) {	    $hide_voting = 1;	}	else {	   $user = wp_get_current_user();	   $user_voted = $wpdb->get_var("select id from ".$table_name." where user_id='".$user->ID."' and comment_id='".$comment->comment_ID."'");	   	   if(!empty($user_voted)) {	       $hide_voting = 1;	   }	   if($user->ID == $comment->user_id) {	       $hide_voting = 1;	   }	}	?>	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">		<div id="comment-<?php comment_ID(); ?>" <?php echo $classname;?>>    		<div class="comment-author vcard">			<?php echo get_user_avatar( $comment->user_id, 45, $comment->comment_author_email ); ?>			<?php printf( __($link) ); //printf( __( get_comment_author_link() ) ); ?>		</div><!-- .comment-author .vcard -->         <div class="wpanswerstuff">        <ul>          <li><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">			<?php				/* translators: 1: date, 2: time */				printf( __( '%1$s at %2$s', 'capiton' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'capiton' ), ' ' );			?></li>        <?php if($hide_voting == 0) { ?><li id="report_<?php echo $comment->comment_ID;?>"><a href="#" class="reportme" commentid="<?php echo $comment->comment_ID;?>">Report This Post</a></li><?php } ?>        <?php if(current_user_can('moderate_comments') || (is_user_logged_in() && $post->user_id == $user->ID)): ?>        <li><a href="#" class="bestanswer" commentid="<?php echo $comment->comment_ID;?>">Select as Best Answer</a></li>        <?php endif; ?>        </ul>         </div>		<?php if ( $comment->comment_approved == '0' ) : ?>			<em><?php _e( 'Your comment is awaiting moderation.', 'capiton' ); ?></em>			<br />		<?php endif; ?>		<div class="comment-body"><?php comment_text(); ?></div>       		<div class="reply">			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>		</div><!-- .reply -->	</div><!-- #comment-##  -->	<?php			break;		case 'pingback'  :		case 'trackback' :	?>	<li class="post pingback">		<p><?php _e( 'Pingback:', 'capiton' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'capiton'), ' ' ); ?></p>	<?php			break;	endswitch;}endif;/** * Display "best answer"  * * @param int $postID */function display_best_answer( $postID ) {    global $best_answer_id, $wpdb, $table_prefix;    $best_answer_id = get_post_meta($postID, '_bestanswer');    if(empty($best_answer_id)) return;    	$comment = get_comment($best_answer_id[0]);	$comment_votes = get_comment_votes($comment->comment_ID);	if(empty($comment_votes)) {	    $comment_votes = 0;	}		$classname = '';	if($comment_votes < 0) {	    $classname = 'negative';	}	$table_name = $table_prefix."user_comments";		$hide_voting = 0;		if(!is_user_logged_in()) {	    $hide_voting = 1;	}	else {	   $user = wp_get_current_user();	   $user_voted = $wpdb->get_var("select id from ".$table_name." where user_id='".$user->ID."' and comment_id='".$comment->comment_ID."'");	   	   if(!empty($user_voted)) {	       $hide_voting = 1;	   }	   if($user->ID == $comment->user_id) {	       $hide_voting = 1;	   }	}		$link = '';    if((int)$comment->user_id > 0) {        $user = get_user_by('id', $comment->user_id);        if(is_object($user) && isset($user->data->user_login)) {            $link = '<a href="'.get_bloginfo('url').'/?p='.get_option('viewprofile_page_id').'&profile='.$user->data->user_login.'">'.$user->data->display_name.'</a>';        }        else {            $link = $user->data->display_name;//sprintf(__( get_comment_author_link() ));        }    }    else {        $link = $comment->comment_author; //sprintf(__( get_comment_author_link() ));    }        ?>    <li class="comment byuser depth-1" id="li-comment-<?php echo $comment->comment_ID; ?>">    <div id="comment-<?php echo $comment->comment_ID; ?>" class="best-answer <?php echo $classname;?>">    		<div class="comment-author vcard">			<?php echo get_user_avatar( $comment->user_id, 45 ); ?>			<?php printf( __($link) ); ?>		</div><!-- .comment-author .vcard -->        <div class="wpanswerstuff">        <ul>          <li><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">			<?php				/* translators: 1: date, 2: time */				printf( __( '%1$s at %2$s', 'capiton' ), get_comment_date('', $comment->comment_ID),  get_comment_time('', $comment->comment_ID) ); ?></a><a href="<?php echo get_edit_comment_link($comment->comment_ID); ?>"><?php _e( '(Edit)', 'wp-answers' );?></a>		</li>        <?php //<li><a href="#">Report This Post</a></li> ?>        </ul>        </div>		<?php if ( $comment->comment_approved == '0' ) : ?>			<em><?php _e( 'Your comment is awaiting moderation.', 'capiton' ); ?></em>			<br />		<?php endif; ?>	</li><!-- #comment-##  -->    	<?php	}	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images	add_theme_support( 'post-thumbnails' );		//This feature enables post and comment RSS feed links to head. 	add_theme_support( 'automatic-feed-links' );		//This feature enables post and comment RSS feed links to head. if(isset($args))	add_theme_support( 'custom-background', $args );		//Content Width	if ( ! isset( $content_width ) ) $content_width = 900;// Custom Functions for Theme Options Panelfunction custom_logo() {	global $up_options;	// if there is text defined (instead of logo), display it	if(!empty($up_options->logo_text) && $up_options->logo_type == 'text') {		echo '<h1 id="logo_text">'.$up_options->logo_text.'</h1>';		return;	}	// display custom logo (if defined) or default logo	else {		$logo_img = $up_options->logo;		if(empty($logo_img)) { 			$logo_img = get_template_directory_uri().'/img/logo.png';		}		echo '<img src="'.$logo_img.'" class="logo" alt="logo"/>';						}}function custom_footer_logo() {	global $up_options;		// display custom logo (if defined) or default logo	$logo_img = $up_options->footerLogo;	if(empty($logo_img)) { 		$logo_img = get_template_directory_uri().'/img/logo-footer.png';	}	echo '<img src="'.$logo_img.'" class="footerlogo" alt="footer logo"/>';	}function custom_intro_text() {	global $up_options;	// if there is text defined , display it	if(!empty($up_options->intro_text)) {		echo '<p>'.nl2br($up_options->intro_text).'</p>';		return;	}}function custom_footer_text() {	global $up_options;	// if there is text defined , display it	if(!empty($up_options->footer_text)) {		echo nl2br($up_options->footer_text);		return;	}}function custom_footer_scripts() {	global $up_options;	// if there are scripts defined , display them	if(!empty($up_options->footer_scripts)) {		echo nl2br($up_options->footer_scripts);		return;	}}function custom_blog_items() {	global $up_options;        	if(!empty($up_options->blog_items))		return query_posts('showposts='.(int)$up_options->blog_items);	else 		return query_posts('showposts=4');}function custom_portfolio_items() {	global $up_options;        	if(!empty($up_options->portfolio_items))		return query_posts( 'post_type=portfolio&showposts='.(int)$up_options->portfolio_items);	else 		return query_posts( 'post_type=portfolio');}function custom_theme_css() {	global $up_options;		if(!empty($up_options->styles)) {		echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/css/'.$up_options->styles.'.css"/>';	}}/** * Handle the autoposting campaigns. WP-Cron sucks and is buggy running from plugin, this is much better * And can use more than 3 predefined intervals without workarounds. * */function autoposting_cron() {    global $up_options, $wpdb, $table_prefix;        $campaigns = $wpdb->get_results("select c.*, s.last_post_time from ".$table_prefix."autoposting_campaigns c left join ".$table_prefix."autoposting_status s on c.id=s.campaign_id where c.enabled=1");    if(!empty($campaigns)) {        foreach ($campaigns as $campaign) {            $interval = make_post_interval($campaign->interval_days, $campaign->interval_hours);            if($campaign->last_post_time + $interval <= time()) {               // autoposting_exec(array('app_id' => $up_options->autoposting_app_id, 'campaign_id' => $campaign->id, 'cron' => 1));              }        }    }}add_action('wp', 'autoposting_cron');/** * see if user can post an answer (depending on admin settings) * @return boolean */function check_wp_answers_user_settings() {	global $up_options;		$user = wp_get_current_user();	if(!is_object($user)) return false;	if(!isset($up_options->roles) || empty($up_options->roles)) return true;		foreach($up_options->roles as $role) {		if ( !empty( $user->roles ) && is_array( $user->roles ) ) {			foreach ( $user->roles as $role ) {				if(in_array($role, $up_options->roles))					return true;			}		}	}		// fallback to false	return false;}