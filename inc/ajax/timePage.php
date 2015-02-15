<?php
require_once('../../../../../wp-config.php');
require_once('../../../../../wp-load.php');

$wpdb->flush();
global $wpdb; 
$tGmt='am';
$k1=0;
?>
<div class="col span_12_of_12"> 
    <?php 
    $totalTime = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
    $wCurrent= intval($_POST['stime']);
    for($w=$wCurrent;$w<=intval($_POST['etime']);$w++){ ?>
        <div class="ourCols firstCol">
        <input type="checkbox" name="custom-meta-box[]" value="<?php echo $totalTime[$w]; ?>" <?php if($custom_meta[$k1]==$totalTime[$w]){ echo 'checked="checked"'; $k1++; } ?>  /><strong><?php echo $totalTime[$w]; ?>.00 <?php echo $tGmt; ?></strong>
        </div><!--end-->
        <?php if(intval($totalTime[$w])==11){ $tGmt='pm'; } ?>
    <?php } ?>			
</div>	<!--span_12_of_12-->	 