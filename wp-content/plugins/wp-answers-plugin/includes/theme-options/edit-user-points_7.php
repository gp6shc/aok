<?php
/*
Edit user points
*/

global $wpdb, $table_prefix;
$table_name = $table_prefix.'user_points';

$limit = 20;
$page = (isset($_GET['p'])) ? (int)$_GET['p'] : 0;
$start = $page * $limit;

if(isset($_POST['user_points']) && !empty($_POST['user_points'])):
    foreach ($_POST['user_points'] as $user_id => $points) {
        $wpdb->query('INSERT INTO '.$table_name.' (user_id, points) VALUES ("'.(int)$user_id.'", "'.(int)$points.'") ON DUPLICATE KEY UPDATE points="'.(int)$points.'"');
    }
endif;

$users = $wpdb->get_results("select u.*, IFNULL(p.points, 0) as u_points, (select count(*) from ".$wpdb->users.") as total_users from ".$wpdb->users." u left join ".$table_name." p on u.ID=p.user_id order by u_points DESC  LIMIT ".$start.' , '. $limit);
$options = array();

foreach ($users as $user) {
    
    $options[] = 
        array(  
            "name" => $user->user_nicename."'s Points",
            "desc" => "Set points for user \"".$user->user_nicename."\"",
            "id" => "user_points[".$user->ID."]",
            "type" => "text",
        	"value" => $user->u_points,
        );
    
}


/* ------------ Do not edit below this line ----------- */

//Check if theme options set
global $default_check;
global $default_options;

if(!$default_check):
    foreach($options as $option):
        if($option['type'] != 'image'):
            $default_options[$option['id']] = $option['value'];
        else:
            $default_options[$option['id']] = $option['url'];
        endif;
    endforeach;
    $update_option = get_option('up_themes_'.UPTHEMES_SHORT_NAME);
    if(is_array($update_option)):
        $update_option = array_merge($update_option, $default_options);
        update_option('up_themes_'.UPTHEMES_SHORT_NAME, $update_option);
    else:
        update_option('up_themes_'.UPTHEMES_SHORT_NAME, $default_options);
    endif;
endif;

render_options($options);

// pagination for users
$total_pages = ceil($users[0]->total_users / $limit);
if($total_pages == 0) {
    echo 'No users found.';
}
else {
    echo 'Pages: ';
    for($i=1; $i <= $total_pages; $i++) {
        $classname = "";
        if((isset($_GET['p']) && (int)$_GET['p'] == $i) || !isset($_GET['p'])) {
            $classname = " active";
        }
        echo '<a href="?page=themefurnace&p='.($i-1).'#/edit-user-points" class="page'.$classname.'">'.$i.'</a> ';
    }
}