<?php
/*
Template Name: Left Sidebar Page
*/
?>
<?php get_header(); ?>
<div id="content">


<h1 class="questiontitle"><?php the_title(); ?></h1>
<?php the_post(); ?>

<?php the_content(); ?>


</div><!-- End Content -->


<?php get_sidebar('Page'); ?>

<?php wpanswers_pagination(); ?>

<?php get_footer(); ?>