<?php
require_once('../../../../../wp-config.php');
require_once('../../../../../wp-load.php');

$wpdb->flush();
global $wpdb;
$menuTable = $wpdb->prefix . "hotel_menus";
$menusFood = $wpdb->prefix . "menus";
$id=$_POST['id'];
$mName=$_POST['mName'];
if($mName=='kitchen'){
$wpdb->delete( $menuTable, array( 'id' => $id ) );
}elseif($mName=='menu'){
$wpdb->delete( $menusFood, array( 'id' => $id ) ); 
}
?>