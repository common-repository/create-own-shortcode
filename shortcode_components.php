<?php 
 class Shortcode_compents
 {
      /*
          * Show the content editor
          */
     public  function cosp_shortcode_content(){
        
            echo '<form method="post" action="" class="content_form">
                 <h3> Create Content Shortcode</h3>
            <div class="newtitle">
            <input type="text"  name="stitle" placeholder="Enter Title Here" required="" >
            </div>';
            
            $content = '';
            $editor_id = 'mycustomeditor';
            wp_editor( $content, $editor_id, array('textarea_rows' => 10) );
            
            echo'<div class="newshort">
            <input type="text"  name="shortcode_title" placeholder="Enter ShortCode title. ex: test_conent" required="" >
            </div>
            <input class="content_button" type="Submit"  name="create_content_code" value="Create Content ShortCode">
            </form>';

 }
   
        /*
         * Show image form for create shortcode
         * After submit insert into databasae
         */
        public function cosp_shortcode_image(){
   
            if(filter_var($_POST['image_inserts'],FILTER_SANITIZE_STRING) != "" ) { 


           $image_url = sanitize_text_field($_REQUEST['ad_image']);
		   
           $tokens = explode('/', $image_url);
           $img_path = '/'.$tokens[sizeof($tokens)-4].'/'.$tokens[sizeof($tokens)-3].'/'.$tokens[sizeof($tokens)-2].'/'.$tokens[sizeof($tokens)-1];
                    global $wpdb;

                $ititle = sanitize_text_field($_REQUEST['ititle']);
                $icaption =  sanitize_text_field($_REQUEST['caption']); 
                $i_alt = sanitize_text_field($_REQUEST['image_alt']); 
                $i_link = sanitize_text_field($_REQUEST['inmag_link']); 
                $i_target = sanitize_text_field($_REQUEST['target']); 
                $i_width = sanitize_text_field($_REQUEST['Width']); 
                $i_height = sanitize_text_field($_REQUEST['Height']); 
                $i_shortcode = sanitize_text_field($_REQUEST['short_code']);
				
				
				
                $cdate = date('Y-m-d H:i:s');
        $imag_path_insert =  "INSERT INTO ".$wpdb->prefix."create_image_shortcode (image_title, image_caption, image_alt, image_link, image_target, image_width, image_height, image_path, image_short_code, created_date) VALUES('$ititle','$icaption','$i_alt','$i_link','$i_target', '$i_width', '$i_height','$img_path','$i_shortcode', '$cdate')";
       
            $wpdb->query($imag_path_insert);
             $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;   
      echo "<script type='text/javascript'>window.parent.location = '$url';</script>";  
?>



<?php } ?>
     

            <div  class="form">
    		<form name="images" action="" method="post">
                    <h3> Create Image Shortcode</h3>
                    <img src="<?php echo plugins_url( 'css/default.png', __FILE__ );?>" id="imgsrc">
    			<p class="contact"><label for="name">Upload Image</label></p> 
                         
                        <input id="upload_image" type="hidden" size="36" name="ad_image"  id="thumbnail" value="http://" /> 
                        <input id="upload_image_button" class="button" type="button" value="Upload Image" />
                       
                        <br><br>
    			<p class="contact"><label for="Title">Image Title</label></p> 
    			<input id="email" name="ititle"  required="" type="text"> 
                
                         <p class="contact"><label>Image Caption</label></p> 
    			<input name="caption" type="text"> 
                        
                        <p class="contact"><label>Image Alt</label></p> 
    			<input name="image_alt"  required=""  type="text"> 
                        <p class="contact"><label>Image Link</label></p> 
                        <input name="inmag_link"    type="text" placeholder="http://example.com"> 
                        <p class="contact"><label>Image Target</label></p> 
    			<select name="target">
                        <option value="_self">Self Window</option>
                          <option value="_blank">New Window</option>
                        </select><br><br>
                        <p class="contact"><label>Width</label></p> 
                        <input name="Width"  type="text" placeholder="ex:100"> 
                        <p class="contact"><label>Height</label></p> 
    			<input name="Height"    type="text" placeholder="ex:100"> 
                        <br>
                        <p class="contact"><label class="short">Short Code Title</label></p> 
                         <input name="short_code"  required="" placeholder="Enter ShortCode title. ex: test_image" type="text"> 
                         <br><br>
                        <input class="buttom" name="image_inserts" id="submit" tabindex="5" value="Create Image ShortCode" type="submit"> 	 
                     </form> 
                    </div>     
          
        <?php    
          }
      /*
       * Displaying List of all shortcodes
       */
        public function  cosp_shorcode_listing()
        {  echo "<h3> Content ShortCodes List</h3>";
        
        ?>

           
<table class="widefat fixed" cellspacing="0">
<thead>
    <tr>
        <th id="columnname" class="manage-column column-title column-primary" scope="col">Title</th>
        <th id="columnname" class="manage-column column-shortcode" scope="col">Shortcode</th> 
        <th id="columnname" class="manage-column column-date" scope="col">Date</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th id="columnname" class="manage-column column-title column-primary" scope="col">Title</th>
        <th id="columnname" class="manage-column column-shortcode" scope="col">Shortcode</th> 
        <th id="columnname" class="manage-column column-date" scope="col">Date</th>
    </tr>
</tfoot>
<tbody data-wp-lists="list:post" id="the-list">
    <?php global $wpdb;
    $shortcodes = $wpdb->get_results("select * from ".$wpdb->prefix."create_own_shortcode ORDER BY id desc");
         $i=1; 
         foreach($shortcodes as $shortcodes_comp){
         
         ?>
    
    <tr>
         <?php   $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;?>
        <td data-colname="Title" class="title column-title has-row-actions column-primary">
             <strong><a title="Edit" href="<?php echo esc_html($url);?>&editshort=content_edit&&edits=<?php echo esc_html($shortcodes_comp->id); ?>" class="row-title"><?php echo esc_html($shortcodes_comp->title);?></a></strong> 
            <div class="row-actions">
               
    <span class="edit"><a href="<?php echo esc_html($url);?>&editshort=content_edit&&edits=<?php echo $shortcodes_comp->id; ?>">Edit</a> | </span>
    <span class="Delete"><a onclick="return confirm('Are you sure want to delete this record?');" href="<?php echo esc_html($url);?>&editshort=content_del&dels=<?php echo esc_html($shortcodes_comp->id); ?>"">Delete</a></span>
            </div>
        </td>
        <td data-colname="Shortcode" class="shortcode column-shortcode">
                <span class="shortcode">
                <input type="text" class="large-text code" value="[<?php echo esc_html($shortcodes_comp->short_code);?>]" readonly="readonly" onfocus="this.select();"></span>
        </td>
    <td data-colname="Date" class="date column-date"><?php echo esc_html($shortcodes_comp->created_date);?></td>
   </tr>
   
   
         <?php 
         
         
         } ?>
</tbody>
</table>

    <h3> Image Shortcodes List</h3>
              
<table class="widefat fixed" cellspacing="0">
<thead>
    <tr>
        <th id="columnname" class="manage-column column-title column-primary" scope="col">Title</th>
        <th id="columnname" class="manage-column column-shortcode" scope="col">Shortcode</th> 
        <th id="columnname" class="manage-column column-date" scope="col">Date</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th id="columnname" class="manage-column column-title column-primary" scope="col">Title</th>
        <th id="columnname" class="manage-column column-shortcode" scope="col">Shortcode</th> 
        <th id="columnname" class="manage-column column-date" scope="col">Date</th>
    </tr>
</tfoot>
<tbody data-wp-lists="list:post" id="the-list">
    <?php global $wpdb;
    $img_shortcodes = $wpdb->get_results("select * from ".$wpdb->prefix."create_image_shortcode ORDER BY id DESC");
         $i=1; 
         foreach($img_shortcodes as $shortcodes_img){
         
         ?>
    
    <tr>
        <?php   $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;                ?>
        <td data-colname="Title" class="title column-title has-row-actions column-primary">
            <strong><a title="Edit" href="<?php echo esc_html($url);?>&editshort=imag_edit&edits=<?php echo esc_html($shortcodes_img->id); ?>" class="row-title"><?php echo esc_html($shortcodes_img->image_title);?><br><img src="<?php echo esc_html(content_url());?>/<?php echo esc_html($shortcodes_img->image_path);?>" width="100" height="90"></a></strong> 
            <div class="row-actions">
                
    <span class="edit"><a href="<?php echo esc_html($url);?>&editshort=imag_edit&edits=<?php echo esc_html($shortcodes_img->id); ?>">Edit</a> | </span>
    <span class="Delete"><a onclick="return confirm('Are you sure want to delete this record?');" href="<?php echo $url;?>&editshort=img_del&&dels=<?php echo esc_html($shortcodes_img->id); ?>"">Delete</a></span>
            </div>
        </td>
        <td data-colname="Shortcode" class="shortcode column-shortcode">
                <span class="shortcode">
                <input type="text" class="large-text code" value="[<?php echo esc_html($shortcodes_img->image_short_code);?>]" readonly="readonly" onfocus="this.select();"></span>
        </td>
    <td data-colname="Date" class="date column-date"><?php echo esc_html($shortcodes_img->created_date);?></td>
   </tr>
   
   
         <?php 
         
         
         } ?>
</tbody>
</table>
    
    <?php     }
    
    /* Content shortcode content edit
     * 
     */
    
     public function cosp_shortcode_conent_edit($edit_id){
         
             global $wpdb;
           $short_content_edit = $wpdb->get_row("select * from ".$wpdb->prefix."create_own_shortcode where id = '$edit_id' ");
           
          echo '<form method="post" action="">
            <div class="newtitle">
            <input type="text"  name="stitle"  value="'.$short_content_edit->title.' ">
            </div>';
            
            $content = $short_content_edit->content;
            $editor_id = 'mycustomeditor';
            wp_editor( $content, $editor_id, array('textarea_rows' => 10) );
            
            echo'<div class="newshort">
            <input type="text"  name="shortcode_title" value="'.$short_content_edit->short_code.'">
            </div>
            <input type="hidden"  name="udateid" value="'.$short_content_edit->id.' ">
            <input type="Submit"  class="content_button"  name="update_content_code" value="Update Content ShortCode">
            
            </form>';
            
            if($_REQUEST['update_content_code']){
				
                $stitle = 		sanitize_text_field($_REQUEST['stitle']);
                $scontent =  	$_REQUEST['mycustomeditor'];
                $short_title =  sanitize_text_field($_REQUEST['shortcode_title']);
                $udateid =  	sanitize_text_field($_REQUEST['udateid']);
				
                global $wpdb;
                $update_content_sc =  "UPDATE ".$wpdb->prefix."create_own_shortcode SET title='$stitle',content='$scontent', short_code='$short_title' where id = '$udateid'  ";
                $wpdb->query($update_content_sc);
                $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;   
                echo "<script type='text/javascript'>window.parent.location = '$url';</script>";  
            }
            
     }
     /*
      * Content shortcode delete
      */
      
            public function cosp_shortcode_conent_del($del_id){
                global $wpdb;
                $del_content_sc =  "DELETE FROM ".$wpdb->prefix."create_own_shortcode  where id = '$del_id'  ";
               $wpdb->query($del_content_sc);
           }

           
           
           /*
            * Image shortcode edite here
            */
     public function cosp_shortcode_img_edit($edit_img_id){
         
             global $wpdb;
           $short_imge_edit = $wpdb->get_row("select * from ".$wpdb->prefix."create_image_shortcode where id = '$edit_img_id' "); ?>
           
                  
        <div  class="form">
    		<form name="images" action="" method="post">
                    <h3> Create Image Shortcode</h3>
                    <img src="<?php echo content_url().'/'.$short_imge_edit->image_path?>" id="imgsrc">
    			<p class="contact"><label for="name">Upload Image</label></p> 
                        <input type="hidden" name="hid_up_image" value="<?php echo esc_html($short_imge_edit->image_path);?>">
                        <input id="upload_image" type="hidden" size="36" name="ad_image"  id="thumbnail" value="" /> 
                        <input id="upload_image_button" class="button" type="button" value="Update Image" />
                       
                        <br><br>
    			<p class="contact"><label for="Title">Image Title</label></p> 
                        <input id="email" name="ititle"  required="" type="text" value="<?php echo esc_html($short_imge_edit->image_title);?>"> 
                
                         <p class="contact"><label>Image Caption</label></p> 
    			<input name="caption" type="text" value="<?php echo esc_html($short_imge_edit->image_caption);?>"> 
                        
                        <p class="contact"><label>Image Alt</label></p> 
    			<input name="image_alt"  required=""  type="text" value="<?php echo esc_html($short_imge_edit->image_alt);?>"> 
                        <p class="contact"><label>Image Link</label></p> 
                        <input name="inmag_link"    type="text" value="<?php  if(empty($short_imge_edit->image_link)) {echo "#";} else { echo esc_html($short_imge_edit->image_link); }?>">  
                        <p class="contact"><label>Image Target</label></p> 
    			<select name="target">
                        <option value="_self" <?php if($short_imge_edit->image_target=="self") echo 'selected="selected"'; ?>>Self Window</option>
                          <option value="_blank" <?php if($short_imge_edit->image_target=="_blank") echo 'selected="selected"'; ?>>New Window</option>
                        </select><br><br>
                        <p class="contact"><label>Width</label></p> 
                        <input name="Width"  type="text" value="<?php echo esc_html($short_imge_edit->image_width);?>" placeholder="ex:100">  
                        <p class="contact"><label>Height</label></p> 
    			<input name="Height"    type="text" placeholder="ex:100" value="<?php echo esc_html($short_imge_edit->image_height);?>">  
                        <br>
                        <p class="contact"><label class="short">Short Code Title</label></p> 
                         <input name="short_code"  required="" placeholder="Short Code title for Display Image" type="text" value="<?php echo esc_html($short_imge_edit->image_short_code);?>">  
                         <br><br>
                         <input type="hidden" name='up_im_id' value="<?php echo esc_html($short_imge_edit->id);?>"> 	
                        <input class="buttom" name="image_updates" id="submit" tabindex="5" value="Update Image ShortCode" type="submit"> 	 
   </form> 
</div>    
           <?php  if($_REQUEST['image_updates']){
               
               
                $ititle = sanitize_text_field($_REQUEST['ititle']);
                $icaption =  sanitize_text_field($_REQUEST['caption']); 
                $i_alt = sanitize_text_field($_REQUEST['image_alt']); 
                $i_link = sanitize_text_field($_REQUEST['inmag_link']); 
                $i_target = sanitize_text_field($_REQUEST['target']); 
                $i_width = sanitize_text_field($_REQUEST['Width']); 
                $i_height = sanitize_text_field($_REQUEST['Height']); 
                $i_shortcode = sanitize_text_field($_REQUEST['short_code']);
                $cdate = date('Y-m-d H:i:s');
                $image_url = sanitize_text_field($_REQUEST['ad_image']);
         if(empty($image_url)){     
              $img_path = $_REQUEST['hid_up_image'];
             echo "else";

         } else { 
            
           $tokens = explode('/', $image_url);
$img_path = '/'.$tokens[sizeof($tokens)-4].'/'.$tokens[sizeof($tokens)-3].'/'.$tokens[sizeof($tokens)-2].'/'.$tokens[sizeof($tokens)-1];
echo "ffff";  
         }            
 $up_img_id = sanitize_text_field($_REQUEST[up_im_id]); 
                global $wpdb;
                $update_img_sc =  "UPDATE ".$wpdb->prefix."create_image_shortcode SET image_title='$ititle',image_caption='$icaption', image_alt='$i_alt',image_link='$i_link',image_target='$i_target',image_width='$i_width',image_height='$i_height' , image_path='$img_path', image_short_code='$i_shortcode' where id = '$up_img_id'  ";
                $wpdb->query($update_img_sc);
                $url=strtok($_SERVER["REQUEST_URI"],'&'); //echo $url;   
                echo "<script type='text/javascript'>window.parent.location = '$url';</script>";  
            }
            
     }
      /*
       * Image shortcode delete
       */
            public function cosp_shortcode_img_del($del_img_id){
                global $wpdb;
                $del_content_sc =  "DELETE FROM ".$wpdb->prefix."create_image_shortcode  where id = '$del_img_id'  ";
               $wpdb->query($del_content_sc);
           }

   
 }
 
 //Object creation
 
 $shortcode_obj = new Shortcode_compents();
 ?>

    
    
<script>
    jQuery(document).ready(function($){
    var custom_uploader;
    $('#upload_image_button').click(function(e) {
        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            console.log(custom_uploader.state().get('selection').toJSON());
            attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#upload_image').val(attachment.url);
             $('#imgsrc').attr('src', attachment.url);
            
        });
        //Open the uploader dialog
        custom_uploader.open();

    });
});
    </script>