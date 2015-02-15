<?php
require_once(ABSPATH .'wp-config.php');
require_once(ABSPATH .'wp-load.php');

$wpdb->flush();
global $wpdb;

$menuTable = $wpdb->prefix . "promotions";
$id=$_POST['id'];
$tbName=$_POST['tbName'];

if($tbName=='promotions'){
	//$wpdb->delete( $menuTable, array( 'id' => $id ) ); 
	$wpdb->delete( $menuTable, array( 'ID' => $id ), array( '%d' ) ); 
}
?>