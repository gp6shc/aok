<?php
class WPANSWERS_List_Registered_Users extends WPANSWER_List_Table_Display {

    function __construct(){
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'item',     //singular name of the listed records
            'plural'    => 'items',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
    	return $item[$column_name];
    }

    function column_ID($item){
      
    }

    
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
       );
    }
    
   
    function get_columns(){
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox          
            'user_login' => 'Login Name',
            'user_email' => 'Email',
            'user_registered' => 'Register Date',
            'account_status' => 'Status'
        );
        return $columns;
    }
    
  
    
    function get_bulk_actions() {
        $actions = array(
            'approve' => 'Approve',
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        if('approve'===$this->current_action()) 
        {
        	   
                $this->approve_selected_accounts(($_REQUEST['item']));
            
        }
        
        if('delete'===$this->current_action()) 
        {
                  
                $this->delete_selected_accounts(($_REQUEST['item']));
            
        }

    }

    function approve_selected_accounts($entries)
    {
        global $wpdb, $wpanswer_user_approve;
        $meta_key = 'wpanswer_account_status';
        $meta_value = 'approved'; //set account status
        $failed_accts = ''; //string to store comma separated accounts which failed to update
        $at_least_one_updated = false;
        if (is_array($entries))
        {
            //Let's go through each entry and approve
            foreach($entries as $user_id)
            {
                $result = update_user_meta($user_id, $meta_key, $meta_value);
                
                    $at_least_one_updated = true;
                   
                
            }
           
        } 
      
    }

    function delete_selected_accounts($entries)
    {
        global $wpdb, $wpanswer_user_approve;
        if (is_array($entries))
        {
           
            foreach($entries as $user_id)
            {
                $result = wp_delete_user($user_id);
               
            }
          
        } 
           }
    
    function prepare_items() {
      
        $per_page =15;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        
        $this->process_bulk_action();
    	
    	global $wpdb;
        global $wpanswer_user_approve;
        $data = $this->get_registered_user_data('pending');
        
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;
        $this->set_pagination_args( array(
            'total_items' => $total_items,                 
            'per_page'    => $per_page,                     
            'total_pages' => ceil($total_items/$per_page)   
        ));
    }
    
    //Returns all users who have the special 'wpanswer_account_status' meta key
    function get_registered_user_data($status='')
    {
        $user_fields = array( 'ID', 'user_login', 'user_email', 'user_registered');
        $user_query = new WP_User_Query(array('meta_key' => 'wpanswer_account_status', 'meta_value' => $status, 'fields' => $user_fields));
        $user_results = $user_query->results;

        $final_data = array();
        foreach ($user_results as $user)
        {
            $temp_array = get_object_vars($user); //Turn the object into array
            $temp_array['account_status'] = get_user_meta($temp_array['ID'], 'wpanswer_account_status', true);
            $final_data[] = $temp_array;
        }
        return $final_data;
    }
}