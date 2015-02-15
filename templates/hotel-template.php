<?php 
require_once(plugin_dir_path( __FILE__ ) .'../inc/aq_resize.php');
get_header(); ?>
<?php 
$postid = get_the_ID();
$img_w = get_option('img_w');
$img_h = get_option('img_h');
$start_time = get_post_meta( get_the_ID(), 'start_time', true );
$close_time = get_post_meta( get_the_ID(), 'close_time', true );
$close_day = get_post_meta( get_the_ID(), 'close_day', true );
//$kitchen_gener = get_option('kitchen_name');
//$menu_geners = explode("\n", $kitchen_gener);
$hotel_gener = get_post_meta( get_the_ID(), 'hotel_gener', true );
$hotel_buzz = get_post_meta( get_the_ID(), 'hotel_buzz', true );
$ids = get_post_meta($post->ID, 'vdw_gallery_id', true);
$menu_keys = get_post_meta( get_the_ID(), 'menu_keys', true );
$array_key = explode(',', $menu_keys); 
$hotel_address = get_post_meta( get_the_ID(), 'hotel_address', true ); 
$social_links = get_post_meta($post->ID,'social_link',true);
$custom_meta = get_post_meta($post->ID, '_custom-meta-box', true);
//var_dump($custom_meta);
?>

<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
        <div class="m_hote_single">
        <h1 class="m_hotel_title" style="text-align: left;"><?php the_title(); ?></h1>
        <div class="section group">
        	<div class="col span_4_of_12">
            	<?php if (has_post_thumbnail( $post->ID )): ?>
				<?php 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$image = aq_resize( $image[0], 340, 350, true, true, true, true, true ); //resize & crop img ?>
            
                <div class="he-wrap tpl2">
                    <img src="<?php echo $image ?>" style="max-width: 100%;" alt="" /> 
                    <div class="he-view">
                        <div class="bg a0" data-animate="fadeIn">
                            <div class="center-bar">
                            	
                            	<?php
								if(!empty($social_links)){
								$k=0;
                                foreach($social_links as $social_link){
									$title = strtolower($social_link['profile_name']);
									echo '<a href="http://'.$social_link['profile_link'].'" class="'.$title.' a'.$k.'" data-animate="fadeInUp" target="_blank"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-'.$social_link['profile_icon'].' fa-stack-1x fa-inverse"></i></span></a>';
									$k++;	
									}
								}
								?>
                            </div><!--center-bar-->
                        </div><!--bg-->
                    </div><!--he-view-->
                </div><!--he-wrap-->

                <?php endif; ?>
			<p class="shortAddress"><i class="fa fa-map-marker fa-fw"></i> <?php _e('Address:','m-hotel'); ?> <?php echo $hotel_address; ?></p>
            <?php if(!empty($custom_meta)){ ?><p class="reserveAvail"><i class="fa fa-calendar-o fa-fw"></i> <?php _e('Available','m-hotel'); ?></p><?php }else{ ?><p class="reserveAvail reserveAvailNot"><i class="fa fa-calendar-o fa-fw"></i> <?php echo 'Not Available'.'</p>'; } ?>
            <p class="reserveLink"><i class="fa fa-bell fa-fw"></i> <a class='minline' href="#inline_content" id="<?php echo get_the_ID(); ?>" ><?php _e('Get Reservation','m-hotel'); ?></a></p>
            
            </div><!--span_4_of_12-->
            <div class="col span_6_of_12">
            	<div id="galleryBlock">
                	<div class="zoom-gallery">
                	<?php if(!empty($ids)){ ?> 
						<?php $b=0;
                            foreach($ids as $id):
                                if($b>8) break;
                                $attachment_id = $id; // attachment ID
                                $image_attributes = wp_get_attachment_image_src( $attachment_id,'full' ); // returns an array
                                $image_s = aq_resize( $image_attributes[0], 80, 80, true, true, true, true, true ); 
                                if( $image_attributes ) { ?>
                                <a href="<?php echo $image_attributes[0]; ?>" title="<?php echo $image_attributes[2]; ?>" ><img src="<?php echo $image_s; ?>" alt="" /></a>
                        <?php } $b++;  endforeach;  ?> 
                    <?php } ?>
                    </div> 
                </div><!--galleryBlock-->

                <h3 class="hotel-block-title"><?php _e('Hotel Description','m-hotel'); ?></h3>
            	<div class="m_description">
                	<?php 
						$content = get_post_field('post_content', $postid);
						echo '<p>'.wp_filter_nohtml_kses( $content ).'</p>'; //or strip_tags
					?>
                </div><!--m_description-->
                <h3 class="hotel-block-title"><?php _e('Hotel Information','m-hotel'); ?></h3>
                <div class="m_description m_no_border">
                	<p>
                    	<span class="title-name"><i class="fa fa-clock-o fa-fw fa-space"></i> <?php _e('Open:','m-hotel'); ?></span> <span class="info-short"><?php echo $start_time; ?></span> 
                    	<span class="title-name"><?php _e('to','m-hotel'); ?></span> <span class="info-short"><?php echo $close_time; ?> <?php _e('every day','m-hotel'); ?></span><br />
                    	<span class="title-name"><i class="fa fa-calendar fa-fw fa-space"></i> <?php _e('Closed:','m-hotel'); ?></span> <span class="info-short"><?php echo $close_day; ?></span> <br />
						<span class="title-name"><i class="fa fa-cutlery fa-fw fa-space"></i>  <?php _e('Kitchen:','m-hotel'); ?></span> <?php echo $hotel_gener; ?><br />
						<span class="title-name"><i class="fa fa-birthday-cake fa-fw fa-space"></i> <?php _e('Feature:','m-hotel'); ?></span>
                        <?php 
						foreach($array_key as $key):
							echo $key.',';
						endforeach; 
						?> 	 
                    </p> 
                </div><!--m_description-->
            </div><!--span_6_of_12-->
        </div><!--section-->
        <hr class="m_blank_line" />
        <div class="section group">
        	<h3 class="hotel-block-title"><?php _e('Hotel BUZZ','m-hotel'); ?></h3>
        	<div class="m_hotel_buzz">
				<?php echo $hotel_buzz; ?>
            </div><!--m_description-->
        </div><!--section-->
        </div><!--m_hote_single-->
            <div style='display:none'>
                <div id='inline_content' style='padding:10px; background:#fff;'>            	
            </div><!--inline_content-->
        </div> <!--end-->
		</div><!-- #content -->
	</div><!-- #primary -->
<script type="text/javascript">
jQuery(document).ready(function(){	
	var arrayReserv;
	var checkContent = null;
	jQuery(document.body).on('click', '.minline', function(e){
	var menuId = jQuery(this).attr('id'); 
	  //alert( menuId ); // or $(this).val() 
	  jQuery.ajax({
			type: "POST",
			url: "<?php echo plugin_dir_url(__FILE__); ?>../inc/ajax/remainApp.php",
			data: {id: menuId},
			dataType:"html",
			success: function(data){ 
				 checkContent = data;
				 jQuery('#inline_content').html(checkContent);
				 jQuery.colorbox({
					 inline:true, 
					 width:"auto", 
					 overlayClose: false,
					 escKey: false,
					 href:"#inline_content"
				});	// colorbox 
			}
		});
		e.preventDefault();
	});
	
	jQuery(document.body).on('click', '.reserve_form', function(e){
	  var menuId = jQuery(this).attr('id');  
	  	// array of checkbox for sending AJAX
		arrayReserv = jQuery("#reserveForm input:checkbox:checked").map(function(){
			return jQuery(this).val();
		}).toArray();
		if(arrayReserv.length>0){
	  jQuery.ajax({
			type: "POST",
			url: "<?php echo plugin_dir_url(__FILE__); ?>reserve-template.php",
			data: {id: menuId, ids: arrayReserv },
			dataType:"html",
			success: function(data){ 
				checkContent = data;
					 jQuery('#inline_content').html(checkContent);
					 jQuery.colorbox({
						 inline:true, 
						 width:"auto",  
						 overlayClose: false,
						 escKey: false,
						 scrolling: false,
						 href:"#inline_content"
				});	// colorbox
			} 
		});
		e.preventDefault();
		}else{
		 jQuery('.hideClass').fadeIn(300).addClass('errorClass');	
		}
	});
	
	
	jQuery(document.body).on('click', '.reserveBtm', function(e){
		var menuId = jQuery(this).attr('id');
		var isValid = true;
		jQuery('input[type="text"].required, input[type="email"].required, input[type="number"].required').each(function() {
			if (jQuery.trim(jQuery(this).val()) == ''){
				isValid = false;
				jQuery(this).css({"border": "1px solid red","background": "#FFCECE"});
			}
			else {
				jQuery(this).css({"border": "", "background": ""});
			}
		});
		if (isValid == false){ 
			e.preventDefault();
		}else{ 			
			mTitle = jQuery("#m_title").val(),
			postId=jQuery("#m_postId").val(),
			mName=jQuery("#m_name").val(),
			mEmail=jQuery("#m_email").val(),
			phone=jQuery("#m_phone").val(),
			number=jQuery("#m_number").val(),
			mMessage=jQuery("#m_message").val(),
			mReserv=arrayReserv;
		
		   jQuery.ajax({
				type: "POST",
				url: "<?php echo plugin_dir_url(__FILE__); ?>reserved.php", 
				data: {
					mTitle: mTitle,
					postId: postId,
					mName: mName,
					mEmail: mEmail,
					phone: phone,
					number: number,
					mMessage: mMessage,
					mReserv: arrayReserv
				},
				dataType:"html",
				success: function(data){ 
						jQuery('.reservationForm').hide();						
						jQuery('#inline_content').html(data);
						 jQuery.colorbox({
							 inline:true, 
							 width:"25%",  
							 overlayClose: false,
							 escKey: false,
							 href:"#inline_content"
						});	// colorbox
					}	// end success
			});	// end Ajax
			e.preventDefault();
		}	// end else work
		e.preventDefault();
	});	// .reserveBtm 
			
});	// end DOcument.Ready
</script> 
<?php get_footer(); ?>