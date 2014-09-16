<?php
 
 

class Signup_Widget extends WP_Widget {
	
	

	var $prefix;

	var $textdomain;
	
	

	/**

	 * Set up the widget's unique name, ID, class, description, and other options.

	 * @since 0.7

	 */

	function Signup_Widget() {

		$this->prefix = '';

		$this->textdomain = 'signup-widget';
		
		

		$this->plugin_file = 'signup-widget.php';

		$this->settings_url = admin_url( 'widgets.php' );

		$this->donate_url = ''; 

		$this->support_url = ''; 
		
		

		$widget_ops = array('classname' => 'signup-widget', 'description' => __('Displays Login / Signup form.', $this->textdomain) );

		$this->WP_Widget("{$this->prefix}-signup-widget", __('Log in / Sign up', $this->textdomain), $widget_ops); 
		
		

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
		
		

		// display the form if user hasn't logged in

		if(!is_user_logged_in()) { 
		    
		    

		    echo '

                <!--Login Widget-->
                
                

                '.$before_title . $title . $after_title.'

                <p><form action="'.get_option('siteurl').'/wp-login.php" method="post" class="loginwidget" name="loginform">

                <input name="log" type="text"  class="loginbox" value="Username" onblur="if (this.value == \'\')  {this.value = \'Username\';}"  onfocus="if (this.value == \'Username\') {this.value = \'\';}"/>

                <input name="pwd" type="password" class="loginbox" value="Password" onblur="if (this.value == \'\')  {this.value = \'Password\';}"  onfocus="if (this.value == \'Password\') {this.value = \'\';}"/>

                <input type="submit" value="Login" name="wp-submit" class="loginbutton white" />

                <input type="hidden" name="redirect_to" value="'. $_SERVER['REQUEST_URI'] .'" />

                <input type="hidden" name="testcookie" value="1" />

                <a href="'. get_option('siteurl'). '/wp-login.php?action=lostpassword">Forgot Password?</a>

                </form></p>
                
                

                <div class="noaccount">

                <p>Don\'t have an account? <a href="'. get_option('siteurl') .'/signup">Click Here to Signup</a></p>

                <p>

                <a href="'.get_option('home').'/?l=tw"><img src="'.plugins_url( 'img/twitter-button.png' , dirname(__FILE__) ) .'" width="133" height="24" class="twitterbutton"/></a>

                <div id="fbconnect">

                    <fb:login-button scope="offline_access,publish_stream" onlogin="location.href=\''.get_option('home').'/?l=fb\';">Log in with Facebook</fb:login-button>

                </div>

                ';
                
                

                echo '</p>
                
                

                </div>

            ';

        }

        else {

            $user = wp_get_current_user();

            echo '<p>Welcome, '.$user->user_login.'!</p>';

            echo '<p><a href="'.get_bloginfo('url').'/?p='.get_option('viewprofile_page_id').'&profile='.$user->user_login.'">View Profile</a> | <a href="'.get_bloginfo('url').'/?p='.get_option('edit_page_id').'">Edit Profile</a> | <a href="'.wp_logout_url( get_bloginfo('url') ) .'">Logout</a> </p>';

	
	
        }
			
			

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

			'title' => 'Login / Signup',

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
 
 

add_action('widgets_init', 'register_signup_widget');



function register_signup_widget() {

	register_widget('Signup_Widget');

}