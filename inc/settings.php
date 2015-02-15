<div class="wrap">
	<h2 class="m_myicon"><?php _e('Hotel Settings','m-hotel'); ?></h2>
    <?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><i class="fa fa-save fa-fw fa-lg"></i> <strong><?php _e('Settings saved.','m-hotel') ?></strong></p>
    </div>
<?php } ?>
    <p><?php _e('This section is for basic settings setup page','m-hotel'); ?></p>
	<div class="section group custom-group">  
    	<div class="col span_4_of_12" style="margin-top: 0;">
            <form method="post" action="options.php">
                <?php  wp_nonce_field('update-options'); 
						$grid_view_number = get_option('grid_view_number');
						$grid_format = get_option('grid_format');  
						$cols = array( 
							1	=> 'One',
							2	=> 'Two',
							3	=> 'Three', 
							4	=> 'Four', 
							5	=> 'Five',
							6	=> 'Six',
							7	=> 'Seven',
							8	=> 'Eight'
						);
				?>  
                <fieldset class="fieldsetBlock" style="margin-bottom: 10px;">
                	<h3><?php _e('Column View Settings','m-hotel'); ?></h3>
                    <p><strong><?php _e('Number of Column','m-hotel'); ?></strong></p>
                    <select name="grid_view_number" id="grid_view_number">
                    	<?php foreach($cols as $key => $value){ ?>
                    	<option <?php if($key==$grid_view_number){ echo 'selected="selected"'; } ?>  value="<?php echo $key; ?>"><?php echo $cols[$key]; ?></option>                        
                        <?php } ?>
                    </select>
                    <p><strong><?php _e('Grid View Settings','m-hotel'); ?></strong></p>
                    <input type="radio" id="g_yes" class="checkBreak" name="grid_format" <?php if($grid_format == 'grid') echo 'checked="checked"'; ?> value="grid" />Grid &nbsp;&nbsp; 
					<input type="radio" id="g_no" class="checkBreak" name="grid_format" <?php if($grid_format == 'full') echo 'checked="checked"'; ?> value="full" />Full Width &nbsp;&nbsp;
                    <input type="radio" id="g_no" class="checkBreak" name="grid_format" <?php if($grid_format == 'list') echo 'checked="checked"'; ?> value="list" />List
                    
                <p><input type="submit" class="button button-primary" name="Submit" value="<?php _e('Save Settings','m-hotel'); ?>" /></p>
                </fieldset>
			<fieldset class="fieldsetBlock" >   
			<h3><?php _e('Image View Settings','m-hotel'); ?></h3>
            <?php
			$img_w = get_option('img_w');
			$img_h = get_option('img_h');
			?>     
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><strong><?php _e('Image Width','m-hotel'); ?></strong>
            	<input type="number" name="img_w" value="<?php echo $img_w; ?>" />
                </td>
                <td width="10"></td>
                <td>
                <strong><?php _e('Image Height','m-hotel'); ?></strong>
            	<input type="number" name="img_h" value="<?php echo $img_h; ?>" />
                </td>
              </tr>
              <tr>
              	<td colspan="3" height="30" align="center"><strong><?php _e('<i class="fa fa-exclamation-circle"></i> Use High Resolution Images and Square Size for Masonry Grid','m-hotel'); ?></strong></td>
              </tr>
            </table>
             <p><input type="submit" class="button button-primary" name="Submit" value="<?php _e('Save Settings','m-hotel'); ?>" /></p>
             </fieldset>
         </div><!--col 8-->
         		<input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="grid_view_number,grid_format,img_w,img_h" /> 
            </form>  
                            
    </div><!--section-->
</div><!--wrap-->
<?php 
 
?>