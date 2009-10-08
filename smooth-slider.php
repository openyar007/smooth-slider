<?php
/*
Plugin Name: Smooth Slider
Plugin URI: http://www.clickonf5.org/smooth-slider
Description: Smooth Slider adds a smooth content and image slideshow with customizable background and slide intervals to any location of your blog
Version: 2.0	
Author: Tejaswini Deshpande, Sanjeev Mishra
Author URI: http://www.clickonf5.org
Wordpress version supported: 2.7 and above
*/

/*  Copyright 2009  Internet Techies  (email : tedeshpa@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
//Please visit Plugin page http://www.clickonf5.org/smooth-slider for Changelog
//on activation
function install_smooth_slider() {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.'slider';
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE $table_name (
					id mediumint(9) NOT NULL AUTO_INCREMENT,
					date datetime NOT NULL,
					UNIQUE KEY id(id)
				);";
		$rs = $wpdb->query($sql);
	}
   // Need to delete the previously created options in old versions and create only one option field for Smooth Slider
   if (!get_option('smooth_slider_speed')) {
	$smooth_slider = array('speed'=>'7', 
	                       'no_posts'=>'5', 
						   'bg_color'=>'#ffffff', 
						   'height'=>'200',
						   'width'=>'450',
						   'border'=>'1',
						   'brcolor'=>'#999999',
						   'prev_next'=>'1',
						   'goto_slide'=>'1',
						   'title_text'=>'Featured Posts',
						   'title_font'=>'Georgia',
						   'title_fsize'=>'20',
						   'title_fstyle'=>'bold',
						   'title_fcolor'=>'#000000',
						   'ptitle_font'=>'Trebuchet MS',
						   'ptitle_fsize'=>'14',
						   'ptitle_fstyle'=>'bold',
						   'ptitle_fcolor'=>'#000000',
						   'img_align'=>'left',
						   'img_height'=>'120',
						   'img_width'=>'165',
						   'img_border'=>'1',
						   'img_brcolor'=>'#000000',
						   'content_font'=>'Verdana',
						   'content_fsize'=>'12',
						   'content_fstyle'=>'normal',
						   'content_fcolor'=>'#333333',
						   'content_from'=>'content',
						   'content_chars'=>'300',
						   'bg'=>'0',
						   'image_only'=>'0',
						   'allowable_tags'=>'',
						   'more'=>'Read More',
						   'img_size'=>'1',
						   'img_pick'=>'0',
						   'user_level'=>'5',
						   'custom_nav'=>''
			              );
	}
	else {
	$smooth_slider = array('speed'=>get_option('smooth_slider_speed'), 
	                       'no_posts'=>get_option('smooth_slider_no_posts'), 
						   'bg_color'=>get_option('smooth_slider_bg_color'), 
						   'height'=>get_option('smooth_slider_height'),
						   'width'=>get_option('smooth_slider_width'),
						   'border'=>get_option('smooth_slider_border'),
						   'brcolor'=>get_option('smooth_slider_brcolor'),
						   'prev_next'=>get_option('smooth_slider_prev_next'),
						   'goto_slide'=>get_option('smooth_slider_goto_slide'),
						   'title_text'=>get_option('smooth_slider_title_text'),
						   'title_font'=>get_option('smooth_slider_title_font'),
						   'title_fsize'=>get_option('smooth_slider_title_fsize'),
						   'title_fstyle'=>get_option('smooth_slider_title_fstyle'),
						   'title_fcolor'=>get_option('smooth_slider_title_fcolor'),
						   'ptitle_font'=>get_option('smooth_slider_ptitle_font'),
						   'ptitle_fsize'=>get_option('smooth_slider_ptitle_fsize'),
						   'ptitle_fstyle'=>get_option('smooth_slider_ptitle_fstyle'),
						   'ptitle_fcolor'=>get_option('smooth_slider_ptitle_fcolor'),
						   'img_align'=>get_option('smooth_slider_img_align'),
						   'img_height'=>get_option('smooth_slider_img_height'),
						   'img_width'=>get_option('smooth_slider_img_width'),
						   'img_border'=>get_option('smooth_slider_img_border'),
						   'img_brcolor'=>get_option('smooth_slider_img_brcolor'),
						   'content_font'=>get_option('smooth_slider_content_font'),
						   'content_fsize'=>get_option('smooth_slider_content_fsize'),
						   'content_fstyle'=>get_option('smooth_slider_content_fstyle'),
						   'content_fcolor'=>get_option('smooth_slider_content_fcolor'),
						   'content_from'=>get_option('smooth_slider_content_from'),
						   'content_chars'=>get_option('smooth_slider_content_chars'),
						   'bg'=>get_option('smooth_slider_bg'),
						   'image_only'=>get_option('smooth_slider_image_only'),
						   'allowable_tags'=>'',
						   'more'=>'Read More',
						   'img_size'=>'1',
						   'img_pick'=>'0',
						   'user_level'=>'5',
						   'custom_nav'=>''
			              );
	 delete_option('smooth_slider_speed');
	 delete_option('smooth_slider_no_posts');
	 delete_option('smooth_slider_bg_color');
	 delete_option('smooth_slider_height');
	 delete_option('smooth_slider_width');
	 delete_option('smooth_slider_border');
	 delete_option('smooth_slider_brcolor');
	 delete_option('smooth_slider_prev_next');
	 delete_option('smooth_slider_goto_slide');
	 delete_option('smooth_slider_title_text');
	 delete_option('smooth_slider_title_font');
	 delete_option('smooth_slider_title_fsize');
	 delete_option('smooth_slider_title_fstyle');
	 delete_option('smooth_slider_title_fcolor');
	 delete_option('smooth_slider_ptitle_font');
	 delete_option('smooth_slider_ptitle_fsize');
	 delete_option('smooth_slider_ptitle_fstyle');
	 delete_option('smooth_slider_ptitle_fcolor');
	 delete_option('smooth_slider_img_align');
	 delete_option('smooth_slider_img_height');
	 delete_option('smooth_slider_img_width');
	 delete_option('smooth_slider_img_border');
	 delete_option('smooth_slider_img_brcolor');
	 delete_option('smooth_slider_content_font');
	 delete_option('smooth_slider_content_fsize');
	 delete_option('smooth_slider_content_fstyle');
	 delete_option('smooth_slider_content_fcolor');
	 delete_option('smooth_slider_content_from');	
	 delete_option('smooth_slider_content_chars');
	 delete_option('smooth_slider_bg');	
	 delete_option('smooth_slider_clear');	
	 delete_option('smooth_slider_image_only');	
	}
	add_option('smooth_slider_options',$smooth_slider);
}
register_activation_hook( __FILE__, 'install_smooth_slider' );
//defined global variables and constants here
global $smooth_slider;
$smooth_slider = get_option('smooth_slider_options');
define("SMOOTH_SLIDER_VER","2.0",false);

//This adds the post to the slider
function add_to_slider($post_id) {
	global $wpdb, $table_prefix;
	if(isset($_POST['slider']) and $_POST['slider'] == "slider" and !slider($post_id)) {
		$table_name = $table_prefix.'slider';
		$dt = date('Y-m-d H:i:s');
		$sql = "INSERT INTO $table_name (id, date) VALUES ($post_id, '$dt')";
		$wpdb->query($sql);
	}
}

//Removes the post from the slider, if you uncheck the checkbox from the edit post screen
function remove_from_slider($post_id) {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.'slider';
	
	// authorization
	if (!current_user_can('edit_post', $post_id))
		return $post_id;
	// origination and intention
	if (!wp_verify_nonce($_POST['sldr-verify'], 'SmoothSlider'))
		return $post_id;
	
	if(empty($_POST['slider']) and slider($post_id)) {
		$sql = "DELETE FROM $table_name where id = $post_id LIMIT 1";
		$wpdb->query($sql);
	}
  } 

//Checks if the post is already added to slider
function slider($post_id) {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."slider";
	$check = "SELECT id FROM $table_name WHERE id = $post_id";
	$result = $wpdb->query($check);
	if($result == 1) { return TRUE; }
	else { return FALSE; }
}

// Slider checkbox on the admin page
function add_to_slider_checkbox() {
	global $post, $current_user, $smooth_slider;
    get_currentuserinfo();
	
	if ($current_user->allcaps['level_' . $smooth_slider['user_level']]) {
		$extra = "";
		
		if(isset($post->ID)) {
			$post_id = $post->ID;
			if(slider($post_id)) { $extra = 'checked="checked"'; }
		}
		
		echo '<div id="slider_checkbox">
				<input type="checkbox" class="sldr_post" name="slider" value="slider" '.$extra.' />
				<label for="slider">Add this post/page to Smooth Slider</label>
				<input type="hidden" name="sldr-verify" id="sldr-verify" value="'.wp_create_nonce('SmoothSlider').'" />
			  </div>';
    }
}

//CSS for the checkbox on the admin page
function slider_checkbox_css() {
?><style type="text/css" media="screen">#slider_checkbox{margin: 5px 0 10px 0;padding:3px;font-weight:bold;}</style>
<?php
}

add_action('admin_head', 'slider_checkbox_css');
add_action('simple_edit_form', 'add_to_slider_checkbox');
add_action('edit_form_advanced', 'add_to_slider_checkbox');
add_action('edit_page_form', 'add_to_slider_checkbox');
add_action('publish_post', 'add_to_slider');
add_action('publish_page', 'add_to_slider');
add_action('edit_post', 'add_to_slider');
add_action('publish_post', 'remove_from_slider');
add_action('edit_post', 'remove_from_slider');


function smooth_slider_plugin_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}

function get_string_limit($output, $max_char)
{
    $output = str_replace(']]>', ']]&gt;', $output);
    $output = strip_tags($output);

  	if ((strlen($output)>$max_char) && ($espacio = strpos($output, " ", $max_char )))
	{
        $output = substr($output, 0, $espacio).'...';
		return $output;
   }
   else
   {
      return $output;
   }
}

function smooth_slider_get_first_image($post) {
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];
	return $first_img;
}

function carousel_posts_on_slider($max_posts, $offset=0) {
    global $smooth_slider;
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."slider";
	
	$posts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC LIMIT $offset, $max_posts", OBJECT);
	
	$html = '';
	$smooth_sldr_j = 0;
	
	
	foreach($posts as $post) {
		$smooth_sldr_j++;
		$id = $post->id;
		$posts_table = $table_prefix.'posts'; 
		$sql_post = "SELECT * FROM $posts_table WHERE ID = $id";
		$rs_post = $wpdb->get_results("SELECT * FROM $posts_table WHERE ID = $id", OBJECT);
		$data = $rs_post[0];
		
		$post_title = stripslashes($data->post_title);
		$post_title = str_replace('"', '', $post_title);
		$slider_content = $data->post_content;
		
		$permalink = get_permalink($data->ID);
		
		$post_id = $data->ID;
		$html .= '<div class="smooth_slideri">
			<!-- smooth_slideri -->';
			
		$thumbnail = get_post_meta($post_id, 'slider_thumbnail', true);
		$image_control = get_post_meta($post_id, 'slider_image_control', true);
		
		if ($smooth_slider['content_from'] == "slider_content") {
		    $slider_content = get_post_meta($post_id, 'slider_content', true);
		}
		if ($smooth_slider['content_from'] == "excerpt") {
		    $slider_content = $data->post_excerpt;
		}
		
		$slider_content = stripslashes($slider_content);
		$slider_content = str_replace(']]>', ']]&gt;', $slider_content);

		$slider_content = str_replace("\n","<br />",$slider_content);
        $slider_content = strip_tags($slider_content, $smooth_slider['allowable_tags']);
		
		if ( !isset($image_control) or empty($image_control) or $image_control != "x"){
			if ($smooth_slider['img_pick'] == '1') {
			  $first_image = smooth_slider_get_first_image($data);
			  if(!empty($first_image)){ 
				  $html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$first_image.'" alt="'.$post_title.'" /></a>';
			  }
			  else {
				  if( isset($thumbnail) && !empty($thumbnail) ):
					$html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$thumbnail.'" alt="'.$post_title.'" /></a>';
				  endif;
			  }
			}
			else {
			  if( isset($thumbnail) && !empty($thumbnail) ):
				$html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$thumbnail.'" alt="'.$post_title.'" /></a>';
			  endif;
			}
		}
		
		if ($smooth_slider['image_only'] == '1') { 
			$html .= '<!-- /smooth_slideri -->
			</div>';
		}
		else {
			$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.substr($slider_content,0,$smooth_slider['content_chars']).'</span>
				<p class="more"><a href="'.$permalink.'">'.$smooth_slider['more'].'</a></p>
			
				<!-- /smooth_slideri -->
			</div>';
		}
	}
	echo $html;
	return $smooth_sldr_j;
}

function carousel_posts_on_slider_cat($max_posts, $catg_slug, $offset=0) {
    global $smooth_slider;
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."slider";

	$myposts = $wpdb->get_results("SELECT id FROM $table_name ORDER BY date DESC", OBJECT);
	
	$html = '';
	$smooth_sldr_i = 0;
	
	if (!empty($catg_slug)) {
		$category = get_category_by_slug($catg_slug); 
		$slider_cat = $category->term_id;
	}
	else {
		$category = get_the_category();
		$slider_cat = $category[0]->cat_ID;
	}
	
	foreach($myposts as $mypost) {
		$post = get_post($mypost->id);
		$post_cats_arr = get_the_category($post->ID);
		
		$post_cats = array();
		foreach($post_cats_arr as $post_cat_arr) {
		  $post_cats[] = $post_cat_arr->cat_ID;
		}
		
    	if (in_array($slider_cat,$post_cats) or is_home() or (is_paged() and !is_category()) or is_tag() or is_author() or (is_archive() and !is_category()))
		{
			$smooth_sldr_i++;
			
			$post_title = stripslashes($post->post_title);
			$post_title = str_replace('"', '', $post_title);
			$slider_content = $post->post_content;
			
			$permalink = get_permalink($post->ID);
			
			$post_id = $post->ID;
			$html .= '<div class="smooth_slideri">
				<!-- smooth_slideri -->';
				
			$thumbnail = get_post_meta($post_id, 'slider_thumbnail', true);
			
			if ($smooth_slider['content_from'] == "slider_content") {
				$slider_content = get_post_meta($post_id, 'slider_content', true);
			}
			if ($smooth_slider['content_from'] == "excerpt") {
				$slider_content = $post->post_excerpt;
			}
			
			$slider_content = stripslashes($slider_content);
			$slider_content = str_replace(']]>', ']]&gt;', $slider_content);
			
			$slider_content = str_replace("\n","<br />",$slider_content);
            $slider_content = strip_tags($slider_content, $smooth_slider['allowable_tags']);
			
			if ($smooth_slider['img_pick'] == '1') {
			  $first_image = smooth_slider_get_first_image($post);
			  if(!empty($first_image)){ 
				$html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$first_image.'" alt="'.$post_title.'" /></a>';
			  }
			}
			else {
			  if( isset($thumbnail) && !empty($thumbnail) ):
				$html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$thumbnail.'" alt="'.$post_title.'" /></a>';
			  endif;
			}
			
			if ($smooth_slider['image_only'] == '1') { 
				$html .= '<!-- /smooth_slideri -->
				</div>';
			}
			else {
				$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.substr($slider_content,0,$smooth_slider['content_chars']).'</span>
					<p class="more"><a href="'.$permalink.'">'.$smooth_slider['more'].'</a></p>
				
					<!-- /smooth_slideri -->
				</div>';
		    }
	    }
		if ($smooth_sldr_i >= $max_posts)
		   { break; }
	}
	echo $html;
	return $smooth_sldr_i;
}

function smooth_slider_wpmu_carousel_posts($max_posts, $offset=0) {
    global $smooth_slider;
	global $wpdb, $table_prefix, $blog_id;
	
	$html = '';
	$smooth_sldr_k = 0;
	
	$blogs = $wpdb->get_results( $wpdb->prepare("SELECT blog_id FROM $wpdb->blogs WHERE site_id = %d AND public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY registered ASC", $wpdb->siteid), ARRAY_A );
    foreach($blogs as $details) {
	
		$table_name = $wpdb->base_prefix.$details['blog_id']."_slider";
		
		$myposts = $wpdb->get_results("SELECT id FROM $table_name ORDER BY date DESC", OBJECT);
		
		foreach($myposts as $mypost) {
			$posts_table = $wpdb->base_prefix.$details['blog_id']."_posts";
			$id = $mypost->id;
			$post =  $wpdb->get_row("SELECT * FROM $posts_table WHERE ID = $id", OBJECT);
			$smooth_sldr_k++;
			
			$post_title = stripslashes($post->post_title);
			$post_title = str_replace('"', '', $post_title);
			$slider_content = $post->post_content;
			
			$permalink = get_permalink($post->ID);
			
			$post_id = $post->ID;
			$html .= '<div class="smooth_slideri">
				<!-- smooth_slideri -->';
				
			$thumbnail = get_post_meta($post_id, 'slider_thumbnail', true);
			
			if ($smooth_slider['content_from'] == "slider_content") {
				$slider_content = get_post_meta($post_id, 'slider_content', true);
			}
			if ($smooth_slider['content_from'] == "excerpt") {
				$slider_content = $post->post_excerpt;
			}
			
			$slider_content = stripslashes($slider_content);
			$slider_content = str_replace(']]>', ']]&gt;', $slider_content);
			
			$slider_content = str_replace("\n","<br />",$slider_content);
			$slider_content = strip_tags($slider_content, $smooth_slider['allowable_tags']);
			
			if ($smooth_slider['img_pick'] == '1') {
			  $first_image = smooth_slider_get_first_image($post);
			  if(!empty($first_image)){ 
				$html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$first_image.'" alt="'.$post_title.'" /></a>';
			  }
			}
			else {
			  if( isset($thumbnail) && !empty($thumbnail) ):
				$html .= '<a href="'.$permalink.'"><img class="smooth_slider_thumbnail" src="'.$thumbnail.'" alt="'.$post_title.'" /></a>';
			  endif;
			}
			
			if ($smooth_slider['image_only'] == '1') { 
				$html .= '<!-- /smooth_slideri -->
				</div>';
			}
			else {
				$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.substr($slider_content,0,$smooth_slider['content_chars']).'</span>
					<p class="more"><a href="'.$permalink.'">'.$smooth_slider['more'].'</a></p>
				
					<!-- /smooth_slideri -->
				</div>';
			}
		if ($smooth_sldr_k >= $max_posts)
		   { break; }
	    }
		
	if ($smooth_sldr_k >= $max_posts)
		   { break; }
    }
	echo $html;
	return $smooth_sldr_k;
}

function smooth_slider_css() {
global $smooth_slider;
?>
<style type="text/css" media="screen">#smooth_sldr{width:<?php echo $smooth_slider['width']; ?>px;height:<?php echo $smooth_slider['height']; ?>px;background-color:<?php if ($smooth_slider['bg'] == '1') { echo "transparent";} else { echo $smooth_slider['bg_color']; } ?>;border:<?php echo $smooth_slider['border']; ?>px solid <?php echo $smooth_slider['brcolor']; ?>;}#smooth_sldr_items{padding:10px <?php if ($smooth_slider['prev_next'] == 1) {echo "18";} else {echo "12";} ?>px 0px <?php if ($smooth_slider['prev_next'] == 1) {echo "26";} else {echo "12";} ?>px;}#smooth_sliderc{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 44);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");$nav_size = $height;} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.smooth_slideri{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 54);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");$nav_size = $height;} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.sldr_title{font-family:<?php echo $smooth_slider['title_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['title_fsize']; ?>px;font-weight:<?php if ($smooth_slider['title_fstyle'] == "bold" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "bold";} else { echo "normal"; } ?>;font-style:<?php if ($smooth_slider['title_fstyle'] == "italic" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['title_fcolor']; ?>;}#smooth_sldr_body h2{line-height:<?php echo ($smooth_slider['ptitle_fsize'] + 3); ?>px;font-family:<?php echo $smooth_slider['ptitle_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['ptitle_fsize']; ?>px;font-weight:<?php if ($smooth_slider['ptitle_fstyle'] == "bold" or $smooth_slider['ptitle_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['ptitle_fstyle'] == "italic" or $smooth_slider['ptitle_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px 0 5px 0;}#smooth_sldr_body h2 a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}#smooth_sldr_body span{font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-weight:<?php if ($smooth_slider['content_fstyle'] == "bold" or $smooth_slider['content_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['content_fstyle']=="italic" or $smooth_slider['content_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['content_fcolor']; ?>;}.smooth_slider_thumbnail{float:<?php echo $smooth_slider['img_align']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px <?php if($smooth_slider['img_align'] == "left") {echo "5";} else {echo "0";} ?>px 0 <?php if($smooth_slider['img_align'] == "right") {echo "5";} else {echo "0";} ?>px;<?php if ($smooth_slider['img_size'] == 1) { ?>width:<?php echo $smooth_slider['img_width']; ?>px;height:<?php echo $smooth_slider['img_height']; ?>px;<?php } ?> border:<?php echo $smooth_slider['img_border']; ?>px solid <?php echo $smooth_slider['img_brcolor']; ?>;}#smooth_sldr_body p.more a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;}#smooth_sliderc_nav li{border:1px solid <?php echo $smooth_slider['content_fcolor']; ?>;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;}#smooth_sliderc_nav li a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}.sldrlink{padding-right:<?php if ($smooth_slider['prev_next'] == 1) {echo "40";} else {echo "25";} ?>px;}.sldrlink a{color:<?php echo $smooth_slider['content_fcolor']; ?>;}</style>
<?php
}

add_action('wp_head', 'smooth_slider_css');

function smooth_slider_enqueue_scripts() {
//	wp_register_script('jquery', false, false, false, false);
	wp_enqueue_script( 'stepcarousel', smooth_slider_plugin_url( 'js/stepcarousel.js' ),
		array('jquery'), SMOOTH_SLIDER_VER, false); 
	wp_enqueue_style( 'smooth_slider_css', smooth_slider_plugin_url( 'css/smooth-slider.css' ),
		false, SMOOTH_SLIDER_VER, 'all'); 
}

add_action( 'init', 'smooth_slider_enqueue_scripts' );

function get_smooth_slider() {
 global $smooth_slider; 
?>
<script type="text/javascript">
stepcarousel.setup({
	galleryid: 'smooth_sliderc', //id of carousel DIV
	beltclass: 'smooth_sliderb', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'smooth_slideri', //class of panel DIVs each holding content
	autostep: {enable: true, moveby:1, pause:<?php echo $smooth_slider['speed']*1000; ?>},
	panelbehavior: {speed:500, wraparound:false, persist:false},
	defaultbuttons: {enable: <?php if ($smooth_slider['prev_next'] == 1) {echo "true";} else {echo "false";} ?>, moveby: 1, leftnav: ['<?php echo smooth_slider_plugin_url( 'images/button_prev.png' ); ?>', -25, <?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } echo (($smooth_slider['height'] - $extra_height)/2); ?>], rightnav: ['<?php echo smooth_slider_plugin_url( 'images/button_next.png' ); ?>', 0, <?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } echo (($smooth_slider['height'] - $extra_height)/2); ?>]},
	statusvars: ['imageA', 'imageB', 'imageC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'], //content setting ['inline'] or ['external', 'path_to_external_file']
	onslide:function(){
	  jQuery("#smooth_sliderc_nav li a").css("fontWeight", "normal");
	  jQuery("#smooth_sliderc_nav li a").css("fontSize", "<?php echo $smooth_slider['content_fsize']; ?>px");
	  var curr_slide = imageA;
  	  jQuery("#sldr"+curr_slide).css("fontWeight", "bolder");
	  jQuery("#sldr"+curr_slide).css("fontSize", "<?php echo ($smooth_slider['content_fsize'] + 5); ?>px");
	  
	  <?php if ($smooth_slider['goto_slide'] == 2) { 
 				list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");
				global $sldr_nav_width;
				$sldr_nav_width = $width/2;
	  ?>
	  var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; ?>;
	  jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
	  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+nav_width+"px 0");
	  <?php } ?>
	  
  }
})
</script>
<noscript><strong>This page is having a slideshow that uses Javascript. Your browser either doesn't support Javascript or you have it turned off. To see this page as it is meant to appear please use a Javascript enabled browser.</strong></noscript>
    	<div id="smooth_sldr">
		<div id="smooth_sldr_items">
			<div id="smooth_sldr_body">
				<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { ?><div class="sldr_title"><?php echo $smooth_slider['title_text']; ?></div> <?php } ?>
				<div id="smooth_sliderc">
					<div class="smooth_sliderb">
					<?php global $smooth_sldr_j; $smooth_sldr_j = carousel_posts_on_slider($smooth_slider['no_posts']); ?>
					</div>
				</div>
			</div>
            <?php if ($smooth_slider['goto_slide'] == 1) { ?>
            <ul id="smooth_sliderc_nav">
                <?php global $smooth_sldr_j; for($i=1; $i<=$smooth_sldr_j; $i++) { 
				echo "<li><a id=\"sldr".$i."\" href=\"#\" >".$i."</a></li>\n";
                 } ?>
			</ul>
            <?php } 
			if ($smooth_slider['goto_slide'] == 2) { ?>
            <div id="smooth_sliderc_nav">
                <?php global $smooth_sldr_j; for($i=1; $i<=$smooth_sldr_j; $i++) { 
				list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide".$i.".png");
				$width = $width/2;
				echo "<a class=\"smooth_sliderc_nav\" id=\"sldr".$i."\" style=\"background-image:url(".smooth_slider_plugin_url( 'images/' )."slide".$i.".png);background-position:0 0;width:".$width."px;height:".$height."px;\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" ></a>\n";
                 } ?>
			  </div>
	  <?php }  
			 if ($smooth_slider['goto_slide'] == 3) { ?>	 
             <div id="smooth_sliderc_nav"><li style="border:none;"><?php echo $smooth_slider['custom_nav']; ?></li></div>
      <?php } ?>
            <br class="sldrbr" />
            <div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
		</div>
	</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery('#smooth_sliderc_nav a').click(function() {
		var id = jQuery(this).attr('id');
        var step_to_slide = id.replace(/sldr/, "");
        document.getElementById(id).href = "javascript:stepcarousel.stepTo('smooth_sliderc', "+step_to_slide+")";
    });
	});
</script>    
<?php	
}

//Smooth Slider template tag to get the Category specific posts in the slider.
function get_smooth_slider_cat($catg_slug) {
 global $smooth_slider; 
?>
<script type="text/javascript">
stepcarousel.setup({
	galleryid: 'smooth_sliderc', //id of carousel DIV
	beltclass: 'smooth_sliderb', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'smooth_slideri', //class of panel DIVs each holding content
	autostep: {enable: true, moveby:1, pause:<?php echo $smooth_slider['speed']*1000; ?>},
	panelbehavior: {speed:500, wraparound:false, persist:false},
	defaultbuttons: {enable: <?php if ($smooth_slider['prev_next'] == 1) {echo "true";} else {echo "false";} ?>, moveby: 1, leftnav: ['<?php echo smooth_slider_plugin_url( 'images/button_prev.png' ); ?>', -25, <?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } echo (($smooth_slider['height'] - $extra_height)/2); ?>], rightnav: ['<?php echo smooth_slider_plugin_url( 'images/button_next.png' ); ?>', 0, <?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } echo (($smooth_slider['height'] - $extra_height)/2); ?>]},
	statusvars: ['imageA', 'imageB', 'imageC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'], //content setting ['inline'] or ['external', 'path_to_external_file']
	onslide:function(){
	  jQuery("#smooth_sliderc_nav li a").css("fontWeight", "normal");
	  jQuery("#smooth_sliderc_nav li a").css("fontSize", "<?php echo $smooth_slider['content_fsize']; ?>px");
	  var curr_slide = imageA;
  	  jQuery("#sldr"+curr_slide).css("fontWeight", "bolder");
	  jQuery("#sldr"+curr_slide).css("fontSize", "<?php echo ($smooth_slider['content_fsize'] + 5); ?>px");
	  
	  <?php if ($smooth_slider['goto_slide'] == 2) { 
 				list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");
				global $sldr_nav_width;
				$sldr_nav_width = $width/2;
	  ?>
	  var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; ?>;
	  jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
	  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+nav_width+"px 0");
	  <?php } ?>
	  
  }
})
</script>
<noscript><strong>This page is having a slideshow that uses Javascript. Your browser either doesn't support Javascript or you have it turned off. To see this page as it is meant to appear please use a Javascript enabled browser.</strong></noscript>
    	<div id="smooth_sldr">
		<div id="smooth_sldr_items">
			<div id="smooth_sldr_body">
				<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { ?><div class="sldr_title"><?php echo $smooth_slider['title_text']; ?></div> <?php } ?>
				<div id="smooth_sliderc">
					<div class="smooth_sliderb">
					<?php global $smooth_sldr_i; $smooth_sldr_i = carousel_posts_on_slider_cat($smooth_slider['no_posts'], $catg_slug); ?>
					</div>
				</div>
			</div>
            <?php if ($smooth_slider['goto_slide'] == 1) { ?>
            <ul id="smooth_sliderc_nav">
                <?php global $smooth_sldr_i; for($i=1; $i<=$smooth_sldr_i; $i++) { 
				echo "<li><a id=\"sldr".$i."\" href=\"#\" >".$i."</a></li>\n";
                 } ?>
			</ul>
            <?php } 
			if ($smooth_slider['goto_slide'] == 2) { ?>
            <div id="smooth_sliderc_nav">
                <?php global $smooth_sldr_i; for($i=1; $i<=$smooth_sldr_i; $i++) { 
				list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide".$i.".png");
				$width = $width/2;
				echo "<a class=\"smooth_sliderc_nav\" id=\"sldr".$i."\" style=\"background-image:url(".smooth_slider_plugin_url( 'images/' )."slide".$i.".png);background-position:0 0;width:".$width."px;height:".$height."px;\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" ></a>\n";
                 } ?>
			</div>
       <?php }  
			 if ($smooth_slider['goto_slide'] == 3) { ?>	 
             <div id="smooth_sliderc_nav"><li style="border:none;"><?php echo $smooth_slider['custom_nav']; ?></li></div>
      <?php } ?>
            <br class="sldrbr" />
            <div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
		</div>
	</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery('#smooth_sliderc_nav a').click(function() {
		var id = jQuery(this).attr('id');
        var step_to_slide = id.replace(/sldr/, "");
        document.getElementById(id).href = "javascript:stepcarousel.stepTo('smooth_sliderc', "+step_to_slide+")";
    });
	});
</script>    
<?php	
}

//Smooth Slider especially for WPMU sites, to get the slider posts on the overall WPMU site
function get_smooth_slider_wpmu_all() {
 global $smooth_slider; 
?>
<script type="text/javascript">
stepcarousel.setup({
	galleryid: 'smooth_sliderc', //id of carousel DIV
	beltclass: 'smooth_sliderb', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'smooth_slideri', //class of panel DIVs each holding content
	autostep: {enable: true, moveby:1, pause:<?php echo $smooth_slider['speed']*1000; ?>},
	panelbehavior: {speed:500, wraparound:false, persist:false},
	defaultbuttons: {enable: <?php if ($smooth_slider['prev_next'] == 1) {echo "true";} else {echo "false";} ?>, moveby: 1, leftnav: ['<?php echo smooth_slider_plugin_url( 'images/button_prev.png' ); ?>', -25, <?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } echo (($smooth_slider['height'] - $extra_height)/2); ?>], rightnav: ['<?php echo smooth_slider_plugin_url( 'images/button_next.png' ); ?>', 0, <?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } echo (($smooth_slider['height'] - $extra_height)/2); ?>]},
	statusvars: ['imageA', 'imageB', 'imageC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'], //content setting ['inline'] or ['external', 'path_to_external_file']
	onslide:function(){
	  jQuery("#smooth_sliderc_nav li a").css("fontWeight", "normal");
	  jQuery("#smooth_sliderc_nav li a").css("fontSize", "<?php echo $smooth_slider['content_fsize']; ?>px");
	  var curr_slide = imageA;
  	  jQuery("#sldr"+curr_slide).css("fontWeight", "bolder");
	  jQuery("#sldr"+curr_slide).css("fontSize", "<?php echo ($smooth_slider['content_fsize'] + 5); ?>px");
	  
	  <?php if ($smooth_slider['goto_slide'] == 2) { 
 				list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");
				global $sldr_nav_width;
				$sldr_nav_width = $width/2;
	  ?>
	  var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; ?>;
	  jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
	  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+nav_width+"px 0");
	  <?php } ?>
	  
  }
})
</script>
<noscript><strong>This page is having a slideshow that uses Javascript. Your browser either doesn't support Javascript or you have it turned off. To see this page as it is meant to appear please use a Javascript enabled browser.</strong></noscript>
    	<div id="smooth_sldr">
		<div id="smooth_sldr_items">
			<div id="smooth_sldr_body">
				<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { ?><div class="sldr_title"><?php echo $smooth_slider['title_text']; ?></div> <?php } ?>
				<div id="smooth_sliderc">
					<div class="smooth_sliderb">
					<?php global $smooth_sldr_k; $smooth_sldr_k = smooth_slider_wpmu_carousel_posts($smooth_slider['no_posts']); ?>
					</div>
				</div>
			</div>
            <?php if ($smooth_slider['goto_slide'] == 1) { ?>
            <ul id="smooth_sliderc_nav">
                <?php global $smooth_sldr_k; for($i=1; $i<=$smooth_sldr_k; $i++) { 
				echo "<li><a id=\"sldr".$i."\" href=\"#\" >".$i."</a></li>\n";
                 } ?>
			</ul>
            <?php } 
			if ($smooth_slider['goto_slide'] == 2) { ?>
            <div id="smooth_sliderc_nav">
                <?php global $smooth_sldr_k; for($i=1; $i<=$smooth_sldr_k; $i++) { 
				list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide".$i.".png");
				$width = $width/2;
				echo "<a class=\"smooth_sliderc_nav\" id=\"sldr".$i."\" style=\"background-image:url(".smooth_slider_plugin_url( 'images/' )."slide".$i.".png);background-position:0 0;width:".$width."px;height:".$height."px;\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" ></a>\n";
                 } ?>
			</div>
       <?php }  
			 if ($smooth_slider['goto_slide'] == 3) { ?>	 
             <div id="smooth_sliderc_nav"><li style="border:none;"><?php echo $smooth_slider['custom_nav']; ?></li></div>
      <?php } ?>
            <br class="sldrbr" />
            <div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
		</div>
	</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery('#smooth_sliderc_nav a').click(function() {
		var id = jQuery(this).attr('id');
        var step_to_slide = id.replace(/sldr/, "");
        document.getElementById(id).href = "javascript:stepcarousel.stepTo('smooth_sliderc', "+step_to_slide+")";
    });
	});
</script>    
<?php	
}

// Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'smooth_slider_settings');
  add_action( 'admin_init', 'register_mysettings' ); 
} 

function smooth_slider_admin_scripts() {
  if ( is_admin() ){ // admin actions
  // Settings page only
	if ( isset($_GET['page']) && 'smooth-slider.php' == $_GET['page'] ) {
	wp_register_script('jquery', false, false, false, false);
	wp_enqueue_script( 'stepcarousel', smooth_slider_plugin_url( 'js/stepcarousel.js' ),
		array('jquery'), SMOOTH_SLIDER_VER, false); 
	wp_enqueue_style( 'smooth_slider_css', smooth_slider_plugin_url( 'css/smooth-slider.css' ),
		false, SMOOTH_SLIDER_VER, 'all');
	}
  }
}

add_action( 'admin_init', 'smooth_slider_admin_scripts' );

function smooth_slider_admin_head() {
global $smooth_slider;
if ( is_admin() ){ // admin actions
   
  // Settings page only
	if ( isset($_GET['page']) && 'smooth-slider.php' == $_GET['page'] ) {
		wp_print_scripts( 'farbtastic' );
		wp_print_styles( 'farbtastic' );
?>
<script type="text/javascript">
	// <![CDATA[
jQuery(document).ready(function() {
		jQuery('#colorbox_1').farbtastic('#color_value_1');
		jQuery('#color_picker_1').click(function () {
           if (jQuery('#colorbox_1').css('display') == "block") {
		      jQuery('#colorbox_1').fadeOut("slow"); }
		   else {
		      jQuery('#colorbox_1').fadeIn("slow"); }
        });
		var colorpick_1 = false;
		jQuery(document).mousedown(function(){
		    if (colorpick_1 == true) {
    			return; }
				jQuery('#colorbox_1').fadeOut("slow");
		});
		jQuery(document).mouseup(function(){
		    colorpick_1 = false;
		});
//for second color box
		jQuery('#colorbox_2').farbtastic('#color_value_2');
		jQuery('#color_picker_2').click(function () {
           if (jQuery('#colorbox_2').css('display') == "block") {
		      jQuery('#colorbox_2').fadeOut("slow"); }
		   else {
		      jQuery('#colorbox_2').fadeIn("slow"); }
        });
		var colorpick_2 = false;
		jQuery(document).mousedown(function(){
		    if (colorpick_2 == true) {
    			return; }
				jQuery('#colorbox_2').fadeOut("slow");
		});
		jQuery(document).mouseup(function(){
		    colorpick_2 = false;
		});
//for third color box
		jQuery('#colorbox_3').farbtastic('#color_value_3');
		jQuery('#color_picker_3').click(function () {
           if (jQuery('#colorbox_3').css('display') == "block") {
		      jQuery('#colorbox_3').fadeOut("slow"); }
		   else {
		      jQuery('#colorbox_3').fadeIn("slow"); }
        });
		var colorpick_3 = false;
		jQuery(document).mousedown(function(){
		    if (colorpick_3 == true) {
    			return; }
				jQuery('#colorbox_3').fadeOut("slow");
		});
		jQuery(document).mouseup(function(){
		    colorpick_3 = false;
		});
//for fourth color box
		jQuery('#colorbox_4').farbtastic('#color_value_4');
		jQuery('#color_picker_4').click(function () {
           if (jQuery('#colorbox_4').css('display') == "block") {
		      jQuery('#colorbox_4').fadeOut("slow"); }
		   else {
		      jQuery('#colorbox_4').fadeIn("slow"); }
        });
		var colorpick_4 = false;
		jQuery(document).mousedown(function(){
		    if (colorpick_4 == true) {
    			return; }
				jQuery('#colorbox_4').fadeOut("slow");
		});
		jQuery(document).mouseup(function(){
		    colorpick_4 = false;
		});
//for fifth color box
		jQuery('#colorbox_5').farbtastic('#color_value_5');
		jQuery('#color_picker_5').click(function () {
           if (jQuery('#colorbox_5').css('display') == "block") {
		      jQuery('#colorbox_5').fadeOut("slow"); }
		   else {
		      jQuery('#colorbox_5').fadeIn("slow"); }
        });
		var colorpick_5 = false;
		jQuery(document).mousedown(function(){
		    if (colorpick_5 == true) {
    			return; }
				jQuery('#colorbox_5').fadeOut("slow");
		});
		jQuery(document).mouseup(function(){
		    colorpick_5 = false;
		});
//for sixth color box
		jQuery('#colorbox_6').farbtastic('#color_value_6');
		jQuery('#color_picker_6').click(function () {
           if (jQuery('#colorbox_6').css('display') == "block") {
		      jQuery('#colorbox_6').fadeOut("slow"); }
		   else {
		      jQuery('#colorbox_6').fadeIn("slow"); }
        });
		var colorpick_6 = false;
		jQuery(document).mousedown(function(){
		    if (colorpick_6 == true) {
    			return; }
				jQuery('#colorbox_6').fadeOut("slow");
		});
		jQuery(document).mouseup(function(){
		    colorpick_6 = false;
		});
		jQuery('#sldr_close').click(function () {
			jQuery('#sldr_message').fadeOut("slow");
		});
});
function confirmRemove()
{
	var agree=confirm("This will remove selected Posts/Pages from Slider.");
	if (agree)
	return true ;
	else
	return false ;
}
function confirmRemoveAll()
{
	var agree=confirm("Remove all Posts/Pages from Smooth Slider??");
	if (agree)
	return true ;
	else
	return false ;
}
</script>
<style type="text/css">
.color-picker-wrap {
		position: absolute;
 		display: none; 
		background: #fff;
		border: 3px solid #ccc;
		padding: 3px;
		z-index: 1000;
	}
#divFeedityWidget span[style] {
        display:none !important;
}
#sldr_message {background-color:#FEF7DA;clear:both;width:72%;}
#sldr_close {float:right;} 
</style>
<style type="text/css" media="screen">#smooth_sldr{width:<?php echo $smooth_slider['width']; ?>px;height:<?php echo $smooth_slider['height']; ?>px;background-color:<?php if ($smooth_slider['bg'] == '1') { echo "transparent";} else { echo $smooth_slider['bg_color']; } ?>;border:<?php echo $smooth_slider['border']; ?>px solid <?php echo $smooth_slider['brcolor']; ?>;}#smooth_sldr_items{padding:10px <?php if ($smooth_slider['prev_next'] == 1) {echo "18";} else {echo "12";} ?>px 0px <?php if ($smooth_slider['prev_next'] == 1) {echo "26";} else {echo "12";} ?>px;}#smooth_sliderc{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 44);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");$nav_size = $height;} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.smooth_slideri{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 54);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){list($width, $height, $type, $attr) = getimagesize("".smooth_slider_plugin_url( 'images/' )."slide1.png");$nav_size = $height;} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.sldr_title{font-family:<?php echo $smooth_slider['title_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['title_fsize']; ?>px;font-weight:<?php if ($smooth_slider['title_fstyle'] == "bold" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "bold";} else { echo "normal"; } ?>;font-style:<?php if ($smooth_slider['title_fstyle'] == "italic" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['title_fcolor']; ?>;}#smooth_sldr_body h2{line-height:<?php echo ($smooth_slider['ptitle_fsize'] + 3); ?>px;font-family:<?php echo $smooth_slider['ptitle_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['ptitle_fsize']; ?>px;font-weight:<?php if ($smooth_slider['ptitle_fstyle'] == "bold" or $smooth_slider['ptitle_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['ptitle_fstyle'] == "italic" or $smooth_slider['ptitle_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px 0 5px 0;}#smooth_sldr_body h2 a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}#smooth_sldr_body span{font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-weight:<?php if ($smooth_slider['content_fstyle'] == "bold" or $smooth_slider['content_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['content_fstyle']=="italic" or $smooth_slider['content_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['content_fcolor']; ?>;}.smooth_slider_thumbnail{float:<?php echo $smooth_slider['img_align']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px <?php if($smooth_slider['img_align'] == "left") {echo "5";} else {echo "0";} ?>px 0 <?php if($smooth_slider['img_align'] == "right") {echo "5";} else {echo "0";} ?>px;<?php if ($smooth_slider['img_size'] == 1) { ?>width:<?php echo $smooth_slider['img_width']; ?>px;height:<?php echo $smooth_slider['img_height']; ?>px;<?php } ?> border:<?php echo $smooth_slider['img_border']; ?>px solid <?php echo $smooth_slider['img_brcolor']; ?>;}#smooth_sldr_body p.more a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;}#smooth_sliderc_nav li{border:1px solid <?php echo $smooth_slider['content_fcolor']; ?>;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;}#smooth_sliderc_nav li a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}.sldrlink{padding-right:<?php if ($smooth_slider['prev_next'] == 1) {echo "40";} else {echo "25";} ?>px;}.sldrlink a{color:<?php echo $smooth_slider['content_fcolor']; ?>;}</style>
<?php
   } //for smooth slider option page
 }//only for admin
}

add_action('admin_head', 'smooth_slider_admin_head');

// function for adding settings page to wp-admin
function smooth_slider_settings() {
    // Add a new submenu under Options:
    add_options_page('Smooth Slider', 'Smooth Slider', 9, basename(__FILE__), 'smooth_slider_settings_page');
}

// This function displays the page content for the Smooth Slider Options submenu
function smooth_slider_settings_page() {
global $smooth_slider;
// displaying plugin version info
	require_once(ABSPATH.'/wp-admin/includes/plugin-install.php');
	$plug_api = plugins_api('plugin_information', array('slug' => sanitize_title('Smooth Slider') ));
		if ( is_wp_error($plug_api) ) {
			wp_die($plug_api);
		}
?>

<div class="wrap">
<?php
if (SMOOTH_SLIDER_VER != $plug_api->version) {
     echo '<div id="sldr_message">A new version Smooth Slider (version '.$plug_api->version.') is available. Please upgrade to enjoy all available features.<img id="sldr_close" src="'.smooth_slider_plugin_url( 'images/close.jpg' ).'" /></div>';
}
?>
<h2 style="float:left;">Smooth Slider Options </h2>
<form  style="float:left;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8046056">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<form  style="clear:both;" method="post" action="options.php">
<div id="poststuff" class="metabox-holder has-right-sidebar" > 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About this Plugin:</span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="http://www.clickonf5.org/smooth-slider" title="Smooth Slider Homepage" >Plugin Homepage</a></li>
                <li><a href="http://www.clickonf5.org" title="Visit Internet Techies" >Plugin Parent Site</a></li>
                <li><a href="http://www.clickonf5.org/phpbb/smooth-slider-f12/" title="Support Forum for Smooth Slider" >Support Forum</a></li>
                <li><a href="http://www.clickonf5.org/about/tejaswini" title="Smooth Slider Author Page" >About the Author</a></li>
                <li><a href="http://wordpress.org/extend/plugins/smooth-slider/stats/">Status:Downloaded <strong><?php echo $plug_api->downloaded; ?></strong> times</a></li>
                <li><a href="http://clickonf5.org/go/paypal/smooth-slider/" title="Donate if you liked the plugin and support in enhancing Smooth Slider and creating new plugins" >Donate with Paypal</a></li>
                </ul> 
              </div> 
			</div> 
     </div>

     <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>Credits:</span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="http://www.dynamicdrive.com" title="Step Carousel jQuery plugin by Dynamic Drive" >Step Carousel Viewer</a></li>
                <li><a href="http://www.bioxd.com/featureme" title="FeatureMe Wordpress Plugin by Oscar Alcalá" >FeatureMe Wordpress Plugin</a></li>
                <li><a href="http://acko.net/dev/farbtastic" title="Farbtastic Color Picker by Steven Wittens" >Farbtastic Color Picker</a></li>
                <li><a href="http://jquery.com/" title="jQuery JavaScript Library - John Resig" >jQuery JavaScript Library</a></li>
                </ul> 
              </div> 
			</div> 
     </div>
     
          <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>Support &amp; Donations</span></h3> 
			  <div class="inside">
					<script language="JavaScript" type="text/javascript">
                    <!--
                        // Customize the widget by editing the fields below
                        // All fields are required
                    
                        // Your Feedity RSS feed URL
                        feedity_widget_feed = "http://feedity.com/rss.aspx/clickonf5-org/UlVTUldR";
                    
                        // Number of items to display in the widget
                        feedity_widget_numberofitems = "5";
                    
                        // Show feed item published date (values: yes or no)
                        feedity_widget_showdate = "no";
                    
                        // Widget box width (in px, pt, em, or %)
                        feedity_widget_width = "220px";
                    
                        // Widget background color in hex or by name (eg: #ffffff or white)
                        feedity_widget_backcolor = "#ffffff";
                    
                        // Widget font/link color in hex or by name (eg: #000000 or black)
                        feedity_widget_fontcolor = "#000000";
                    //-->
                    </script>
                    <script language="JavaScript" type="text/javascript" src="http://feedity.com/js/widget.js"></script>
              </div> 
			</div> 
     </div>   

<h2>Preview</h2> 
<?php settings_fields('smooth-slider-group'); ?>
<div style="width:70%;">
<?php 
get_smooth_slider();
?> </div>

<h2>Slider Box</h2> 
<p>Customize the looks of the Slider box wrapping the complete slideshow from here</p> 

<div style="float:left;">
<table class="form-table">

<tr valign="top">
<th scope="row">Slide Pause Interval</th>
<td><input type="text" name="smooth_slider_options[speed]" id="smooth_slider_speed" class="small-text" value="<?php echo $smooth_slider['speed']; ?>" />&nbsp;(in secs)</td>
</tr>

<tr valign="top">
<th scope="row">Number of Posts in the Slideshow</th>
<td><input type="text" name="smooth_slider_options[no_posts]" id="smooth_slider_no_posts" class="small-text" value="<?php echo $smooth_slider['no_posts']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Background Color</th>
<td><input type="text" name="smooth_slider_options[bg_color]" id="color_value_1" value="<?php echo $smooth_slider['bg_color']; ?>" />&nbsp; <img id="color_picker_1" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_1"></div> &nbsp; &nbsp; &nbsp; 
<label for="smooth_slider_bg"><input name="smooth_slider_options[bg]" type="checkbox" id="smooth_slider_bg" value="1" <?php checked('1', $smooth_slider['bg']); ?>  /> Use Transparent Background</label> </td>
</tr>
 
<tr valign="top">
<th scope="row">Slider Height</th>
<td><input type="text" name="smooth_slider_options[height]" id="smooth_slider_height" class="small-text" value="<?php echo $smooth_slider['height']; ?>" />&nbsp;px</td>
</tr>


<tr valign="top">
<th scope="row">Slider Width</th>
<td><input type="text" name="smooth_slider_options[width]" id="smooth_slider_width" class="small-text" value="<?php echo $smooth_slider['width']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Border Thickness</th>
<td><input type="text" name="smooth_slider_options[border]" id="smooth_slider_border" class="small-text" value="<?php echo $smooth_slider['border']; ?>" />&nbsp;px &nbsp;(put 0 if no border is required)</td>
</tr>

<tr valign="top">
<th scope="row">Border Color</th>
<td><input type="text" name="smooth_slider_options[brcolor]" id="color_value_6" value="<?php echo $smooth_slider['brcolor']; ?>" />&nbsp; <img id="color_picker_6" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_6"></div></td>
</tr>

<tr valign="top"> 
<th scope="row">Navigation Buttons</th> 
<td><fieldset><legend class="screen-reader-text"><span>Navigation Buttons</span></legend> 
<label for="smooth_slider_prev_next"> 
<input name="smooth_slider_options[prev_next]" type="checkbox" id="smooth_slider_prev_next" value="1" <?php checked("1", $smooth_slider['prev_next']); ?> /> 
 Show Prev/Next navigation arrows</label><br /> 
<label for="smooth_slider_goto_slide">Show go to slide number links at the bottom as 1, 2, 3 etc. or images</label><br />
<input name="smooth_slider_options[goto_slide]" type="radio" id="smooth_slider_goto_slide" value="0" <?php checked('0', $smooth_slider['goto_slide']); ?>  /> None <br /> 
<input name="smooth_slider_options[goto_slide]" type="radio" id="smooth_slider_goto_slide" value="1" <?php checked('1', $smooth_slider['goto_slide']); ?>  /> Numbers <br /> 
<input name="smooth_slider_options[goto_slide]" type="radio" id="smooth_slider_goto_slide" value="2" <?php checked('2', $smooth_slider['goto_slide']); ?>  /> Custom Images for Navigation <br /> 
<input name="smooth_slider_options[goto_slide]" type="radio" id="smooth_slider_goto_slide" value="3" <?php checked('3', $smooth_slider['goto_slide']); ?>  /> Enter Custom Text or HTML &nbsp; &nbsp; 
<input type="text" name="smooth_slider_options[custom_nav]" class="regular-text code" value="<?php echo htmlentities($smooth_slider['custom_nav'], ENT_QUOTES); ?>" />
</fieldset></td> 
</tr> 

</table>

<h2>Slider Title</h2> 
<p>Customize the looks of the main title of the Slideshow from here</p> 
<table class="form-table">

<tr valign="top">
<th scope="row">Text</th>
<td><input type="text" name="smooth_slider_options[title_text]" id="smooth_slider_title_text" value="<?php echo $smooth_slider['title_text']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Font</th>
<td><select name="smooth_slider_options[title_font]" id="smooth_slider_title_font" >
<option value="Arial" <?php if ($smooth_slider['title_font'] == "Arial"){ echo "selected";}?> >Arial</option>
<option value="Book Antiqua" <?php if ($smooth_slider['title_font'] == "Book Antiqua"){ echo "selected";}?> >Book Antiqua</option>
<option value="Bookman Old Style" <?php if ($smooth_slider['title_font'] == "Bookman Old Style"){ echo "selected";}?> >Bookman Old Style</option>
<option value="Calibri" <?php if ($smooth_slider['title_font'] == "Calibri"){ echo "selected";}?> >Calibri</option>
<option value="Century Schoolbook" <?php if ($smooth_slider['title_font'] == "Century Schoolbook"){ echo "selected";}?> >Century Schoolbook</option>
<option value="Courier New" <?php if ($smooth_slider['title_font'] == "Courier New"){ echo "selected";}?> >Courier New</option>
<option value="Geneva" <?php if ($smooth_slider['title_font'] == "Geneva"){ echo "selected";}?> >Geneva</option>
<option value="Georgia" <?php if ($smooth_slider['title_font'] == "Georgia"){ echo "selected";} ?> >Georgia</option>
<option value="Helvetica" <?php if ($smooth_slider['title_font'] == "Helvetica"){ echo "selected";}?> >Helvetica</option>
<option value="Monotype Corsiva" <?php if ($smooth_slider['title_font'] == "Monotype Corsiva"){ echo "selected";}?> >Monotype Corsiva</option>
<option value="Times New Roman" <?php if ($smooth_slider['title_font'] == "Times New Roman"){ echo "selected";}?> >Times New Roman</option>
<option value="Trebuchet MS" <?php if ($smooth_slider['title_font'] == "Trebuchet MS"){ echo "selected";}?> >Trebuchet MS</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Font Color</th>
<td><input type="text" name="smooth_slider_options[title_fcolor]" id="color_value_2" value="<?php echo $smooth_slider['title_fcolor']; ?>" />&nbsp; <img id="color_picker_2" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_2"></div></td>
</tr>

<tr valign="top">
<th scope="row">Font Size</th>
<td><input type="text" name="smooth_slider_options[title_fsize]" id="smooth_slider_title_fsize" class="small-text" value="<?php echo $smooth_slider['title_fsize']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Font Style</th>
<td><select name="smooth_slider_options[title_fstyle]" id="smooth_slider_title_fstyle" >
<option value="bold" <?php if ($smooth_slider['title_fstyle'] == "bold"){ echo "selected";}?> >Bold</option>
<option value="bold italic" <?php if ($smooth_slider['title_fstyle'] == "bold italic"){ echo "selected";}?> >Bold Italic</option>
<option value="italic" <?php if ($smooth_slider['title_fstyle'] == "italic"){ echo "selected";}?> >Italic</option>
<option value="normal" <?php if ($smooth_slider['title_fstyle'] == "normal"){ echo "selected";}?> >Normal</option>
</select>
</td>
</tr>
</table>

<h2>Post Title</h2> 
<p>Customize the looks of the title of each of the sliding post here</p> 
<table class="form-table">

<tr valign="top">
<th scope="row">Font</th>
<td><select name="smooth_slider_options[ptitle_font]" id="smooth_slider_ptitle_font" >
<option value="Arial" <?php if ($smooth_slider['ptitle_font'] == "Arial"){ echo "selected";}?> >Arial</option>
<option value="Book Antiqua" <?php if ($smooth_slider['ptitle_font'] == "Book Antiqua"){ echo "selected";}?> >Book Antiqua</option>
<option value="Bookman Old Style" <?php if ($smooth_slider['ptitle_font'] == "Bookman Old Style"){ echo "selected";}?> >Bookman Old Style</option>
<option value="Calibri" <?php if ($smooth_slider['ptitle_font'] == "Calibri"){ echo "selected";}?> >Calibri</option>
<option value="Century Schoolbook" <?php if ($smooth_slider['ptitle_font'] == "Century Schoolbook"){ echo "selected";}?> >Century Schoolbook</option>
<option value="Courier New" <?php if ($smooth_slider['ptitle_font'] == "Courier New"){ echo "selected";}?> >Courier New</option>
<option value="Geneva" <?php if ($smooth_slider['ptitle_font'] == "Geneva"){ echo "selected";}?> >Geneva</option>
<option value="Georgia" <?php if ($smooth_slider['ptitle_font'] == "Georgia"){ echo "selected";} ?> >Georgia</option>
<option value="Helvetica" <?php if ($smooth_slider['ptitle_font'] == "Helvetica"){ echo "selected";}?> >Helvetica</option>
<option value="Monotype Corsiva" <?php if ($smooth_slider['ptitle_font'] == "Monotype Corsiva"){ echo "selected";}?> >Monotype Corsiva</option>
<option value="Times New Roman" <?php if ($smooth_slider['ptitle_font'] == "Times New Roman"){ echo "selected";}?> >Times New Roman</option>
<option value="Trebuchet MS" <?php if ($smooth_slider['ptitle_font'] == "Trebuchet MS"){ echo "selected";}?> >Trebuchet MS</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Font Color</th>
<td><input type="text" name="smooth_slider_options[ptitle_fcolor]" id="color_value_3" value="<?php echo $smooth_slider['ptitle_fcolor']; ?>" />&nbsp; <img id="color_picker_3" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_3"></div></td>
</tr>

<tr valign="top">
<th scope="row">Font Size</th>
<td><input type="text" name="smooth_slider_options[ptitle_fsize]" id="smooth_slider_ptitle_fsize" class="small-text" value="<?php echo $smooth_slider['ptitle_fsize']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Font Style</th>
<td><select name="smooth_slider_options[ptitle_fstyle]" id="smooth_slider_ptitle_fstyle" >
<option value="bold" <?php if ($smooth_slider['ptitle_fstyle'] == "bold"){ echo "selected";}?> >Bold</option>
<option value="bold italic" <?php if ($smooth_slider['ptitle_fstyle'] == "bold italic"){ echo "selected";}?> >Bold Italic</option>
<option value="italic" <?php if ($smooth_slider['ptitle_fstyle'] == "italic"){ echo "selected";}?> >Italic</option>
<option value="normal" <?php if ($smooth_slider['ptitle_fstyle'] == "normal"){ echo "selected";}?> >Normal</option>
</select>
</td>
</tr>
</table>

<h2>Thumbnail Image</h2> 
<p>Customize the looks of the thumbnail image for each of the sliding post here</p> 
<table class="form-table">

<tr valign="top"> 
<th scope="row">Pick Image From</th> 
<td><fieldset><legend class="screen-reader-text"><span>Pick Image From</span></legend> 
<input name="smooth_slider_options[img_pick]" type="radio" value="0" <?php checked('0', $smooth_slider['img_pick']); ?>  /> slider_thumbnail Custom Field &nbsp; &nbsp;<br />
<input name="smooth_slider_options[img_pick]" type="radio" value="1" <?php checked('1', $smooth_slider['img_pick']); ?>  /> First Image from the Content&nbsp; 
</fieldset></td> 
</tr> 

<tr valign="top">
<th scope="row">Align to</th>
<td><select name="smooth_slider_options[img_align]" id="smooth_slider_img_align" >
<option value="left" <?php if ($smooth_slider['img_align'] == "left"){ echo "selected";}?> >Left</option>
<option value="right" <?php if ($smooth_slider['img_align'] == "right"){ echo "selected";}?> >Right</option>
<option value="none" <?php if ($smooth_slider['img_align'] == "none"){ echo "selected";}?> >Center</option>
</select>
</td>
</tr>

<tr valign="top"> 
<th scope="row">Image Size</th> 
<td><fieldset><legend class="screen-reader-text"><span>Image Size</span></legend> 
<input name="smooth_slider_options[img_size]" type="radio" value="0" <?php checked('0', $smooth_slider['img_size']); ?>  /> Original Size &nbsp; &nbsp; <br />
<input name="smooth_slider_options[img_size]" type="radio" value="1" <?php checked('1', $smooth_slider['img_size']); ?>  /> Custom Size:&nbsp; 
<label for="smooth_slider_options[img_height]">Height</label>
<input type="text" name="smooth_slider_options[img_height]" class="small-text" value="<?php echo $smooth_slider['img_height']; ?>" />&nbsp;px &nbsp;&nbsp; 
<label for="smooth_slider_options[img_width]">Width</label>
<input type="text" name="smooth_slider_options[img_width]" class="small-text" value="<?php echo $smooth_slider['img_width']; ?>" />&nbsp;px &nbsp;&nbsp; 
</fieldset></td> 
</tr> 

<tr valign="top">
<th scope="row">Border Thickness</th>
<td><input type="text" name="smooth_slider_options[img_border]" id="smooth_slider_img_border" class="small-text" value="<?php echo $smooth_slider['img_border']; ?>" />&nbsp;px &nbsp;(put 0 if no border is required)</td>
</tr>

<tr valign="top">
<th scope="row">Border Color</th>
<td><input type="text" name="smooth_slider_options[img_brcolor]" id="color_value_4" value="<?php echo $smooth_slider['img_brcolor']; ?>" />&nbsp; <img id="color_picker_4" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_4"></div></td>
</tr>

<tr valign="top">
<th scope="row">Make pure Image Slider</th>
<td><input name="smooth_slider_options[image_only]" type="checkbox" value="1" <?php checked('1', $smooth_slider['image_only']); ?>  />&nbsp;(check this to convert Smooth Slider to Image Slider with no content)</td>
</tr>
</table>

<h2>Slider Content</h2> 
<p>Customize the looks of the content of each of the sliding post here</p> 
<table class="form-table">
<tr valign="top">
<th scope="row">Font</th>
<td><select name="smooth_slider_options[content_font]" id="smooth_slider_content_font" >
<option value="Arial" <?php if ($smooth_slider['content_font'] == "Arial"){ echo "selected";}?> >Arial</option>
<option value="Book Antiqua" <?php if ($smooth_slider['content_font'] == "Book Antiqua"){ echo "selected";}?> >Book Antiqua</option>
<option value="Bookman Old Style" <?php if ($smooth_slider['content_font'] == "Bookman Old Style"){ echo "selected";}?> >Bookman Old Style</option>
<option value="Calibri" <?php if ($smooth_slider['content_font'] == "Calibri"){ echo "selected";}?> >Calibri</option>
<option value="Century Schoolbook" <?php if ($smooth_slider['content_font'] == "Century Schoolbook"){ echo "selected";}?> >Century Schoolbook</option>
<option value="Courier New" <?php if ($smooth_slider['content_font'] == "Courier New"){ echo "selected";}?> >Courier New</option>
<option value="Geneva" <?php if ($smooth_slider['content_font'] == "Geneva"){ echo "selected";}?> >Geneva</option>
<option value="Georgia" <?php if ($smooth_slider['content_font'] == "Georgia"){ echo "selected";} ?> >Georgia</option>
<option value="Helvetica" <?php if ($smooth_slider['content_font'] == "Helvetica"){ echo "selected";}?> >Helvetica</option>
<option value="Monotype Corsiva" <?php if ($smooth_slider['content_font'] == "Monotype Corsiva"){ echo "selected";}?> >Monotype Corsiva</option>
<option value="Times New Roman" <?php if ($smooth_slider['content_font'] == "Times New Roman"){ echo "selected";}?> >Times New Roman</option>
<option value="Trebuchet MS" <?php if ($smooth_slider['content_font'] == "Trebuchet MS"){ echo "selected";}?> >Trebuchet MS</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Font Color</th>
<td><input type="text" name="smooth_slider_options[content_fcolor]" id="color_value_5" value="<?php echo $smooth_slider['content_fcolor']; ?>" />&nbsp; <img id="color_picker_5" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_5"></div></td>
</tr>

<tr valign="top">
<th scope="row">Font Size</th>
<td><input type="text" name="smooth_slider_options[content_fsize]" id="smooth_slider_content_fsize" class="small-text" value="<?php echo $smooth_slider['content_fsize']; ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Font Style</th>
<td><select name="smooth_slider_options[content_fstyle]" id="smooth_slider_content_fstyle" >
<option value="bold" <?php if ($smooth_slider['content_fstyle'] == "bold"){ echo "selected";}?> >Bold</option>
<option value="bold italic" <?php if ($smooth_slider['content_fstyle'] == "bold italic"){ echo "selected";}?> >Bold Italic</option>
<option value="italic" <?php if ($smooth_slider['content_fstyle'] == "italic"){ echo "selected";}?> >Italic</option>
<option value="normal" <?php if ($smooth_slider['content_fstyle'] == "normal"){ echo "selected";}?> >Normal</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Pick content From</th>
<td><select name="smooth_slider_options[content_from]" id="smooth_slider_content_from" >
<option value="slider_content" <?php if ($smooth_slider['content_from'] == "slider_content"){ echo "selected";}?> >Slider Content Custom field</option>
<option value="excerpt" <?php if ($smooth_slider['content_from'] == "excerpt"){ echo "selected";}?> >Post Excerpt</option>
<option value="content" <?php if ($smooth_slider['content_from'] == "content"){ echo "selected";}?> >From Content</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Maximum content size</th>
<td><input type="text" name="smooth_slider_options[content_chars]" id="smooth_slider_content_chars" class="small-text" value="<?php echo $smooth_slider['content_chars']; ?>" />&nbsp;characters &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
</tr>

</table>

<h2>Miscellaneous</h2> 

<table class="form-table">
<tr valign="top">
<th scope="row">Retain these html tags</th>
<td><input type="text" name="smooth_slider_options[allowable_tags]" class="regular-text code" value="<?php echo $smooth_slider['allowable_tags']; ?>" />&nbsp;(read <a href="http://www.clickonf5.org/smooth-slider" title="how to retain html like line breaks and links in the Smooth Slider" target="_blank">Usage section of the plugin page</a> to know more)</td>
</tr>
<tr valign="top">
<th scope="row">Continue Reading Text</th>
<td><input type="text" name="smooth_slider_options[more]" class="regular-text code" value="<?php echo $smooth_slider['more']; ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Minimum User Level to add Post to the Slider</th>
<td><select name="smooth_slider_options[user_level]" >
<option value="10" <?php if ($smooth_slider['user_level'] == "8"){ echo "selected";}?> >Administrator</option>
<option value="7" <?php if ($smooth_slider['user_level'] == "5"){ echo "selected";}?> >Editor and Admininstrator</option>
<option value="2" <?php if ($smooth_slider['user_level'] == "2"){ echo "selected";}?> >Author, Editor and Admininstrator</option>
<option value="1" <?php if ($smooth_slider['user_level'] == "1"){ echo "selected";}?> >Contributor, Author, Editor and Admininstrator</option>
</select>
</td>
</tr>
</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</div> <!--end of float left -->
</div> <!--end of poststuff -->
</form>
<?php 
if ($_POST['remove_posts_slider']) {
   if ( $_POST['slider_posts'] ) {
       global $wpdb, $table_prefix;
       $table_name = $table_prefix.'slider';
	   foreach ( $_POST['slider_posts'] as $post_id=>$val ) {
		   $sql = "DELETE FROM $table_name where id = $post_id LIMIT 1";
		   $wpdb->query($sql);
	   }
   }
   if ($_POST['remove_all'] == "Remove All at Once") {
       global $wpdb, $table_prefix;
       $table_name = $table_prefix.'slider';
	   $sql = "DELETE FROM $table_name";
	   $wpdb->query($sql);
   }
}
?>
<div style="clear:both"></div>
<form action="" method="post">
<input type="hidden" name="remove_posts_slider" value="1" />
<h3>Posts/Pages Added To Smooth Slider</h3>
<p><em>Check the Post/Page and Press "Remove Selected" to remove them From Smooth Slider. Press "Remove All at Once" to remove all the posts from the slider.</em></p>

    <table class="widefat">
    <thead><tr><th>Post/Page Title</th><th>Author</th><th>Post Date</th><th>Remove Post</th></tr></thead><tbody>

<?php  
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."slider";
	$slider_posts = $wpdb->get_results("SELECT id FROM $table_name", OBJECT);
	
    $count = 0;	
	foreach($slider_posts as $slider_post) {
	  $slider_arr[] = $slider_post->id;
	  $post = get_post($slider_post->id);	  
	  if ( in_array($post->ID, $slider_arr) ) {
		  $count++;
		  echo '<tr' . ($count % 2 ? ' class="alternate"' : '') . '><td><strong>' . $post->post_title . '</strong></td><td>By ' . get_userdata($post->post_author)->display_name . '</td><td>' . date('l, F j. Y',strtotime($post->post_date)) . '</td><td><input type="checkbox" name="slider_posts[' . $post->ID . ']" value="1" /></td></tr>'; 
	  }
	}
	if ($count == 0) {
		echo '<tr><td colspan="4">No posts/pages have been added to the Slider - You can add respective post/page to slider on the Edit screen for that Post/Page</td></tr>';
	}
	echo '</tbody><tfoot><tr><th>Post/Page Title</th><th>Author</th><th>Post Date</th><th>Remove Post</th></tr></tfoot></table>'; 
    if ($count) echo '<div class="submit"><input type="submit" value="Remove Selected" onclick="return confirmRemove()" /><input type="submit" name="remove_all" value="Remove All at Once" onclick="return confirmRemoveAll()" /></div></form>';
?>    
    </tbody></table>
</form>
<?php check_admin_referer('smooth-slider-group-options');?>
</div> <!--end of float wrap -->
<?php	
}
function register_mysettings() { // whitelist options
  register_setting( 'smooth-slider-group', 'smooth_slider_options' );
}
?>