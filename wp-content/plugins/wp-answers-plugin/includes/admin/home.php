<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#theme-options').submit(function(event){
			var recaptcha_new_question =document.getElementById('recaptcha_new_question').value;
			var recaptcha_signup =document.getElementById('recaptcha_signup').value;
			if(is_recaptcha)
			{
				 if(recaptcha_new_question=='true' || recaptcha_signup=='true'){
					   
					    jQuery( ".wpaRecaptchaError" ).remove();
						var invalid=false;
						var public_key = jQuery('#recaptcha_public_key').val();
						var private_key = jQuery('#recaptcha_private_key').val();
						if (public_key == '') {
							var privetKeyErrorHTML='<span class="wpaRecaptchaError" style="color:red;margin-left: 22px;">*Required</span>';
							jQuery('#recaptcha_public_key').parent().append(privetKeyErrorHTML);
							invalid=true;
						}
						if (private_key == '') {
							var privateKeyErrorHTML='<span class="wpaRecaptchaError" style="color:red;margin-left: 22px;">*Required</span>';
							jQuery('#recaptcha_private_key').parent().append(privateKeyErrorHTML);
							invalid=true;
						}
						if(invalid){
							event.preventDefault();
						}
				 }
			}
		});
	});
</script>
<?php if ( is_user_logged_in() ):?>

	<?php //$upthemes =  THEME_DIR.'/admin/';?>
	<?php $upthemes =  dirname(__FILE__);?>
	
	<script type="text/javascript">
	    var upThemes = "<?php echo THEME_DIR; ?>";
	</script>

	<div id="upthemes_framework" class="wrap">
	    
		<?php upfw_admin_header(); ?>
    
		<form method="post" enctype="multipart/form-data" action="" id="theme-options" name="theme-options">
		    
		<?php //Security Nonce For Cross Site Hacking
        wp_nonce_field('save_upthemes','upfw'); ?>
		    
		<div class="button-zone-wrapper zone-top">
		    <div class="button-zone">
			<span class="top">
			    <span class="formState"><?php _e("Theme options have changed. Make sure to save.","upfw"); ?></span>
			    <button class="save" id="up_save" name="up_save" type="submit"><?php _e("Save Changes","upfw"); ?></button>
			    <button class="button" type="reset"><?php _e("Discard Changes","upfw"); ?></button>
			</span>
		    </div><!-- .button-zone -->
		</div><!-- /.button-zone-wrapper -->
		
		<div id="up_main">

				<div id="up_sidebar">
				
					<div id="up_nav" class="box">
						
						<ul>
							<?php //Create dynamic tab links from array
							global $up_tabs;
							    foreach ($up_tabs as $tab):
								foreach($tab as $title => $shortname):?>
								    <li class="<?php echo $shortname?>"><a href="#<?php echo $shortname?>"><?php echo $title?></a></li>
								<?php endforeach;
							    endforeach;?>
							<?php // include theme options if user has plugin + theme ?>
							<?php $themepath = get_theme_root().'/'.get_template(); ?>
							
							<?php
							
							if (is_dir($themepath.'/theme-options/') && $handle = opendir($themepath.'/theme-options/')) {
                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != "..") {
                                        $tmp = explode("_", $entry);
                                        array_pop($tmp);
                                        $opt_name = implode(' ', $tmp);
                                        echo '<li class="wpanswers-'.str_replace(' ', '-', $opt_name).'"><a href="#wpanswers-'.str_replace(' ', '-', $opt_name).'">'. __(ucwords($opt_name),"upfw").'</a></li>';
                                    }
                                }
                                closedir($handle);
                            }
                            ?>
							
							<li class="import-export"><a href="#import-export"><?php _e("Import/Export","upfw"); ?></a></li>
							
							<li class="word-count" id="word_count_menu"><a href="#wordcount"><?php _e("Word Count Limit","upfw"); ?></a></li>
							<li class="limit-response" id="limit_response"><a href="#limitresponse"><?php _e("Limit responses","upfw"); ?></a></li>
							
							<li class="user-approve" id="user_approve"><a href="#userapprove"><?php _e("New User Approve","upfw"); ?></a></li>
							
							<?php
								if (is_plugin_active('WP-Answers-Plugin-Paypal/wp-answers-plugin-paypal.php')) {
									echo '<li class="paypal"><a href="#wpanswers-paypal">'.__('PayPal Settings', 'upfw').'</a></li>';
								}
								if (is_plugin_active('WP-Answers-Plugin-User-Levels/wp-answers-plugin-user-levels.php')) {
									echo '<li class="user-levels"><a href="#wpanswers-user-levels">'.__('User Levels', 'upfw').'</a></li>';
								}
							?>
							
						</ul>
									
					</div><!-- /#up_nav -->
				
				</div><!-- /#up_sidebar -->
				
				<div id="up_content">
					<div id="tabber">
					    <?php //Create dynamic tabs from array
					    foreach ($up_tabs as $order => $tab):
						foreach($tab as $title => $shortname):?>
						    <div id="<?php echo $shortname?>">
							<h3><?php echo $title?></h3>
							<ul class="feature-set">
							    <?php //require_once (THEME_PATH . '/theme-options/'.$shortname.'_'.$order.'.php'); ?>
							    <?php require_once (dirname(__FILE__) . '/../theme-options/'.$shortname.'_'.$order.'.php'); ?>
							</ul>										
						    </div><!-- /#<?php echo $shortname?> -->
						<?php endforeach;
					    endforeach;
					    
					    $themepath = get_theme_root().'/'.get_template();
					    // include theme options if user has plugin + theme
					    	
							if (is_dir($themepath.'/theme-options/') && $handle = opendir($themepath.'/theme-options/')) {
                                while (false !== ($entry = readdir($handle))) {
                                    if ($entry != "." && $entry != "..") {
                                        $tmp = explode("_", $entry);
                                        array_pop($tmp);
                                        $opt_name = implode(' ', $tmp);
                                        //echo '<li class="wpanswers-'.str_replace(' ', '-', $opt_name).'"><a href="#wpanswers-'.str_replace(' ', '-', $opt_name).'">'. __(ucwords($opt_name),"upfw").'</a></li>';
                                        echo '<div id="wpanswers-'.str_replace(' ', '-', $opt_name).'">';
							            echo '<h3>'. ucwords($opt_name).'</h3>';
							            echo '<ul class="feature-set">';
						                require_once($themepath . '/theme-options/'.$entry);
						                echo '</ul>';
						                echo '</div><!-- /#wpanswers-'.str_replace(' ', '-', $opt_name).' -->';
                                    }
                                }
                                closedir($handle);
                            }
							
                            if (is_plugin_active('WP-Answers-Plugin-Paypal/wp-answers-plugin-paypal.php')) {
                            	echo '<div id="wpanswers-paypal">';
                            	echo '<h3>WP Answers PayPal Settings</h3>';
                            	echo '<ul class="feature-set">';
                            	//require_once($themepath . '/theme-options/'.$entry);
                            	$dir = plugin_dir_path( __FILE__ );
                            	include($dir.'../../../WP-Answers-Plugin-Paypal/includes/paypal-settings.php');
                            	echo '</ul>';
                            	echo '</div><!-- /#wpanswers-paypal -->';
                            }
                            
                            if (is_plugin_active('WP-Answers-Plugin-User-Levels/wp-answers-plugin-user-levels.php')) {
                            	echo '<div id="wpanswers-user-levels">';
								echo '<h3>WP Answers User Level Settings</h3>';
								echo '<ul class="feature-set">';
								//require_once($themepath . '/theme-options/'.$entry);
								$dir = plugin_dir_path( __FILE__ );
								include($dir.'../../../WP-Answers-Plugin-User-Levels/includes/user-level-settings.php');
								echo '</ul>';
								echo '</div><!-- /#wpanswers-user-levels -->';
                            }
							
						?>
					    </form>
					    <div id="import-export">
						<h3><?php _e("Import/Export","upfw"); ?></h3>
						<ul class="feature-set">
						
						<?php if(!defined('THEME_PATH')) { define( 'THEME_PATH' , plugin_dir_path(__FILE__ )); } ?>
						    <?php require_once (THEME_PATH . '/import-export.php'); ?>
						</ul>										
					    </div><!-- /#import-export -->
				
					      <div id="wordcount">
						<h3><?php _e("Word Count and Limit","upfw"); ?></h3>
						<ul class="feature-set">
						
						<?php if(!defined('THEME_PATH')) { define( 'THEME_PATH' , plugin_dir_path(__FILE__ )); } ?>
						    <?php require_once (THEME_PATH . '/wordcount.php'); ?>
						</ul>										
					    </div><!-- /#word count-->
                                            
                                            
                                            
                        <div id="limitresponse">
						<h3><?php _e("Limit Responses","upfw"); ?></h3>
						<ul class="feature-set">
						
						<?php if(!defined('THEME_PATH')) { define( 'THEME_PATH' , plugin_dir_path(__FILE__ )); } ?>
						    <?php require_once (THEME_PATH . '/limit-comments-display.php'); ?>
						</ul>										
					    </div><!-- /#limit response-->
				 
					    <div id="userapprove">
						<h3><?php _e("New User Approve","upfw"); ?></h3>
						<ul class="feature-set">
						
						<?php if(!defined('THEME_PATH')) { define( 'THEME_PATH' , plugin_dir_path(__FILE__ )); } ?>
						    <?php require_once (THEME_PATH . '/newuser_display.php'); ?>
						</ul>										
					    </div><!-- /#userapprove-->
				 
				
					</div><!-- /#tabber -->

				</div><!-- /#up_content -->
			
				<div class="clear"></div>

			<div class="button-zone-wrapper zone-bottom">
			    <div class="button-zone">
				<span class="top">
				    <span class="formState"><?php _e("Theme options have changed. Make sure to save.","upfw"); ?></span>
				    <button class="save" id="up_save" name="up_save" type="submit"><?php _e("Save Changes","upfw"); ?></button>
				    <button class="button" type="reset"><?php _e("Discard Changes","upfw"); ?></button>
				</span>
			    </div><!-- .button-zone -->
			</div><!-- /.button-zone-wrapper -->
			
			</div><!-- /#up_container -->
		
		<div id="up_footer">
		
			<ul>
				<li><?php echo UPTHEMES_NAME?> <?php _e("Version","upfw"); ?> <?php echo UPTHEMES_THEME_VER; ?></li>
              
			</ul>
		
		</div><!-- /#up_footer -->
		
		</form>
	
	</div><!-- /#upthemes_framework -->

<?php else: _e("You must be logged in to view this page","upfw"); endif;?>