<?php
/**
 * Tabber Widget
 */
class example_widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function example_widget() {
        parent::WP_Widget(false, $name = 'Tabber');
    }
	
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $message 	= $instance['message'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul class="tabs">
    <li><a href="#tab1">Recent</a></li>
    <li><a href="#tab2">Comments</a></li>
    <li><a href="#tab3">Popular</a></li>
</ul>

<div class="tab_container">
<div id="tab1" class="tab_content">
    
<?php query_posts('showposts=5'); ?>
<?php while (have_posts()) : the_post(); ?>
<div class="tabpost">
<?php the_post_thumbnail('small-thumb', array('class' => 'tabthumb')); ?>
<p class="tabtitle"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
<p class="tabmeta"><?php the_time('j/n/Y') ?> <?php comments_number( 'No Comments', 'One Comment', '% Comments' ); ?></p>
</div>
<?php endwhile;?>
<?php wp_reset_query(); ?>     
</div>
    
    
<div id="tab2" class="tab_content">

<?php 
global $wpdb;
$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
$comments = $wpdb->get_results($sql);
foreach ($comments as $comment) :
?>

<div class="tabpost">
<?php echo get_avatar( $comment, '45' ); ?>
<p class="tabtitle"><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?><?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->comment_author); ?>: <?php echo strip_tags($comment->com_excerpt); ?></a></p>
</div>
<?php endforeach; ?>
<?php wp_reset_query(); ?>

</div> 


<div id="tab3" class="tab_content">
<?php  
$popPosts = new WP_Query();
$popPosts->query('ignore_sticky_posts=1&posts_per_page=5&orderby=comment_count');
while ($popPosts->have_posts()) : $popPosts->the_post(); ?>
<div class="tabpost">
<?php the_post_thumbnail('small-thumb', array('class' => 'tabthumb')); ?>
<p class="tabtitle"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
<p class="tabmeta"><?php the_time('j/n/Y') ?> <?php comments_number( 'No Comments', 'One Comment', '% Comments' ); ?></p>
</div>
<?php endwhile; ?>
<?php wp_reset_query(); ?>
</div>


</div>
              <?php echo $after_widget; ?>
        <?php
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['message'] = strip_tags($new_instance['message']);
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
 
        $title 		= esc_attr($instance['title']);
        $message	= esc_attr($instance['message']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','themefurnace'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<?php
		/*<p>
          <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo $message; ?>" />
        </p>*/?>
        <?php
    }
 
 
} // end class example_widget
add_action('widgets_init', create_function('', 'return register_widget("example_widget");'));
?>
