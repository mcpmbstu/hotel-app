<?php
require_once('../../../../wp-config.php');
require_once('../../../../wp-load.php');

$titles = array('Mr','Mrs','Miss','Ms','Dr');
global $wpdb; 
$resTable = $wpdb->prefix ."reservations";

$postId = $_POST['id'];
$reserveTimes = $_POST['ids'];
$mRes = $wpdb->get_var( "SELECT * FROM $resTable WHERE id = $postId" );
?> 

<div class="section group reservationForm">
	<h4 style="margin-bottom: 0; margin-top: 0; text-align:center;"><?php _e('Reservation Form','m-hotel'); ?></h4> 
	<p style="margin-bottom: 0; margin-top: 0; text-align:center;"><?php _e('Selected Time: ','m-hotel'); ?>
    <?php 
            $tjon = ' <strong>AM</strong>';
            foreach($reserveTimes as $reserveTime): ?>
                <?php 
                if($reserveTime>=12)
                $tjon = ' <strong>PM</strong>';
                echo $reserveTime.$tjon.', '; ?>
            <?php endforeach; ?>
        </p> 
	<div class="col span_4_of_8" style="width: 47.7%;">
    		
        <?php echo $output; ?>
        <form name="reserveForm" id="saveReserve" class="form" method="post" action="./">
        <input type="hidden" name="menu_food_hidden" value="Y">
        <input type="hidden" name="post_id" id="m_postId" value="<?php echo $postId;  ?>"  />
        <?php 
        foreach($reserveTimes as $reserveTime): ?>
        <input type="hidden" name="reservation_time[]" id="m_reservation" value="<?php echo $reserveTime;  ?>"  /> 
        <?php endforeach; ?> 
        
            <p>
            <label><?php _e('Title','m-hotel'); ?></label>
            <select name="title" id="m_title">
                <option value="0"><?php _e('Select...','m-hotel'); ?></option>
                <?php foreach($titles as $title): ?>
                <option value="<?php echo $title; ?>"><?php echo $title; ?></option>
                <?php endforeach; ?>
            </select>
            </p>  
            <p><label><?php _e('Your Name','m-hotel'); ?></label>
            <input type="text" name="name" id="m_name" class="clickClass" placeholder="enter name" /></p>
            <p>
            <label><?php _e('Your Email','m-hotel'); ?> <span style="color: red;">*</span></label>
            <input type="email" name="email" id="m_email" class="required" placeholder="enter email" /></p> 
            <p>
            <label><?php _e('Your Email','m-hotel'); ?> <span style="color: red;">*</span></label>
            <input type="email" name="email1" id="m_email" placeholder="enter email" /></p> 
            
            
        
    </div><!--col span_4_of_8-->
    <div class="col span_4_of_8" style="width: 47.7%;"> 
    		<p>
            <label><?php _e('Your Contact Number','m-hotel'); ?></label>
            <input type="tel" name="phone" id="m_phone" placeholder="enter phone" /></p>
            <p>
            <label><?php _e('Number of People','m-hotel'); ?> <span style="color: red;">*</span></label>
            <input type="number" id="m_number" class="required" name="number" /></p>
            <p><label><?php _e('Your Message','m-hotel'); ?></label>
            <textarea name="message" id="m_message" style=" height: 95px;" placeholder="enter texts"></textarea></p>
    </div><!--col-->
    <div class="col span_8_of_8"> 
            <p style="margin:0; text-align: center;"><input type="button" id="<?php echo $postId;  ?>" name="reserveBtm" class="reserveBtm" value="Reserve" /></p>
    </div><!--col-->
     </form>
</div><!--section-->
