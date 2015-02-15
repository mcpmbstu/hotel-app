<?php
 $labels = array( 
        'name' => _x( 'Hotels', 'hotel' ),
        'singular_name' => _x( 'Hotel', 'hotel' ),
        'add_new' => _x( 'Add New', 'hotel' ),
        'add_new_item' => _x( 'Add New Hotel', 'hotel' ),
        'edit_item' => _x( 'Edit Hotel', 'hotel' ),
        'new_item' => _x( 'New Hotel', 'hotel' ),
        'view_item' => _x( 'View Hotel', 'hotel' ),
        'search_items' => _x( 'Search Hotels', 'hotel' ),
        'not_found' => _x( 'No hotels found', 'hotel' ),
        'not_found_in_trash' => _x( 'No hotels found in Trash', 'hotel' ),
        'parent_item_colon' => _x( 'Parent Hotel:', 'hotel' ),
        'menu_name' => _x( 'Hotels', 'hotel' ),
    );
	
	// Supports
    $supports = array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes' );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,            
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,        
        'menu_icon' => '',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
		'supports' => $supports,
        'rewrite' => array( 'slug' => 'hotel', 'with_front' => true ),
        'capability_type' => 'post'
    );

register_post_type( 'hotel', $args );
	
// this is Extra Meta Box
add_action( 'add_meta_boxes', 'hotel_extra_box' );
function hotel_extra_box() {
    add_meta_box( 
        'hotel_extra_box',
        __( '<i class="fa fa-bank fa-lg"></i> Hotel Extra Info.', 'm_hotel' ),
        'hotel_box_content',
        'hotel',
        'normal',
        'high'
    );
}


// this is Choose Menu Meta Box
add_action( 'add_meta_boxes', 'hotel_extra_box_two' );
function hotel_extra_box_two() {
    add_meta_box( 
        'hotel_extra_box_two',
        __( '<i class="fa fa-list-alt fa-lg"></i> Choose Menu From lists', 'm_hotel' ),
        'hotel_box_content_two',
        'hotel',
        'side',
        'default'
    );
}


function hotel_box_content_two($post){
	global $wpdb;	
  	wp_nonce_field( plugin_basename( __FILE__ ), 'hotel_box_content_nonce' );
	$menu_keys = get_post_meta( get_the_ID(), 'menu_keys', false );
	 
    $string_key = $menu_keys[0];
    $array_key = explode(',', $string_key); 
    $totalSelect = count($array_key);   
	$menus = $wpdb->get_results( "SELECT * FROM wp_menus"); 
	$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM wp_menus" ); 
	
	$result = array();
	foreach ($menus as $key => $value) {
		$result[] = $value->menu_name;
	}
	$total = count($result); 
	echo '<select name="menu_keys[]" id="menu_keys" multiple="yes" size="8" style="width: 100%;">';
	$j=0;
	for($i=0; $i<$total;$i++){ 
		if($j<$totalSelect)
		$tmp_key = $array_key[$j];										
		if(strcmp($tmp_key, $result[$i])==0){
			echo '<option value="'.$result[$i].'" selected="selected" class="selectedClass">'.$result[$i].'</option>';
			$j++;
		}else{ 
			echo '<option value="'.$result[$i].'"  >'.$result[$i].'</option>';		
		 }	// end if statement
	}	// end foreach
	echo '</select>'; 			
    ?> 
        
    <p><strong>Keywords</strong></p>
        <div id="keywordsMenu">                                
        <?php  
            for($k=0; $k<$totalSelect;$k++){
                 echo '<a href="#" class="buttonLink" id="" >'.$array_key[$k].'</a>';
            }
        ?>
        <div style="clear: both;"></div>        
    </div><!--keywordsMenu-->        
<?php }


function hotel_box_content( $post ) {
  global $wpdb;	
  //$menuTable	= $wpdb->prefix . "hotel_menus";
  wp_nonce_field( plugin_basename( __FILE__ ), 'hotel_box_content_nonce' );
  $kitchen_gener = get_option('kitchen_name');
  $menu_geners = explode("\n", $kitchen_gener);
  
  $hotel_gener = get_post_meta( get_the_ID(), 'hotel_gener', true );
  $author_name = get_post_meta( get_the_ID(), 'author_name', true );
  $author_email = get_post_meta( get_the_ID(), 'author_email', true );
  $close_day = get_post_meta( get_the_ID(), 'close_day', true );
  $start_time = get_post_meta( get_the_ID(), 'start_time', true );
  $close_time = get_post_meta( get_the_ID(), 'close_time', true );
  $total_seat = get_post_meta( get_the_ID(), 'total_seat', true );
  $seat_price = get_post_meta( get_the_ID(), 'seat_price', true );  
  $hotel_buzz = get_post_meta( get_the_ID(), 'hotel_buzz', true );
  $hotel_gener = get_post_meta( get_the_ID(), 'hotel_gener', true );
  $hotel_address = get_post_meta( get_the_ID(), 'hotel_address', true ); 
  $social_links = get_post_meta(get_the_ID(),'social_link',true);
  
	// Get post meta value using the key from our save function in the second paramater.
	$custom_meta = get_post_meta($post->ID, '_custom-meta-box', true);
	//print_r( $custom_meta); 
	$tGmt='am';
	$k1=0; 
  ?>
  
  <div class="section group custom-group">
        <div class="col span_6_of_12">
			<p><i class="fa fa-male"></i> <strong>Kitchen Gener</strong></p>
            <?php //echo $hotel_gener; ?>
            <select id="hotel_gener" name="hotel_gener">
            	<?php 
				//print_r($menu_geners);
				foreach($menu_geners as $menu_gener){
					$menu_gener = trim(preg_replace('/\s\s+/', ' ', $menu_gener));
					 ?>
                	<option <?php if($menu_gener==$hotel_gener){ echo 'selected="selected"'; } ?>  value="<?php echo $menu_gener; ?>"><?php echo $menu_gener; ?></option>                        
                <?php } ?>
            </select>
            <strong><i class="fa fa-bed"></i> Total Seat</strong>
            <input type="number" id="total_seat" name="total_seat" value="<?php echo $total_seat; ?>"  /> 
            
            <strong>Seat Price (<i class="fa fa-usd"></i>)</strong>
            <input type="number" id="seat_price" name="seat_price" value="<?php echo $seat_price; ?>"  />
        </div><!--span_6_of_12-->  
        <div class="col span_6_of_12">
        	<p><i class="fa fa-envelope"></i> <strong>Address</strong></p>
            <textarea name="hotel_address" id="hotel_address" style="height: 131px;"><?php echo $hotel_address; ?></textarea>
        </div><!--span_6_of_12--> 
  </div><!--section-->
  
  <div class="section group custom-group">
  		<div class="col span_3_of_12">
        	<p><i class="fa fa-male"></i> <strong>Authority Name</strong></p>
            <input type="text" id="author_name" name="author_name" placeholder="enter name" value="<?php echo $author_name; ?>"  />
        </div><!--span_4_of_12--> 
        <div class="col span_3_of_12">
            <p><i class="fa fa-envelope"></i> <strong>Email</strong></p>
            <input type="email" id="author_email" name="author_email" placeholder="enter email" value="<?php echo $author_email; ?>"  />
        </div><!--span_4_of_12--> 
        <div class="col span_3_of_12">
        	<p><i class="fa fa-clock-o"></i> <strong>Closing Day</strong></p>
            <?php echo '<input type="text" id="hero-demo" name="close_day" value="'.$close_day.'" placeholder="enter a day" />'; ?>
        </div><!--span_3_of_12-->
        <div class="col span_1_of_12">
            <p><strong>From</strong></p> 
            <input type="text" id="date_timepicker_start" name="start_time" value="<?php echo $start_time; ?>"  />
        </div><!--span_1_of_12--> 
        <div class="col span_1_of_12">
            <p><strong>To </strong></p>
            <input type="text" id="date_timepicker_end" class="closeTime" name="close_time" value="<?php echo $close_time; ?>"  />
            <!--<input type="hidden" id="endTime" value="" />-->
            <input type="hidden" id="s_time" value="<?php echo $start_time; ?>" />
            <input type="hidden" id="e_time" value="<?php echo $close_time; ?>" />
            <input type="hidden" id="scriptUrl" value="<?php echo plugin_dir_url(__FILE__) . 'ajax/timePage.php'; ?>" />
        </div><!--span_1_of_12-->
        <div style="clear: both;"></div>
        <h2 style="padding-left: 0; margin-bottom: 0;"><i class="fa fa-cutlery fa-fw fa-lg"></i><?php _e('Select Available Time Slot','m-hotel'); ?></h2>
        <div id="ajaxTime">
        	<div class="col span_12_of_12">
                
                <?php 
                $totalTime = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
                $wCurrent= intval($start_time);
                for($w=$wCurrent;$w<=intval($close_time);$w++){ ?>
                    <div class="ourCols firstCol">
                    <input type="checkbox" name="custom-meta-box[]" value="<?php echo $totalTime[$w]; ?>" <?php if($custom_meta[$k1]==$totalTime[$w]){ echo 'checked="checked"'; $k1++; } ?>  /><strong><?php echo $totalTime[$w]; ?>.00 <?php echo $tGmt; ?></strong>
                    </div><!--end-->
                    <?php if(intval($totalTime[$w])==11){ $tGmt='pm'; } ?>
                <?php } ?>			
            </div>	<!--span_12_of_12-->
        </div> 
             
  </div><!--section-->
  
   <div class="section group custom-group">    
        <div class="col span_12_of_12">
   			<h2 style="padding-left: 0; margin-top: 10px;"><i class="fa fa-comments fa-lg fa-fw"></i> <?php _e('Hotel Buzz','m-hotel'); ?></h2>
    		<textarea name="hotel_buzz" id="hotel_buzz" rows="5"><?php echo $hotel_buzz; ?></textarea>
        </div>  <!--span_12_of_12-->     
   </div><!--section-->
	
	<?php
	/***** ADD Repeater Feature for Social   *********/
	//if(!empty($social_links)){
		require_once(plugin_dir_path( __FILE__ ) .'repeater.php');
	//}
	?>   
    
<?php 	
}

// This Custom Gallery Meta Box
 function add_gallery_metabox() { 
 
      add_meta_box(
        'gallery-metabox',
		__( '<i class="fa fa-camera-retro fa-lg"></i> Hotel Gallery', 'm_hotel' ),
        'gallery_meta_callback',
        'hotel',
        'normal',
        'core'
      ); 
  }
  add_action('add_meta_boxes', 'add_gallery_metabox');

  function gallery_meta_callback($post) {
    //wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
	global $wpdb;	
  	wp_nonce_field( plugin_basename( __FILE__ ), 'gallery_meta_nonce' );
    $ids = get_post_meta($post->ID, 'vdw_gallery_id', true);

    ?>
    <table class="form-table">
      <tr><td>
        <a class="gallery-add button button-primary" href="#" data-uploader-title="Add image(s) to gallery" data-uploader-button-text="Add image(s)">Add image(s)</a>

        <ul id="gallery-metabox-list">
        <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>

          <li>
            <input type="hidden" name="vdw_gallery_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
            <img class="image-preview" src="<?php echo $image[0]; ?>">
            <div class="fakeDiv"></div>
            <a class="change-image changeClass" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><i class="fa fa-camera fa-lg"></i></a>
            <small class="removeClass"><a class="remove-image" href="#"><i class="fa fa-remove fa-lg"></i></a></small>
          </li>

        <?php endforeach; endif; ?>
        </ul>

      </td></tr>
    </table>
  <?php }
  
  



add_action( 'save_post', 'hotel_box_save' );
function hotel_box_save( $post_id ) {
	
  if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], plugin_basename( __FILE__ ))) return;	
  
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['hotel_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'hotel' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  
  
  if(isset($_POST['vdw_gallery_id'])) {
      update_post_meta($post_id, 'vdw_gallery_id', $_POST['vdw_gallery_id']);
    } else {
      delete_post_meta($post_id, 'vdw_gallery_id');
    }
	
  // This for Multiple Checkbox Update area	
  $custom = $_POST['custom-meta-box'];
  if(!empty($custom)) 
  update_post_meta( $post_id, '_custom-meta-box', $custom );
  
  
  $hotel_gener = $_POST['hotel_gener']; 
  $author_name 	= $_POST['author_name'];
  $author_email = $_POST['author_email'];
  $close_day 	= $_POST['close_day'];
  $start_time 	= $_POST['start_time'];
  $close_time 	= $_POST['close_time'];
  $total_seat	= $_POST['total_seat'];
  $seat_price	= $_POST['seat_price'];
  $hotel_buzz 	= $_POST['hotel_buzz'];
  $menu_keys 	= $_POST['menu_keys'];  
  $hrs			= $_POST['hrs'];
  $hotel_address= $_POST['hotel_address']; 	
  
  $social_link = $_POST['social_link'];
  if(!empty($social_link)) 
  update_post_meta($post_id,'social_link',$social_link);
  
  update_post_meta( $post_id, 'hotel_gener', $hotel_gener );
  update_post_meta( $post_id, 'author_name', $author_name );
  update_post_meta( $post_id, 'author_email', $author_email );
  update_post_meta( $post_id, 'close_day', $close_day );
  update_post_meta( $post_id, 'start_time', $start_time );
  update_post_meta( $post_id, 'close_time', $close_time );
  update_post_meta( $post_id, 'total_seat', $total_seat );
  update_post_meta( $post_id, 'seat_price', $seat_price );
  update_post_meta( $post_id, 'hotel_buzz', $hotel_buzz );
  update_post_meta( $post_id, 'hotel_address', $hotel_address );
  
  $menu_keys = implode(',', $_POST['menu_keys']);
  update_post_meta($post_id, 'menu_keys', $menu_keys);
}

?>