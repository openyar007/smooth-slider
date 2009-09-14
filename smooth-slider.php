<?php
/*
Plugin Name: Smooth Slider
Plugin URI: http://www.clickonf5.org/smooth-slider
Description: Smooth Slider adds a smooth content and image slideshow with customizable background and slide intervals to any location of your blog
Version: 1.0	
Author: Tejaswini Deshpande, Sanjeev Mishra
Author URI: http://www.clickonf5.org
Wordpress version supported: 2.7 and above
*/

/*  Copyright 2009  Internet Techies  (email : tejaswini@clickonf5.org)

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
	
	add_option('smooth_slider_speed','7');
	add_option('smooth_slider_no_posts','5');
	add_option('smooth_slider_bg_color','#ffffff');
	add_option('smooth_slider_height','200');
	add_option('smooth_slider_width','450');
	add_option('smooth_slider_border','1');
	add_option('smooth_slider_brcolor','#999999');
	add_option('smooth_slider_prev_next','1');
	add_option('smooth_slider_goto_slide','1');
	add_option('smooth_slider_title_text','Featured Posts');
	add_option('smooth_slider_title_font','Georgia');
	add_option('smooth_slider_title_fsize','20');
	add_option('smooth_slider_title_fstyle','italic');
	add_option('smooth_slider_title_fcolor','#000000');
	add_option('smooth_slider_ptitle_font','Trebuchet MS');
	add_option('smooth_slider_ptitle_fsize','14');
	add_option('smooth_slider_ptitle_fstyle','bold');
	add_option('smooth_slider_ptitle_fcolor','#000000');
	add_option('smooth_slider_img_align','left');
	add_option('smooth_slider_img_height','120');
	add_option('smooth_slider_img_width','165');
	add_option('smooth_slider_img_border','1');
	add_option('smooth_slider_img_brcolor','#000000');
	add_option('smooth_slider_content_font','Verdana');
	add_option('smooth_slider_content_fsize','12');
	add_option('smooth_slider_content_fstyle','normal');
	add_option('smooth_slider_content_fcolor','#333333');
	add_option('smooth_slider_content_from','content');	
	add_option('smooth_slider_content_chars','300');	
}

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
	global $post;

	$extra = "";
	
	if(isset($post->ID)) {
		$post_id = $post->ID;
		if(slider($post_id)) { $extra = 'checked="checked"'; }
	}
	
	echo '<div id="slider_checkbox">
			<input type="checkbox" class="sldr_post" name="slider" value="slider" '.$extra.' />
			<label for="slider">Add this post to Smooth Slider</label>
			<input type="hidden" name="sldr-verify" id="sldr-verify" value="'.wp_create_nonce('SmoothSlider').'" />
		  </div>';
}

//CSS for the checkbox on the admin page
function slider_checkbox_css() {
?><style type="text/css" media="screen">#slider_checkbox{margin: 5px 0 10px 0;padding:3px;font-weight:bold;}</style>
<?php
}

// Display the posts added to slider
function show_posts_on_slider($max_posts=5, $offset=0, $before='<li>', $after='</li>') {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."slider";
	
	$sql = "SELECT * FROM $table_name ORDER BY date DESC LIMIT $offset, $max_posts";
	$posts = $wpdb->get_results($sql);
	
	$html = '';
	foreach($posts as $post) {
		
		$id = $post->id;
		$posts_table = $table_prefix.'posts'; 
		$sql_post = "SELECT * FROM $posts_table where id = $id";
		$rs_post = $wpdb->get_results($sql_post);
		$data = $rs_post[0];
		$post_title = stripslashes($data->post_title);
		$post_title = str_replace('"', '', $post_title);
		$permalink = get_permalink($data->ID);
		$post_id = $data->ID;
		$html .= $before .'<a href="'. $permalink .'" title="'. $post_title .'" id="destacado_'.$post_id.'">'. $post_title .'</a>'. $after;
	}
	echo $html;
}

add_action('admin_head', 'slider_checkbox_css');
add_action('simple_edit_form', 'add_to_slider_checkbox');
add_action('edit_form_advanced', 'add_to_slider_checkbox');
add_action('publish_post', 'add_to_slider');
add_action('edit_post', 'add_to_slider');
add_action('publish_post', 'remove_from_slider');
add_action('edit_post', 'remove_from_slider');
register_activation_hook( __FILE__, 'install_smooth_slider' );

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

function carousel_posts_on_slider($max_posts, $offset=0) {
	if(!function_exists('show_posts_on_slider'))
		return false;
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."slider";
	
	$posts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC LIMIT $offset, $max_posts", OBJECT);
	
	$html = '';
	$coint_i = 0;
	
	
	foreach($posts as $post) {
		$coint_i++;
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
		$html .= '<div class="board_item">
			<!-- board_item -->';
			
		$thumbnail = get_post_meta($post_id, 'slider_thumbnail', true);
		
		if (get_option('smooth_slider_content_from') == "slider_content") {
		    $slider_content = get_post_meta($post_id, 'slider_content', true);
		}
		if (get_option('smooth_slider_content_from') == "excerpt") {
		    $slider_content = $data->post_excerpt;
		}
		
		$slider_content = stripslashes($slider_content);
		$slider_content = str_replace(']]>', ']]&gt;', $slider_content);
		$slider_content = strip_tags($slider_content);
				
		if( isset($thumbnail) && !empty($thumbnail) ):
			$html .= '<img class="smooth_slider_thumbnail" src="'.$thumbnail.'" alt="'.$post_title.'" />';
		endif;
		
		$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.get_string_limit($slider_content,get_option('smooth_slider_content_chars')).'</span>
			<p class="more"><a href="'.$permalink.'">Read more</a></p>
			<!-- /board_item -->
		</div>';
	}
	echo $html;
	return $coint_i;
}

function smooth_slider_css() {
?>
<style type="text/css" media="screen">#board{width:<?php echo get_option('smooth_slider_width'); ?>px;height:<?php echo get_option('smooth_slider_height'); ?>px;overflow:hidden;background-color:<?php echo get_option('smooth_slider_bg_color'); ?>;border:<?php echo get_option('smooth_slider_border'); ?>px solid <?php echo get_option('smooth_slider_brcolor'); ?>;margin: 10px auto 10px auto;line-height:18px;}#board a{text-decoration:none;}#board_items{width:100%;padding:10px <?php if (get_option('smooth_slider_prev_next') == 1) {echo "18";} else {echo "12";} ?>px 0px <?php if (get_option('smooth_slider_prev_next') == 1) {echo "26";} else {echo "12";} ?>px;}#board_body{width:100%;}#board_carusel{width:<?php if (get_option('smooth_slider_prev_next') == 1) {echo (get_option('smooth_slider_width') - 44);} else {echo (get_option('smooth_slider_width') - 24);} ?>px;height:<?php $sldr_title = get_option('smooth_slider_title_text'); if(!empty($sldr_title)) { $extra_height = get_option('smooth_slider_title_fsize') + get_option('smooth_slider_content_fsize') + 5 + 18; } else { $extra_height = get_option('smooth_slider_content_fsize') + 5 + 5 + 18;  } echo (get_option('smooth_slider_height') - $extra_height); ?>px;position:relative;text-align:justify;}#board_carusel .belt{position:absolute;/*dont change this value*/left:0;top:0;}.board_item{width:<?php if (get_option('smooth_slider_prev_next') == 1) {echo (get_option('smooth_slider_width') - 54);} else {echo (get_option('smooth_slider_width') - 24);} ?>px;padding-right:10px;height:<?php $sldr_title = get_option('smooth_slider_title_text'); if(!empty($sldr_title)) { $extra_height = get_option('smooth_slider_title_fsize') + get_option('smooth_slider_content_fsize') + 5 + 18; } else { $extra_height = get_option('smooth_slider_content_fsize') + 5 + 5 + 18;  } echo (get_option('smooth_slider_height') - $extra_height); ?>px;overflow:hidden;line-height:18px;}.sldr_title{color:#000;font-family:<?php echo get_option('smooth_slider_title_font'); ?>, Arial, Helvetica, sans-serif;font-size:<?php echo get_option('smooth_slider_title_fsize'); ?>px;font-weight:<?php if (get_option('smooth_slider_title_fstyle') == "bold" or get_option('smooth_slider_title_fstyle') == "bold italic" ){echo "bold";} else { echo "normal"; } ?>;font-style:<?php if (get_option('smooth_slider_title_fstyle') == "italic" or get_option('smooth_slider_title_fstyle') == "bold italic" ){echo "italic";} else {echo "normal";} ?>;color:<?php echo get_option('smooth_slider_title_fcolor'); ?>;margin:0;}#board_body h2{font-family:<?php echo get_option('smooth_slider_ptitle_font'); ?>, Arial, Helvetica, sans-serif;font-size:<?php echo get_option('smooth_slider_ptitle_fsize'); ?>px;font-weight:<?php if (get_option('smooth_slider_ptitle_fstyle') == "bold" or get_option('smooth_slider_ptitle_fstyle') == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if (get_option('smooth_slider_ptitle_fstyle') == "italic" or get_option('smooth_slider_ptitle_fstyle') == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo get_option('smooth_slider_ptitle_fcolor'); ?>;display:block;margin:<?php $sldr_title = get_option('smooth_slider_title_text'); if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px 0 5px 0;}#board_body h2 a{color:<?php echo get_option('smooth_slider_ptitle_fcolor'); ?>;}.slider_item {padding-left:1px;}#board_body span{font-family:<?php echo get_option('smooth_slider_content_font'); ?>, Arial, Helvetica, sans-serif;font-size:<?php echo get_option('smooth_slider_content_fsize'); ?>px;font-weight:<?php if (get_option('smooth_slider_content_fstyle') == "bold" or get_option('smooth_slider_content_fstyle') == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if (get_option('smooth_slider_content_fstyle')=="italic" or get_option('smooth_slider_content_fstyle') == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo get_option('smooth_slider_content_fcolor'); ?>;}.smooth_slider_thumbnail{float:<?php echo get_option('smooth_slider_img_align'); ?>;margin:12px <?php if(get_option('smooth_slider_img_align') == "left") {echo "5";} else {echo "0";} ?>px 0 <?php if(get_option('smooth_slider_img_align') == "right") {echo "5";} else {echo "0";} ?>px;width:<?php echo get_option('smooth_slider_img_width'); ?>px;height:<?php echo get_option('smooth_slider_img_height'); ?>px;border:<?php echo get_option('smooth_slider_img_border'); ?>px solid <?php echo get_option('smooth_slider_img_brcolor'); ?>;}#board_body p.more a{text-decoration:underline;color:<?php echo get_option('smooth_slider_ptitle_fcolor'); ?>;float:right;font-family:<?php echo get_option('smooth_slider_content_font'); ?>, Arial, Helvetica, sans-serif;font-size:<?php echo get_option('smooth_slider_content_fsize'); ?>px;}#board_body p.more a:hover{text-decoration:none;}#board_carusel_nav{float:left;width:70%;overflow:hidden;padding:0;margin:2px 0 0 0;}#board_carusel_nav li{float:left;margin:0 5px 0 0;display:block;border:1px solid <?php echo get_option('smooth_slider_content_fcolor'); ?>;background-color:<?php echo get_option('smooth_slider_bg_color'); ?>;line-height:14px;font-size:<?php echo get_option('smooth_slider_content_fsize'); ?>px;font-family:<?php echo get_option('smooth_slider_content_font'); ?>, Arial, Helvetica, sans-serif;}#board_carusel_nav li a{diaplay:block;padding:1px 5px 1px 5px;color:<?php echo get_option('smooth_slider_ptitle_fcolor'); ?>;outline:none;}.sldrlink{font-size:8px;float:right;padding-right:<?php if (get_option('smooth_slider_prev_next') == 1) {echo "40";} else {echo "25";} ?>px;margin-top:7px;font-family:Verdana, Helvetica, sans-serif;}.sldrlink a{color:<?php echo get_option('smooth_slider_content_fcolor'); ?>;}</style>
<?php
}

add_action('wp_head', 'smooth_slider_css');

function smooth_slider_enqueue_scripts() {
	wp_register_script('jquery', false, false, false, false);
	wp_enqueue_script( 'stepcarousel', smooth_slider_plugin_url( 'js/stepcarousel.js' ),
		array('jquery'), false, false); 
}

add_action( 'init', 'smooth_slider_enqueue_scripts' );

function get_smooth_slider() {

?>
<script type="text/javascript">
stepcarousel.setup({
	galleryid: 'board_carusel', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'board_item', //class of panel DIVs each holding content
	autostep: {enable: true, moveby:1, pause:<?php echo get_option('smooth_slider_speed')*1000; ?>},
	panelbehavior: {speed:500, wraparound:false, persist:false},
	defaultbuttons: {enable: <?php if (get_option('smooth_slider_prev_next') == 1) {echo "true";} else {echo "false";} ?>, moveby: 1, leftnav: ['<?php echo smooth_slider_plugin_url( 'images/button_prev.png' ); ?>', -25, 60], rightnav: ['<?php echo smooth_slider_plugin_url( 'images/button_next.png' ); ?>', 0, 60]},
	statusvars: ['imageA', 'imageB', 'imageC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'], //content setting ['inline'] or ['external', 'path_to_external_file']
	onslide:function(){
	  jQuery("#board_carusel_nav li a").css("fontWeight", "normal");
	  jQuery("#board_carusel_nav li a").css("fontSize", "<?php echo get_option('smooth_slider_content_fsize'); ?>px");
	  var curr_slide = imageA;
	  jQuery("#sldr"+curr_slide).css("fontWeight", "bolder");
	  jQuery("#sldr"+curr_slide).css("fontSize", "<?php echo (get_option('smooth_slider_content_fsize') + 5); ?>px");
  }
})
</script>
<noscript><strong>This page is having a slideshow that uses Javascript. Your browser either doesn't support Javascript or you have it turned off. To see this page as it is meant to appear please use a Javascript enabled browser.</strong></noscript>
    	<div id="board">
		<div id="board_items">
			<div id="board_body">
				<?php $sldr_title = get_option('smooth_slider_title_text'); if(!empty($sldr_title)) { ?><div class="sldr_title"><?php echo get_option('smooth_slider_title_text'); ?></div> <?php } ?>
				<div id="board_carusel">
					<div class="belt">
					<?php global $coint_i; $coint_i = carousel_posts_on_slider(get_option('smooth_slider_no_posts')); ?>
					</div>
				</div>
			</div>
            <?php if (get_option('smooth_slider_goto_slide') == 1) { ?>
            <ul id="board_carusel_nav">
                <?php global $coint_i; for($i=1; $i<=$coint_i; $i++) { 
				echo "<li><a id=\"sldr".$i."\" title=\"".$i."\" href=\"#\" >".$i."</a></li>\n";
                 } ?>
			</ul>
            <?php } ?>
            <span class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></span>
		</div>
	</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery('#board_carusel_nav a').click(function() {
		var title = jQuery(this).attr('title');
		var id = jQuery(this).attr('id');
		var step_size = title - imageA;
        document.getElementById(id).href = "javascript:stepcarousel.stepBy('board_carusel', "+step_size+")";
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

function smooth_slider_admin_head() {
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
});
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
</style>
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
?>
<div class="wrap">
<h2>Smooth Slider</h2>
<div id="poststuff" class="metabox-holder has-right-sidebar" style="float:right;" > 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About this Plugin:</span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="http://www.clickonf5.org/smooth-slider" title="Smooth Slider Homepage" >Plugin Homepage</a></li>
                <li><a href="http://www.clickonf5.org" title="Visit Internet Techies" >Plugin Parent Site</a></li>
                <li><a href="http://www.clickonf5.org/phpbb/smooth-slider-f12/" title="Support Forum for Smooth Slider" >Support Forum</a></li>
                <li><a href="http://www.clickonf5.org/about/tejaswini" title="Smooth Slider Author Page" >About the Author</a></li>
                <li><a href="http://clickonf5.org/go/paypal/smooth-slider/" title="Donate if you liked the plugin and support in enhancing Smooth Slider and creating new plugins" >Donate with Paypal</a></li>
                </ul> 
              </div> 
			</div> 
     </div>

    <div id="side-info-column" class="inner-sidebar"> 
	  <div class="inside">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8046056">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>                   						
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
   
   
</div>

<form style="float:left;" method="post" action="options.php">
<?php settings_fields('smooth-slider-group'); ?>

<h3>Slider Box</h3> 
<p>Customize the looks of the Slider box wrapping the complete slideshow from here</p> 

<table class="form-table">

<tr valign="top">
<th scope="row">Slide Pause Interval</th>
<td><input type="text" name="smooth_slider_speed" id="smooth_slider_speed" class="small-text" value="<?php echo get_option('smooth_slider_speed'); ?>" />&nbsp;(in secs)</td>
</tr>

<tr valign="top">
<th scope="row">Number of Posts in the Slideshow</th>
<td><input type="text" name="smooth_slider_no_posts" id="smooth_slider_no_posts" class="small-text" value="<?php echo get_option('smooth_slider_no_posts'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Background Color</th>
<td><input type="text" name="smooth_slider_bg_color" id="color_value_1" value="<?php echo get_option('smooth_slider_bg_color'); ?>" />&nbsp; <img id="color_picker_1" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_1"></div></td>
</tr>
 
<tr valign="top">
<th scope="row">Slider Height</th>
<td><input type="text" name="smooth_slider_height" id="smooth_slider_height" class="small-text" value="<?php echo get_option('smooth_slider_height'); ?>" />&nbsp;px</td>
</tr>


<tr valign="top">
<th scope="row">Slider Width</th>
<td><input type="text" name="smooth_slider_width" id="smooth_slider_width" class="small-text" value="<?php echo get_option('smooth_slider_width'); ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Border Thickness</th>
<td><input type="text" name="smooth_slider_border" id="smooth_slider_border" class="small-text" value="<?php echo get_option('smooth_slider_border'); ?>" />&nbsp;px &nbsp;(put 0 if no border is required)</td>
</tr>

<tr valign="top">
<th scope="row">Border Color</th>
<td><input type="text" name="smooth_slider_brcolor" id="color_value_6" value="<?php echo get_option('smooth_slider_brcolor'); ?>" />&nbsp; <img id="color_picker_6" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_6"></div></td>
</tr>

<tr valign="top"> 
<th scope="row">Navigation Buttons</th> 
<td><fieldset><legend class="screen-reader-text"><span>Navigation Buttons</span></legend> 
<label for="smooth_slider_prev_next"> 
<input name="smooth_slider_prev_next" type="checkbox" id="smooth_slider_prev_next" value="1" <?php checked("1", get_option('smooth_slider_prev_next')); ?> /> 
 Show Prev/Next navigation arrows</label><br /> 
<label for="smooth_slider_goto_slide"><input name="smooth_slider_goto_slide" type="checkbox" id="smooth_slider_goto_slide" value="1" <?php checked('1', get_option('smooth_slider_goto_slide')); ?>  /> Show go to slide number links at the bottom as 1, 2, 3 etc.</label> 
</fieldset></td> 
</tr> 

</table>

<h3>Slider Title</h3> 
<p>Customize the looks of the main title of the Slideshow from here</p> 
<table class="form-table">

<tr valign="top">
<th scope="row">Text</th>
<td><input type="text" name="smooth_slider_title_text" id="smooth_slider_title_text" value="<?php echo get_option('smooth_slider_title_text'); ?>" /></td>
</tr>

<tr valign="top">
<th scope="row">Font</th>
<td><select name="smooth_slider_title_font" id="smooth_slider_title_font" >
<option value="Arial" <?php if (get_option('smooth_slider_title_font') == "Arial"){ echo "selected";}?> >Arial</option>
<option value="Book Antiqua" <?php if (get_option('smooth_slider_title_font') == "Book Antiqua"){ echo "selected";}?> >Book Antiqua</option>
<option value="Bookman Old Style" <?php if (get_option('smooth_slider_title_font') == "Bookman Old Style"){ echo "selected";}?> >Bookman Old Style</option>
<option value="Calibri" <?php if (get_option('smooth_slider_title_font') == "Calibri"){ echo "selected";}?> >Calibri</option>
<option value="Century Schoolbook" <?php if (get_option('smooth_slider_title_font') == "Century Schoolbook"){ echo "selected";}?> >Century Schoolbook</option>
<option value="Courier New" <?php if (get_option('smooth_slider_title_font') == "Courier New"){ echo "selected";}?> >Courier New</option>
<option value="Geneva" <?php if (get_option('smooth_slider_title_font') == "Geneva"){ echo "selected";}?> >Geneva</option>
<option value="Georgia" <?php if (get_option('smooth_slider_title_font') == "Georgia"){ echo "selected";} ?> >Georgia</option>
<option value="Helvetica" <?php if (get_option('smooth_slider_title_font') == "Helvetica"){ echo "selected";}?> >Helvetica</option>
<option value="Monotype Corsiva" <?php if (get_option('smooth_slider_title_font') == "Monotype Corsiva"){ echo "selected";}?> >Monotype Corsiva</option>
<option value="Times New Roman" <?php if (get_option('smooth_slider_title_font') == "Times New Roman"){ echo "selected";}?> >Times New Roman</option>
<option value="Trebuchet MS" <?php if (get_option('smooth_slider_title_font') == "Trebuchet MS"){ echo "selected";}?> >Trebuchet MS</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Font Color</th>
<td><input type="text" name="smooth_slider_title_fcolor" id="color_value_2" value="<?php echo get_option('smooth_slider_title_fcolor'); ?>" />&nbsp; <img id="color_picker_2" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_2"></div></td>
</tr>

<tr valign="top">
<th scope="row">Font Size</th>
<td><input type="text" name="smooth_slider_title_fsize" id="smooth_slider_title_fsize" class="small-text" value="<?php echo get_option('smooth_slider_title_fsize'); ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Font Style</th>
<td><select name="smooth_slider_title_fstyle" id="smooth_slider_title_fstyle" >
<option value="bold" <?php if (get_option('smooth_slider_title_fstyle') == "bold"){ echo "selected";}?> >Bold</option>
<option value="bold italic" <?php if (get_option('smooth_slider_title_fstyle') == "bold italic"){ echo "selected";}?> >Bold Italic</option>
<option value="italic" <?php if (get_option('smooth_slider_title_fstyle') == "italic"){ echo "selected";}?> >Italic</option>
<option value="normal" <?php if (get_option('smooth_slider_title_fstyle') == "normal"){ echo "selected";}?> >Normal</option>
</select>
</td>
</tr>
</table>

<h3>Post Title</h3> 
<p>Customize the looks of the title of each of the sliding post here</p> 
<table class="form-table">

<tr valign="top">
<th scope="row">Font</th>
<td><select name="smooth_slider_ptitle_font" id="smooth_slider_ptitle_font" >
<option value="Arial" <?php if (get_option('smooth_slider_ptitle_font') == "Arial"){ echo "selected";}?> >Arial</option>
<option value="Book Antiqua" <?php if (get_option('smooth_slider_ptitle_font') == "Book Antiqua"){ echo "selected";}?> >Book Antiqua</option>
<option value="Bookman Old Style" <?php if (get_option('smooth_slider_ptitle_font') == "Bookman Old Style"){ echo "selected";}?> >Bookman Old Style</option>
<option value="Calibri" <?php if (get_option('smooth_slider_ptitle_font') == "Calibri"){ echo "selected";}?> >Calibri</option>
<option value="Century Schoolbook" <?php if (get_option('smooth_slider_ptitle_font') == "Century Schoolbook"){ echo "selected";}?> >Century Schoolbook</option>
<option value="Courier New" <?php if (get_option('smooth_slider_ptitle_font') == "Courier New"){ echo "selected";}?> >Courier New</option>
<option value="Geneva" <?php if (get_option('smooth_slider_ptitle_font') == "Geneva"){ echo "selected";}?> >Geneva</option>
<option value="Georgia" <?php if (get_option('smooth_slider_ptitle_font') == "Georgia"){ echo "selected";} ?> >Georgia</option>
<option value="Helvetica" <?php if (get_option('smooth_slider_ptitle_font') == "Helvetica"){ echo "selected";}?> >Helvetica</option>
<option value="Monotype Corsiva" <?php if (get_option('smooth_slider_ptitle_font') == "Monotype Corsiva"){ echo "selected";}?> >Monotype Corsiva</option>
<option value="Times New Roman" <?php if (get_option('smooth_slider_ptitle_font') == "Times New Roman"){ echo "selected";}?> >Times New Roman</option>
<option value="Trebuchet MS" <?php if (get_option('smooth_slider_ptitle_font') == "Trebuchet MS"){ echo "selected";}?> >Trebuchet MS</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Font Color</th>
<td><input type="text" name="smooth_slider_ptitle_fcolor" id="color_value_3" value="<?php echo get_option('smooth_slider_ptitle_fcolor'); ?>" />&nbsp; <img id="color_picker_3" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_3"></div></td>
</tr>

<tr valign="top">
<th scope="row">Font Size</th>
<td><input type="text" name="smooth_slider_ptitle_fsize" id="smooth_slider_ptitle_fsize" class="small-text" value="<?php echo get_option('smooth_slider_ptitle_fsize'); ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Font Style</th>
<td><select name="smooth_slider_ptitle_fstyle" id="smooth_slider_ptitle_fstyle" >
<option value="bold" <?php if (get_option('smooth_slider_ptitle_fstyle') == "bold"){ echo "selected";}?> >Bold</option>
<option value="bold italic" <?php if (get_option('smooth_slider_ptitle_fstyle') == "bold italic"){ echo "selected";}?> >Bold Italic</option>
<option value="italic" <?php if (get_option('smooth_slider_ptitle_fstyle') == "italic"){ echo "selected";}?> >Italic</option>
<option value="normal" <?php if (get_option('smooth_slider_ptitle_fstyle') == "normal"){ echo "selected";}?> >Normal</option>
</select>
</td>
</tr>
</table>

<h3>Thumbnail Image</h3> 
<p>Customize the looks of the thumbnail image for each of the sliding post here</p> 
<table class="form-table">

<tr valign="top">
<th scope="row">Align to</th>
<td><select name="smooth_slider_img_align" id="smooth_slider_img_align" >
<option value="left" <?php if (get_option('smooth_slider_img_align') == "left"){ echo "selected";}?> >Left</option>
<option value="right" <?php if (get_option('smooth_slider_img_align') == "right"){ echo "selected";}?> >Right</option>
<option value="none" <?php if (get_option('smooth_slider_img_align') == "none"){ echo "selected";}?> >Center</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Height</th>
<td><input type="text" name="smooth_slider_img_height" id="smooth_slider_img_height" class="small-text" value="<?php echo get_option('smooth_slider_img_height'); ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Width</th>
<td><input type="text" name="smooth_slider_img_width" id="smooth_slider_img_width" class="small-text" value="<?php echo get_option('smooth_slider_img_width'); ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Border Thickness</th>
<td><input type="text" name="smooth_slider_img_border" id="smooth_slider_img_border" class="small-text" value="<?php echo get_option('smooth_slider_img_border'); ?>" />&nbsp;px &nbsp;(put 0 if no border is required)</td>
</tr>

<tr valign="top">
<th scope="row">Border Color</th>
<td><input type="text" name="smooth_slider_img_brcolor" id="color_value_4" value="<?php echo get_option('smooth_slider_img_brcolor'); ?>" />&nbsp; <img id="color_picker_4" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_4"></div></td>
</tr>

</table>

<h3>Slider Content</h3> 
<p>Customize the looks of the content of each of the sliding post here</p> 
<table class="form-table">

<tr valign="top">
<th scope="row">Font</th>
<td><select name="smooth_slider_content_font" id="smooth_slider_content_font" >
<option value="Arial" <?php if (get_option('smooth_slider_content_font') == "Arial"){ echo "selected";}?> >Arial</option>
<option value="Book Antiqua" <?php if (get_option('smooth_slider_content_font') == "Book Antiqua"){ echo "selected";}?> >Book Antiqua</option>
<option value="Bookman Old Style" <?php if (get_option('smooth_slider_content_font') == "Bookman Old Style"){ echo "selected";}?> >Bookman Old Style</option>
<option value="Calibri" <?php if (get_option('smooth_slider_content_font') == "Calibri"){ echo "selected";}?> >Calibri</option>
<option value="Century Schoolbook" <?php if (get_option('smooth_slider_content_font') == "Century Schoolbook"){ echo "selected";}?> >Century Schoolbook</option>
<option value="Courier New" <?php if (get_option('smooth_slider_content_font') == "Courier New"){ echo "selected";}?> >Courier New</option>
<option value="Geneva" <?php if (get_option('smooth_slider_content_font') == "Geneva"){ echo "selected";}?> >Geneva</option>
<option value="Georgia" <?php if (get_option('smooth_slider_content_font') == "Georgia"){ echo "selected";} ?> >Georgia</option>
<option value="Helvetica" <?php if (get_option('smooth_slider_content_font') == "Helvetica"){ echo "selected";}?> >Helvetica</option>
<option value="Monotype Corsiva" <?php if (get_option('smooth_slider_content_font') == "Monotype Corsiva"){ echo "selected";}?> >Monotype Corsiva</option>
<option value="Times New Roman" <?php if (get_option('smooth_slider_content_font') == "Times New Roman"){ echo "selected";}?> >Times New Roman</option>
<option value="Trebuchet MS" <?php if (get_option('smooth_slider_content_font') == "Trebuchet MS"){ echo "selected";}?> >Trebuchet MS</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Font Color</th>
<td><input type="text" name="smooth_slider_content_fcolor" id="color_value_5" value="<?php echo get_option('smooth_slider_content_fcolor'); ?>" />&nbsp; <img id="color_picker_5" src="<?php echo smooth_slider_plugin_url( 'images/color_picker.png' ); ?>" alt="Pick the color of your choice" /><div class="color-picker-wrap" id="colorbox_5"></div></td>
</tr>

<tr valign="top">
<th scope="row">Font Size</th>
<td><input type="text" name="smooth_slider_content_fsize" id="smooth_slider_content_fsize" class="small-text" value="<?php echo get_option('smooth_slider_content_fsize'); ?>" />&nbsp;px</td>
</tr>

<tr valign="top">
<th scope="row">Font Style</th>
<td><select name="smooth_slider_content_fstyle" id="smooth_slider_content_fstyle" >
<option value="bold" <?php if (get_option('smooth_slider_content_fstyle') == "bold"){ echo "selected";}?> >Bold</option>
<option value="bold italic" <?php if (get_option('smooth_slider_content_fstyle') == "bold italic"){ echo "selected";}?> >Bold Italic</option>
<option value="italic" <?php if (get_option('smooth_slider_content_fstyle') == "italic"){ echo "selected";}?> >Italic</option>
<option value="normal" <?php if (get_option('smooth_slider_content_fstyle') == "normal"){ echo "selected";}?> >Normal</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Pick content From</th>
<td><select name="smooth_slider_content_from" id="smooth_slider_content_from" >
<option value="slider_content" <?php if (get_option('smooth_slider_content_from') == "slider_content"){ echo "selected";}?> >Slider Content Custom field</option>
<option value="excerpt" <?php if (get_option('smooth_slider_content_from') == "excerpt"){ echo "selected";}?> >Post Excerpt</option>
<option value="content" <?php if (get_option('smooth_slider_content_from') == "content"){ echo "selected";}?> >From Content</option>
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">Maximum content size</th>
<td><input type="text" name="smooth_slider_content_chars" id="smooth_slider_content_chars" class="small-text" value="<?php echo get_option('smooth_slider_content_chars'); ?>" />&nbsp;characters</td>
</tr>

</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
<?php check_admin_referer('smooth-slider-group-options');?>
</form>
</div>	
<?php	
}
function register_mysettings() { // whitelist options
  register_setting( 'smooth-slider-group', 'smooth_slider_speed' );
  register_setting( 'smooth-slider-group', 'smooth_slider_no_posts' );
  register_setting( 'smooth-slider-group', 'smooth_slider_bg_color' );
  register_setting( 'smooth-slider-group', 'smooth_slider_height' );
  register_setting( 'smooth-slider-group', 'smooth_slider_width' );
  register_setting( 'smooth-slider-group', 'smooth_slider_border' );
  register_setting( 'smooth-slider-group', 'smooth_slider_brcolor' );
  register_setting( 'smooth-slider-group', 'smooth_slider_prev_next' );
  register_setting( 'smooth-slider-group', 'smooth_slider_goto_slide' );
  register_setting( 'smooth-slider-group', 'smooth_slider_title_text' );
  register_setting( 'smooth-slider-group', 'smooth_slider_title_font' );
  register_setting( 'smooth-slider-group', 'smooth_slider_title_fsize' );
  register_setting( 'smooth-slider-group', 'smooth_slider_title_fstyle' );
  register_setting( 'smooth-slider-group', 'smooth_slider_title_fcolor' );
  register_setting( 'smooth-slider-group', 'smooth_slider_ptitle_font' );
  register_setting( 'smooth-slider-group', 'smooth_slider_ptitle_fsize' );
  register_setting( 'smooth-slider-group', 'smooth_slider_ptitle_fstyle' );
  register_setting( 'smooth-slider-group', 'smooth_slider_ptitle_fcolor' );
  register_setting( 'smooth-slider-group', 'smooth_slider_img_align' );
  register_setting( 'smooth-slider-group', 'smooth_slider_img_height' );
  register_setting( 'smooth-slider-group', 'smooth_slider_img_width' );
  register_setting( 'smooth-slider-group', 'smooth_slider_img_border' );
  register_setting( 'smooth-slider-group', 'smooth_slider_img_brcolor' );
  register_setting( 'smooth-slider-group', 'smooth_slider_content_font' );
  register_setting( 'smooth-slider-group', 'smooth_slider_content_fsize' );
  register_setting( 'smooth-slider-group', 'smooth_slider_content_fstyle' );
  register_setting( 'smooth-slider-group', 'smooth_slider_content_fcolor' );
  register_setting( 'smooth-slider-group', 'smooth_slider_content_from' );
  register_setting( 'smooth-slider-group', 'smooth_slider_content_chars' );
}
?>