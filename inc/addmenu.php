<?php
global $wpdb;
$menuTable	= $wpdb->prefix . "hotel_menus";
$menusFood	= $wpdb->prefix . "menus";

if(($_POST['menu_food_hidden'] == 'Y') && !empty($_POST['menu_name'])) {
	$wpdb->insert( 
		$menusFood, 
		array( 
			'menu_name' => $_POST['menu_name']
		), 
		array(
			'%s'
		) 
	);
	?>
	<div class="updated" style="margin-left: 0;"><p><strong><?php _e('Hotel Info saved.' ); ?></strong></p></div>
	<?php
} elseif(($_POST['menu_food_hidden'] == 'Y') && empty($_POST['menu_name'])) {
	//Normal page display 
	echo '<div class="error" style="margin-left: 0;"><p><i class="fa fa-exclamation-triangle fa-fw fa-lg"></i> <strong>'.__('Hotel Menu Name Not Saved Because Of Blank Field' ).'</strong></p></div>';
}


?>
<div class="wrap">
	<h2 class="m_myicon"><?php _e('Master Data','m-hotel'); ?></h2>
    <?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><i class="fa fa-save fa-fw fa-lg"></i> <strong><?php _e('Settings saved.','m-hotel') ?></strong></p>
    </div>
<?php } ?>
	<div class="section group custom-group">
    	               
            <div class="col span_4_of_12">
                <div id="poststuff">
                    <div class="postbox">
                        <div class="handlediv customToggle" title="Click to toggle"><br></div>
                        <h3 class="hndle ui-sortable-handle"><span><i class="fa fa-bars"></i> <?php _e('Kitchen','m_hotel') ?></span></h3>
                        <div class="inside"> 
                            <h4><i class="fa fa-bullhorn"></i> <?php _e('Kitchen Genre List','m_hotel'); ?></h4>
                            <form method="post" action="options.php">
                            <input type="hidden" name="menu_kitchen_hidden" value="Y">
								<?php  
									wp_nonce_field('update-options');   
                                	$kitchen_gener = get_option('kitchen_name');
                                ?>  
                            <div id="keywordsMenu">                                
                                <div style="clear: both;"></div>        
                            </div><!--keywordsMenu-->
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="3">
                                    <textarea name="kitchen_name" rows="10" id="kitchen_name"><?php echo $kitchen_gener; ?></textarea>
                                    <small style="color: #F00;"><strong>Do not add extra blank space</strong></small>
                                </td>
                              </tr>
                            </table>
                                <input type="hidden" name="action" value="update" />
                                <input type="hidden" name="page_options" value="kitchen_name" /><br />
                                <input type="submit" class="button button-primary" name="Submit" value="<?php _e('Save Data', 'm_hotel' ) ?>" /> 
                            </form>  
                        </div><!--inside-->
                    </div><!--postbox-->
                </div><!--poststuff-->  

            </div><!--span_4_of_12-->
            <div class="col span_4_of_12">
                <div id="poststuff">
                    <div class="postbox">
                        <div class="handlediv customToggle" title="Click to toggle"><br></div>
                        <h3 class="hndle ui-sortable-handle"><span><i class="fa fa-bars"></i> <?php _e('Menu','m_hotel') ?></span></h3>
                        <div class="inside"> 
                            <h4><i class="fa fa-bullhorn"></i> <?php _e('List Of Menu','m_hotel'); ?></h4>
                            <div id="keywordsMenu1">                                
                                <?php $menuRows = $wpdb->get_results("SELECT * FROM {$menusFood}");
                                        foreach ($menuRows as $menuRow){
                                            echo '<a href="#" class="buttonLink" id="'.$menuRow->id.'" >'.$menuRow->menu_name.' <span rel="'.$menuRow->id.'" class="closeBtm" title="menu"></span></a>';
                                        } ?>
                                <div style="clear: both;"></div>        
                            </div><!--keywordsMenu-->
                            <form name="add_hotel_info" id="addMenu" class="bootstrap-frm" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                                <input type="hidden" name="menu_food_hidden" value="Y">
                                <p>
                                    <label><?php _e("Name:" ); ?></label>
                                    <input type="text" name="menu_name" placeholder="enter menu name" >
                                </p>
                                <input type="submit" class="button button-primary" name="Submit" value="<?php _e('Save Data', 'm_hotel' ) ?>" />
                            </form>
                        </div><!--inside-->
                    </div><!--postbox-->
                </div><!--poststuff-->
            </div><!--span_4_of_12-->
    </div><!--section-->
</div><!--wrap-->
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.closeBtm').click(function(){
		var menuId = jQuery(this).attr('rel');
		var menuTable = jQuery(this).attr('title');	
		//alert(menuTable);	
		jQuery.ajax({
			type: "POST",
			url: "<?php echo plugin_dir_url(__FILE__); ?>ajax/menukey.php",
			data: {id: menuId, mName: menuTable},
			dataType:"html",
			success: function(data){
				if(menuTable=='kitchen'){
					jQuery("#keywordsMenu").find('a#'+ menuId).fadeOut("normal", function() {
						jQuery(this).remove();
					});
				}else{
					jQuery("#keywordsMenu1").find('a#'+ menuId).fadeOut("normal", function() {
						jQuery(this).remove();
					});
				}
			}
		});
		return false;			
	});
});

</script>