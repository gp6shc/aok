<?php

/**
 * Flushes rewrite rules on plugin activation to ensure portfolio posts don't 404
 * http://codex.wordpress.org/Function_Reference/flush_rewrite_rules
 */

function questionposttype_activation() {
	questionposttype();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'questionposttype_activation' );

function questionposttype() {

	/**
	 * Enable the Questions custom post type
	 * http://codex.wordpress.org/Function_Reference/register_post_type
	 */

	$labels = array(
		'name' => __( 'Questions', 'questionposttype' ),
		'singular_name' => __( 'Question', 'questionposttype' ),
		'add_new' => __( 'Add New Question', 'questionposttype' ),
		'add_new_item' => __( 'Add New Question', 'questionposttype' ),
		'edit_item' => __( 'Edit Question', 'questionposttype' ),
		'new_item' => __( 'Add New Question', 'questionposttype' ),
		'view_item' => __( 'View Question', 'questionposttype' ),
		'search_items' => __( 'Search Questions', 'questionposttype' ),
		'not_found' => __( 'No questions found', 'questionposttype' ),
		'not_found_in_trash' => __( 'No questions found in trash', 'questionposttype' )
	);

	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'show_ui' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ),
		'capability_type' => 'post',
		'rewrite' => array("slug" => "question"), // Permalinks format
		'menu_position' => 5,
		'has_archive' => true,
		'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'query_var' => true,
        'can_export' => true,
	); 

	register_post_type( 'question', $args );
	
	/**
	 * Register a taxonomy for Question Tags
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	 
	
	$taxonomy_question_tag_labels = array(
		'name' => _x( 'Question Tags', 'questionposttype' ),
		'singular_name' => _x( 'Question Tag', 'questionposttype' ),
		'search_items' => _x( 'Search Question Tags', 'questionposttype' ),
		'popular_items' => _x( 'Popular Question Tags', 'questionposttype' ),
		'all_items' => _x( 'All Question Tags', 'questionposttype' ),
		'parent_item' => _x( 'Parent Question Tag', 'questionposttype' ),
		'parent_item_colon' => _x( 'Parent Question Tag:', 'questionposttype' ),
		'edit_item' => _x( 'Edit Question Tag', 'questionposttype' ),
		'update_item' => _x( 'Update Question Tag', 'questionposttype' ),
		'add_new_item' => _x( 'Add New Question Tag', 'questionposttype' ),
		'new_item_name' => _x( 'New Question Tag Name', 'questionposttype' ),
		'separate_items_with_commas' => _x( 'Separate question tags with commas', 'questionposttype' ),
		'add_or_remove_items' => _x( 'Add or remove question tags', 'questionposttype' ),
		'choose_from_most_used' => _x( 'Choose from the most used question tags', 'questionposttype' ),
		'menu_name' => _x( 'Question Tags', 'questionposttype' )
	);
	
	$taxonomy_question_tag_args = array(
		'labels' => $taxonomy_question_tag_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => true,
		'query_var' => true
	);
	
	register_taxonomy( 'question_tag', array( 'question' ), $taxonomy_question_tag_args );
	
	/**
	 * Register a taxonomy for Question Categories
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */

    $taxonomy_question_category_labels = array(
		'name' => _x( 'Question Categories', 'questionposttype' ),
		'singular_name' => _x( 'Question Category', 'questionposttype' ),
		'search_items' => _x( 'Search Question Categories', 'questionposttype' ),
		'popular_items' => _x( 'Popular Question Categories', 'questionposttype' ),
		'all_items' => _x( 'All Question Categories', 'questionposttype' ),
		'parent_item' => _x( 'Parent Question Category', 'questionposttype' ),
		'parent_item_colon' => _x( 'Parent Question Category:', 'questionposttype' ),
		'edit_item' => _x( 'Edit Question Category', 'questionposttype' ),
		'update_item' => _x( 'Update Question Category', 'questionposttype' ),
		'add_new_item' => _x( 'Add New Question Category', 'questionposttype' ),
		'new_item_name' => _x( 'New Question Category Name', 'questionposttype' ),
		'separate_items_with_commas' => _x( 'Separate question categories with commas', 'questionposttype' ),
		'add_or_remove_items' => _x( 'Add or remove question categories', 'questionposttype' ),
		'choose_from_most_used' => _x( 'Choose from the most used question categories', 'questionposttype' ),
		'menu_name' => _x( 'Question Categories', 'questionposttype' ),
    );
	
    $taxonomy_question_category_args = array(
		'labels' => $taxonomy_question_category_labels,
		'public' => true,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'questions'),
		'query_var' => true
    );
	
    register_taxonomy( 'question_category', array( 'question' ), $taxonomy_question_category_args );
	
}

add_action( 'init', 'questionposttype', 0 );

// Allow thumbnails to be used on portfolio post type

add_theme_support( 'post-thumbnails', array( 'question' ) );
 

/**
 * Add Question count to "Right Now" Dashboard Widget
 */

function add_question_counts() {
        if ( ! post_type_exists( 'question' ) ) {
             return;
        }

        $num_posts = wp_count_posts( 'question' );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( 'Question Item', 'Question Items', intval($num_posts->publish) );
        if ( current_user_can( 'edit_posts' ) ) {
            $num = "<a href='edit.php?post_type=question'>$num</a>";
            $text = "<a href='edit.php?post_type=question'>$text</a>";
        }
        echo '<td class="first b b-question">' . $num . '</td>';
        echo '<td class="t question">' . $text . '</td>';
        echo '</tr>';

        if ($num_posts->pending > 0) {
            $num = number_format_i18n( $num_posts->pending );
            $text = _n( 'Questions Pending', 'Questions Pending', intval($num_posts->pending) );
            if ( current_user_can( 'edit_posts' ) ) {
                $num = "<a href='edit.php?post_status=pending&post_type=question'>$num</a>";
                $text = "<a href='edit.php?post_status=pending&post_type=question'>$text</a>";
            }
            echo '<td class="first b b-question">' . $num . '</td>';
            echo '<td class="t question">' . $text . '</td>';

            echo '</tr>';
        }
}

add_action( 'right_now_content_table_end', 'add_question_counts' );

/**
 * Displays the custom post type icon in the dashboard
 */

function questionposttype_question_icons() { ?>
    <style>
        /* Admin Menu - 16px */
        #menu-posts-question .wp-menu-image {
            background: url(<?php get_bloginfo( 'wpurl' ); ?>/wp-content/plugins/WP-Answers-Plugin/images/icon-adminmenu16-sprite.png) no-repeat 6px 6px !important;
        }
		#menu-posts-question:hover .wp-menu-image, #menu-posts-question.wp-has-current-submenu .wp-menu-image {
            background-position: 6px -26px !important;
        }
        /* Post Screen - 32px */
        .icon32-posts-question {
        	background: url(<?php get_bloginfo( 'wpurl' ); ?>/wp-content/plugins/WP-Answers-Plugin/images/icon-adminpage32.png) no-repeat left top !important;
        }
        @media
        only screen and (-webkit-min-device-pixel-ratio: 1.5),
        only screen and (   min--moz-device-pixel-ratio: 1.5),
        only screen and (     -o-min-device-pixel-ratio: 3/2),
        only screen and (        min-device-pixel-ratio: 1.5) {
        	/* Admin Menu - 16px @2x */
        	#menu-posts-question .wp-menu-image {
        		background-image: url('<?php get_bloginfo( 'wpurl' ); ?>/wp-content/plugins/WP-Answers-Plugin/images/icon-adminmenu16-sprite@2x.png') !important;
        		-webkit-background-size: 16px 48px;
        		-moz-background-size: 16px 48px;
        		background-size: 16px 48px;
        	}
        	/* Post Screen - 32px @2x */
        	.icon32-posts-question {
        		background-image: url('<?php get_bloginfo( 'wpurl' ); ?>/wp-content/plugins/WP-Answers-Plugin/images/icon-adminpage32@2x.png') !important;
        		-webkit-background-size: 32px 32px;
        		-moz-background-size: 32px 32px;
        		background-size: 32px 32px;
        	}
        }
    </style>
<?php }

add_action( 'admin_head', 'questionposttype_question_icons' );

?>