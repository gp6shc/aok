<?php
/**
 * Handle comment upvotes/downvotes
 */

/**
 * Create tables for comment votes
 *
 */
function comment_vote_init() {
    global $wpdb, $table_prefix;
    $table_name = $table_prefix.'comment_votes';
    if(get_option('comment_votes_tables_created') != '1') {
        $wpdb->query(
        "
        CREATE TABLE IF NOT EXISTS ".$table_name." (
            `id` int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `comment_id` int(11) NOT NULL,
            `points` int(11) NOT NULL DEFAULT 0,
            UNIQUE comment_id(comment_id)
        );
        "
        );
        
        $table_name = $table_prefix.'user_comments';
        $wpdb->query(
        "
        CREATE TABLE IF NOT EXISTS ".$table_name." (
            `id` int(9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `comment_id` int(11) NOT NULL,            
            UNIQUE user_comment(user_id, comment_id)
        );
        "
        );
        update_option('comment_votes_tables_created', '1');
    }
}

/**
 * 
 * Handles comment upvote
 *
 * @param int $commentID
 */
function comment_upvote($commentID) {
    global $wpdb, $table_prefix;
    if(!is_user_logged_in()) return;
    
    $comment_votes_table = $table_prefix.'comment_votes';
    $user_comments_table = $table_prefix.'user_comments';
    
    $user = wp_get_current_user();
    
    $id = $wpdb->query("INSERT INTO ".$user_comments_table." (user_id, comment_id) VALUES ('".$user->ID."', '".(int)$commentID."')");
    
    // int if above query passed (user voted for the comment first time)
    if(is_int($id)) {
        $wpdb->query("INSERT INTO ".$comment_votes_table." (comment_id, points) VALUES ('".(int)$commentID."', 1) ON DUPLICATE KEY UPDATE points=points+1");
    }
    add_user_points_votes($commentID, 'up');
}

/**
 * Handles comment downvote
 *
 * @param int $commentID
 */
function comment_downvote($commentID) {
    global $wpdb, $table_prefix;
    if(!is_user_logged_in()) return;
    
    $comment_votes_table = $table_prefix.'comment_votes';
    $user_comments_table = $table_prefix.'user_comments';
    
    $user = wp_get_current_user();
    
    $id = $wpdb->query("INSERT INTO ".$user_comments_table." (user_id, comment_id) VALUES ('".$user->ID."', '".(int)$commentID."')");
    
    // int if above query passed (user voted for the comment first time)
    if(is_int($id)) {
        $wpdb->query("INSERT INTO ".$comment_votes_table." (comment_id, points) VALUES ('".(int)$commentID."', -1) ON DUPLICATE KEY UPDATE points=points-1");
    }
    add_user_points_votes($commentID, 'down');
}

/**
 * Gets comment votes 
 *
 * @param int $commentID
 * @param bool $ajax
 * @return mixed
 */
function get_comment_votes($commentID, $ajax=false) {
    global $wpdb, $table_prefix;
    
    $comment_votes_table = $table_prefix.'comment_votes';
    $votes = $wpdb->get_var("select points from ".$comment_votes_table." WHERE comment_id='".(int)$commentID."'");
    
    if($ajax === false) {
        return $votes;
    }
    // return JSON with current comment votes for ajax call.
    header("content-type: text/json");
    echo json_encode(array('votes' => $votes));
    exit;
}

function add_user_points_votes($commentID, $type) {
    global $wpdb, $table_prefix;
    
    $table_name = $table_prefix.'user_points';
    //$user = wp_get_current_user();
    $comment = get_comment($commentID);
    $userID = $comment->user_id;
    
    $currentTheme = wp_get_theme();
    $themeName = str_replace(' ', '_', strtolower($currentTheme->Name));
    $opt = wp_load_alloptions();
    
    $up_opt = unserialize($opt['up_themes_'.$themeName]); 
    $points = (int)$up_opt['points_per_vote'];

    if($type == 'down') {
        $points = $points * (-1);
    }

    $wpdb->query('INSERT into '.$table_name.' (user_id, points) VALUES ("'.$userID.'", "'.$points.'") ON DUPLICATE KEY UPDATE points=points+'.$points) or die(wp_error());
    
}

/**
 * Comment vote JS (jquery actions)
 *
 */
function comment_vote_js() {
    echo '
    <script type="text/javascript">
    jQuery(document).ready(function() { 
        jQuery("a.vote").click(function(e) {
            e.preventDefault;
            var commentID = jQuery(this).attr("commentid");
            var action = jQuery(this).attr("action");
            if(action != "upvote" && action != "downvote") return;
            
            jQuery.get("'.get_bloginfo('url').'/?"+action+"="+commentID, function(data) {
                jQuery("#comment-"+commentID+" .total-votes").text(data.votes);
                jQuery("#comment-"+commentID+" .voting-buttons").remove();
            });
            return false;
        });
    });
    </script>
    ';
}

add_action('init', 'comment_vote_init');
add_action('wp_footer', 'comment_vote_js');

/**
 * Handle ajax call 
 */
if(!empty($_GET['upvote'])) {
    $comment_id = (int)$_GET['upvote'];
    comment_upvote($comment_id);
    get_comment_votes($comment_id, true);
}

if(!empty($_GET['downvote'])) {
    $comment_id = (int)$_GET['downvote'];
    comment_downvote($comment_id);
    get_comment_votes($comment_id, true);
}