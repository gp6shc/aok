<?php
include_once('AwAPI.class.php');
class SocialMedia extends WP_Widget {
 
	/**
	 * constructor
	 */	 
	function SocialMedia() {
		parent::WP_Widget('capiton_socialmedia', 'Social media', array('description' => 'Display social media content'));	
	}
 
	/**
	 * display widget
	 */	 
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		/*
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		?>
		<p>Hello, i'm your multi-widget example. You can add me many many times :).</p>
		<p>Check out other articles at <a href="http://justcoded.com/" target="_blank">JustCoded</a>.</p>
		<?php 
		
		*/
		
		global $up_options;
    //echo $args['before_widget'];
        //$opts = get_option('social_media');
        //$title = $opts['option1'];
        $title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
        
        // display the content
        echo '<ul id="socialmedia">';
        
        if($up_options->facebook_icon != 'hidden' && strlen($up_options->facebook_id)>2) {
            $prefix = '';
            $up_options->facebok_id = str_replace("https//", "", $up_options->facebook_id);
            $up_options->facebok_id = str_replace("http//", "", $up_options->facebook_id);
            if(strpos($up_options->facebok_id, 'http://') === false && strpos($up_options->facebok_id, 'https://') === false) {
                $prefix = 'http://';
            }
            echo '<li class="facebook"><span class="socialnumber"><a href="'.$prefix.$up_options->facebook_id.'">'.$this->social_media_get_fb_count().' </a></span><p>Fans</p></li>'; 
        }
        
        if($up_options->twitter_icon != 'hidden' && !empty($up_options->twitter_id)) {
            echo '<li class="twitter"><span class="socialnumber"><a href="http://twitter.com/'.$up_options->twitter_id.'">'.$this->social_media_get_twitter_count().' </a></span><p>Followers</p></li>';
        }
        
        if($up_options->feedburner_icon != 'hidden' && !empty($up_options->feedburner_url)) {
            $prefix = '';
            if(strpos($up_options->facebok_id, 'http://') === false) {
                $prefix = 'http://';
            }
            
            echo '<li class="rss"><span class="socialnumber"><a href="http://feeds.feedburner.com/'.$up_options->feedburner_url.'">'.$this->social_media_get_feedburner_count().' </a></span><p>Subscribers</p></li>';
        }
        
        if($up_options->dribbble_icon != 'hidden' && !empty($up_options->dribbble_url)) {
            $prefix = '';
            if(strpos($up_options->dribbble_url, 'http://') === false) {
                $prefix = 'http://';
            }
            
            echo '<li class="dribbble"><span class="socialnumber"><a href="http://dribbble.com/'.$up_options->dribbble_url.'">'.$this->social_media_get_dribbble_count().' </a></span><p>Followers</p></li>';
        }
        
        
        echo '</ul>';
    
    //echo $args['after_widget'];
		
		
		echo $after_widget;
	}
 
	/**
	 *	update/save function
	 */	 	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
 
	/**
	 *	admin control form
	 */	 	
	function form($instance) {
		$default = 	array( 'title' => __('Social media','themefurnace') );
		$instance = wp_parse_args( (array) $instance, $default );
 
		$field_id = $this->get_field_id('title');
		$field_name = $this->get_field_name('title');
		echo "\r\n".'<p>This widget displays social media icons and follower count.</p><p><label for="'.$field_id.'">'.__('Title').': <input type="text" class="widefat" id="'.$field_id.'" name="'.$field_name.'" value="'.attribute_escape( $instance['title'] ).'" /><label></p>';
	}
	
	function social_media_get_fb_count() {
        global $up_options;
        
        $res = get_option('social_media_fb');
        // cache - one hour
        if(!empty($res) && isset($res['retrieved'])) {
            if(time() < $res['retrieved']+72000)
                return $res['count'];
        }
        $fb_page = array_pop(explode("/", $up_options->facebook_id));
        $response = wp_remote_get("https://graph.facebook.com/".$fb_page);
        if(is_object($response) && isset($response->errors)) {
            $response = wp_remote_get("https://graph.facebook.com/".$fb_page);
        }
        
        if(is_array($response) && isset($response['body'])) {        
            $tmp = json_decode($response['body']);
            $count = $tmp->likes;        
            // store result        
            $result = array('retrieved' => time(), 'count' => $count);
            update_option('social_media_fb', $result);
            
            return $count;
        }
        else {
            return $res['count'];
        }
    }

    function social_media_get_twitter_count() {
        global $up_options;
        
        $twitter_id = $up_options->twitter_id;
        if(!empty($twitter_id)) {
            $res = get_option('social_media_twitter');
            // cache - one hour
            if(!empty($res) && isset($res['retrieved'])) {
                if(time() < $res['retrieved']+72000)
                    return $res['count'];
            }
            $response = wp_remote_get("https://api.twitter.com/1/users/show.json?screen_name=".$twitter_id."&include_entities=true");
             if(is_object($response) && isset($response->errors)) {
                // try again, sometimes name lookup fails
                $response = wp_remote_get('http://api.dribbble.com/'.$dribbble_id);
            }
            if(is_array($response)) {
                $response = json_decode($response['body']);
                // store result (twitter limits number of requests per day)
                $result = array('retrieved' => time(), 'count' => $response->followers_count);
                update_option('social_media_twitter', $result);
                
                return $response->followers_count;
            }
            else {
                return $res['count'];
            }
        }
    }
    
    function social_media_get_feedburner_count() {
        global $up_options;
        
        $feedburner_id =  $up_options->feedburner_url; //array_pop(explode("/", $up_options->feedburner_url));        
        if(!empty($feedburner_id)) {
            $res = get_option('social_media_feedburner');
            // cache - one hour
            if(!empty($res) && isset($res['retrieved'])) {
                if(time() < $res['retrieved']+72000)
                    return $res['count'];
            }
    		
        	$fbid = $feedburner_id;
        			
        	$aw = new AwAPI($fbid);
        		
        	try{	    
        	    $tm = 3600*24*2;
        	    $ts = time() - $tm;
        	    $res = $aw -> FeedDataHistory(date("Y-m-d", $ts), date("Y-m-d") );
           	    $count = $res[date("Y-m-d", $ts)]['circulation'];
        	}
        		
        	catch(Exception $e){}
        	
            // store result
            if(!empty($count)) {
                $result = array('retrieved' => time(), 'count' => (string)$count);
                update_option('social_media_feedburner', $result);
                
                return (string)$count;
            }
            else {
                return $res['count'];
            }
        }
    }
    
    function social_media_get_dribbble_count() {
        global $up_options;
        
        $dribbble_id = $up_options->dribbble_url; //array_pop(explode("/", $up_options->dribbble_url));
        if(!empty($dribbble_id)) {
            $res = get_option('social_media_dribbble');
            // cache - one hour
            
            if(!empty($res) && isset($res['retrieved'])) {
                if(time() < $res['retrieved']+72000) {
                    return $res['count'];
                }
            }
            
            $response = wp_remote_get('http://api.dribbble.com/'.$dribbble_id);
            
            if(is_object($response) && isset($response->errors)) {
                // try again, sometimes name lookup fails
                $response = wp_remote_get('http://api.dribbble.com/'.$dribbble_id);
            }
            // if we got the result, update the local cache too
            if(is_array($response)) {
                $content = json_decode($response['body']);
                // store result
                $result = array('retrieved' => time(), 'count' => (string)$content->followers_count);
                update_option('social_media_dribbble', $result);
                return $content->followers_count;
            }
            // if we got an error, display the cached result.
            else {
                return $res['count'];
            }
            
        }
    }
	
}
add_action('widgets_init', create_function('', 'return register_widget("SocialMedia");'));
return;