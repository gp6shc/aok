<?php get_header(); ?>

<div id="blog">





<?php while ( have_posts() ) : the_post() ?>
<div class="blogitem" id="post-<?php the_ID(); ?>">
<p><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-thumb', array('class' => 'blogimage')); ?></a></p>
<h3 class="itemintro"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
<p class="meta"><?php the_time('F j, Y') ?> - <a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' . __('No Comments', 'themefurnace') . '', '' . __('One Comment', 'themefurnace') . '', '' . __('% Comments', 'themefurnace') . '' ); ?></a></p>
<?php the_excerpt(); ?>
</div>
<?php endwhile; ?>
<?php wp_reset_query(); ?> 

</div><!-- End Blog -->
<?php wpanswers_pagination(); ?>


<?php get_footer(); ?>