<?php get_header(); ?><div class="content"><h2 class="questiontitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="Read <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2><ul class="questionmeta"><!--<li><?php _e('by:','wp-answers') ?> <a class="url fn n" href="<?php echo get_the_author_meta('user_url'); ?>" target="_blank"><?php the_author_meta( 'first_name' ); ?> <?php the_author_meta( 'last_name' ); ?></a></li>--></ul><?php the_post(); ?><?php the_content(); ?><hr><?=function_exists('thumbs_rating_getlink') ? thumbs_rating_getlink() : ''?><?php comments_template('', true); ?></div><!-- Content --><?php get_sidebar('Questions'); ?><?php get_footer(); ?>