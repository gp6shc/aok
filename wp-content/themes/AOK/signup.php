<?php
/*
Template Name: Signup
*/
?>
<?php get_header(); ?>
<div id="content">


<h1 class="questiontitle"><?php the_title(); ?></h1>
<?php the_post(); ?>
<?php get_template_part('signup', 'form'); ?>

</div><!-- End Content-->

<?php get_sidebar('Questions'); ?>
<?php get_footer(); ?>