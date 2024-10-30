<?php
error_reporting(E_ALL ^ E_NOTICE);
/*
Plugin Name: Create Own Shortcode
Version: 1.0
Plugin URI: http://venugopalphp.wordpress.com
Description: This plugin helpful for create your own shortcode for your content . You can put this short code in post, page, widget.. etc
Author: Venugopal
Author URI: http://venugopalphp.wordpress.com
*/


/* 
 * Include styles for table
 */
add_action( 'admin_init', 'cosp_include_styless' );
 function cosp_include_styless() {         
$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)).'/css';
$pluginfolder_js = get_bloginfo('url') . '/' . PLUGINDIR . '/' . dirname(plugin_basename(__FILE__)).'/js';
wp_enqueue_style( 'ownplugin', $pluginfolder.'/ownplugin.css' );
	
        wp_enqueue_media();


 }

add_action('admin_menu', 'cosp_create_own_shortcode_plugin');

function cosp_create_own_shortcode_plugin() {
	add_menu_page('Create Shortcodes', 'Create Shortcodes', 'read', 'own-shortcode', 'cosp_create_shortcode_plugin', 'dashicons-clipboard');
}

function cosp_create_shortcode_plugin(){
         include "shortcode_components.php";
       
        echo "<h1 class='heading'> <span class='dashicons dashicons-clipboard'></span>&nbsp;Welcome to Create Shortcodes</h1>";
?>
<div class="main_wrap">
     <div class="full">
                <?php
                //Calling Sidabar links from url
                 $content_functon = filter_var($_REQUEST['fuction'],FILTER_SANITIZE_STRING);
				   if($content_functon){
					echo $shortcode_obj->$content_functon();
               }  else {
                 
                    $page = filter_var($_REQUEST['editshort'],FILTER_SANITIZE_STRING);

                    switch ($page) {
                        case 'content_edit':
                        echo $shortcode_obj->cosp_shortcode_conent_edit(sanitize_text_field($_REQUEST['edits']));
						
                        break;
                       
                        case 'content_del':
                        echo $shortcode_obj->cosp_shortcode_conent_del(sanitize_text_field($_REQUEST['dels']));
                        break;
                     
                        case 'imag_edit':
                        echo $shortcode_obj->cosp_shortcode_img_edit(sanitize_text_field($_REQUEST['edits']));
                        break;
                        
                        case 'img_del':
                        echo $shortcode_obj->cosp_shortcode_img_del(sanitize_text_field($_REQUEST['dels']));
                        break;

                            }
                    //Display All Shortcode listing
                    echo $shortcode_obj->cosp_shorcode_listing();
                     }
                ?>
    </div>

    <div class="righ_bar">
        <h2> Select Short Code Type</h2>
        <?php   $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;                ?>
        <a href="<?php echo $url;?>&fuction=cosp_shortcode_content"> Create Content Short Code</a>
        <a href="<?php echo  $url;?>&fuction=cosp_shortcode_image"> Create Image Short Code</a>
       

    </div>
</div>

<?php

// Inserting details into datase
 if( filter_var($_REQUEST['create_content_code'],FILTER_SANITIZE_STRING) != "" )
    {
		$stitle = 	sanitize_text_field($_POST['stitle']);
		$scontent =  $_POST['mycustomeditor'];
		$short_title = sanitize_text_field($_REQUEST['shortcode_title']);
	  
      global $wpdb;
     $cdate = date('Y-m-d H:i:s');
     $insert_shortcode =  "INSERT INTO ".$wpdb->prefix."create_own_shortcode (title, content, short_code, created_date) VALUES('$stitle','$scontent','$short_title', '$cdate')";
    
    $wpdb->query($insert_shortcode);
     $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;   
      echo "<script type='text/javascript'>window.parent.location = '$url';</script>";  
    }

    
    
    }//Pugin Function end here

      
    // Creating Dynamic Shortcode for Content
global $wpdb;
    $shortcodess = $wpdb->get_results("select * from ".$wpdb->prefix."create_own_shortcode");
    foreach ($shortcodess as $shortcodes_comps) {
            $stitle = $shortcodes_comps->title;
            $scontent = $shortcodes_comps->content;
            add_shortcode($shortcodes_comps->short_code, function() use ( $stitle, $scontent ) {
            echo $stitle.'<br>';
        echo $scontent;
});

}

  // Creating Dynamic Shortcode for Image
global $wpdb;
    $shortcodess_img = $wpdb->get_results("select * from ".$wpdb->prefix."create_image_shortcode");
    $i=1;
      foreach ($shortcodess_img as $sc_img) {
          
            $ititle = $sc_img->image_title;
            $icap = $sc_img->image_caption;  
			$image_alt = $sc_img->image_alt;  $image_link = $sc_img->image_link;  $image_target = $sc_img->image_target; $image_width = $sc_img->image_width;  $image_height= $sc_img->image_height;  $image_path = $sc_img->image_path;  
            $image_short_code = $sc_img->image_short_code;
            
            add_shortcode($image_short_code, function() use ( $image_path, $image_width, $image_height, $ititle, $icap, $image_link, $image_target, $image_alt ) {
          
		echo '<a href="'.$image_link.'" target="'.$image_target.'" title="'.$ititle.'">
		<img src="'.content_url().$image_path.'" width="'.$image_width.'" height="'.$image_height.'" ><figcaption>'.$icap.'</figcaption></a>';
});

}














//Create table while activation

function cosp_shortcode_own_database_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'create_own_shortcode';
    $sql = "CREATE TABLE $table_name (
        id int(9) unsigned NOT NULL AUTO_INCREMENT,
            title varchar(250),
            content LONGTEXT,
            short_code varchar(300),
			created_date varchar(300),
               PRIMARY KEY  (id)
        );";
 
     $image_table = $wpdb->prefix . 'create_image_shortcode';
     $image_table_s = "CREATE TABLE $image_table (
            id int(9) unsigned NOT NULL AUTO_INCREMENT,
            image_title varchar(250),
            image_caption varchar(250),
            image_alt varchar(250),
            image_link varchar(300),
            image_target varchar(250),
            image_width varchar(250),
            image_height varchar(250),
            image_path varchar(250),
            image_short_code varchar(300),
			created_date varchar(300),
            PRIMARY KEY  (id)
        );";
 
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    dbDelta( $image_table_s );
}
 
register_activation_hook( __FILE__, 'cosp_shortcode_own_database_table' );