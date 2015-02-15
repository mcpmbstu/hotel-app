<?php  
require_once('../../../../wp-config.php');
require_once('../../../../wp-load.php');
	
global $wpdb;
//$mydb = new wpdb('myname', 'mypassword', 'mydb', 'localhost');
$wpdb->show_errors();


$reservationTable = $wpdb->prefix . "reservations";
$postTable = $wpdb->prefix . "posts";
// define variables
$postId = '';
$thepost = '';
$mTitle = '';
$mName = '';
$mEmail = '';
$phone = '';
$number = '';
$mMessage = ''; 

/*if($_POST){
	
	$reservationTable = $wpdb->prefix . "reservations";
	$postTable = $wpdb->prefix . "posts";
	
	// collect all input and trim to remove leading and trailing whitespaces 
  
  
    $thepost = $wpdb->get_row("SELECT post_title FROM $postTable WHERE id = $postId");
  	$postId= trim($_POST['postId']);
	$thepost = trim($thepost);
	$mTitle= trim($_POST['mTitle']);
	$mName= trim($_POST['mName']);
	$mEmail= trim($_POST['mEmail']);
	$phone= trim($_POST['phone']);
	$number= trim($_POST['number']);
	$mMessage= trim($_POST['mMessage']);
	$mReserv= trim($_POST['mReserv']);
	$mReserv = implode (",", $mReserv);


  
  $errors = array();
  
  
  
  
  
  
  // Validate the input
  if (strlen($mName) == 0)
    array_push($errors, "Please enter your name");
 
    
  if (!filter_var($mEmail, FILTER_VALIDATE_EMAIL))
    array_push($errors, "Please specify a valid email address");
    
 
    
  // If no errors were found, proceed with storing the user input
  if (count($errors) == 0) {
    array_push($errors, "No errors were found. Thanks!");
  }
  
  //Prepare errors for output
  $output = '';
  foreach($errors as $val) {
    $output .= "<p class='output'>$val</p>";
  }
	
}
*/

$postId= $_POST['postId'];
$thepost = $wpdb->get_row("SELECT post_title FROM $postTable WHERE id = $postId");
$mTitle= $_POST['mTitle'];
$mName= $_POST['mName'];
$mEmail= $_POST['mEmail'];
$phone= $_POST['phone'];
$number= $_POST['number'];
$mMessage= $_POST['mMessage'];
$mReserv= $_POST['mReserv'];
$mReserv = implode (",", $mReserv);

 

$wpdb->insert( 
	$reservationTable, 
	array( 
		'post_id' => $postId,
		'post_title' => $thepost->post_title,
		'title' => $mTitle,
		'name' => $mName,
		'email' => $mEmail,
		'phone' => $phone,
		'people' => $number,
		'message' => $mMessage,
		'reserved_date' => $mReserv,
		'created'	=> date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) )
	), 
	array('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s')); 
	
	if($wpdb->show_errors()!=false){ ?>
	
	<div style="margin:auto; display: table-cell; vertical-align: middle; vertical-align: central; text-align: center;"><br /> 
        <h4 style="margin: 10px 0;"><i class="fa fa-calendar fa-2x"></i><br /><br /> Reservation Have been Saved Successfully</h4>  
    </div>

	<?php }else{ ?>
		<div style="margin:auto; text-align: center;"><br /> 
        <p>Something went wrong!!!</p>  
    </div>
	<?php } ?>                         
