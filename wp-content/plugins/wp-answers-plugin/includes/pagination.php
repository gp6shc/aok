<?php

function wpanswers_pagination($pages = '', $range = 2, $slug='question')
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagination_link(1, $slug)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagination_link($paged-1, $slug)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagination_link($i, $slug)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagination_link($paged+1, $slug)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagination_link($pages, $slug)."'>&raquo;</a>";
         echo "</div>\n";
     }
}


function get_wpanswers_pagination($pages = '', $range = 2, $slug='question')
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         
         if(!$pages)
         {
             $pages = 1;
         }
     }
     
     $return = '';   

     if(1 != $pages)
     {
         $return .= "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) {
             $return .= "<a href='".get_pagination_link(1, $slug)."'>&laquo;</a>";
         }
         if($paged > 1 && $showitems < $pages) {
             $return .= "<a href='".get_pagination_link($paged-1, $slug)."'>&lsaquo;</a>";
         }

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 $return .= ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagination_link($i, $slug)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) {
             $return .= "<a href='".get_pagination_link($paged+1, $slug)."'>&rsaquo;</a>";  
         }
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
             $return .= "<a href='".get_pagination_link($pages, $slug)."'>&raquo;</a>";
         }
         $return .= "</div>\n";
     }
     return $return;
}

/**
 * Thanks to Kriesi for Pagination code - http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
 */

function get_pagination_link($page, $slug='question') {
    global $wp_query;
    
    $post_type = get_query_var('post_type');
    if($page > 1) {
        if($post_type == 'question') {
            return get_bloginfo('url').'/'.$slug.'/page/'.$page;
            //return get_bloginfo('url').'/?paged='.$page;
        }
        else {
            return get_pagenum_link($page);
        }
    }
    else {
        return get_pagenum_link(1);
    }
    
}