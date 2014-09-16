<?php
/*
Template Name: View Profile
*/
?>
<?php get_header(); ?>
<div id="content">
<?php 
global $_user_data, $_user_meta, $up_options, $wpdb, $table_prefix;
?>

<h1 class="questiontitle"><?php echo !empty($_user_data->user_login)?$_user_data->user_login:''."'s "; _e('Profile page', 'wp-answers');  ?></h1>

<p>
<?php _e('User points', 'wp-answers'); ?><br/>
<?php  
    $table_name = $table_prefix.'user_points';    if(isset($_user_data->ID))
    $points = $wpdb->get_var("select points from ".$table_name." where user_id='".$_user_data->ID."'");
    if(empty($points)) {
        $points = 0;
    }
    echo $points;
?>
</p>

<p>
<?php _e('Member Since', 'wp-answers'); ?><br/><?php if(isset($_user_data)):?>
<?php echo date("M j, Y", strtotime($_user_data->user_registered)).' ('.readable_time(strtotime($_user_data->user_registered), 1).')'; ?><?php endif;?>
</p>

<p>
<?php _e('Website', 'wp-answers'); ?><br/><?php if(isset($_user_data)):?>
<?php echo '<a href="'.$_user_data->user_url.'">'.$_user_data->user_url.'</a>'; ?><?php endif;?>
</p>

<p>
<?php _e('Location', 'wp-answers'); ?><br/>
<?php echo !empty($_user_data)?$_user_data->location:''; ?>
</p>

<p>
<?php _e('Occupation', 'wp-answers'); ?><br/>
<?php echo !empty($_user_data)?$_user_data->occupation:''; ?>
</p>

<p>
<?php _e('Interests', 'wp-answers'); ?><br/>
<?php echo !empty($_user_data)?$_user_data->interests:''; ?>
</p>

<p>
<?php _e('Avatar', 'wp-answers'); ?><br/>
<?php echo get_user_avatar(!empty($_user_data)?$_user_data->ID:'');?>
</p>

<div style="clear:both; height:40px;"></div>

<h3 class="questiontitle"><?php _e('Recent Answers', 'wp-answers'); ?></h3>
<ul>
<?phpif(isset($_user_data))
$comments = $wpdb->get_results('select c.*, p.post_title from '.$wpdb->comments.' c left join '.$wpdb->posts.' p on c.comment_post_ID=p.ID where c.user_id="'.$_user_data->ID.'" and p.post_type="question" group by c.comment_post_ID order by c.comment_date DESC limit 10');if(isset($comments))
foreach ($comments as $comment) {
    echo '<li><a href="'.get_permalink($comment->comment_post_ID).'">'.$comment->post_title.'</a> <span class="info">'.__('Started', 'wp-answers').' '.readable_time(strtotime($comment->comment_date)).' '.__('ago', 'wp-answers').'</span></li>';
}
?>
</ul>

<h3 class="questiontitle"><?php _e('Recent Questions', 'wp-answers'); ?></h3>
<ul>
<?phpif(isset($_user_data))
$posts = $wpdb->get_results('select p.*, max(c.comment_date) as comment_date from '.$wpdb->posts.' p left join '.$wpdb->comments.' c on c.comment_post_ID=p.ID where p.post_author="'.$_user_data->ID.'" and p.post_type="question" group by p.ID order by p.post_date DESC limit 10');
foreach ($posts as $post) {
    if($post->comment_count >= 1) {
        $replies = __('Most recent reply', 'wp-answers');
        $replies .= ' '.readable_time(strtotime($post->comment_date)).' '.__('ago', 'wp-answers');
    }
    else {
        $replies = __('No replies', 'wp-answers');
    }
    echo '<li><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>  <span class="info">'.__('Started', 'wp-answers').' '.readable_time(strtotime($post->post_date)).' '.__('ago', 'wp-answers').' '.$replies.'</span></li>';
}
?>
</ul>

</div><!-- End Content -->


<?php get_sidebar('Questions'); ?>


<?php get_footer(); ?>