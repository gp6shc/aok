<div class="wrap">
	         <form method="post" action="options.php">
	        	<?php settings_fields( 'wpanswer_settings_options' ); ?>
			  	<?php do_settings_sections('wpanswer_setting_section'); ?>
			  	<p><input class="button-primary"  name="Submit" type="submit" value="<?php esc_attr_e(__('Save Changes','wpanswers')); ?>" /></p>		
	         </form>
    
	        <script>
	        jQuery(document).ready(function() {
                    if (jQuery("input#limit_true").prop("checked")) {
                   
                    jQuery("#maxchars_option").parent().parent().show();
	                jQuery("#warning_option").parent().parent().show();
	            }
	            else {
	                jQuery("#maxchars_option").parent().parent().hide();
	                jQuery("#warning_option").parent().parent().hide();
	            }
	            jQuery("input[name*='ask_limitation_option']").on("change", function() {
                    if (jQuery("input#limit_true").prop("checked")) {

                        jQuery("#maxchars_option").parent().parent().show("slow");
                        jQuery("#warning_option").parent().parent().show("slow");
                    }
                    else {

                        jQuery("#maxchars_option").parent().parent().hide("slow");
                        jQuery("#warning_option").parent().parent().hide("slow");
                    }
	            });
	        });
	        </script>
</div>





