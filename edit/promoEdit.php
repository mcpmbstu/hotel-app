<div class="wrap">
<h2><i class="fa fa-chain-broken"></i> Edit Promotion <a href="admin.php?page=m-hotel-promotion" class="add-new-h2"><i class="fa fa-plus"></i> Add New</a></h2>
<?php
global $wpdb;
$promotionTable	= $wpdb->prefix . "promotions";
$getId= $_GET['id'];
if($_POST['promotion_hidden'] == 'Y') {
	$wpdb->insert( 
		$promotionTable, 
		array( 
			'promotion_name' => $_POST['promotion_name'],
			'promotion_desc' => $_POST['promotion_desc']
		), 
		array(
			'%s',
			'%s'
		) 
	);
	?>
	<div class="updated" style="margin-left: 0;"><p><strong><?php _e(INFOSAVE); ?></strong></p></div>
	<?php
} else {
	//Normal page display
}

if($_POST['promotion_hidden'] == 'E') {
$wpdb->update( 
		$promotionTable, 
		array(  
				'promotion_name' => $_POST['promotion_name'],
				'promotion_desc' => $_POST['promotion_desc']
		), 
		array( 'ID' => $getId ), 
		array( 
			'%s',	// value1
			'%s'	// value2
		), 
		array( '%d' ) 
	);
}
?>
	<div class="section group custom-group">
    	               
            <div class="col span_5_of_12">
            
                <div id="poststuff">
                    <div class="postbox">
                        <div class="handlediv customToggle" title="Click to toggle"><br></div>
                        <h3 class="hndle ui-sortable-handle"><span><i class="fa fa-bars"></i> <?php _e('Edit ','m_hotel') ?></span></h3>
                        <div class="inside">
                            <?php $mylink = $wpdb->get_row("SELECT * FROM $promotionTable WHERE id = $getId");  ?>
                            <form name="add_hotel_info" id="promotions" class="bootstrap-frm" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                                <input type="hidden" name="promotion_hidden" value="E">
                                <input type="hidden" name="id" value="<?php echo $mylink->id; ?>">
                                <p>
                                    <label><?php _e("Name:" ); ?></label>
                                    <input type="text" name="promotion_name" value="<?php echo $mylink->promotion_name; ?>" >
                                </p>
                                <p>
                                    <label><?php _e("Description:" ); ?></label>
                                    <textarea name="promotion_desc" class="textarea" rows="5" style="height: 95px;"><?php echo $mylink->promotion_desc; ?></textarea> 
                                </p>
                                <input type="submit" class="button button-primary" name="Submit" value="<?php _e('Update', 'm_hotel' ) ?>" />
                            </form> 
                        </div><!--inside-->
                    </div><!--postbox-->
                </div><!--poststuff-->  

            </div><!--span_4_of_12-->
            
            <div class="col span_7_of_12">                        	
                            
                            <?php require_once(plugin_dir_path( __FILE__ ) .'../inc/promotiontable.php'); ?> 
                
            </div><!--span_8_of_12-->
       		         
    </div><!--section-->
    
        
            
</div><!--wrap-->