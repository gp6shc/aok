<?php
/*
Template Name: Top Users
*/
?>
<?php get_header(); ?>
<div id="content">


<h1 class="questiontitle"><?php the_title(); ?></h1>

<?php 
global $wpdb, $table_prefix;

$users = $wpdb->get_results("select u.*, IFNULL(p.points, 0) as u_points from ".$wpdb->users." u left join ".$table_prefix.'user_points'." p on u.ID=p.user_id order by u_points desc limit 20"); 
foreach ($users as $user) {
    
?>
<div class="topusers" style="clear:left;">
<p class="topusersimg">
<a href="<?php echo get_bloginfo('url').'/?p='.get_option('viewprofile_page_id').'&profile='.($user->user_login);?>"><?php echo get_user_avatar($user->ID);?></a></p>
<div class="submittedbyhome"><a href="<?php echo get_bloginfo('url').'/?p='.get_option('viewprofile_page_id').'&profile='.($user->user_login); ?>"><?php echo $user->display_name;?></a> | Points: <?php echo $user->u_points;?></a></div>
</div>

<?php } ?>

</div><!-- End Content-->

<?php get_sidebar('Questions'); ?>
<?php get_footer(); ?>