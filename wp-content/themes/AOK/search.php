<?php get_header(); ?>

<div class="content">

<h1 class="questiontitle"><?php _e('Search Results for','themefurnace') ?> <?php the_search_query(); ?></h2>

<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>


<?php while ( have_posts() ) : the_post() ?>
<div <?php post_class( 'question'); ?> id="post-<?php the_ID(); ?>">
<div class="questionnumber"><p><a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' . __('0', 'wp-answers') . '', '' . __('1', 'wp-answers') . '', '' . __('%', 'wp-answers') . '' ); ?></a></p></div>
<div class="questionmain">
<h2 class="questiontitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<ul class="questionmeta">
<li><?php _e('Asked in:','wp-answers') ?> <?php echo get_the_term_list(get_the_id(), 'question_category') ?></li>
<li><?php _e('Asked By','wp-answers') ?> <a class="url fn n" href="<?php echo get_link_to_profile(get_the_author_meta('user_login')); ?>"><?php the_author(); ?></a></li>
<li>Asked on <?php the_time('F j, Y') ?></li>
</div>
</ul>
</div><!-- End Question-->
<?php endwhile; ?>
<?php //wp_reset_query(); ?> 


<?php wpanswers_pagination(); ?>
</div><!-- End content -->

<?php get_sidebar('Questions'); ?>
<?php get_footer(); ?>