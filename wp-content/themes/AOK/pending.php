<?php
/*
Template Name: Pending
Used for thankyou page 
*/

get_header();
?>
    <div class="content">

        <h1 class="questiontitle"><?php the_title(); ?></h1>

        <?php the_post(); ?>

        <?php the_content(); ?>



    </div><!-- Content -->

<?php get_sidebar('Blog'); ?>
<?php get_footer(); ?>