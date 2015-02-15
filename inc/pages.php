<?php
add_action('admin_menu', 'h_my_menu_pages');
function h_my_menu_pages(){
    /*add_menu_page('Hotel App', 'Hotel App', 'manage_options', 'h-m-reservation-menu', 'h_my_menu_reservation', '', 70 );
	add_submenu_page('h-m-reservation-menu', 'All Reservations', 'All Reservations', 'manage_options', 'h-m-reservation-menu' );*/
    /*add_submenu_page('m-reservation-menu', 'All Reservations', 'All Reservations', 'manage_options', 'm-reservation-menu' );
    add_submenu_page('m-reservation-menu', 'All Hotel', 'All Hotel', 'manage_options', 'm-hotel', 'm_hotel_all' );
	
	add_submenu_page('m-reservation-menu', 'Promotions', 'Promotions', 'manage_options', 'm-hotel-promotion', 'm_hotel_promotion' );
	add_submenu_page(NULL, __('Edit','m-reservation-menu'), __('Edit','m-reservation-menu'), 'manage_options', 'm-hotel-promotion-edit', 'm_hotel_promotion_edit');
	add_submenu_page('m-reservation-menu', 'Master Data', 'Master Data', 'manage_options', 'm-hotel-menu', 'm_hotel_menu' );
	
	add_submenu_page('m-reservation-menu', 'Settings', 'Settings', 'manage_options', 'm-settings', 'm_reservation_settings' );*/
	
	
  
	add_menu_page('Hotel App', 'Hotel App', 'manage_options', 'h-reservation-menu', 'h_menu_reservation', '', 40 );
	add_submenu_page('h-reservation-menu', 'Reservation List', 'Reservation List', 'manage_options', 'h-reservation-list', 'h_reservation_list' );
	//add_submenu_page('h-reservation-menu', 'Hotel App', 'Hotel App', 'manage_options', 'h-reservation-menu' );
	add_submenu_page('h-reservation-menu', 'Master Data', 'Master Data', 'manage_options', 'h-master-data', 'h_master_data' );	
	
	  
}
?>