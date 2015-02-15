<?php
/*
Plugin Name: Hotel App.
Plugin URI: http://www.mamuncse.co.nr/
Description: Custom Hotel/Restaurant Reservation wordpress plugin
Version: 1.0.2
Author: Mamunuzzaman
Author URI: http://www.mamuncse.co.nr/
License: GPL
*/
/*
|--------------------------------------------------------------------------
| CONSTANTS TABLE CREATED
|--------------------------------------------------------------------------
*/
function bd_union_table_install(){
	global $wpdb;
$charset_collate = $wpdb->get_charset_collate();
$hotel_menus_table = $wpdb->prefix . 'menus';
$table_reservations = $wpdb->prefix . 'reservations';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$hotel_menus_table'" ) != $hotel_menus_table ) {
	$sql = "CREATE TABLE $hotel_menus_table (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  menu_name varchar(55) NOT NULL,
	  PRIMARY KEY (id)
	) $charset_collate;";
	
	//reference to upgrade.php file
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_reservations'" ) != $table_reservations ) {
	$sql = "CREATE TABLE $table_reservations (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  post_id int(10) NOT NULL,
	  post_title varchar(55) NOT NULL, 
	  title varchar(55) NOT NULL,
	  name varchar(55) NOT NULL,
	  email varchar(255) NOT NULL,
	  phone varchar(55) NOT NULL,
	  people varchar(10) NOT NULL,
	  message varchar(255) NOT NULL,
	  reserved_date varchar(55) NOT NULL,
	  created DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
	  PRIMARY KEY (id)
	) $charset_collate;";
	
	//reference to upgrade.php file
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
 }	
}

//end of plugin installation
register_activation_hook( __FILE__, 'bd_union_table_install' );

define('ROOTDIR', plugin_dir_path(__FILE__));
define('ROOTDIR_PLUGIN', plugin_dir_url(__FILE__));
define('INFOSAVE', 'Information Saved');
/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/ 
if ( ! defined( 'M_HOTEL_RESERVE_FILE' ) )
    define( 'M_HOTEL_RESERVE_FILE', __FILE__ );
if ( ! defined( 'M_HOTEL_RESERVE_DIR' ) )
    define( 'M_HOTEL_RESERVE_DIR', dirname( M_HOTEL_RESERVE_FILE ) );
if ( ! defined( 'M_HOTEL_PLUGIN_URL' ) )
    define( 'M_HOTEL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/ 
add_filter( 'template_include', 'rc_tc_template_chooser'); 
/*
|--------------------------------------------------------------------------
| PLUGIN FUNCTIONS
|--------------------------------------------------------------------------
*/ 
/**
 * Returns template file
 *
 * @since 1.0
 */ 
function rc_tc_template_chooser( $template ) {
 
    // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'hotel' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return rc_tc_get_template_hierarchy( 'hotel-template' );
    }
 
}	

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function rc_tc_get_template_hierarchy( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'hotel_template/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = M_HOTEL_RESERVE_DIR . '/templates/' . $template;
    } 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}
 
/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/
 
add_filter( 'template_include', 'rc_tc_template_chooser' );	
/*
|--------------------------------------------------------------------------
| ENQUEUE SCRIPTS AND STYLE FOR ADMIN
|--------------------------------------------------------------------------
*/
function h_reservation_scripts() {     
	wp_enqueue_style('h-fontawasome-base', plugins_url( '/assets/css/font-awesome.min.css', __FILE__ ), array(),'all');
	wp_enqueue_style('h-grid-repeater', plugins_url( '/assets/css/grid-repeater.css', __FILE__ ), array(),'all');
	wp_enqueue_script('reservation-custom-js', plugin_dir_url(__FILE__) . 'assets/js/custom.js', array('jquery'),'1.0', false);  
	wp_enqueue_script('m-jquery.datetimepicker-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.datetimepicker.js', array('jquery'),'', true);
	wp_enqueue_script('m-autocom-js', plugin_dir_url(__FILE__) . 'assets/js/jquery.auto-complete.min.js', array('jquery'),'', true);
	
	wp_enqueue_style('m-reservation-base', plugins_url( '/assets/css/reservation-base.css', __FILE__ ), array(),'all');
	wp_enqueue_style('m-grid-css', plugins_url( '/assets/css/grid-css.css', __FILE__ ), array(),'all');	
	wp_enqueue_style('m-datetime-base', plugins_url( '/assets/css/jquery.datetimepicker.css', __FILE__ ), array(),'all'); 
	
	/*** Add Gallery Plugin ****/
	wp_enqueue_script('gallery-metabox', plugin_dir_url(__FILE__) . '/assets/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
	wp_enqueue_style('gallery-metabox', plugin_dir_url(__FILE__) . 'assets/css/gallery-metabox.css');
	
	/*wp_enqueue_script('m-sweet-alert.min', plugin_dir_url(__FILE__) . 'assets/js/sweet-alert.min.js', array('jquery'),'', false);
	wp_enqueue_style('m-sweet-alert', plugin_dir_url(__FILE__) . 'assets/css/sweet-alert.css');*/
	
	wp_enqueue_style('h-magnific-popup', plugins_url( '/assets/magnific-popup/magnific-popup.css', __FILE__ ), array(),'all'); 	
	wp_enqueue_script('m-jquery.magnific-popup', plugin_dir_url(__FILE__) . 'assets/magnific-popup/jquery.magnific-popup.min.js', array('jquery'),'', false);
		
}

add_action( 'admin_enqueue_scripts', 'h_reservation_scripts' ); 

/*
|--------------------------------------------------------------------------
| ENQUEUE SCRIPTS AND STYLE FOR FRONT-END
|--------------------------------------------------------------------------
*/
function h_hotel_scripts() { 
	wp_enqueue_style('h-fontawasome-base', plugins_url( '/assets/css/font-awesome.min.css', __FILE__ ), array(),'all'); 	
	wp_enqueue_script('m-modernizr', plugin_dir_url(__FILE__) . 'assets/js/modernizr.custom.js', array('jquery'), false);
	
	/**** THIS IS IMAGE POPUP CSS ****/
	wp_enqueue_style('h-magnific-popup', plugins_url( '/assets/magnific-popup/magnific-popup.css', __FILE__ ), array(),'all'); 	
	
	/**** THIS IS STYLE GRID CSS ****/
	wp_enqueue_style('hotel-grid', plugin_dir_url(__FILE__) . 'assets/css/grid-theme.css');
	
	/**** THIS IS HOVER IMAGE CSS ****/
	wp_enqueue_style('m-hoverex-all', plugin_dir_url(__FILE__) . 'assets/css/hoverex-all.css');
	wp_enqueue_style('m-templates', plugin_dir_url(__FILE__) . 'assets/css/templates.css');
	
	/**** THIS IS MODAL SCRIPT AND CSS ****/
	wp_enqueue_style('m-colorbox', plugin_dir_url(__FILE__) . 'assets/colorbox.css');
	wp_enqueue_script('m-jquery.colorbox', plugin_dir_url(__FILE__) . 'assets/js/jquery.colorbox.js', array('jquery'),'', false);
	wp_enqueue_script('m-jquery.magnific-popup', plugin_dir_url(__FILE__) . 'assets/magnific-popup/jquery.magnific-popup.min.js', array('jquery'),'', false);
	
	/**** THIS IS FLUID GRID SCRIPT and CSS ****/
	wp_enqueue_style('hotel-set-grid', plugin_dir_url(__FILE__) . 'assets/css/set2.css');
	wp_enqueue_script('m-jquery.isotope.min', plugin_dir_url(__FILE__) . 'assets/js/jquery.isotope.min.js', array('jquery'),'', true);
	wp_enqueue_script('m-jquery.isotope.perfectmasonry', plugin_dir_url(__FILE__) . 'assets/js/jquery.isotope.perfectmasonry.js', array('jquery'),'', true);
	
	wp_enqueue_script('m-blocksit.min', plugin_dir_url(__FILE__) . 'assets/js/awesome-grid-1.0.2.min.js', array('jquery'),'', false);

	/**** THIS IS IMAGE HOVER STYLE ****/
	wp_enqueue_script('m-jquery.hoverex', plugin_dir_url(__FILE__) . 'assets/js/jquery.hoverex.min.js', array('jquery'), false); 
	wp_enqueue_script(
        'theme-m-custom', // name your script so that you can attach other scripts and de-register, etc.
        plugin_dir_url(__FILE__) . 'assets/js/custom-theme.js', // this is the location of your script file
        array('jquery') // this array lists the scripts upon which your script depends
    );
	
	wp_enqueue_script(
        'theme-footer-custom', // name your script so that you can attach other scripts and de-register, etc.
        plugin_dir_url(__FILE__) . 'assets/js/footer-custom.js', // this is the location of your script file
        array('jquery'), // this array lists the scripts upon which your script depends
		true, true, true
    );
	
}
add_action( 'wp_enqueue_scripts', 'h_hotel_scripts' ); 

/*
|--------------------------------------------------------------------------
| ADMIN MENU
|--------------------------------------------------------------------------
*/
require_once(plugin_dir_path( __FILE__ ) .'inc/pages.php'); 

/**** Create Custom Post Type And Extra Field  ***********/
add_action( 'init', 'register_cpt_hotel' );	
function register_cpt_hotel() {
	require_once(plugin_dir_path( __FILE__ ) .'inc/hotelExtra.php');   
} 

/**** Custom Admin Menu Icon Function ***********/
function add_menu_icons_styles(){ ?> 
<style>
#adminmenu .menu-icon-hotel div.wp-menu-image:before { content: '\f513'; }
#adminmenu .toplevel_page_h-reservation-menu div.wp-menu-image:before{ content: '\f488'; }
</style>
<?php }
add_action( 'admin_head', 'add_menu_icons_styles' );
 
    
 

/**** Reservation Function ***********/
function h_menu_reservation(){	
	require_once(plugin_dir_path( __FILE__ ) .'inc/settings.php');
}

function h_reservation_list(){
	 
	require_once(plugin_dir_path( __FILE__ ) .'inc/reservation-list.php'); 
	
}

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once(plugin_dir_path( __FILE__ ) .'inc/tableList.php');
}





function h_master_data(){ 
	require_once(plugin_dir_path( __FILE__ ) .'inc/addmenu.php');    
}

// Output Function
function list_of_hotel($atts, $content=null){
require_once(plugin_dir_path( __FILE__ ) .'inc/pagination.php');
require_once(plugin_dir_path( __FILE__ ) .'inc/aq_resize.php');
// Default Values
global $wpdb;
global $post;
//$menuTable	= $wpdb->prefix . "hotel_menus";
$grid_view_number = get_option('grid_view_number');
$grid_format = get_option('grid_format');
$kitchen_gener = get_option('kitchen_name');
$menu_geners = explode("\n", $kitchen_gener);
$img_w = get_option('img_w');
$img_h = get_option('img_h');
$hotel_gener = get_post_meta( get_the_ID(), 'hotel_gener', true );  

$dNumber	= -1; 
$dOrder		= 'DESC';

if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

$atts = shortcode_atts(
	array(
		'num' 		=> $dNumber,
		'order'		=> $dOrder, 
	), $atts, 'hotel_lists' ); 

$args = array( 
		'post_type' 		=> 'hotel',
		'posts_per_page' 	=> $atts['num'],
		'paged'            	=> $paged
	);
query_posts( $args ); 	
if($grid_format=='grid'){
	
?>
<div style="margin: auto; width: 100%; max-width:100%;">
<div class="pagination">
<?php if (function_exists("wpex_pagination")) {
    wpex_pagination();
} ?>
</div><!--pagination-->
<span style=" float: right;"><strong><?php _e('Sort List:','m-hotel'); ?></strong> <select name="ajax_grid" id="ajaxGrid">
	<option value="0">Show All</option>
    <?php foreach($menu_geners as $menu_gener){ ?>
        <option value="<?php echo $menu_gener; ?>"><?php echo $menu_gener; ?></option>                        
    <?php } ?>
</select>
</span>                                       
<div style="clear: both;"></div>
    <div id="ajaxContent" class="main">             
        <!-- .container is main centered wrapper --> 
        <!--<div class="section group">-->
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
                        <a href="#"><img src="<?php echo $image ?>" alt="" /></a> 
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
					</div>
                    </div><!--e-wrap-->
                    <div class="hotel_basic_info"> 
                	<h4><a href="<?php the_permalink(); ?>" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                	<div class="section group">
                    	<div class="col span_5_of_8">
                            <small class="smallClass"><i class="fa fa-clock-o"></i> <strong><?php _e('Open', 'm_hotel'); ?>:</strong> 
                                <?php echo $start_time = get_post_meta( get_the_ID(), 'start_time', true ); ?> <strong><?php _e('to', 'm_hotel'); ?></strong>
                                <?php echo $close_time = get_post_meta( get_the_ID(), 'close_time', true ); ?></small>
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
    </div><!--ajaxContent-->
    <div style='display:none'>
        <div id='inline_content' style='padding:10px; background:#fff;'></div><!--inline_content-->
    </div> <!--end-->
</div><!--container--> 
<!--<script src="<?php echo  plugin_dir_url(__FILE__) . 'assets/js/grid.js'; ?>"></script>-->
<script type="text/javascript">
/*jQuery(function() {
	Grid.init();
});*/

</script>

<script type="text/javascript">
jQuery(document).ready(function(){	
	var arrayReserv;
	jQuery('#ajaxGrid').on('change', function(e) {
	  //alert( this.value ); // or $(this).val()
	  var menuId = jQuery(this).val(); 
	  //if(menuId !=0){
	  jQuery.ajax({
			type: "POST",
			url: "<?php echo plugin_dir_url(__FILE__); ?>inc/ajax/ajaxPost.php",
			data: {id: menuId},
			dataType:"html",
			beforeSend: function() {
              	jQuery('#ajaxContent').html('<div id="loading"><i class="fa fa-cog fa-spin fa-4x"></i></div>'); 
           },
			success: function(data){ 
				jQuery('#ajaxContent').html(data); 
			}
		}); 
		e.preventDefault();			
	});
	
	
	var checkContent = null;
	jQuery(document.body).on('click', '.minline', function(e){
	var menuId = jQuery(this).attr('id'); 
	  //alert( menuId ); // or $(this).val() 
	  jQuery.ajax({
			type: "POST",
			url: "<?php echo plugin_dir_url(__FILE__); ?>inc/ajax/remainApp.php",
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
			url: "<?php echo plugin_dir_url(__FILE__); ?>templates/reserve-template.php",
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
				url: "<?php echo plugin_dir_url(__FILE__); ?>templates/reserved.php", 
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
<?php wp_reset_query(); } // end the Grid View ?>                    
<?php if($grid_format=='full'){ ?>
<div style="clear: both;"></div> 
<?php $totalMenus = $wpdb->get_results("SELECT * FROM {$menuTable}"); ?>
<div id="filters" class="filters-container">            
    <ul class="media-boxes-filter" id="filter">
      <li><a class="selected" href="#" data-filter="*">All</a></li>
      <?php
		foreach($menu_geners as $menu_gener){ ?>
			<li><a href="#" data-filter=".<?php echo $menu_gener; ?>" class="selected"><?php echo $menu_gener; ?></a></li>
		<?php } ?> 
    </ul>
</div><!--filters--> 

<div id="main_isotop" class="isotope">
  	<?php $i=0; $j=0; while (have_posts()) : the_post();
	$hotel_gener = get_post_meta( get_the_ID(), 'hotel_gener', true );
	?> 
	<?php if (has_post_thumbnail( $post->ID ) ): ?>      
    <?php 
		$thumb = get_post_thumbnail_id();
        $img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
        $image = aq_resize( $img_url, $img_w, $img_h, true, true, true, true, true ); //resize & crop img ?>	
    <?php endif; ?>
    <div class="element-item customPort <?php echo $hotel_gener; ?>" >
        <div class="grid">
            <figure class="effect-goliath">
                <img src="<?php echo $image ?>" width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" alt="" />
                <figcaption>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p>
                        <small class="smallClass"><i class="fa fa-clock-o"></i> <strong><?php _e('Open', 'm_hotel'); ?>:</strong> 
                        <span class="timeColor" ><?php echo $start_time = get_post_meta( get_the_ID(), 'start_time', true ); ?></span> <strong><?php _e('to', 'm_hotel'); ?></strong>
                        <span class="timeColor"><?php echo $close_time = get_post_meta( get_the_ID(), 'close_time', true ); ?></span>
                        </small>
                        <small class="smallClass"><i class="fa fa-calendar"></i> <strong><?php _e('Close', 'm_hotel'); ?>:</strong> 
                            <span class="timeColor"><?php echo $close_day = get_post_meta( get_the_ID(), 'close_day', true ); ?></span>
                        </small> 
                    </p> 
                </figcaption>
            </figure>
        </div>
    </div> <!--element-->
    <?php  endwhile;?>
    <div style="clear: both;"></div>
</div><!--isotope-->

<script type="text/javascript"> 
 
jQuery(window).load(function(){
	var $container = jQuery('#main_isotop');
	$container.isotope({
		layoutMode: 'perfectMasonry',
		perfectMasonry: {
		layout: 'vertical',
		liquid: true,
		columnWidth: 200,	// Force columns to 200px wide
		columnHeight: 200,	// Force columns to 200px wide
		cols: <?php echo $grid_view_number; ?>,	// Force to have x columns (default: null)
		minCols: 1,              // Set min col count (default: 1)
	},
		filter: '*',
		animationOptions: {
			duration: 750,
			easing: 'linear',
			queue: false
		}
	});
 
	jQuery('#filter a').click(function(e){
		jQuery('#filter .current').removeClass('current');
		jQuery(this).addClass('current');
		var selector = jQuery(this).attr('data-filter');
		$container.isotope({
			filter: selector,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false
			}
		 });
		 e.preventDefault();
	}); 
});       
</script>
 
<?php wp_reset_query(); } // end the Grid View ?>

<?php if($grid_format=='list'){ ?>
<div class="pagination">
<?php if (function_exists("wpex_pagination")) {
    wpex_pagination();
} ?>
</div><!--pagination-->
<div style="clear: both;"></div>
<div style="margin: 0 0 0 10px; width: 100%; max-width:640px;">
<div id="ajaxContent">  

<?php $i=0; $j=0; while (have_posts()) : the_post(); ?> 
<?php if (has_post_thumbnail( $post->ID ) ): ?>      
<?php $thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
	$image = aq_resize( $img_url, 250, 180, true, true, true, true, true ); //resize & crop img ?>	
<?php endif; ?>
<div class="section group m-lists">
	<div class="col span_2_of_8 imgHover" title="<?php the_title(); ?>"> 
    	<a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>" alt="" /></a>
    </div>
    
    <div class="col span_6_of_8" title="<?php the_title(); ?>">
    	<h3 style="margin-top: 0; font-weight: 200;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><strong><?php _e('Kitchen:','m-hotel'); ?></strong> <?php echo $hotel_gener; ?></p>
        <p>
            <small class="smallClass"><i class="fa fa-clock-o"></i> <strong><?php _e('Open', 'm_hotel'); ?>:</strong> 
            <?php echo $start_time = get_post_meta( get_the_ID(), 'start_time', true ); ?> <strong><?php _e('to', 'm_hotel'); ?></strong>
            <?php echo $close_time = get_post_meta( get_the_ID(), 'close_time', true ); ?>
            </small>
            <small class="smallClass"><i class="fa fa-calendar"></i> <strong><?php _e('Close', 'm_hotel'); ?>:</strong> 
                <?php echo $close_day = get_post_meta( get_the_ID(), 'close_day', true ); ?>
            </small> 
        </p> 
        <p><strong><?php _e('Feaure:','m-hotel'); ?></strong> 
        	<?php $menu_keys = get_post_meta( get_the_ID(), 'menu_keys', true ); ?>
            <?php 
				echo $menu_keys;
			?>
        </p> 
    </div>
</div><!--section-->
<?php  endwhile;?>  
</div><!--ajaxContent-->
</div><!--end-->
<?php wp_reset_query(); } // end the Grid View  
}
add_shortcode('hotel_lists', 'list_of_hotel');