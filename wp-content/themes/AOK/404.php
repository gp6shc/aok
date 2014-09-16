<?php get_header(); ?>
<h1 class="posttitle"><?php _e('404 - Nothing Found','themefurnace') ?></h1>
<div id="main">

<div id="content">

<?php the_post(); ?>

<?php the_post_thumbnail('post-thumb', array('class' => 'featuredimage')); ?>
<?php the_content(); ?>

<p><?php _e('Nothing found for this page.','themefurnace') ?></p>

</div><!-- End Content -->

<br class="clear" />

</div><!-- End Container -->

<?php get_footer(); ?>