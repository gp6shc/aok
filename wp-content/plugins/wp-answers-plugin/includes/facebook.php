<?php

/**

 * Handle fb connect

 *

 */





require_once('facebook-php-sdk/src/facebook.php');

require_once(ABSPATH . 'wp-includes/pluggable.php');

add_action("init", "wpanswers_fb_init");



/**

 * Handle FB authenticating and creating user/logging in

 *

 */

function wpanswers_fb_init()

{

    if(empty($_GET['l']) || $_GET['l'] != 'fb' || is_user_logged_in()) {

        return;

    }

    

    global $wpdb, $up_options;



    $facebook_app_id = $up_options->facebook_app_id;

    $facebook_app_secret = $up_options->facebook_app_secret;

    

    if (!empty($facebook_app_id) && !empty($facebook_app_secret))

    {



        $facebook = new Facebook(array(

        'appId'  => $facebook_app_id,

        'secret' => $facebook_app_secret,

        'cookie' => true

        ));



        // See if there is a user from a cookie

        $user = $facebook->getUser();



        if ($user>0) {

            try {

                // Proceed knowing you have a logged in user who's authenticated.

                $user_profile = $facebook->api('/me');

            } catch (FacebookApiException $e) {

                echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';

                $user = null;

            }

        }







        $fid = $user;

        $wpuser = wp_get_current_user();



        if(isset($wpuser->ID) && $wpuser->ID > 0) {

            return;

        }



        if (!empty($fid))

        {

            $table_name = $table_prefix."usermeta";

            $sql = "select `user_id` from ".$wpdb->usermeta." where `meta_value` = '".$fid."' and `meta_key` = 'facebookuserid' limit 1";

            $result = $wpdb->get_var($sql);



            if (empty($result))

            {

                //$userinfo = $connectApi->users_getInfo(array($fid),array('name','first_name','last_name','profile_url'));

                $userinfo = $facebook->api('/me?fields=id,name,first_name,last_name,picture');



                if(!empty($userinfo))

                {

                    include_once( ABSPATH . WPINC . '/registration.php' );

                    //$userinfo = $userinfo[0];

                    $username = str_replace(" ",'_',$userinfo['name']);

                    $userdata1 = array(

                    'user_pass' => wp_generate_password(),

                    'user_login' => $username."_facebook",

                    'display_name' => $username."_facebook",

                    'user_url' => "http://www.facebook.com/profile.php?id=$fid",

                    'first_name' => $userinfo['first_name'],

                    'last_name' => $userinfo['last_name'],

                    'user_email' => $username."@facebook.com"

                    );



                    $wpuserid = $wpdb->get_var("select id from ".$wpdb->users." where user_email='".$username.'@facebook.com'."'");

                    if(empty($wpuserid)) {

                        $wpuserid = wp_insert_user($userdata1);

                    }

                    wp_set_current_user($wpuserid);





                    update_usermeta($wpuserid, 'facebookuserid', $fid);

                    //update_usermeta($wpuserid, 'facebookuserimg', "<fb:profile-pic uid='$fid' facebook-logo='true' size='square'></fb:profile-pic>");

                    update_usermeta($wpuserid, 'facebookuserimg', $userinfo['picture']['data']['url']); //"<fb:profile-pic uid='$fid' facebook-logo='true' size='square'></fb:profile-pic>");

                    update_usermeta($wpuserid, 'facebookusername', $userinfo['name']);

                    update_usermeta($wpuserid, 'facebookuserscreenname', $userinfo['name']);



                }

            }

            else

            {

                $wpuserid = $result;

            }

            if(!empty($wpuserid))

            {

                wp_set_auth_cookie($wpuserid, true, false);

                wp_set_current_user($wpuserid);

                if( isset($_GET['p']) ) {
					wp_safe_redirect( home_url('/?p='.$_GET['p']) );
                }else{
					wp_safe_redirect( home_url('/submit-idea') );
				}

                exit;

            }

        }

    }

}



/**

 * Prepare question (set html element that is later handled)

 *

 * @param $content

 */

function facebook_prepare($content)

{

	global $post;

	if ((is_single()) || (is_page())) {

		$_SESSION['currentPostID'] = $post->ID;

	}

	

	$user = wp_get_current_user();

	

	if($post->post_author != $user->ID) {

	    return $content;

	}

	

	$content = $content ."<div style='display:none;'><input type='button' id='facrun'  onclick='fapublish();'></div>";

	return $content;

}



/**

 * Load FB JS SDK and posting to FB function.

 *

 */

function facebook_post() 

{

	load_facebook_js();

	

    sleep(1);

	

    if((!is_single() && !is_page()) || !isset($_SESSION['currentPostID'])) {

        return;

    }

    

	$user = wp_get_current_user();

	$post = get_post($_SESSION['currentPostID']);



	if(empty($post) || $post->post_author != $user->ID) {

	    return;

	}

	

	$has_published = get_post_meta($post->ID,'facebooked',true);

    if($has_published == 'YES') {

		return;

	}

	

	$blog = get_option("blogname");

	$url = get_permalink($post->ID);

	

	// get post image

	$args = array(

        'post_type' => 'attachment',

        'numberposts' => -1,

        'post_status' => null,

        'post_parent' => $post->ID

    );



    $attachments = get_posts( $args );

    

    $img = '';

    if ( $attachments ) {

        foreach ( $attachments as $attachment ) {

            $img = wp_get_attachment_image_src( $attachment->ID );

            break;

        }

    }

?>

    

<script type="text/javascript">

function fapublish()

{

    var obj = {

          method: 'feed',

          link: '<?php echo $url;  ?>',

          picture: '<?php echo $img; ?>',

          name: '<?php echo strip_tags(str_replace("'", "", $post->post_title)); ?>',

          caption: '<?php echo "My question about ".strip_tags(str_replace("'", "", $post->post_title))." on ".$blog;?>',

          description: '<?php echo "summary: ".substr(strip_tags(str_replace("'", "", $post->post_content)), 0, 100);  ?>'

    };



    FB.ui(obj, function() { return true;});

}

document.getElementById('facrun').click();

</script>



<?php

    update_post_meta($post->ID, 'facebooked', 'YES');

  

}



/**

 * Load Facebook JS SDK

 */



function load_facebook_js() {

    global $up_options;

    if(empty($up_options->facebook_app_id)) return;

    

    echo '

    <script type="text/javascript" src="//connect.facebook.net/en_US/all.js"></script>

	<div id="fb-root"></div>

    <script type="text/javascript">

            FB.init({

                appId: "'.$up_options->facebook_app_id.'",

                status: true,

                cookie: true,

                xfbml: true,

                oauth: true

            });

 

            FB.Event.subscribe(\'auth.statusChange\', function(response) {

                if (!response.authResponse) {

                    FB.disconnect({ reload: (window.location.pathname == \'/settings/extend\') });

                }

            });

       

    </script>

    

    ';



}



add_filter('the_content',"facebook_prepare");

add_action('wp_footer',"facebook_post");