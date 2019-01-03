<?php
/*
NAME : IPN PROCESS FILE FOR PAYPAL
DESCRIPTION : THIS FILE WILL BE CALLED ON SUCCESSFUL PAYMENT VIA PAYPAL. THE CODE MENTIONED IN THIS FILE WILL FETCH THE POSTED EVENT DATA AND ACCORDINGLY IT WILL SEND EMAIL TO THE ADMIN AS WELL AS THE USER.
*/


global $wpdb;

$payhere=get_option('payment_method_payhere');
/*$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';*/
$url = 'https://sandbox.payhere.lk/pay/checkout';
$raw_post_data = file_get_contents('php://input');
//$raw_post_data='cmd=_notify-validate&'.$raw_post_data;

$raw_post_array = explode('&', $raw_post_data);

$myPost = array();
//$generatedArray = array();
//foreach ($raw_post_array as $keyval) {
//  $keyval = explode ('=', $keyval); 
//  if (count($keyval) == 2){
//      array_push($myPost,$keyval[0],$keyval[1]);
//      $validateHS = $validateHS.'+'.$keyval[1];
//  }
//}
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval); 
  if (count($keyval) == 2){
     $myPost[$keyval[0]] = urldecode($keyval[1]);
	$_POST[$keyval[0]] = urldecode($keyval[1]);
	$new_string.=	$keyval[0]."==".$keyval[1]."&&";
  }
}

//        $merchant_id = $_POST['merchant_id'];
//        $order_id = $_POST['order_id'];
//        $payment_id = $_POST['payment_id'];
//        $payhere_amount = $_POST['payhere_amount'];        
//        $payhere_currency = $_POST['payhere_currency'];
//        $status_code = $_POST['status_code'];
//        $md5sig = $_POST['md5sig'];       
//        $payhere_secret_code = 'Secretpayhere1210575';
//        $payhere_secret = strtoupper(md5($payhere_secret_code));
//        $md5sigRespond = strtoupper(md5($merchant_id.$order_id.$payhere_amount.$payhere_currency.$status_code.$payhere_secret));
        

//$raw_post_array_final = serialize($myPost);
//$validateHS_final = serialize($validateHS);
        
//   $file = TEMPL_PAYMENT_FOLDER_PATH . '/payhere/errors.txt'; 
//    $open = fopen( $file, "a" ); 
//    $write = fputs( $open, $raw_post_array_final); 
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open, $order_id); 
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open, $payment_id); 
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $payhere_amount); 
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $payhere_currency); 
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $status_code);     
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $payhere_secret); 
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $md5sigbefore);    
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $md5sigbefore2);        
//    $write = fputs( $open, '---' );
//    $write = fputs( $open, $md5sig ); 
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open,  $md5sigRespond);
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open,  $md5sigRespond3);    
//    fclose( $open );
//    die();
 
/*new Code*/
$arg=array('method' => 'POST',
		 'timeout' => 45,
		 'redirection' => 5,
		 'httpversion' => '1.0',
		 'body' => $myPost,
		 'user-agent' => 'WordPress/'. $wp_version .'; '. home_url(),
	);

$response = wp_remote_get($url,$arg );
/*Finish New Code*/

/* read the IPN message sent from payhere and prepend 'cmd=_notify-validate'*/
//$bodyrespose1 = trim($response['body']);
//$bodyrespose2 = is_wp_error( $response );
//$bodyrespose3 = $response['response']['code'];
//$complete = 'Complete';
//$bodyrespose_final = serialize($bodyrespose);
//
//    $file = TEMPL_PAYMENT_FOLDER_PATH . '/payhere/errors.txt'; 
//    $open = fopen( $file, "a" ); 
//    $write = fputs( $open, $bodyrespose1);  
//    $write = fputs( $open, '---' ); 
//     $write = fputs( $open, $bodyrespose2);  
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open, $bodyrespose3);  
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open,  $bodyrespose_final);
//    $write = fputs( $open, '---' ); 
//    $write = fputs( $open,  $complete);            
//    fclose( $open );

if(!is_wp_error( $response ) && $response['response']['code']==200) {
        global $current_user;
//        $merchant_id = $_POST['merchant_id'];
//        $order_id = $_POST['order_id'];
//        $payment_id = $_POST['payment_id'];
//        $payhere_amount = $_POST['payhere_amount'];        
//        $payhere_currency = $_POST['payhere_currency'];
//        $status_code = $_POST['status_code'];
//        $md5sig = $_POST['md5sig'];       
        $payhere_secret_code = 'Secretpayhere1210575';
//        $complete = 'Complete';
        $payhere_secret = strtoupper(md5($payhere_secret_code));
        $md5sigRespond = strtoupper(md5($merchant_id.$order_id.$payhere_amount.$payhere_currency.$status_code.$payhere_secret));        
    
     
    
//if($md5sig = $md5sigRespond && $md5sig!=''){
if($md5sig = $md5sigRespond){    
	$transaction_db_table_name = $wpdb->prefix.'transactions';
        $merchant_id = $_POST['merchant_id'];
        $order_id = $_POST['order_id'];
        $payment_id = $_POST['payment_id'];
        $payhere_amount = $_POST['payhere_amount'];        
        $payhere_currency = $_POST['payhere_currency'];
        $status_code = $_POST['status_code'];    

//        if($custom_1=='upgpkg'){
//        $sql = "select max(trans_id) as trans_id,status,post_id from $transaction_db_table_name where payment_method = %d";
//	$sql_data = $wpdb->get_row($wpdb->prepare($sql,$pid));		
//        $postid = $pid;
//        }  else {        
        $sql = "select max(trans_id) as trans_id,status,post_id from $transaction_db_table_name where payment_method = 'payhere' && package_id= %d";
	$sql_data = $wpdb->get_row($wpdb->prepare($sql,$order_id));		
        $postid = $sql_data->post_id;

	switch ($status_code){
		case '2':

	
				$sql = "select max(trans_id) as trans_id,status from $transaction_db_table_name where payment_method ='payhere' && post_id=$postid";
				$sql_data = $wpdb->get_row($sql);				
				$wpdb->query("UPDATE $transaction_db_table_name set status=1,payment_date='".date("Y-m-d H:i:s")."' where trans_id=$sql_data->trans_id");				
				$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET post_date='".date("Y-m-d H:i:s")."',post_status='publish' where ID = %d",$postid));
                                
                                
			break;
		case '-1':

				$sql = "select max(trans_id) as trans_id,status from $transaction_db_table_name where payment_method = $postid";
				$sql_data = $wpdb->get_row($sql);				
				$wpdb->query("UPDATE $transaction_db_table_name set status=2,payment_date='".date("Y-m-d H:i:s")."' where trans_id=$sql_data->trans_id");				
			break;
		case '-2':
				$sql = "select max(trans_id) as trans_id,status from $transaction_db_table_name where payment_method = $postid";
				$sql_data = $wpdb->get_row($sql);				
				$wpdb->query("UPDATE $transaction_db_table_name set status=0,payment_date='".date("Y-m-d H:i:s")."' where trans_id=$sql_data->trans_id");				
			break;
		case '-3':
				$sql = "select max(trans_id) as trans_id,status from $transaction_db_table_name where payment_method = $postid";
				$sql_data = $wpdb->get_row($sql);				
				$wpdb->query("UPDATE $transaction_db_table_name set status=0,payment_date='".date("Y-m-d H:i:s")."' where trans_id=$sql_data->trans_id");				
			break;                        
		case '0':                     
					$user_id = $current_user->ID;
					$sql = "select max(trans_id) as trans_id,status from $transaction_db_table_name where post_id = %d";
					$sql_data = $wpdb->get_row($wpdb->prepare($sql,$postid));
					$wpdb->query("UPDATE $transaction_db_table_name set status=0,payment_date='".date("Y-m-d H:i:s")."' where trans_id=$sql_data->trans_id");	
		break; 
	}
	
}	        
}
?>