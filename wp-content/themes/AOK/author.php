<?php get_header(); ?>

<div id="blog">

<h2 class="intro"><?php _e('Author Archives','themefurnace') ?></h2>
<p class="meta"><?php _e('Last Updated','themefurnace') ?> <?php the_modified_time('F j, Y'); ?></p>

<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
<?php $author - get_query_var('author');?>
<?php query_posts( 'post_type=question&paged='.$paged.'&author='.$author); ?>

<?php while ( have_posts() ) : the_post() ?>
<div <?php post_class( 'question'); ?> id="post-<?php the_ID(); ?>">
<div class="questionnumber"><p><a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' . __('0', 'wp-answers') . '', '' . __('1', 'wp-answers') . '', '' . __('%', 'wp-answers') . '' ); ?></a></p></div>
<div class="questionmain">
<h2 class="questiontitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<ul class="questionmeta">
<li><?php _e('Asked in:','wp-answers') ?> <?php echo get_the_term_list(get_the_id(), 'question_category') ?></li>
<li><?php _e('Asked By','wp-answers') ?> <a class="url fn n" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></li>
<li>Asked on <?php the_time('F j, Y') ?></li>
</div>
</ul>
</div><!-- End Question-->
<?php endwhile; ?>

<?php //wp_reset_query(); ?> 

</div><!-- End Blog -->
<?php wpanswers_pagination(); ?>


<?php get_footer(); ?>