<?php 
//This plugin creates an entry in the options database. When the plugin will be deleted, this code will automatically delete the database entry from the options Wordpress table.
delete_option('smooth_slider_options'); 
//This plugin creates its own database table to save the post ids for the posts and pages added to Smooth Slider. When the plugin will be deleted, the database will aslo get deleted.
global $wpdb, $table_prefix;
$table_name = $table_prefix.'slider';
$sql = "DROP TABLE $table_name";
$wpdb->query($sql);
?>