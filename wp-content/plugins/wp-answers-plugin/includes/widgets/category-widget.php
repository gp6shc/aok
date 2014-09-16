<?php

function wp_get_cat_postcount($id) {
    $cat = get_category($id);
    $count = (int) $cat->count;
    $taxonomy = 'category';
    $args = array(
      'child_of' => $id,
    );
    $tax_terms = get_terms($taxonomy,$args);
    foreach ($tax_terms as $tax_term) {
        $count +=$tax_term->count;
    }
    return $count;
}


 
class Category_Widget extends WP_Widget {
	
	var $prefix;
	var $textdomain;
	
	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.7
	 */
	function Category_Widget() {
		$this->prefix = '';
		$this->textdomain = 'category-widget';
		
		$this->plugin_file = 'category-widget.php';
		$this->settings_url = admin_url( 'widgets.php' );
		$this->donate_url = ''; 
		$this->support_url = ''; 
		
		$widget_ops = array('classname' => 'category-widget', 'description' => __('Display categories and their post counts', $this->textdomain) );
		$this->WP_Widget("{$this->prefix}-category-widget", __('Categories', $this->textdomain), $widget_ops); 
		
		// Filtering pluginn action links and plugin row meta
		add_filter( 'plugin_action_links', array(&$this, 'plugin_action_links'),  10, 2 );
		add_filter( 'plugin_row_meta', array(&$this, 'plugin_row_meta'),  10, 2 );
	}
	
	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 */
	function widget($args, $instance) {  
		extract( $args );
		
		echo $before_widget;

		/* If there is a title given, add it along with the $before_title and $after_title variables. */
		$title = $instance['title'];
		if ( $title) {
			$title =  apply_filters( 'widget_title',  $title, $instance, $this->id_base );
		}

		$categories = get_terms( 'question_category' );
		
        echo '		
		<!--Categories Widget-->
        ';
        echo $before_title . $title . $after_title;
        
        echo '<ul>';
		
		foreach($categories as $category) {
		    //$count = wp_get_cat_postcount($category->cat_ID);
		    echo '<li class="cat-item cat-item-'.$category->term_id.'"><a href="'.get_bloginfo('url').'/questions/'.$category->slug.'" title="View all posts filed under '.$category->name.'">'.$category->name.'</a> <span class="cat-count">'.$category->count.'</span></li>';
		}
			
		echo '
		</ul>
        <!--End Categories Widget-->
        ';
		
	    echo $after_widget;
   }
	
	/**
	 * Updates the widget control options for the particular instance of the widget.
	 */
	function update($new_instance, $old_instance) {                
       return $new_instance;
   }
	
	/**
	 * Displays the widget control options in the Widgets admin screen.
	 */
	function form($instance) {  
		$defaults = array(
			'title' => 'Categories',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
   
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', $this->textdomain ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
        
       <?php
	}
	
	function plugin_action_links( $actions, $plugin_file ) {
			if ( $plugin_file == $this->plugin_file && $this->settings_url)
				$actions[] = '<a href="'.$this->settings_url.'">' . __('Settings', 'dp-core') .'</a>';
			
			return $actions;
		}
	
	function plugin_row_meta( $plugin_meta, $plugin_file ){
			if ( $plugin_file == $this->plugin_file ) {
				$plugin_meta[] = '<a href="'.$this->donate_url.'">' . __('Donate', 'dp-core') .'</a>';
				$plugin_meta[] = '<a href="'.$this->support_url.'">' . __('Support', 'dp-core') .'</a>';
			}

			return $plugin_meta;
		}

}
 
add_action('widgets_init', 'register_category_widget');

function register_category_widget() {
	register_widget('Category_Widget');
}