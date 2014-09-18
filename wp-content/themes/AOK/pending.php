<?php
/*
Template Name: Pending
Used for thankyou page 
*/

get_header();
?>
    <div class="content">

        <h1 class="questiontitle"><?php the_title(); ?></h1>
        <ul class="questionmeta">
            <li><?php _e('Posted in:','wp-answers') ?> <?php echo get_the_term_list(get_the_id(), 'question_category') ?></li>
            <li><?php _e('Posted By','wp-answers') ?> <a class="url fn n" href="<?php echo get_link_to_profile(get_the_author_meta('user_login', $post->post_author)); ?>"><?php echo get_the_author_meta('display_name', $post->post_author) ?></a></li>
            <li>Posted on <?php the_time('F j, Y') ?></li>
        </ul>
        <?php the_post(); ?>

        <?php the_content(); ?>

        <?php comments_template('', true); ?>


    </div><!-- Content -->

<?php get_sidebar('Blog'); ?>
<?php get_footer(); ?>