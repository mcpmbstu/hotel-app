<?php 
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class My_Example_List_Table extends WP_List_Table { 
	var $example_data;
    function __construct(){
    global $status, $page;
	
        parent::__construct( array(
            'singular'  => __( 'reservation', 'mylisttable' ),     //singular name of the listed records
            'plural'    => __( 'reservation', 'mylisttable' ),   //plural name of the listed records
            'ajax'      => false        //does this table support ajax?

    ) );

    add_action( 'admin_head', array( &$this, 'admin_header' ) );            

	}	
	
    function getArrayValue() {
		global $wpdb;
		$tableReservations	= $wpdb->prefix . "reservations";
		$data = $wpdb->get_results("SELECT id,post_title,name,email,phone,reserved_date,date_format(created, '%W<br/> %m/%d/%Y<br/> %l:%i %p') created FROM {$tableReservations}", ARRAY_A);	
		 return $this->example_data =$data; 
	}  

  function admin_header() { 
    $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
    if( 'my_list_test' != $page )
    return;
    echo '<style type="text/css">';
    echo '.wp-list-table .column-id { width: 5%; }';
    echo '.wp-list-table .column-posttitle { width: 20%; }';
    echo '.wp-list-table .column-name { width: 15%; }';
    echo '.wp-list-table .column-email { width: 25%;}';
	echo '.wp-list-table .column-phone { width: 10%;}';
	echo '.wp-list-table .column-reserved_date { width: 5%;}';
	echo '.wp-list-table .column-created { width: 5%;}';
    echo '</style>';
  }

  function no_items() {
    _e( 'No books found, dude.' );
  }

  function column_default( $item, $column_name ) {
    switch( $column_name ) { 
        case 'post_title':
        case 'name':
        case 'email':
		case 'phone':
		case 'reserved_date':
		case 'created':
            return $item[ $column_name ];
        default:
            return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
    }
  }

function get_sortable_columns() {
  $sortable_columns = array(
    'post_title'  => array('post_title',false),
    'name' => array('name',false),
    'email'   => array('email',false),
	'phone'   => array('phone',false),
	'created'   => array('created',true)
  );
  return $sortable_columns;
}

function get_columns(){
	$columns = array(
		'cb'        	=> '<input type="checkbox" />',
		'post_title' 	=> __( '<i class="fa fa-book"></i> Title', 'm-hotel' ),
		'name'    		=> __( '<i class="fa fa-user"></i> Name', 'm-hotel' ),
		'email'      	=> __( '<i class="fa fa-at"></i> Email', 'm-hotel' ),
		'phone'      	=> __( '<i class="fa fa-phone"></i> Phone', 'm-hotel' ),
		'reserved_date' => __( '<i class="fa fa-calendar"></i> Reserved Date', 'm-hotel' ),
		'created'      	=> __( '<i class="fa fa-clock-o"></i> Created', 'm-hotel' )
	);
	 return $columns;
}

function usort_reorder( $a, $b ) {
  // If no sort, default to title
  $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'created';
  // If no order, default to asc
  $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'desc';
  // Determine sort order
  $result = strcmp( $a[$orderby], $b[$orderby] );
  // Send final sort direction to usort
  return ( $order === 'asc' ) ? $result : -$result;
}

/*function column_post_title($item){
  $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&reservation=%s"></a>',$_REQUEST['page'],'edit',$item['id']),
        );

  return sprintf('%1$s %2$s', $item['post_title'], $this->row_actions($actions) );
}*/

/*function column_created($item){
	$action = array(
		'action'	=> sprintf('01'),
	);
	return sprintf('%1$s %2$s', $item['created'], $this->row_actions($actions) );
}*/

function get_bulk_actions() {
  $actions = array(
    'delete'    => 'Delete'
  );
  return $actions;
}

function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="reservation[]" value="%s" />', $item['id']
        );    
    }

function prepare_items() {
  $columns  = $this->get_columns();
  $hidden   = array();
  $sortable = $this->get_sortable_columns();
  $this->_column_headers = array( $columns, $hidden, $sortable );
  usort( $this->example_data, array( &$this, 'usort_reorder' ) );
  
  $per_page = 20;
  $current_page = $this->get_pagenum();
  $total_items = count( $this->example_data );

  // only ncessary because we have sample data
  $this->found_data = array_slice( $this->example_data,( ( $current_page-1 )* $per_page ), $per_page );

  $this->set_pagination_args( array(
    'total_items' => $total_items,                  //WE have to calculate the total number of items
    'per_page'    => $per_page                     //WE have to determine how many items to show on a page
  ) );
  $this->items = $this->found_data;
}

} //class





function add_options() {
  global $myListTable;
  $option = 'per_page';
  $args = array(
         'label' => 'reservation',
         'default' => 10,
         'option' => 'books_per_page'
         );
  add_screen_option( $option, $args );
  $myListTable = new My_Example_List_Table();
}
add_action( "load-$hook", 'add_options' );

?>