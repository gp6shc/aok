<?php
	/* word count and Limit 
	 */
       add_action( 'admin_menu', 'wpanswer_word_count_limit' );
	if( !function_exists('wpanswer_word_count_limit'))  {
		function wpanswer_word_count_limit() {
			
			add_action( 'admin_init', 'wpanswer_word_limit_options_settings' );
		}
	}
	
	if( !function_exists('wpanswer_word_limit_options_settings'))  {
		function wpanswer_word_limit_options_settings(){			
			register_setting( 
				'wpanswer_settings_options',  
				'wpanswer_settings_options', 
				'wpanswer_wordcount_options_validate' 
				);
				
			add_settings_section(
				'wpanswers_option_main', 
				'', 
				'', 
				'wpanswer_setting_section'  
				);
				
			add_settings_field(
				'ask_limitation_option', 
				__( 'Set a limit?', 'wpanswers' ), 
				'func_ask_limitation_option', 
				'wpanswer_setting_section',  
				'wpanswers_option_main' 
				); 
			
				
			add_settings_field(
				'maxchars_option', 
				__( 'Max characters allowed', 'wpanswers' ), 
				'func_maxchars_option', 
				'wpanswer_setting_section',  
				'wpanswers_option_main' 
				); 
		
			add_settings_field(
				'warning_option', 
				__( 'Warning', 'wpanswers' ), 
				'func_warning_option', 
				'wpanswer_setting_section',  
				'wpanswers_option_main' 
				); 
				
	    }
	}
	/** The Limitation (yes or no) radio buttons **/
	
	if( !function_exists('func_ask_limitation_option'))  {
		function func_ask_limitation_option() {
			
			$options = get_option( 'wpanswer_settings_options' );
			
			
			$ask_limitation_option = ($options['ask_limitation_option'] != '') ? $options['ask_limitation_option'] : 0 ;
			
			 ?>
			<label for="limit_true" > <?php _e( 'Yes', 'wpanswers' ); ?></label>
			<input type="radio" <?php if ($ask_limitation_option == 1) echo'checked="checked"' ; ?> id="limit_true" name="wpanswer_settings_options[ask_limitation_option]" value="1" /> 
			<label for="limit_false" > <?php _e( 'No', 'wpanswers' ); ?></label>
			<input type="radio" id="limit_false" <?php if ($ask_limitation_option == 0) echo'checked="checked"' ; ?> name="wpanswer_settings_options[ask_limitation_option]" value="0" /> 
	    <?php }
	}
	
	
	if( !function_exists('func_maxchars_option'))  {
		function func_maxchars_option(){
		
			$options = get_option( 'wpanswer_settings_options' );
			$maxchars_option = ($options['maxchars_option'] != '') ? $options['maxchars_option'] : '1000';
			if($maxchars_option == 0)
			{
				$maxchars_option=1000;
			}
			 ?>
			<input type="number" id="maxchars_option" name="wpanswer_settings_options[maxchars_option]" value="<?php echo esc_attr($maxchars_option); ?>" />
			
		<?php }
	}
	
	if( !function_exists('func_warning_option'))  {
		function func_warning_option(){
		
			$options = get_option( 'wpanswer_settings_options' );
			$warning_option = ($options['warning_option'] != '') ? $options['warning_option'] :'100';
			if($warning_option == 0)
			{
				$warning_option=100;
			} 
			 ?>
			<input type="number" id="warning_option" name="wpanswer_settings_options[warning_option]" value="<?php echo esc_attr($warning_option); ?>" />
			
		<?php }
	}
	
	
	
		
	/**
	 * Sanitize and validate input. Accepts an array, return a sanitized array.
	 */
	if( !function_exists('wpanswer_wordcount_options_validate'))  {
		function wpanswer_wordcount_options_validate( $input ) {
		$options = get_option( 'wpanswer_settings_options' );
				
		$options['ask_limitation_option'] = $input['ask_limitation_option'];
	
		
		if ( ! isset( $input['ask_limitation_option'] ) )
			$input['ask_limitation_option'] = null;
		
		$options['maxchars_option'] = wp_filter_nohtml_kses( intval( $input['maxchars_option'] ) );			
		$options['warning_option'] = wp_filter_nohtml_kses( intval( $input['warning_option'] ) );
			
		return $options;	
		}
	}	
	/**
	 * Adds the script after tinymce script
	 */
	if (!function_exists('wpanswer_show_wordcount')) {
	    function wpanswer_show_wordcount($post) {
	    
	    $p_id = get_the_ID();
	    $post_type = get_post_type($p_id);
	    if ($post_type == 'question'):
	        // Retrieving settings values
	        $options = get_option( 'wpanswer_settings_options' );
	        $set_limit = ($options['ask_limitation_option'] == 1) ? 1 : 0;
	    
	        $max = ($options['maxchars_option'] > 0) ? $options['maxchars_option'] : 1000;
	        $warn = ($options['warning_option'] > 0) ? $options['warning_option'] : 100;
	        $format = '#input characters | #words words';
	        
	        $c_user = wp_get_current_user();
			$user_r = $c_user->roles;
			$user_role = $user_r[0];
		
	        echo "<script>\n";
	        echo "jQuery(window).load(function() {\n";	       
	        echo "switchEditors.switchto(jQuery('#content-tmce').get(0));";	      
	        echo "/* The textarea and the iframe */
			var textarea_cont = jQuery('#content');
			var wysiwyg_cont = jQuery('#content_ifr').contents();
					
			/* Variables Initial define */
			var setLimit = ".$set_limit."; // Limit = 1, no limit = 0
			var maxCharacters = ".$max."; // max characters count if limit is set
			var warningNumb = ".$warn."; // number of characters before limit where the user is warned
			var formatString = '".$format."'; // The syntax used to display the output
			var charInfo = jQuery('#wp-word-count'); // Output container, same as Default WP Word count 
			var contentLength = 0;
			var numLeft = 0;
			var numWords = 0;
			
			/* The events on each container */
			textarea_cont.on('keyup', function(event){getTheCharacterCount('textarea');})
	                     .on('paste', function(event){setTimeout(function(){getTheCharacterCount('textarea');}, 10);});
			
	        wysiwyg_cont.on('keyup', 'body', function(event){getTheCharacterCount('wysiwig');})
	                    .on('paste', 'body', function(event){setTimeout(function(){getTheCharacterCount('wysiwig');}, 10);});
	        
			
			/* Function to find the characters count */ 
	        function getTheCharacterCount(cont){
				charInfo.html(countByCharacters(cont));
			}
			
			/* Counting the characters and the words */
			function countByCharacters(cont){
			    if (cont == 'textarea') {
			        // Textarea case
			        var raw_content = textarea_cont.val();
			    } else {
	                // WysiWyg case
	                var raw_content = jQuery('#content_ifr').contents().find('body').html();
	            }
	            var content = raw_content.replace(/(\\r\\n)+|\\n+|\\r+|\s+|(&nbsp;)+/gm,' '); // Replace newline, tabulations, &nbsp; by space to preserve word count
	            content = content.replace(/<[^>]+>/ig,''); // Replace HTML tags by spaces
	            content = content.replace(/(&lt;)[^(\&gt;)]+(\&gt;)/ig,''); // Replace HTML tags by spaces
	            content = content.replace(/\s+/ig,' '); // Replace multiple spaces by one space 
				contentLength = content.length;
				
	            // All cases var definitions
	            numInput = contentLength;
	            numWords = getCleanedWordStringLength(content);
	            
	            // Treatment if limit set (change color by status)
	            if(setLimit > 0){
	                if (contentLength <= maxCharacters - warningNumb)
	                    charInfo.css('color', 'inherit');
	                else if (contentLength < maxCharacters && contentLength >= maxCharacters - warningNumb)
	                    charInfo.css('color', 'orange');
	                else if(contentLength > maxCharacters)
	                    charInfo.css('color', 'red');
	                numLeft = (maxCharacters - numInput > 0) ? maxCharacters - numInput : 0;
	            }
	            
	            // Output the result
	            return formatDisplayInfo();
				    
			}
			
			/* Displaying the result in the defined format */
			function formatDisplayInfo(){
			    var output = formatString;
			    if (output.indexOf('#input') != -1)
				    output = output.replace('#input', numInput);
	            if (output.indexOf('#words') != -1)
				    output = output.replace('#words', numWords);
				//When no limit set, #max, #left cannot be substituted.
				if(setLimit > 0){
				    if (output.indexOf('#max') != -1)
					    output = output.replace('#max', maxCharacters);
	                if (output.indexOf('#left') != -1)
					    output = output.replace('#left', numLeft);
				}
				return output;
			}
			
			/* Cleaning content to count the words */	
			function getCleanedWordStringLength(content){
			    // Cleaning and splitting wordstring (tags are already stripped)
				var rawContent = content;
				var cleanedContent = rawContent.replace(/\s[\.:!\?;\(\)]+\s/gi, ' '); //Replacing ponctuation with spaces
				var cleanedContent = cleanedContent.replace(/\s+/ig,' ') //Multiple spaces case replaced by one space
				var splitString = cleanedContent.split(' ');
				// Word Count defining
				var wordCount = splitString.length - 1;
				return wordCount;
			}";
			
			// Launching word count on load
	        echo "getTheCharacterCount('wysiwig');";
	       
			// Refuse saving if too many characters only if for the defined users
			if ($set_limit > 0) {
	        echo "jQuery('#submitdiv').on('mouseover', function() {
	            if (contentLength > maxCharacters) {
	                alert('".__( 'Sorry, but you exceeded the characters limit!', 'wpanswers')."');
	            }
	        });\n
	        jQuery('form#post').on('submit', function() {
	        if (contentLength < maxCharacters && '".$user_role."' == 'contributor') {
	                alert('".__( 'Your Post has been submitted to the editorial team for validation and publish. Thanks for your contribution!', 'wpanswers')."');
	            }
	        });\n";
	        }
	        
	        echo "});\n"; 
	        echo "</script>\n";
	    endif; 
	    }
	add_action( 'after_wp_tiny_mce', 'wpanswer_show_wordcount');
	}
	
	/**
	 * Function to avoid post save if characters limit is reached
	 */
	 if (!function_exists('wpanswer_maxcharreached')) {
	    function wpanswer_maxcharreached(){ 
	        
	        $options = get_option( 'wpanswer_settings_options' );
	        $setLimit = $options['ask_limitation_option'];
	      
	        $maxchars = ($options['maxchars_option'] != '') ? $options['maxchars_option'] : '1000';
	        
	        if ($setLimit == 1) {
	            global $post;
	            $content = wp_filter_nohtml_kses($post->post_content);
	            if (strlen($content) > $maxchars) 
	                wp_die( __('Sorry, but you exceeded the characters limit!', 'wpanswers') ); 
	        }
	    } 
	    add_action('draft_to_publish', 'wpanswer_maxcharreached');
	    add_action('pending_to_publish', 'wpanswer_maxcharreached'); 
	    add_action('draft_to_pending', 'wpanswer_maxcharreached');
	}
?>