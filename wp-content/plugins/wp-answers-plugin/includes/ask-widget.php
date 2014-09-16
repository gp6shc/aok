<?php
/**
 * "Ask a question" widget
 * Used in cases when plugin and theme are separate
 *
 */
class Ask_Widget extends WP_Widget {
	
	var $prefix;
	var $textdomain;
	
	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 * @since 0.7
	 */
	function Ask_Widget() {
		$this->prefix = '';
		$this->textdomain = 'ask-widget';
		
		$this->plugin_file = 'ask-widget.php';
		$this->settings_url = admin_url( 'widgets.php' );
		$this->donate_url = ''; 
		$this->support_url = ''; 
		
		$widget_ops = array('classname' => 'ask-widget', 'description' => __('Displays "Ask a question" form.', $this->textdomain) );
		$this->WP_Widget("{$this->prefix}-ask-widget", __('Ask a question', $this->textdomain), $widget_ops); 
		
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
		
		// display the form
	    echo ask_a_question();
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
			'title' => 'Ask a question',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
   
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
 
add_action('widgets_init', 'register_ask_widget');

function register_ask_widget() {
	register_widget('Ask_Widget');
}

/**
 * Returns "ask a question" form, for use in templates 
 *
 * @return string
 */
function ask_a_question() {
    return '
    <p>
    <form action="'.get_bloginfo('url').'/?p='.get_option('submit_page_id').'" method="get"  class="ask">
    <input name="p" type="hidden" value="'.get_option('submit_page_id').'" />
    <input name="q" type="text" class="askinput" value="Ask a Question" onblur="if (this.value == \'\')  {this.value = \'Ask a Question\';}"  onfocus="if (this.value == \'Ask a Question\') {this.value = \'\';}"/>
    <input type="submit" value="Ask" class="topbutton topblue" />
    </form>
    </p>
    ';
}