<?php 
if(!isset($_SESSION))     {         session_start();     } 
/**
 * Handle all twitter stuff - login, update status
 */
require_once('twitteroauth.php');

/**
 * Handles creating / authenticating the user
 *
 */
function authorize_twitter_user($token, $verifier) {
    global $wpdb, $up_options;
    
    $twitter_consumer_key	= $up_options->twitter_consumer_key; 
	$twitter_consumer_secret = $up_options->twitter_consumer_secret;
    
    $connection = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $_SESSION['twitter_token']['oauth_token'], $_SESSION['twitter_token']['oauth_token_secret']);
    
    // Let's request the access token


    $access_token = $connection->getAccessToken($verifier);


    //var_dump($access_token);exit;
    // Save it in a session var
    $_SESSION['access_token'] = $access_token;
    // Let's get the user's info
    
    //$connection->format = 'xml';
    	
    	/* Run request on twitter API as user. */
    	$xml = $connection->get('account/verify_credentials');

        //var_dump($xml);
    	
        //var_dump($xml->id);

     	$result = $xml;
     	
     	$twitterId = (string)$result->id;
     	
     	$screen_name = (string)$result->screen_name;
    	$name = (string)$result->name;
    	$url = "http://twitter.com/#!/".$name;
		$imageurl = (string)$result->profile_image_url;
    	

    
    if (!empty($twitterId)) {
			
			$sql = "select `user_id` from `".$wpdb->usermeta."` where `meta_value` = '".$twitterId."' and `meta_key` = 'twitteruserid' limit 1";
			$result = $wpdb->get_var($sql);
			
			if (empty($result))
			{
				include_once( ABSPATH . WPINC . '/registration.php' );
  				$userdata = array(
	    			'user_pass' => wp_generate_password(),
    				'user_login' => $screen_name."_twitter",
    				'display_name' => $screen_name."_twitter",
    				'user_url' => $url,
    				'user_email' => $screen_name."@twitter.com"
  				);
  				
  			   $wpuserid = wp_insert_user($userdata);
			}
			else {
				$wpuserid = $result;	             
			}
		}
		if(!empty($wpuserid)) {
		    update_usermeta($wpuserid, 'twitteruserid', $twitterId);
			update_usermeta($wpuserid, 'twitteruserimg', $imageurl);
			update_usermeta($wpuserid, 'twitterusername', $name);
			update_usermeta($wpuserid, 'twitteruserscreenname', $screen_name);
				
      		wp_set_auth_cookie($wpuserid, true, false);
      		wp_set_current_user($wpuserid);
  		}		

       
		wp_safe_redirect(get_option('siteurl'));
		exit;
}

/**
 * Handles twitter authorization (redirects to twitter url if user clicked on "twitter" ion
 *
 * @return void
 */

function twitter_init()
{
	global $wpdb, $user_identity, $user_ID,$table_prefix,$id, $up_options;
	
	if((empty($_GET['l']) || $_GET['l'] != 'tw' || is_user_logged_in()) && !isset($_GET['oauth_token']) && !isset($_GET['oauth_verifier'])) {
        return;
    }
    
    $twitter_consumer_key	= $up_options->twitter_consumer_key; //get_option("qya_textTwitterConsumerKey");
	$twitter_consumer_secret = $up_options->twitter_consumer_secret; //get_option("qya_textTwitterConsumerSecret");		
    		
    
    if(isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
        return authorize_twitter_user($_GET['oauth_token'], $_GET['oauth_verifier']);
    }
    if(empty($twitter_consumer_key) || empty($twitter_consumer_secret)) return;
    
        $connection = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret);
    	$oauth_callback = get_option("siteurl");
        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken($oauth_callback);

        $token = $request_token['oauth_token'];
        $_SESSION['twitter_token'] = $request_token;
        /* If last connection failed don't display authorization link. */

        switch ($connection->http_code) {
          case 200:
            /* Build authorize URL and redirect user to Twitter. */
            $url = $connection->getAuthorizeURL($token);
            header('Location: ' . $url); 
            break;
          default:
            /* Show notification if something went wrong. */
            echo 'Could not connect to Twitter. Refresh the page or try again later.';
        }
        exit;
    
}

/**
 * Handles posting to twitter. APP requires "write" permission.
 *
 * @param int $postID
 * @return int
 */
function twitter_post_question($postID) {
    global $wp_rewrite, $up_options;
    
    if ((isset($_SESSION['twitter_accesstoken'])) && (isset($_SESSION['twitter_accesstokensecret']))) {
		$post_text = strip_tags(get_post_field('post_content',$postID));
		
		if (strlen($post_text)> 70) {
		  $post_text = substr($post_text,0,70)."...";
		}
		
		// Need to do "init" action to get custom post type and its rewrite rules: get_permalink() relies on this
		// WP_Rewrite might be no initialized yet 
        if(!is_object($wp_rewrite)) {
            $wp_rewrite = new WP_Rewrite();
        }
		do_action("init");
		
		$post_text = get_permalink($postID)." : ".$post_text;
		$post_text = urldecode($post_text);
		
		$twitter_consumer_key	= $up_options->twitter_consumer_key; 
	    $twitter_consumer_secret = $up_options->twitter_consumer_secret;
    
		$connection = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $_SESSION['twitter_accesstoken'], $_SESSION['twitter_accesstokensecret']);
    	
		return $connection->oAuthRequest("http://api.twitter.com/1/statuses/update.xml", "POST", array("status"=>$post_text));
    	
	}
	return $postID;
}

/**
 * Handles posting answer to twitter. APP requires write permission.
 *
 * @param int $commentID
 * @return mixed
 */
function twitter_post_answer($commentID)
{
    global $up_options;
    if ((isset($_SESSION['twitter_accesstoken'])) && (isset($_SESSION['twitter_accesstokensecret'])))
	{
		$comment_text = strip_tags(get_comment_text($commentID));
		if (strlen($comment_text)> 70) {
			$comment_text = substr($comment_text,0,70)."...";
		}
		
		$comment_text = get_comment_link($commentID) . " : " . $comment_text;
		$comment_text = urldecode($comment_text);
		
		$twitter_consumer_key	= $up_options->twitter_consumer_key; //get_option("qya_textTwitterConsumerKey");
	    $twitter_consumer_secret = $up_options->twitter_consumer_secret; //get_option("qya_textTwitterConsumerSecret");		
    
		$connection = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $_SESSION['twitter_accesstoken'], $_SESSION['twitter_accesstokensecret']);
    	
		return $connection->oAuthRequest("http://api.twitter.com/1/statuses/update.xml", "POST", array("status"=>$comment_text));
		    	
	}
}

add_action('init',"twitter_init");
add_action('comment_post','twitter_post_answer');
add_action('wp_insert_post','twitter_post_question');