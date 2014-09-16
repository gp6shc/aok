<br class="clear" />
<div id="footer">

<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 1') ) ?>

<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 2') ) ?>

<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 3') ) ?>

<?php	/* Widgetised Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer 4') ) ?>


<br class="clear" />
<div id="bottom">
<p><?php custom_footer_logo();?></p>
<p class="copy"><?php echo custom_footer_text();?><br />
<?php _e('&copy; Copyright','themefurnace') ?> <?php the_time('Y') ?> <?php bloginfo('name'); ?> - <?php _e('Powered by WordPress','wp-answers') ?> 
&amp; <a href="http://wp-answers.com"><?php _e('Question &amp; Answer Theme','wp-answers') ?></a>
</p>
<?php echo custom_footer_scripts(); ?>

</div><!-- End Bottom -->
</div><!-- End Footer-->
</div><!-- End Container -->
<?php wp_footer(); ?>
</body>
</html>