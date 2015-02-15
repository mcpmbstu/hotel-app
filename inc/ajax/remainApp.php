<?php
require_once('../../../../../wp-config.php');
require_once('../../../../../wp-load.php');

global $wpdb; 
$wpdb->show_errors();

$tGmt='am';
$k1=0;
$id=$_POST['id'];
$reservationTable = $wpdb->prefix . "reservations";
$custom_metas = get_post_meta($id, '_custom-meta-box', true);


$fivesdrafts = $wpdb->get_results( 
	"SELECT * FROM $reservationTable WHERE post_id = $id 
	AND created between concat_ws(' ',curdate(),'23:59:59') - interval 1 day and concat_ws(' ',curdate(),'23:59:59')");
//print_r($fivesdrafts);
foreach ( $fivesdrafts as $fivesdraft ) 
{
	$tmpVal .= $fivesdraft->reserved_date.','; 
}

//echo $reservedDates;
$openReseve = $custom_metas;
$reservedDate = explode(",", $tmpVal);
sort($reservedDate, 1);
$totalCurrDate = count($reservedDate);
$r=1;
$allAvailable = $custom_metas;
//echo count($allAvailable);
//print_r($reservedDate);
if(!empty($custom_metas)){
?> 
<div class="timeTable" style="text-align:center;">
	<h3><?php _e('Available Date','m-hotel'); ?></h3>
	<form name="add_hotel_info" id="reserveForm" class="bootstrap-frm" method="post" action="">
    
	<?php
	//echo $plugin_dir_path = plugins_url( '../../template/reserve-template.php', __FILE__ );
	 foreach($custom_metas as $custom_meta): ?>
    	<?php  
		
		$custom_meta = intval($custom_meta);
		$reserved = intval($reservedDate[$r]);
		//echo $reserved . '<br/>';
        if($custom_meta>=12){ $tGmt ='pm'; }
		if($reserved == $custom_meta){ $r++;		 
		 ?>
         <input type="checkbox" title="<?php echo $r; ?>" onclick="return false;" name="reserve_time[]" style="position: relative; top: 1px;" value="<?php echo $custom_meta; ?>" id="reserve_time" class="commonReserve" /> <span style="text-decoration:line-through; color: #F00;"><?php echo $custom_meta.' '.$tGmt.'&nbsp;&nbsp;'; ?></span>
         <?php }else{ ?>
         <input type="checkbox" name="reserve_time[]" style="position: relative; top: 1px;" value="<?php echo $custom_meta; ?>" id="reserve_time" class="commonReserve" /> <?php echo $custom_meta.' '.$tGmt.'&nbsp;&nbsp;'; ?>
         <?php } ?>
    	
         
    <?php   endforeach; ?><br /><br />
   <!-- <input type="hidden" name="redirect_page" value="reserve" />-->
    <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $id; ?>" />
    <p><input type="button" name="reserve" class="reserve_form" id="<?php echo $id; ?>" value="Reserve" /></p>
</form>
<div class="hideClass"><span>Must Select One Time</span></div>
</div><!--timeTable-->
<?php }else{ ?>
<h3 align="center"><?php _e('Available Date','m-hotel'); ?></h3>
<p align="center"><?php _e('Reservation Not Available','m-hotel'); ?></p>
<?php } ?>
  