<div class="wrap">
	<h2 class="m_myicon"><?php _e('Hotel Reservation List','m-hotel'); ?></h2>

<?php
//Delete Reservation Table Data 
global $wpdb; 
if($_POST['action'] == 'delete') { 
$tableName = $_POST['wp_reservations'];
$totalDel =$_POST['reservation'];
foreach($totalDel as $del):
	$wpdb->delete( 'wp_reservations', array( 'id' => $del ), array( '%d' ) );
	$wpdb->show_errors();
endforeach; 
} ?> 
<form method="post">
<input type="hidden" name="s" value="wp_reservations">
<?php
$myListTable = new My_Example_List_Table();
$myListTable->getArrayValue();
$myListTable->prepare_items(); 
//$myListTable->search_box( 'search', 'search_id' );
$myListTable->display(); 
echo '</form>'; 
?>
</div><!--wrap-->