<?php/*Template Name: Blog*/?><?php get_header(); ?><div id="content"><?php query_posts( ''); ?><?php while ( have_posts() ) : the_post() ?><div <?php post_class( 'question'); ?> id="post-<?php the_ID(); ?>"><!--<div class="questionnumber"><p><a href="<?php the_permalink(); ?>#comments"><?php comments_number( '' . __('0', 'wp-answers') . '', '' . __('1', 'wp-answers') . '', '' . __('%', 'wp-answers') . '' ); ?></a></p></div>--><div class="event"><i class="fa fa-calendar-o fa-3x"></i></div><div class="questionmain"><h2 class="questiontitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><ul class="questionmeta"><li><?php the_time('F j, Y') ?></li></div></ul><?php the_content(); ?></div><!-- End Question--><?php endwhile; ?><?php wp_reset_query(); ?> <?php wpanswers_pagination(); ?></div><!-- End Content--><?php get_sidebar('Blog'); ?><?php get_footer(); ?>