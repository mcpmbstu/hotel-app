<?php
require_once('../../../../../wp-config.php');
require_once('../../../../../wp-load.php');
require_once(plugin_dir_path( __FILE__ ) .'../aq_resize.php');

$id = $_POST['id']; 
$grid_view_number = get_option('grid_view_number');
$grid_format = get_option('grid_format');
$img_w = get_option('img_w');
$img_h = get_option('img_h');
$dNumber	= -1; 
$dOrder		= 'DESC';

if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }

if(!empty($id)){ 
$args = array(
	'post_type'  => 'hotel',
	'posts_per_page' 	=> $atts['num'],
	'paged'            	=> $paged,
	'meta_query' => array(
		array(
			'key'     => 'hotel_gener',
			'value'   => $id,
			'compare' => 'LIKE',
		)
	),
); 
}else{
$args = array(
	'post_type'  => 'hotel',
	'posts_per_page' 	=> $dNumber,
	'paged'            	=> $paged
); 	
}
 
query_posts( $args );
?> 
    <!-- .container is main centered wrapper --> 
        <ul class="gridView">
        <?php $i=0; $j=0; while (have_posts()) : the_post();
		$hotel_buzz = get_post_meta( get_the_ID(), 'hotel_buzz', true );
		?>
            <li>
                <div class="he-wrap tpl4">
                <?php if (has_post_thumbnail( $post->ID ) ): ?>        
                <?php 
					$thumb = get_post_thumbnail_id();
                    $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
                    $image = aq_resize( $img_url, $img_w, $img_h, true, true, true, true, true ); //resize & crop img ?>
                    <img src="<?php echo $image ?>" alt="" /> 
                <?php endif; ?>
                    <div class="he-view">
						<div class="bg">
							<div class="a0" style="width: 100%;" data-animate="fadeInDown"></div> 
						</div>
						<div class="content">
							<h3 class="info-title a3" data-animate="fadeInLeft"><?php the_title(); ?></h3>
							<div class="detail a2" data-animate="fadeInUp"><?php echo $hotel_buzz; ?></div>
							<a href="<?php the_permalink(); ?>" class="more a2" data-animate="fadeInRight"><i class="fa fa-info-circle"></i> View Detail</a>
						</div>
					</div><!--he-view--> 
                </div><!--he-wrap-->                         
                <div class="hotel_basic_info"> 
                	<h4><a href="<?php the_permalink(); ?>" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                	<div class="section group">
                    	<div class="col span_5_of_8">
                            <small class="smallClass"><i class="fa fa-clock-o"></i> <strong><?php _e('Open', 'm_hotel'); ?>:</strong> 
                                <?php echo $start_time = get_post_meta( get_the_ID(), 'start_time', true ); ?> <strong><?php _e('to', 'm_hotel'); ?></strong>
                                <?php echo $close_time = get_post_meta( get_the_ID(), 'close_time', true ); ?>
                            </small>
                            <small class="smallClass"><i class="fa fa-calendar"></i> <strong><?php _e('Close', 'm_hotel'); ?>:</strong> 
                                <?php echo $close_day = get_post_meta( get_the_ID(), 'close_day', true ); ?>
                            </small> 
                        </div><!--col-->
                        <div class="col span_3_of_8">
                        	<p class="reservationBtn"><a class='minline' href="#inline_content" id="<?php echo get_the_ID(); ?>" ><?php _e('Reservation','m-hotel'); ?></a></p>
                            <!--<a href="<?php echo plugin_dir_url(__FILE__); ?>inc/ajax/remailApp.php?height=400&width=600" class="thickbox">Subscribe to my blog via Email</a>-->
                        </div><!--col-->
                    </div><!--section-->
                </div><!--hotel_basic_info-->   
            </li><!--item--> 
            <?php  endwhile;?>  
        </ul><!--mGrid--> 
        
        <script type="text/javascript">
        	/*jQuery("#mGrid").gridalicious({selector: '.item', gutter: 15, width: 280, animate: true, animationOptions: {
    	queue: true,
    	speed: 200,
    	duration: 300,
    	effect: 'fadeInOnAppear',
  	}});*/
	
 
 
			jQuery('ul.gridView').AwesomeGrid({
				rowSpacing  : 20,
				colSpacing  : 20,
				initSpacing : 0, 
				responsive  : true,              // itching for responsiveness?
				fadeIn      : true,              // allow fadeIn effect for an element?
				hiddenClass : false,             // ignore an element having this class or false for none
				item        : 'li',              // item selector to stack on the grid
				onReady     : function(item){ },
				columns     : {
					'defaults' : 4,
					'1100' : 3,
					'860' : 2,
					'580' : 1
				},
				context     : 'window'           // resizing context, 'window' by default.
			}); 
        </script>