<?php
/*
 * insert option for paypal in database while plugin activation
 */

class payhere {

    function pluginprefix_install() {

        global $wpdb;
        
        // Database table creation
        $htmlTable_name = $wpdb->prefix . "payhere";
        $sql = "CREATE TABLE " . $htmlTable_name . " ( payhere_ID INT(20) NOT NULL AUTO_INCREMENT, 
                First_name VARCHAR(50) NOT NULL,
                Last_name VARCHAR(50) NOT NULL,
                Email VARCHAR(100) NOT NULL,
                phone INT(10) NOT NULL,
                address VARCHAR(300) NOT NULL,
                order_id VARCHAR(100) NOT NULL,
                items VARCHAR(100) NOT NULL,
                currency VARCHAR(100) NOT NULL,
                amount VARCHAR(100) NOT NULL,
                paymentsConfirm VARCHAR(100) NOT NULL,
                PRIMARY KEY (payhere_ID));";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

			$PayHeretransfer_update = array(
				'methodname' => 'PayHere Transfer',
				'methodkey' => 'payhere',
				'payhere_isactive' => '1',
				'payOpts' => array
					(
						array
							(
								'title' => __('Your PayHere Merchant ID'),
								'fieldname' => 'merchant_id',
								'value' => '1210575',
								'description' => __('Example: 1210575')
							)
					),
			);
			update_option('payment_method_payhere',$PayHeretransfer_update);

        
//        add_option("dbhtml_db_version", $htmlTable_db_version);
        //flush permalinks
        flush_rewrite_rules();
    }

    

    function pluginprefix_deactivation() {
        // our post type will be automatically removed, so no need to unregister it
        // clear the permalinks to remove our post type's rules
        flush_rewrite_rules();
    }

    function pluginprefix_unstall() {
        global $wpdb;
        $db_tableName = $wpdb->prefix . "Payhere";
        $sql = "DROP TABLE IF EXISTS $db_tableName ;";
        $wpdb->query($sql);
        delete_option("payment_method_payhere");
    }
    
//    function payhereOptionUpdate() {
//        $paymentmethodname = 'payhere';
//        
//        $paymethodinfo = array();
//	$payOpts = array();
//	$payOpts[] = array(
//					"title"			=>	__('Your PayHere Merchant ID','templatic-admin'),
//					"fieldname"		=>	"merchant_id",
//					"value"			=>	"1210575",
//					"description"	=>	__('Example','templatic-admin').__(": 1210575",'templatic-admin')
//					);
//	$paymethodinfo = array(
//						"name" 		=> __('PayHere','templatic-admin'),
//						"key" 		=> $paymentmethodname,
//						"isactive"	=>	'1', /* 1->display,0->hide*/
//						"payOpts"	=>	$payOpts,
//						);
//	
//	update_option("payment_method_$paymentmethodname", $paymethodinfo );
//	$install_message = __("Payment Method integrated successfully",'templatic-admin');
//	$option_id = $wpdb->get_var("select option_id from $wpdb->options where option_name like \"payment_method_$paymentmethodname\"");
//	wp_redirect("admin.php?page=monetization&tab=payment_options");
//        
//        
//        
//    }
}



//$paymentmethodname = 'payhere'; 
//if($_REQUEST['install']==$paymentmethodname)
//{
//	$paymethodinfo = array();
//	$payOpts = array();
//	$payOpts[] = array(
//					"title"			=>	__('Your PayHere Merchant ID','templatic-admin'),
//					"fieldname"		=>	"merchant_id",
//					"value"			=>	"1210575",
//					"description"	=>	__('Example','templatic-admin').__(": 1210575",'templatic-admin')
//					);
//	$paymethodinfo = array(
//						"name" 		=> __('PayHere','templatic-admin'),
//						"key" 		=> $paymentmethodname,
//						"isactive"	=>	'1', /* 1->display,0->hide*/
//						"display_order"=>'7',
//						"payOpts"	=>	$payOpts,
//						);
//	
//	update_option("payment_method_$paymentmethodname", $paymethodinfo );
//	$install_message = __("Payment Method integrated successfully",'templatic-admin');
//	$option_id = $wpdb->get_var("select option_id from $wpdb->options where option_name like \"payment_method_$paymentmethodname\"");
//	wp_redirect("admin.php?page=monetization&tab=payment_options");
//}elseif($_REQUEST['uninstall']==$paymentmethodname)
//{
//	delete_option("payment_method_$paymentmethodname");
//	$install_message = __("this payment method cannot deleted because it is fix, you can deactive it",'templatic-admin');
//}
?>