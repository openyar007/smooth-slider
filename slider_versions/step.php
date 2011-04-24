<?php 
function carousel_posts_on_slider($max_posts, $offset=0, $slider_id = '1',$out_echo = '1') {
    global $smooth_slider;
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.SLIDER_TABLE;
	$post_table = $table_prefix."posts";
	$rand = $smooth_slider['rand'];
	if(isset($rand) and $rand=='1'){
	  $orderby = 'RAND()';
	}
	else {
	  $orderby = 'a.slide_order ASC, a.date DESC';
	}
	
	$posts = $wpdb->get_results("SELECT a.post_id, a.date FROM 
	                             $table_name a LEFT OUTER JOIN $post_table b 
								 ON a.post_id = b.ID 
								 WHERE (b.post_status = 'publish' OR (b.post_type='attachment' AND b.post_status = 'inherit')) AND a.slider_id = '$slider_id' 
	                             ORDER BY ".$orderby." LIMIT $offset, $max_posts", OBJECT);
	
	$html = '';
	$smooth_sldr_j = 0;
	
	foreach($posts as $post) {
		$id = $post->post_id;
		$posts_table = $table_prefix.'posts'; 
		$sql_post = "SELECT * FROM $posts_table WHERE ID = $id";
		$rs_post = $wpdb->get_results("SELECT * FROM $posts_table WHERE ID = $id", OBJECT);
		$data = $rs_post[0];
		
		$post_title = stripslashes($data->post_title);
		$post_title = str_replace('"', '', $post_title);
		$slider_content = $data->post_content;

//2.3 changes		
//		$permalink = get_permalink($data->ID);
		
		$post_id = $data->ID;
		
//2.1 changes start
            $slide_redirect_url = get_post_meta($post_id, 'slide_redirect_url', true);
			$sslider_nolink = get_post_meta($post_id,'sslider_nolink',true);
			trim($slide_redirect_url);
			if(!empty($slide_redirect_url) and isset($slide_redirect_url)) {
			   $permalink = $slide_redirect_url;
			}
			else{
			   $permalink = get_permalink($post_id);
			}
			if($sslider_nolink=='1'){
			  $permalink='';
			}
//2.1 changes end	
	   		$smooth_sldr_j++;
		$html .= '<div class="smooth_slideri">
			<!-- smooth_slideri -->';
			
		$thumbnail = get_post_meta($post_id, $smooth_slider['img_pick'][1], true);
		//$image_control = get_post_meta($post_id, 'slider_image_control', true);
		
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
		
		$slider_content = strip_shortcodes( $slider_content );
				
		if($smooth_slider['img_pick'][0] == '1'){
		 $custom_key = array($smooth_slider['img_pick'][1]);
		}
		else {
		 $custom_key = '';
		}
		
		if($smooth_slider['img_pick'][2] == '1'){
		 $the_post_thumbnail = true;
		}
		else {
		 $the_post_thumbnail = false;
		}
		
		if($smooth_slider['img_pick'][3] == '1'){
		 $attachment = true;
		 $order_of_image = $smooth_slider['img_pick'][4];
		}
		else{
		 $attachment = false;
		 $order_of_image = '1';
		}
		
		if($smooth_slider['img_pick'][5] == '1'){
			 $image_scan = true;
		}
		else {
			 $image_scan = false;
		}
		
		if($smooth_slider['img_size'] == '1'){
		 $gti_width = $smooth_slider['img_width'];
		}
		else {
		 $gti_width = false;
		}
		
		if($smooth_slider['crop'] == '0'){
		 $extract_size = 'full';
		}
		elseif($smooth_slider['crop'] == '1'){
		 $extract_size = 'large';
		}
		elseif($smooth_slider['crop'] == '2'){
		 $extract_size = 'medium';
		}
		else{
		 $extract_size = 'thumbnail';
		}
		
		$img_args = array(
			'custom_key' => $custom_key,
			'post_id' => $post_id,
			'attachment' => $attachment,
			'size' => $extract_size,
			'the_post_thumbnail' => $the_post_thumbnail,
			'default_image' => false,
			'order_of_image' => $order_of_image,
			'link_to_post' => false,
			'image_class' => 'smooth_slider_thumbnail',
			'image_scan' => $image_scan,
			'width' => $gti_width,
			'height' => false,
			'echo' => false,
			'permalink' => $permalink
		);
			
		$html .=  sslider_get_the_image($img_args);
		
		if(!$smooth_slider['content_limit'] or $smooth_slider['content_limit'] == '' or $smooth_slider['content_limit'] == ' ') 
		  $slider_excerpt = substr($slider_content,0,$smooth_slider['content_chars']);
		else 
		  $slider_excerpt = smooth_slider_word_limiter( $slider_content, $limit = $smooth_slider['content_limit'] );
		  		
		if ($smooth_slider['image_only'] == '1') { 
			$html .= '<!-- /smooth_slideri -->
			</div>';
		}
		else {
		   if($permalink!='') {
			$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.$slider_excerpt.'</span>
				<p class="more"><a href="'.$permalink.'">'.$smooth_slider['more'].'</a></p>
			
				<!-- /smooth_slideri -->
			</div>'; }
		   else{
		   $html .= '<h2 >'.$post_title.'</h2><span> '.$slider_excerpt.'</span>
				<!-- /smooth_slideri -->
			</div>';    }
		}
	}
	if($out_echo == '1') {
	   echo $html;
	}
	$r_array = array( $smooth_sldr_j, $html);
	return $r_array;
}

function carousel_posts_on_slider_cat($max_posts, $catg_slug, $offset=0) {
    global $smooth_slider;
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.SLIDER_TABLE;
    $post_table = $table_prefix."posts";
	
	$myposts = $wpdb->get_results("SELECT a.post_id, a.date FROM 
	                             $table_name a LEFT OUTER JOIN $post_table b 
								 ON a.post_id = b.ID 
								 WHERE b.post_status = 'publish' OR (b.post_type='attachment' AND b.post_status = 'inherit')    
	                             ORDER BY a.slide_order ASC, a.date DESC LIMIT $offset, $max_posts", OBJECT);
	
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
		$post = get_post($mypost->post_id);
		$post_cats_arr = get_the_category($post->ID);
		
		$post_cats = array();
		foreach($post_cats_arr as $post_cat_arr) {
		  $post_cats[] = $post_cat_arr->cat_ID;
		}
		
    	if ((isset($slider_cat) and in_array($slider_cat,$post_cats)) or (empty($catg_slug) and (is_home() or (is_paged() and !is_category()) or is_tag() or is_author() or (is_archive() and !is_category()))))
		{
			$post_title = stripslashes($post->post_title);
			$post_title = str_replace('"', '', $post_title);
			$slider_content = $post->post_content;
			
//			$permalink = get_permalink($post->ID);
			
			$post_id = $post->ID;
//2.1 changes start
            $slide_redirect_url = get_post_meta($post_id, 'slide_redirect_url', true);
			$sslider_nolink = get_post_meta($post_id,'sslider_nolink',true);
			trim($slide_redirect_url);
			if(!empty($slide_redirect_url) and isset($slide_redirect_url)) {
			   $permalink = $slide_redirect_url;
			}
			else{
			   $permalink = get_permalink($post_id);
			}
			if($sslider_nolink=='1'){
			  $permalink='';
			}

//2.1 changes end	
					 
		    $smooth_sldr_i++;
			
			$html .= '<div class="smooth_slideri">
				<!-- smooth_slideri -->';
				
			$thumbnail = get_post_meta($post_id, 'slider_thumbnail', true);
			$image_control = get_post_meta($post_id, 'slider_image_control', true);
			
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
			
			$slider_content = strip_shortcodes( $slider_content );
						
			if($smooth_slider['img_pick'][0] == '1'){
			 $custom_key = array($smooth_slider['img_pick'][0]);
			}
			else {
			 $custom_key = '';
			}
			
			if($smooth_slider['img_pick'][2] == '1'){
			 $the_post_thumbnail = true;
			}
			else {
			 $the_post_thumbnail = false;
			}
			
			if($smooth_slider['img_pick'][3] == '1'){
			 $attachment = true;
			 $order_of_image = $smooth_slider['img_pick'][4];
			}
			else{
			 $attachment = false;
			 $order_of_image = '1';
			}
			
			if($smooth_slider['img_pick'][5] == '1'){
			 $image_scan = true;
			}
			else {
			 $image_scan = false;
			}
			
			if($smooth_slider['img_size'] == '1'){
			 $gti_width = false;
			}
			else {
			 $gti_width = $smooth_slider['img_width'];
			}
			
			if($smooth_slider['crop'] == '0'){
			 $extract_size = 'full';
			}
			elseif($smooth_slider['crop'] == '1'){
			 $extract_size = 'large';
			}
			elseif($smooth_slider['crop'] == '2'){
			 $extract_size = 'medium';
			}
			else{
			 $extract_size = 'thumbnail';
			}
			
			$img_args = array(
				'custom_key' => $custom_key,
				'attachment' => $attachment,
				'size' => $extract_size,
				'the_post_thumbnail' => $the_post_thumbnail,
				'default_image' => false,
				'order_of_image' => $order_of_image,
				'link_to_post' => false,
				'image_class' => 'smooth_slider_thumbnail',
				'image_scan' => $image_scan,
				'width' => $gti_width,
				'height' => false,
				'echo' => false,
				'permalink' => $permalink
			);
		
			$html .=  sslider_get_the_image($img_args);
		
		if(!$smooth_slider['content_limit'] or $smooth_slider['content_limit'] == '' or $smooth_slider['content_limit'] == ' ') 
		  $slider_excerpt = substr($slider_content,0,$smooth_slider['content_chars']);
		else 
		  $slider_excerpt = smooth_slider_word_limiter( $slider_content, $limit = $smooth_slider['content_limit'] );
			
			if ($smooth_slider['image_only'] == '1') { 
				$html .= '<!-- /smooth_slideri -->
				</div>';
			}
			else {
	          if($permalink!='') {
				$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.$slider_excerpt.'</span>
					<p class="more"><a href="'.$permalink.'">'.$smooth_slider['more'].'</a></p>
				
					<!-- /smooth_slideri -->
				</div>';
			  }
			  else{
			   $html .= '<h2 >'.$post_title.'</h2><span> '.$slider_excerpt.'</span>
					<!-- /smooth_slideri -->
				</div>';
			  }
		    }
	  } 
		if ($smooth_sldr_i >= $max_posts)
		   { break; }
	}
	echo $html;
	return $smooth_sldr_i;
}

//For displaying category specific posts in chronologically reverse order, Smooth Slider 2.3.3
function carousel_posts_on_slider_category($max_posts='5', $catg_slug='', $offset=0, $out_echo = '1') {
    global $smooth_slider;
	global $wpdb, $table_prefix;
	
	if (!empty($catg_slug)) {
		$category = get_category_by_slug($catg_slug); 
		$slider_cat = $category->term_id;
	}
	else {
		$category = get_the_category();
		$slider_cat = $category[0]->cat_ID;
	}
	
	$posts = get_posts('numberposts='.$max_posts.'&offset='.$offset.'&category='.$slider_cat);
	
	$html = '';
	$smooth_sldr_a = 0;
	
	foreach($posts as $post) {
		$id = $post->ID;
		
		$post_title = stripslashes($post->post_title);
		$post_title = str_replace('"', '', $post_title);
		$slider_content = $post->post_content;

//2.3 changes		
//		$permalink = get_permalink($post->ID);
		
		$post_id = $post->ID;
		
//2.1 changes start
            $slide_redirect_url = get_post_meta($post_id, 'slide_redirect_url', true);
			$sslider_nolink = get_post_meta($post_id,'sslider_nolink',true);
			trim($slide_redirect_url);
			if(!empty($slide_redirect_url) and isset($slide_redirect_url)) {
			   $permalink = $slide_redirect_url;
			}
			else{
			   $permalink = get_permalink($post_id);
			}
			if($sslider_nolink=='1'){
			  $permalink='';
			}
//2.1 changes end	
	   		$smooth_sldr_a++;
		$html .= '<div class="smooth_slideri">
			<!-- smooth_slideri -->';
			
		$thumbnail = get_post_meta($post_id, $smooth_slider['img_pick'][1], true);
		//$image_control = get_post_meta($post_id, 'slider_image_control', true);
		
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
		
		$slider_content = strip_shortcodes( $slider_content );
				
		if($smooth_slider['img_pick'][0] == '1'){
		 $custom_key = array($smooth_slider['img_pick'][1]);
		}
		else {
		 $custom_key = '';
		}
		
		if($smooth_slider['img_pick'][2] == '1'){
		 $the_post_thumbnail = true;
		}
		else {
		 $the_post_thumbnail = false;
		}
		
		if($smooth_slider['img_pick'][3] == '1'){
		 $attachment = true;
		 $order_of_image = $smooth_slider['img_pick'][4];
		}
		else{
		 $attachment = false;
		 $order_of_image = '1';
		}
		
		if($smooth_slider['img_pick'][5] == '1'){
			 $image_scan = true;
		}
		else {
			 $image_scan = false;
		}
		
		if($smooth_slider['img_size'] == '1'){
		 $gti_width = $smooth_slider['img_width'];
		}
		else {
		 $gti_width = false;
		}
		
		if($smooth_slider['crop'] == '0'){
		 $extract_size = 'full';
		}
		elseif($smooth_slider['crop'] == '1'){
		 $extract_size = 'large';
		}
		elseif($smooth_slider['crop'] == '2'){
		 $extract_size = 'medium';
		}
		else{
		 $extract_size = 'thumbnail';
		}
		
		$img_args = array(
			'custom_key' => $custom_key,
			'post_id' => $post_id,
			'attachment' => $attachment,
			'size' => $extract_size,
			'the_post_thumbnail' => $the_post_thumbnail,
			'default_image' => false,
			'order_of_image' => $order_of_image,
			'link_to_post' => false,
			'image_class' => 'smooth_slider_thumbnail',
			'image_scan' => $image_scan,
			'width' => $gti_width,
			'height' => false,
			'echo' => false,
			'permalink' => $permalink
		);
			
		$html .=  sslider_get_the_image($img_args);
		
		if(!$smooth_slider['content_limit'] or $smooth_slider['content_limit'] == '' or $smooth_slider['content_limit'] == ' ') 
		  $slider_excerpt = substr($slider_content,0,$smooth_slider['content_chars']);
		else 
		  $slider_excerpt = smooth_slider_word_limiter( $slider_content, $limit = $smooth_slider['content_limit'] );
		  		
		if ($smooth_slider['image_only'] == '1') { 
			$html .= '<!-- /smooth_slideri -->
			</div>';
		}
		else {
		   if($permalink!='') {
			$html .= '<h2 ><a href="'.$permalink.'">'.$post_title.'</a></h2><span> '.$slider_excerpt.'</span>
				<p class="more"><a href="'.$permalink.'">'.$smooth_slider['more'].'</a></p>
			
				<!-- /smooth_slideri -->
			</div>'; }
		   else{
		   $html .= '<h2 >'.$post_title.'</h2><span> '.$slider_excerpt.'</span>
				<!-- /smooth_slideri -->
			</div>';    }
		}
	}
	if($out_echo == '1') {
	   echo $html;
	}
	$r_array = array( $smooth_sldr_a, $html);
	return $r_array;
}

function get_smooth_slider_category($catg_slug) {
 global $smooth_slider; 
 ?>
	<script type="text/javascript">
	stepcarousel.setup({
		galleryid: 'smooth_sliderc', //id of carousel DIV
		beltclass: 'smooth_sliderb', //class of inner "belt" DIV containing all the panel DIVs
		panelclass: 'smooth_slideri', //class of panel DIVs each holding content
		autostep: {<?php if ($smooth_slider['autostep'] == '1'){ echo "enable: true";} else {echo "enable: false";}?>, moveby:1, pause:<?php echo $smooth_slider['speed']*1000; ?>},
		panelbehavior: {speed:<?php echo $smooth_slider['transition']*100; ?>, wraparound: true, wrapbehavior: 'slide', persist:false},
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
					
					global $sldr_nav_width;
					$sldr_nav_width = $smooth_slider['navimg_w'];
		  ?>
		  var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; ?>;
		  jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
		  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+nav_width+"px 0");
		  <?php } ?>
	  }
	})
	</script>
	<noscript><strong><?php echo $smooth_slider['noscript'];?></strong></noscript>
			<div id="smooth_sldr">
			<div id="smooth_sldr_items">
				<div id="smooth_sldr_body">
					<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { ?><div class="sldr_title"><?php echo $smooth_slider['title_text']; ?></div> <?php } ?>
					<div id="smooth_sliderc">
						<div class="smooth_sliderb">
						<?php global $smooth_sldr_a; $r_array = carousel_posts_on_slider_category($smooth_slider['no_posts'], $catg_slug, '0', '0'); $smooth_sldr_a = $r_array[0]; echo $r_array[1];?>
						</div>
					</div>
				</div>
				<?php if ($smooth_slider['goto_slide'] == 1) { ?>
				<ul id="smooth_sliderc_nav">
					<?php global $smooth_sldr_a; for($i=1; $i<=$smooth_sldr_a; $i++) { 
					echo "<li><a id=\"sldr".$i."\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" >".$i."</a></li>\n";
					 } ?>
				</ul>
				<?php } 
				if ($smooth_slider['goto_slide'] == 2) { ?>
				<div id="smooth_sliderc_nav">
					<?php global $smooth_sldr_a; for($i=1; $i<=$smooth_sldr_a; $i++) { 
					
					$width = $smooth_slider['navimg_w'];
					echo "<a class=\"smooth_sliderc_nav\" id=\"sldr".$i."\" style=\"background-image:url(".smooth_slider_plugin_url( 'images/' )."slide".$i.".png);background-position:0 0;width:".$width."px;height:".$smooth_slider['navimg_ht']."px;\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" ></a>\n";
					 } ?>
				  </div>
		  <?php }  
				 if ($smooth_slider['goto_slide'] == 3) { ?>	 
				 <div id="smooth_sliderc_nav"><li style="border:none;"><?php echo $smooth_slider['custom_nav']; ?></li></div>
		  <?php } ?>
				<div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
                <div class="sldr_clearlt"></div><div class="sldr_clearrt"></div>
			</div>
		</div>
<?php	
} 

function smooth_slider_css() {
global $smooth_slider,$post;
if(is_singular()) {
 $slider_style = get_post_meta($post->ID,'slider_style',true);
}
if((is_singular() and $slider_style == 'default.css') 
or (!is_singular() and $smooth_slider['stylesheet'] == 'default.css') 
or  (is_singular() and is_active_widget(false, false, 'sslider_wid', true) and (!isset($slider_style) or empty($slider_style) )) 
or (is_singular() and isset($smooth_slider['shortcode']) ) )
{
?>
<style type="text/css" media="screen">#smooth_sldr{width:<?php echo $smooth_slider['width']; ?>px;height:<?php echo $smooth_slider['height']; ?>px;background-color:<?php if ($smooth_slider['bg'] == '1') { echo "transparent";} else { echo $smooth_slider['bg_color']; } ?>;border:<?php echo $smooth_slider['border']; ?>px solid <?php echo $smooth_slider['brcolor']; ?>;}#smooth_sldr_items{padding:10px <?php if ($smooth_slider['prev_next'] == 1) {echo "18";} else {echo "12";} ?>px 0px <?php if ($smooth_slider['prev_next'] == 1) {echo "26";} else {echo "12";} ?>px;}#smooth_sliderc{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 44);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){$nav_size = $smooth_slider['navimg_ht'];} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.smooth_slideri{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 54);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){$nav_size = $smooth_slider['navimg_ht'];} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.sldr_title{font-family:<?php echo $smooth_slider['title_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['title_fsize']; ?>px;font-weight:<?php if ($smooth_slider['title_fstyle'] == "bold" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "bold";} else { echo "normal"; } ?>;font-style:<?php if ($smooth_slider['title_fstyle'] == "italic" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['title_fcolor']; ?>;}#smooth_sldr_body h2{line-height:<?php echo ($smooth_slider['ptitle_fsize'] + 3); ?>px;font-family:<?php echo $smooth_slider['ptitle_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['ptitle_fsize']; ?>px;font-weight:<?php if ($smooth_slider['ptitle_fstyle'] == "bold" or $smooth_slider['ptitle_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['ptitle_fstyle'] == "italic" or $smooth_slider['ptitle_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px 0 5px 0;}#smooth_sldr_body h2 a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}#smooth_sldr_body span{font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-weight:<?php if ($smooth_slider['content_fstyle'] == "bold" or $smooth_slider['content_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['content_fstyle']=="italic" or $smooth_slider['content_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['content_fcolor']; ?>;}.smooth_slider_thumbnail{float:<?php echo $smooth_slider['img_align']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px <?php if($smooth_slider['img_align'] == "left") {echo "5";} else {echo "0";} ?>px 0 <?php if($smooth_slider['img_align'] == "right") {echo "5";} else {echo "0";} ?>px;max-height:<?php echo $smooth_slider['img_height']; ?>px;border:<?php echo $smooth_slider['img_border']; ?>px solid <?php echo $smooth_slider['img_brcolor']; ?>;}#smooth_sldr_body p.more a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;}#smooth_sliderc_nav li{border:1px solid <?php echo $smooth_slider['content_fcolor']; ?>;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;}#smooth_sliderc_nav li a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}.sldrlink{padding-right:<?php if ($smooth_slider['prev_next'] == 1) {echo "40";} else {echo "25";} ?>px;}.sldrlink a{color:<?php echo $smooth_slider['content_fcolor']; ?>;}</style>
<?php  }
}

add_action('wp_head', 'smooth_slider_css');

function smooth_slider_enqueue_scripts() {
//	wp_register_script('jquery', false, false, false, false);
	wp_enqueue_script( 'stepcarousel', smooth_slider_plugin_url( 'js/stepcarousel.js' ),
		array('jquery'), SMOOTH_SLIDER_VER, false); 
}

add_action( 'init', 'smooth_slider_enqueue_scripts' );

function smooth_slider_enqueue_styles() {	
  global $post, $smooth_slider, $wp_registered_widgets,$wp_widget_factory;
  if(is_singular()) {
	 $slider_style = get_post_meta($post->ID,'slider_style',true);
	 if((is_active_widget(false, false, 'sslider_wid', true) or isset($smooth_slider['shortcode']) ) and (!isset($slider_style) or empty($slider_style))){
	   $slider_style='default.css';
	 }
	 if (!isset($slider_style) or empty($slider_style) ) {
	     wp_enqueue_style( 'smooth_slider_head_css', smooth_slider_plugin_url( 'css/styles/'.$smooth_slider['stylesheet'] ),
		false, SMOOTH_SLIDER_VER, 'all');
	 }
     else {
	     wp_enqueue_style( 'smooth_slider_head_css', smooth_slider_plugin_url( 'css/styles/'.$slider_style ),
		false, SMOOTH_SLIDER_VER, 'all');
	}
  }
  else {
     $slider_style = $smooth_slider['stylesheet'];
     wp_enqueue_style( 'smooth_slider_head_css', smooth_slider_plugin_url( 'css/styles/'.$slider_style ),
		false, SMOOTH_SLIDER_VER, 'all'); 
  }
}
add_action( 'wp', 'smooth_slider_enqueue_styles' );

function get_smooth_slider($slider_id='') {
 global $smooth_slider; 
 
 if($smooth_slider['multiple_sliders'] == '1' and is_singular() and (empty($slider_id) or !isset($slider_id))){
    global $post;
	$post_id = $post->ID;
    $slider_id = get_slider_for_the_post($post_id);
 }
if((!is_singular() or $smooth_slider['multiple_sliders'] != '1') and (empty($slider_id) or !isset($slider_id))){
  $slider_id = '1';
}
if(!empty($slider_id)){
 global $smooth_sldr_j; $r_array = carousel_posts_on_slider($smooth_slider['no_posts'], $offset=0, $slider_id, '0'); $smooth_sldr_j = $r_array[0]; 
?>
	<script type="text/javascript">
	stepcarousel.setup({
		galleryid: 'smooth_sliderc', //id of carousel DIV
		beltclass: 'smooth_sliderb', //class of inner "belt" DIV containing all the panel DIVs
		panelclass: 'smooth_slideri', //class of panel DIVs each holding content
		autostep: {<?php if ($smooth_slider['autostep'] == '1'){ echo "enable: true";} else {echo "enable: false";}?>, moveby:1, pause:<?php echo $smooth_slider['speed']*1000; ?>},
		panelbehavior: {speed:<?php echo $smooth_slider['transition']*100; ?>, wraparound: true, wrapbehavior: 'slide', persist:false},
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
					
					global $sldr_nav_width;
					$sldr_nav_width = $smooth_slider['navimg_w'];
		  ?>
		  var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; ?>;
		  jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
		  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+nav_width+"px 0");
		  <?php } ?>
	  }
	})
	</script>
	<noscript><strong><?php echo $smooth_slider['noscript'];?></strong></noscript>
			<div id="smooth_sldr">
			<div id="smooth_sldr_items">
				<div id="smooth_sldr_body">
					<?php 
					if($smooth_slider['title_from']=='1') $sldr_title = get_smooth_slider_name($slider_id);
					else $sldr_title = $smooth_slider['title_text']; 
					if(!empty($sldr_title)) { ?><div class="sldr_title"><?php echo $smooth_slider['title_text']; ?></div> <?php } ?>
					<div id="smooth_sliderc">
						<div class="smooth_sliderb">
						<?php global $smooth_sldr_j; $r_array = carousel_posts_on_slider($smooth_slider['no_posts'], $offset=0, $slider_id, '0'); $smooth_sldr_j = $r_array[0]; echo $r_array[1];?>
						</div>
					</div>
				</div>
				<?php if ($smooth_slider['goto_slide'] == 1) { ?>
				<ul id="smooth_sliderc_nav">
					<?php global $smooth_sldr_j; for($i=1; $i<=$smooth_sldr_j; $i++) { 
					echo "<li><a id=\"sldr".$i."\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" >".$i."</a></li>\n";
					 } ?>
				</ul>
				<?php } 
				if ($smooth_slider['goto_slide'] == 2) { ?>
				<div id="smooth_sliderc_nav">
					<?php global $smooth_sldr_j; for($i=1; $i<=$smooth_sldr_j; $i++) { 
					
					$width = $smooth_slider['navimg_w'];
					echo "<a class=\"smooth_sliderc_nav\" id=\"sldr".$i."\" style=\"background-image:url(".smooth_slider_plugin_url( 'images/' )."slide".$i.".png);background-position:0 0;width:".$width."px;height:".$smooth_slider['navimg_ht']."px;\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" ></a>\n";
					 } ?>
				  </div>
		  <?php }  
				 if ($smooth_slider['goto_slide'] == 3) { ?>	 
				 <div id="smooth_sliderc_nav"><li style="border:none;"><?php echo $smooth_slider['custom_nav']; ?></li></div>
		  <?php } ?>
				<div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
                <div class="sldr_clearlt"></div><div class="sldr_clearrt"></div>
			</div>
		</div>
<?php	
  } //end of not empty slider_id condition
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
	autostep: {<?php if ($smooth_slider['autostep'] == '1'){ echo "enable: true";} else {echo "enable: false";}?>, moveby:1, pause:<?php echo $smooth_slider['speed']*1000; ?>},
	panelbehavior: {speed:<?php echo $smooth_slider['transition']*100; ?>, wraparound: true, wrapbehavior: 'slide', persist:false},
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
 				
				global $sldr_nav_width;
				$sldr_nav_width = $smooth_slider['navimg_w'];
	  ?>
	  var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; ?>;
	  jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
	  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+nav_width+"px 0");
	  <?php } ?>
	  
  }
})
</script>
<noscript><strong><?php echo $smooth_slider['noscript'];?></strong></noscript>
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
				echo "<li><a id=\"sldr".$i."\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" >".$i."</a></li>\n";
                 } ?>
			</ul>
            <?php } 
			if ($smooth_slider['goto_slide'] == 2) { ?>
            <div id="smooth_sliderc_nav">
                <?php global $smooth_sldr_i; for($i=1; $i<=$smooth_sldr_i; $i++) { 

				$width = $smooth_slider['navimg_w'];
				echo "<a class=\"smooth_sliderc_nav\" id=\"sldr".$i."\" style=\"background-image:url(".smooth_slider_plugin_url( 'images/' )."slide".$i.".png);background-position:0 0;width:".$width."px;height:".$smooth_slider['navimg_ht']."px;\" href=\"javascript:stepcarousel.stepTo('smooth_sliderc', ".$i.")\" ></a>\n";
                 } ?>
			</div>
       <?php }  
			 if ($smooth_slider['goto_slide'] == 3) { ?>	 
             <div id="smooth_sliderc_nav"><li style="border:none;"><?php echo $smooth_slider['custom_nav']; ?></li></div>
      <?php } ?>
            <div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
		</div>
	</div>
<?php	
}
function return_smooth_slider($slider_id='') {
 global $smooth_slider; 
 
 if($smooth_slider['multiple_sliders'] == '1' and is_singular() and (empty($slider_id) or !isset($slider_id))){
    global $post;
	$post_id = $post->ID;
    $slider_id = get_slider_for_the_post($post_id);
 }
if($smooth_slider['multiple_sliders'] != '1' and (empty($slider_id) or !isset($slider_id))){
  $slider_id = '1';
}
$slider_html='';
if(!empty($slider_id)){
	if ($smooth_slider['autostep'] == '1'){ $autostep = "enable: true";} else {$autostep = "enable: false";}
	if ($smooth_slider['prev_next'] == 1) {$defaultbuttons = "true";} else {$defaultbuttons = "false";} 
	$sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $smooth_slider['content_fsize'] + 5 + 18; } else { $extra_height = $smooth_slider['content_fsize'] + 5 + 5 + 18;  } 
	$nav_ht = (($smooth_slider['height'] - $extra_height)/2); 
	$fontSize = $smooth_slider['content_fsize'] + 5;
	
	$slider_html=$slider_html.'<script type="text/javascript">
	stepcarousel.setup({
		galleryid: "smooth_sliderc", //id of carousel DIV
		beltclass: "smooth_sliderb", //class of inner "belt" DIV containing all the panel DIVs
		panelclass: "smooth_slideri", //class of panel DIVs each holding content
		autostep: {'.$autostep.', moveby:1, pause:'. $smooth_slider['speed']*1000 .'},
		panelbehavior: {speed:'. $smooth_slider['transition']*100 .', wraparound: true, wrapbehavior: "slide", persist:false},
		defaultbuttons: {enable: '.$defaultbuttons.', moveby: 1, leftnav: ["'. smooth_slider_plugin_url( 'images/button_prev.png' ) .'", -25, '.$nav_ht.'], rightnav: ["'. smooth_slider_plugin_url( 'images/button_next.png' ).'", 0, '.$nav_ht.']},
		statusvars: ["imageA", "imageB", "imageC"], //register 3 variables that contain current panel (start), current panel (last), and total panels
		contenttype: ["inline"], //content setting ["inline"] or ["external", "path_to_external_file"]
		onslide:function(){
		  jQuery("#smooth_sliderc_nav li a").css("fontWeight", "normal");
		  jQuery("#smooth_sliderc_nav li a").css("fontSize", "'.$smooth_slider['content_fsize'].'px");
		  var curr_slide = imageA;
		  jQuery("#sldr"+curr_slide).css("fontWeight", "bolder");
		  jQuery("#sldr"+curr_slide).css("fontSize", "'.$fontSize.'px");';
		  
		  if ($smooth_slider['goto_slide'] == 2) { 
					
					global $sldr_nav_width;
					$sldr_nav_width = $smooth_slider['navimg_w'];
			 // var nav_width = <?php global $sldr_nav_width; echo $sldr_nav_width; 
			  $slider_html = $slider_html.'jQuery("#smooth_sliderc_nav a").css("backgroundPosition", "0 0");
			  jQuery("#sldr"+curr_slide).css("backgroundPosition", "-"+'.$sldr_nav_width.'+"px 0")';
	      }
	$slider_html=$slider_html.' }
	 })
	</script>
	<noscript><strong>'.$smooth_slider['noscript'].'</strong></noscript>
			<div id="smooth_sldr">
			<div id="smooth_sldr_items">
				<div id="smooth_sldr_body">';
				
				if($smooth_slider['title_from']=='1') $sldr_title = get_smooth_slider_name($slider_id);
				else $sldr_title = $smooth_slider['title_text'];  
				if(!empty($sldr_title)) { 
                   $slider_html=$slider_html.'<div class="sldr_title">'. $smooth_slider['title_text'].'</div>'; 
				} 
				global $smooth_sldr_j; 
				$r_array = carousel_posts_on_slider($smooth_slider['no_posts'], $offset=0, $slider_id, $echo = '0'); 
				$smooth_sldr_j = $r_array[0];
						
		$slider_html=$slider_html.'<div id="smooth_sliderc">
						<div class="smooth_sliderb">
						  '.$r_array[1].'
						</div>
					</div>
				</div>';
		if ($smooth_slider['goto_slide'] == 1) { 
			$slider_html=$slider_html.'<ul id="smooth_sliderc_nav">';
				for($i=1; $i<=$smooth_sldr_j; $i++) { 
					$slider_html=$slider_html.'<li><a id="sldr'.$i.'" href="javascript:stepcarousel.stepTo(\'smooth_sliderc\', '.$i.')" >'.$i.'</a></li>';
				} 
		  $slider_html=$slider_html.'</ul>';
        } 
		if ($smooth_slider['goto_slide'] == 2) { 
			$slider_html=$slider_html.'<div id="smooth_sliderc_nav">';
			$width = $smooth_slider['navimg_w'];
			for($i=1; $i<=$smooth_sldr_j; $i++) { 
			    $slider_html=$slider_html.'<a class="smooth_sliderc_nav" id="sldr'.$i.'" style="background-image:url('.smooth_slider_plugin_url('images/').'slide'.$i.'.png);background-position:0 0;width:'.$width.'px;height:'.$smooth_slider['navimg_ht'].'px;" href="javascript:stepcarousel.stepTo(\'smooth_sliderc\', '.$i.')" ></a>';
	        } 
			$slider_html=$slider_html.'</div>';
		}  
	    if ($smooth_slider['goto_slide'] == 3) { 	 
			$slider_html=$slider_html.'<div id="smooth_sliderc_nav"><li style="border:none;">'.$smooth_slider["custom_nav"].'</li></div>';
		} 
		$slider_html=$slider_html.'<div class="sldrlink"><a href="http://www.clickonf5.org/smooth-slider" target="_blank">Smooth Slider</a></div>
			</div>
		</div>';
  } //end of not empty slider_id condition
  return $slider_html;
}

function smooth_slider_simple_shortcode($atts) {
	extract(shortcode_atts(array(
		'id' => '',
	), $atts));

	return return_smooth_slider($id);
}
add_shortcode('smoothslider', 'smooth_slider_simple_shortcode');

//admin settings
function smooth_slider_admin_scripts() {
  if ( is_admin() ){ // admin actions
  // Settings page only
	if ( isset($_GET['page']) && ('smooth-slider-admin' == $_GET['page'] or 'smooth-slider-settings' == $_GET['page'] )  ) {
	wp_register_script('jquery', false, false, false, false);
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-sortable' );
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
   
  // Sliders page only
    if ( isset($_GET['page']) && 'smooth-slider-admin' == $_GET['page'] ) {
	  $sliders = ss_get_sliders(); 
	?>
		<script type="text/javascript">
            // <![CDATA[
        jQuery(document).ready(function() {
                jQuery(function() {
                    jQuery("#slider_tabs").tabs(); 
				<?php foreach($sliders as $slider){?>
                    jQuery("#sslider_sortable_<?php echo $slider['slider_id'];?>").sortable();
                    jQuery("#sslider_sortable_<?php echo $slider['slider_id'];?>").disableSelection();
			    <?php } ?>
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
        function confirmSliderDelete()
        {
            var agree=confirm("Delete this Slider??");
            if (agree)
            return true ;
            else
            return false ;
        }
        function slider_checkform ( form )
        {
          if (form.new_slider_name.value == "") {
            alert( "Please enter the New Slider name." );
            form.new_slider_name.focus();
            return false ;
          }
          return true ;
        }
        </script>
        <style type="text/css">
        /************************************************
        *	ui-tabs  									*
        ************************************************/
        .ui-tabs { padding: .2em; zoom: 1; }
        .ui-tabs .ui-tabs-nav { list-style: none; position: relative; padding: .2em .2em 0; }
        .ui-tabs .ui-tabs-nav li { position: relative; float: left; border-bottom-width: 0 !important; margin: 0 .2em -1px 0; padding: 0;  background-color:#B9B9B9;}
        .ui-tabs .ui-tabs-nav li a { float: left; text-decoration: none; padding: .5em 1em; color:#FFFFFF;}
        .ui-tabs .ui-tabs-nav li.ui-tabs-selected { border-bottom-width: 0; background-color:#ABD37E;}
        .ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: text; color:#FFF;}
        .ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a { cursor: pointer; } /* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */
        .ui-tabs .ui-tabs-panel { padding: 1em 1.4em; display: block; border-width: 0; background: none; }
        .ui-tabs .ui-tabs-hide { display: none !important; }
        /*tabs complete*/
        #divFeedityWidget span[style] {
                display:none !important;
        }
        div#smooth_sldr_donations a{
           color:#366C94 !important;
           text-decoration:none;
        }
        div#smooth_sldr_donations a:hover{
           text-decoration:underline;
        }
        #sldr_message {background-color:#FEF7DA;clear:both;width:72%;}
        #sldr_close {float:right;} 
        </style>
<?php
   } //Sliders page only
   
   // Settings page only
  if ( isset($_GET['page']) && 'smooth-slider-settings' == $_GET['page']  ) {
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
div#smooth_sldr_donations a{
   color:#366C94 !important;
   text-decoration:none;
}
div#smooth_sldr_donations a:hover{
   text-decoration:underline;
}
#sldr_message {background-color:#FEF7DA;clear:both;width:72%;}
#sldr_close {float:right;} 
</style>
<style type="text/css" media="screen">#smooth_sldr{width:<?php echo $smooth_slider['width']; ?>px;height:<?php echo $smooth_slider['height']; ?>px;background-color:<?php if ($smooth_slider['bg'] == '1') { echo "transparent";} else { echo $smooth_slider['bg_color']; } ?>;border:<?php echo $smooth_slider['border']; ?>px solid <?php echo $smooth_slider['brcolor']; ?>;}#smooth_sldr_items{padding:10px <?php if ($smooth_slider['prev_next'] == 1) {echo "18";} else {echo "12";} ?>px 0px <?php if ($smooth_slider['prev_next'] == 1) {echo "26";} else {echo "12";} ?>px;}#smooth_sliderc{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 44);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){$nav_size = $smooth_slider['navimg_ht'];} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.smooth_slideri{width:<?php if ($smooth_slider['prev_next'] == 1) {echo ($smooth_slider['width'] - 54);} else {echo ($smooth_slider['width'] - 24);} ?>px;height:<?php if ($smooth_slider['goto_slide'] == "1"){$nav_size = $smooth_slider['content_fsize'];} elseif ($smooth_slider['goto_slide'] == "2"){$nav_size = $smooth_slider['navimg_ht'];} else {$nav_size = 10;} $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { $extra_height = $smooth_slider['title_fsize'] + $nav_size + 5 + 18; } else { $extra_height = $nav_size + 5 + 5 + 18;  } echo ($smooth_slider['height'] - $extra_height); ?>px;}.sldr_title{font-family:<?php echo $smooth_slider['title_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['title_fsize']; ?>px;font-weight:<?php if ($smooth_slider['title_fstyle'] == "bold" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "bold";} else { echo "normal"; } ?>;font-style:<?php if ($smooth_slider['title_fstyle'] == "italic" or $smooth_slider['title_fstyle'] == "bold italic" ){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['title_fcolor']; ?>;}#smooth_sldr_body h2{line-height:<?php echo ($smooth_slider['ptitle_fsize'] + 3); ?>px;font-family:<?php echo $smooth_slider['ptitle_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['ptitle_fsize']; ?>px;font-weight:<?php if ($smooth_slider['ptitle_fstyle'] == "bold" or $smooth_slider['ptitle_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['ptitle_fstyle'] == "italic" or $smooth_slider['ptitle_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px 0 5px 0;}#smooth_sldr_body h2 a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}#smooth_sldr_body span{font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-weight:<?php if ($smooth_slider['content_fstyle'] == "bold" or $smooth_slider['content_fstyle'] == "bold italic" ){echo "bold";} else {echo "normal";} ?>;font-style:<?php if ($smooth_slider['content_fstyle']=="italic" or $smooth_slider['content_fstyle'] == "bold italic"){echo "italic";} else {echo "normal";} ?>;color:<?php echo $smooth_slider['content_fcolor']; ?>;}.smooth_slider_thumbnail{float:<?php echo $smooth_slider['img_align']; ?>;margin:<?php $sldr_title = $smooth_slider['title_text']; if(!empty($sldr_title)) { echo "10"; } else {echo "0";} ?>px <?php if($smooth_slider['img_align'] == "left") {echo "5";} else {echo "0";} ?>px 0 <?php if($smooth_slider['img_align'] == "right") {echo "5";} else {echo "0";} ?>px;max-height:<?php echo $smooth_slider['img_height']; ?>px;border:<?php echo $smooth_slider['img_border']; ?>px solid <?php echo $smooth_slider['img_brcolor']; ?>;}#smooth_sldr_body p.more a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;}#smooth_sliderc_nav li{border:1px solid <?php echo $smooth_slider['content_fcolor']; ?>;font-size:<?php echo $smooth_slider['content_fsize']; ?>px;font-family:<?php echo $smooth_slider['content_font']; ?>, Arial, Helvetica, sans-serif;}#smooth_sliderc_nav li a{color:<?php echo $smooth_slider['ptitle_fcolor']; ?>;}.sldrlink{padding-right:<?php if ($smooth_slider['prev_next'] == 1) {echo "40";} else {echo "25";} ?>px;}.sldrlink a{color:<?php echo $smooth_slider['content_fcolor']; ?>;}</style>
<?php
   } //for smooth slider option page
 }//only for admin
}
add_action('admin_head', 'smooth_slider_admin_head');
?>