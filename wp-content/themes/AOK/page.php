<?php get_header(); ?><div class="about">	<p>Accountability Okaloosa is a platform for bringing the priorities of all Okaloosa County citizens and property owners to the attention of their state, county and municipal elected officials.</p></div><div class="content"><?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?><?php query_posts( 'post_type=question&paged='.$paged); ?><?php while ( have_posts() ) : the_post() ?><h2 class="date"><?php the_date('','<p>','</p>'); ?></h2>   <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" <?php post_class( 'question'); ?> id="post-<?php the_ID(); ?>">	<div class="avatar"><?php echo get_user_avatar(get_the_author_meta('ID'),50) ?></div>		<div class="questionmain">		<h2 class="questiontitle">			<?php if (strlen($post->post_title) > 45) {			    	echo substr(the_title($before = '', $after = '', FALSE), 0, 45) . '.. <i class="fa fa-caret-right"></i>'; 			    } else {			    	the_title();			    } ?>		</h2>				<ul class="questionmeta">			<li>In: <?php echo strip_tags(get_the_term_list( $post->ID, 'question_category')); ?> | <?php the_author_meta( 'first_name' ); ?> <?php the_author_meta( 'last_name' ); ?>							<span>				    <?=function_exists('thumbs_rating_show_up_votes') ? thumbs_rating_show_down_votes() : ''?>				    <i class="fa fa-thumbs-down"> | </i>				    <?=function_exists('thumbs_rating_show_up_votes') ? thumbs_rating_show_up_votes() : ''?>				    <i class="fa fa-thumbs-up"></i>				</span>			</li>		</ul>			</div></a><!-- End Question--><?php endwhile; ?><?php //wp_reset_query(); ?> <?php wpanswers_pagination(); ?></div><!-- End Content--><?php get_sidebar('Questions'); ?><?php get_footer(); ?>