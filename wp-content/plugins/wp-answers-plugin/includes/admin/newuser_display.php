<?php
	
		global $wpanswer_user_approve;
		
		include_once 'list-registered-users.php'; //For rendering the WPANSWER_List_Table_Display
		$user_list = new WPANSWERS_List_Registered_Users();
		
			
		
	    if(isset($_POST['wpanswer_save_user_registration_settings']))//Do form submission tasks
        {
          
           
        	$wpanswer_user_approve->configs->set_value('wpanswer_enable_manual_registration_approval',isset($_POST["wpanswer_enable_manual_registration_approval"])?'1':'');
         
            //Commit the config settings
           $wpanswer_user_approve->configs->save_config();
           
           if(isset($_POST['wpanswer_enable_manual_registration_approval']))
           {
           
	           
	           	   update_option("approvesettings",1);
           }
           
          else
           {
           	update_option("approvesettings",0);
           
           }
           
           

           if($wpanswer_user_approve->configs->get_value('wpanswer_enable_manual_registration_approval')=='1')
           {
           	update_option("approvesettings",1);
           }
           

           if($wpanswer_user_approve->configs->get_value('wpanswer_enable_manual_registration_approval')=='')
           {
           	update_option("approvesettings",0);
           }
            
        }
        
      ?>

        <form action="#" method="POST">
            
        <div class="postbox">
        
        <div class="inside">
       
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('Enable manual approval of new registrations', 'wpanswer')?>:</th>                
                <td>
                <input name="wpanswer_enable_manual_registration_approval" type="checkbox"<?php if($wpanswer_user_approve->configs->get_value('wpanswer_enable_manual_registration_approval')=='1') echo ' checked="checked"'; ?> value="1"/>
                <span class="description"><?php _e('Check this if you want to automatically disable all newly registered accounts so that you can approve them manually.', 'wpanswer'); ?></span>
                </td>
            </tr>            
        </table>
         
        <input type="submit" name="wpanswer_save_user_registration_settings" id="savecheck" value="<?php _e('Save Settings', 'wpanswer')?>" class="button-primary"/>
        
        </div></div>
        </form>
        <div class="postbox">
        <h3><label for="title"><?php _e('Approve Registered Users', 'wpanswer'); ?></label></h3>
        <div class="inside">
            <?php
            //Fetch, prepare, sort, and filter our data...
           $user_list->prepare_items();
            ?>
            <form id="tables-filter" method="get" onSubmit="return confirm('Are you sure you want to perform this bulk operation on the selected entries?');">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
            <!-- Now we can render the completed list table -->
            <?php $user_list->display(); ?>
            </form>
        </div></div>
