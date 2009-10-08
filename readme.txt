=== Smooth Slider ===
Contributors: Tejaswini Deshpande, Sanjeev Mishra
Tags: slideshow,featured,posts,jquery,slider,content,css,simple,thumbnail,image,post,sidebar,plugin,page,category,wpmu,site,blogs,style,home,categories,picture,flash,gallery
Donate link: http://clickonf5.org/go/paypal/smooth-slider/ 
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 2.0

== Description ==

Smooth Slider is a Wordpress and Wordpress MU Plugin for creating a dynamic slideshow for featured posts on a blog. The slideshow created by Smooth Slider are JavaScript and Text based, that is why bloggers will get full benefit of Search Engine Optimization as the texts are readable by Search Engines. You can choose some of your posts as featured posts and show them into a slideshow on your blog home page (i.e. Index) as well as in Sidebar.

Features:
1. Search Engine Optimized Slideshow
2. Fully Customizable CSS
3. Choose Posts and Pages as Featured Posts/Pages on Single Click
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
14. Images Original Size as well as custom size Option
15. Pick image from content or the custom field
16. New custom field implementation, to allow not to display images on selective posts
17. A new template tag to display Category specific posts on Smooth Slider
18. A new template tag for WPMU, to get slider posts from all over the WPMU site
19. Option to change Read More text and also put it in your language
20. Permission setting option to restrict the users from adding posts to Smooth Slider
21. Remove posts and pages from Smooth Slider selectively or remove all the posts from the slider at one go from the settings page itself
22. Option to retain specific html tags in the slider posts
23. Option to specify custom text or html in place of navigation numbers or buttons
24. Fixed issue of Smooth Slider settings page with Internet Explorer
25. Optimized Smooth Slider code internally
26. Smooth Slider complete uninstall on plugin Delete

[Demo](http://www.clickonf5.org/) |
[Plugin Information](http://www.clickonf5.org/smooth-slider) | 
[Release 2.0](http://www.clickonf5.org/wordpress/smooth-slider-upgrade-2-0-released/5151)

== Installation ==

This plugin is easy to install like other plug-ins of Wordpress as you need to just follow the below mentioned steps:

1. Copy Folder Smooth Slider from the downloaded and extracted file.

2. Paste it in wp-Content/plugins folder on your Wordpress Installation 

3. Activate the plugin from Dashboard / Plugins window.

4. Now Plugin is Activated, Go to the Usage section to see how to use Smooth Slider.

== Usage ==

1. If you want the slideshow with all the added featured posts on your home page, then open Index.php file from Dashboard by clicking on Tab Appearance / Editor and paste the following piece of code at the suitable place. 

if ( function_exists( 'get_smooth_slider' ) ) {
     get_smooth_slider(); }If you want to put the slider before the list of articles on your Wordpress blog homepage, put the above piece of code before the Wordpress Loop (the code is a php code, so ensure that it is enclosed within the php tags). Wordpress loop code is shown below:

if(have_posts()) : while(have_posts()) : the_post();

2. You can use the get_smooth_slider_cat(‘category-name or category slug’)or get_smooth_slider_cat()to get the posts from specific category on the slider. Please read the intructions on plugin page to know the details which tag to use in which case.

3. Use the template tag get_smooth_slider_wpmu_all to get the site wide posts on your WPMU installation.

4. The content in the slider can be picked up from either the post content or the post excerpt or a new custom field slider_content. You can add the custom field on the Edit Post panel for each of the posts. 

5. You can also put a thumbnail image for each of the featured post on Smooth slider. All you need to do is create a new custom field slider_thumbnail on the edit post panel for the particular post and put the link or source URL of the image in the value column.

6. Almost all the fields that appear in the Smooth Slider are customizable, you can change the looks of your Slider and make it suitable for your theme. The defaults set are according to the Default Wordpress theme. Also, you can change the number of posts appearing in the slider and the pause or interval between the two consecutive posts on the slider. For making these changes, there would be  a settings page for Smooth Slider in the wp-admin screen of your blog, once you enable the plugin.

Go to the plugin page to see more details (http://www.clickonf5.org/smooth-slider)
There are lot many features added in Release version 2.0. To see the upgrade details and usage visit http://www.clickonf5.org/wordpress/smooth-slider-upgrade-2-0-released/5151

== Frequently Asked Questions ==

Check the FAQs in the Smooth Slider forum on Internet Techies. 
Forum link: http://www.clickonf5.org/phpbb/smooth-slider-f12/

== Screenshots ==
1. Demo of this plugin is available on my blog
2. How to make a post a featured post
3. Customize the CSS like background colour, width, height etc of Slider Box

Visit the plugin page (http://www.clickonf5.org/smooth-slider) and screenshot-post (http://www.clickonf5.org/wordpress/smooth-slider-featured-posts-slideshow-plugin/4333) to see more about it.

== Changelog ==
Version 2.0 (10/08/2009)
1. New - Now you can add pages to Smooth Slider along with posts
2. New - Images Original Size Option
3. New - Pick image from content or the custom field
4. New - New custom field implementation, to allow not to display images on selective posts
5. New - A new template tag to display Category specific posts on Smooth Slider
6. New - A new template tag for WPMU, to get slider posts from all over the WPMU site
7. New - Option to change “Read More” text and also put it in your language
8. New - Permission setting option to restrict the users from adding posts to Smooth Slider
9. New - Remove posts and pages from Smooth Slider selectively from the settings page itself
10. New - Option to retain specific html tags in the slider posts
11. New - Option to specify custom text or html in place of navigation numbers or buttons
12. Fix - Fixed issue of Smooth Slider settings page with Internet Explorer
13. New - Optimized Smooth Slider code internally
14. New - Smooth Slider complete uninstall on plugin Delete

Version 1.2 (09/22/2009)
1. New - Slider Preview in Smooth Slider setting page
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