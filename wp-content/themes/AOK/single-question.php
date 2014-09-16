<?php get_header(); ?>
<div id="content">

<h1 class="questiontitle"><?php the_title(); ?></h1>
<ul class="questionmeta">
<li><?php _e('Asked in:','wp-answers') ?> <?php echo get_the_term_list(get_the_id(), 'question_category') ?></li>
<li><?php _e('Asked By','wp-answers') ?> <a class="url fn n" href="<?php echo get_link_to_profile(get_the_author_meta('user_login', $post->post_author)); ?>"><?php echo get_the_author_meta('display_name', $post->post_author) ?></a></li>
<li>Asked on <?php the_time('F j, Y') ?></li>
</ul>
<?php the_post(); ?>

<?php the_content(); ?>

<?php comments_template('', true); ?>


</div><!-- Content -->

<?php get_sidebar('Questions'); ?>
<?php get_footer(); ?>