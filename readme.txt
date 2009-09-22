=== Smooth Slider ===
Contributors: Tejaswini Deshpande, Sanjeev Mishra
Tags: slideshow,featured,posts,jquery,slider,content,css,simple,thumbnail,image
Donate link: http://clickonf5.org/go/paypal/smooth-slider/ 
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 1.2

== Description ==

Smooth Slider is a Wordpress Plugin for creating a dynamic slideshow for featured posts on a blog. The slideshow created by Smooth Slider are JavaScript and Text based, that is why bloggers will get full benefit of Search Engine Optimization as the texts are readable by Search Engines. You can choose some of your posts as featured posts and show them into a slideshow on your blog home page (i.e. Index) as well as in Sidebar.

Features:

1. Search Engine Optimized Slideshow
2. Fully Customizable CSS
3. Choose Posts as Featured Posts on Single Click
4. Simple but Decent Slideshow
5. Match Slideshow With Wordpress Theme
6. No Need Of Knowledge of PHP, HTML or CSS
7. Easy To Install Plugin
8. Full Support Available
9. Readable by search engine as you can see the screenshot on Lynx browser available on our blog
10. Option for trasparent background, so that rounded corners can be supported
11. Slider Preview in admin panel
12. Can convert to pure image Slider
13. Facility to put Custom Images in place of navigation numbers
14. Remove all the posts from the slider at one go

[Demo](http://www.clickonf5.org/) |
[Plugin Information](http://www.clickonf5.org/smooth-slider)

== Installation ==

This plugin is easy to install like other plug-ins of Wordpress as you need to just follow the below mentioned steps:

1. Copy Folder Smooth Slider from the downloaded and extracted file.

2. Paste it in wp-Content/plugins folder on your Wordpress Installation 

3. Activate the plugin from Dashboard / Plugins window.

4. Now Plugin is Activated, Go to the Usage section to see how to use Smooth Slider.

== Usage ==

1. If you want the slideshow on your home page, then open Index.php file from Dashboard by clicking on Tab Appearance / Editor and paste the following piece of code at the suitable place. 

if ( function_exists( 'get_smooth_slider' ) ) {
     get_smooth_slider(); }If you want to put the slider before the list of articles on your Wordpress blog homepage, put the above piece of code before the Wordpress Loop (the code is a php code, so ensure that it is enclosed within the php tags). Wordpress loop code is shown below:

if(have_posts()) : while(have_posts()) : the_post();Complete example:

<?php if ( function_exists( 'get_smooth_slider' ) ) { 
  get_smooth_slider(); }
if(have_posts()) : while(have_posts()) : the_post();
   ....(rest of the loop code) 
?> 

2. The content in the slider can be picked up from either the post content or the post excerpt or a new custom field slider_content. You can add the custom field on the Edit Post panel for each of the posts. 

3. You can also put a thumbnail image for each of the featured post on Smooth slider. All you need to do is create a new custom field slider_thumbnail on the edit post panel for the particular post and put the link or source URL of the image in the value column.

4. Almost all the fields that appear in the Smooth Slider are customizable, you can change the looks of your Slider and make it suitable for your theme. The defaults set are according to the Default Wordpress theme. Also, you can change the number of posts appearing in the slider and the pause or interval between the two consecutive posts on the slider. For making these changes, there would be  a settings page for Smooth Slider in the wp-admin screen of your blog, once you enable the plugin.

Go to the plugin page to see more details (http://www.clickonf5.org/smooth-slider)

== Frequently Asked Questions ==

Check the FAQs in the Smooth Slider forum on Internet Techies. 
Forum link: http://www.clickonf5.org/phpbb/smooth-slider-f12/

== Screenshots ==
1. Demo of this plugin is available on my blog
2. How to make a post a featured post
3. Customize the CSS like background colour, width, height etc of Slider Box

Visit the plugin page (http://www.clickonf5.org/smooth-slider) and screenshot-post (http://www.clickonf5.org/wordpress/smooth-slider-featured-posts-slideshow-plugin/4333) to see more about it.

== Changelog ==
Version 1.2 (09/22/2009)
1. New - Slider Preview in Smooth Slider’s setting page
2. New - Facility to set transparent background to the slider
3. New - Facility to Convert it to pure Image Slider 
4. New - Remove all the posts from Smooth Slider in one click
5. New - Custom Images in place of navigation numbers
6. Fixed - CSS id names and class name fixed, to avoid probable conflicts with theme styles and other plugin styles

Version 1.1 (09/14/2009)
1. New - Active Slide in the slideshow will now be highlighted with bolder and bigger navigation number
2. Fixed - Added No Script tag brosers not supporting JavaScript for showing the slideshow
3. Fixed - Issues with Wordpress MU Smooth Slider Options update from setting page

Visit the plugin page (http://www.clickonf5.org/smooth-slider) to see the changelog and release notes.