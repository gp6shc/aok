<?php get_header(); ?>
<div class="about">
	<p><?php _e('Category','themefurnace') ?> : <?php single_cat_title() ?></p>
</div>


<div class="content">


<?php while ( have_posts() ) : the_post() ?>
<h2 class="date"><?php the_date('','<p>','</p>'); ?></h2>   
<div <?php post_class( 'question'); ?> id="post-<?php the_ID(); ?>">

<!-- <div class="questionnumber"><p><a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' . __('0', 'wp-answers') . '', '' . __('1', 'wp-answers') . '', '' . __('%', 'wp-answers') . '' ); ?></a></p></div> -->

<div class="avatar"><?php echo get_user_avatar(get_the_author_meta('ID'),50) ?></div>
<div class="questionmain">

<h2 class="questiontitle">
<a href="<?php the_permalink() ?>" rel="bookmark" title="Read <?php the_title_attribute(); ?>">
<?php if (strlen($post->post_title) > 45) {
echo substr(the_title($before = '', $after = '', FALSE), 0, 45) . '.. <i class="fa fa-caret-right"></i>'; } else {
the_title();
} ?>
</a>
</h2>

<ul class="questionmeta">

<li><?php _e('by:','wp-answers') ?> <a class="url fn n" href="<?php echo get_the_author_meta('user_url'); ?>" target="_blank"><?php the_author_meta( 'first_name' ); ?> <?php the_author_meta( 'last_name' ); ?></a></li>
<span>
	<?=function_exists('thumbs_rating_show_up_votes') ? thumbs_rating_show_down_votes() : ''?>
	<i class="fa fa-thumbs-down"></i>
	<?=function_exists('thumbs_rating_show_up_votes') ? thumbs_rating_show_up_votes() : ''?>
	<i class="fa fa-thumbs-up"></i>
</span>


</div>

</ul>

</div><!-- End Question-->
<?php endwhile; ?>

<?php //wp_reset_query(); ?>

</div><!-- End Content -->
<?php wpanswers_pagination(); ?>
<?php get_sidebar('Questions'); ?>
<?php get_footer(); ?>