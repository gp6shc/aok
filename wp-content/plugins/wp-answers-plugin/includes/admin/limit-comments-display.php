<div id='limit_comments_body'>
<?php
if(isset($_POST['master_settings']))
{
		if ($_POST['master_settings'] == "Save Changes") {
		
		$check_option_master = get_option("limit_comments_master");
		
		
		
		  if ($check_option_master === FALSE) {
		        add_option("limit_comments_master", "$_POST[master_limits_comment]");
		    }
		      else {
		        update_option("limit_comments_master", "$_POST[master_limits_comment]");
		      }
		 }
}

?>
<form method='post' action="#/limitresponse" name='master_settings_form' id='master_settings_form'>
 <?php

        $check_option_master = get_option("limit_comments_master");



        if ($check_option_master=="") {
        $show_master_value =0;
        
          }
       else {
        $show_master_value = $check_option_master;
         }
   ?>
     <table cellspacing='5px' cellpadding='15px'>
    
     <tr>
     <th> &nbsp;Global Response Limit</th><td> </td><td><input type='number' name='master_limits_comment'  id="global_comment_val" value="<?php echo $show_master_value; ?>"/></td>
     </tr>
    <tr>
     <td></td><td></td><td><input type='submit' name='master_settings' value='Save Changes' class='button-primary' /></td>
     </tr>

     </table>
</form>
    
    
   
