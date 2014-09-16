<?php
/*
Reported comments
*/

global $wpdb, $table_prefix;
$table_name = $table_prefix.'reported_comments';

$limit = 20;
$page = (isset($_GET['p'])) ? (int)$_GET['p'] : 0;
$start = $page * $limit;

// delete selected comments
if(!empty($_POST['comments']) ) {
    $ids = array_keys($_POST['comments']);

    foreach($ids as $comment_id) {
        wp_delete_comment($comment_id);
        $wpdb->query("delete from ".$table_name." where comment_id='".(int)$comment_id."' LIMIT 1");
    }
}

if(!empty($_POST['all_comments'])) {
    $ids = $wpdb->get_results("select * from ".$table_name);
    foreach ($ids as $comment_id) {
        wp_delete_comment($comment_id->comment_id);
        $wpdb->query("delete from ".$table_name." where comment_id='".(int)$comment_id->comment_id."' LIMIT 1");
    }
}

$reported = $wpdb->get_results("select rc.*, u.user_login, c.comment_content, (select count(*) from ".$table_name.") as total_reported from ".$table_name." rc left join ".$wpdb->comments." c on rc.comment_id=c.comment_ID left join ".$wpdb->users." u on rc.user_id=u.ID order by rc.comment_id DESC  LIMIT ".$start.' , '. $limit);

$options = array();

if(!empty($reported)) {
    echo '<input type="submit" name="all_comments" value="Delete all reported posts"><br/>';
}

foreach ($reported as $reported_post) {
    
    $options[] = 
        array(  
            "name" => 'Reported post details',
            "desc" => 'Reported by user: '.$reported_post->user_login.'<br/>reported post content: <br/>'.$reported_post->comment_content,
            "id" => "comments[".$reported_post->comment_id."]",
            "type" => "checkbox",
        	"value" => '1',
        	"options" => array('Delete post' => '1',)
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

// paginationif(isset($reported[0]))
$total_pages = ceil($reported[0]->total_reported / $limit);else {		$total_pages=0;	}

if($total_pages == 0) {
    echo 'No items found.';
}
else {
    echo 'Pages: ';
    for($i=1; $i <= $total_pages; $i++) {
        $classname = "";
        if((isset($_GET['p']) && (int)$_GET['p'] == $i) || !$_GET['p']) {
            $classname = " active";
        }
        echo '<a href="?page=themefurnace&p='.($i-1).'#/reported-points" class="page'.$classname.'">'.$i.'</a> ';
    }
}