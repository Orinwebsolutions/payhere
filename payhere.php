<?php

/**
 * @package payhere
 */
/*
  Plugin Name: payhere
  Plugin URI:
  Description: This is a plugin for payhere payment gateway
  Version: 1.0
  Author: Amila
  Author URI:
  License: GPLv2
 */

class PayherePlugin {

    public function __construct() {
        register_activation_hook(__FILE__, array('payhere', 'pluginprefix_install'));
        register_deactivation_hook(__FILE__, array('payhere', 'pluginprefix_deactivation'));
        register_uninstall_hook(__FILE__, array('payhere', 'pluginprefix_unstall'));
        add_action('admin_menu', array($this, 'addingPayheremenu')); //adding to menu tree
        add_action('admin_post_payhere_submit_hidden', array($this, 'payhere_SettingFormSave'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts_and_styles')); //admin scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_scripts_and_styles')); //public scripts and styles        
        add_action('wp_ajax_nopriv_payhere_payment_submition', array($this, 'payhere_payment_submition')); //Customer details user log Ajax submition
        add_action('wp_ajax_payhere_payment_submition', array($this, 'payhere_payment_submition')); //Customer details Ajax submition
    }

//Adding pluging to a menu
    public function addingPayheremenu() {
        add_menu_page(
                'payhere', 'payhere Setting', 'manage_options', plugin_dir_path(__FILE__) . 'admin/payhere-Settings.php', null, 'dashicons-admin-generic', 20
        );
    }

    public function payhere_SettingFormSave() {
        global $wpdb;
        if ($_POST) {
            $payhereupdinfo = payhereConnect::payhereOptions();
            $payhereOptionID = payhereConnect::payhereOptionsID();
            $payOpID = $payhereOptionID[0]->option_id;
            if ($payhereupdinfo) {
                foreach ($payhereupdinfo as $paymentupdinfoObj) {
                    $option_value = unserialize($paymentupdinfoObj->option_value);
                    $payment_method = trim($_POST['methodname']);
                    $paymet_isactive = $_POST['payhere_isactive'];
                    $paymet_mode = $_POST['payhere_mode'];
                    $payhere_secret = $_POST['payhere_secret'];
                    if ($payment_method) {
                        $option_value['methodname'] = $payment_method;
                    }

                    if ($paymet_mode != "") {
                        $option_value['payhere_mode'] = $paymet_mode;
                    } else {
                        $option_value['payhere_mode'] = "";
                    }
                    if ($payhere_secret != "") {
                        $option_value['payhere_secret'] = $payhere_secret;
                    } else {
                        $option_value['payhere_secret'] = "";
                    }
                    $option_value['payhere_isactive'] = $paymet_isactive;

                    $paymentOpts = $option_value['payOpts'];
                    for ($o = 0; $o < count($paymentOpts); $o++) {
                        $paymentOpts[$o]['value'] = $_POST[$paymentOpts[$o]['fieldname']];
                    }
                    $option_value['payOpts'] = $paymentOpts;
                    $option_value_str = serialize($option_value);
                }
            }

            $updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id=%d";
            $success = $wpdb->query($wpdb->prepare($updatestatus, $payOpID));


//        if ($REMsg = update_option("payment_method_payhere", $option_value )) {
//          $sMsg = $REMsg;
//        }  else {
//          $sMsg = "success";
//        }
        }


        if ($success) {
            $sMsg = "success";
            $htmlTable_URL_to_redirect = get_bloginfo("url") . "/wp-admin/admin.php?page=payhere%2Fadmin%2Fpayhere-Settings.php&status=$sMsg";
        } else {
            $sMsg = "fail";
            $htmlTable_URL_to_redirect = get_bloginfo("url") . "/wp-admin/admin.php?page=payhere%2Fadmin%2Fpayhere-Settings.php&status=$sMsg";
        }

        header("Location: " . $htmlTable_URL_to_redirect);
        exit;
    }

    //enqueus scripts and stles on the back end
    public function enqueue_admin_scripts_and_styles() {
        wp_enqueue_style('wp_payhere_table', plugin_dir_url(__FILE__) . 'css/wp_payhere_table.css');
    }

    //enqueues scripts and styled on the front end
    public function enqueue_public_scripts_and_styles() {
        wp_enqueue_style('wp_payhere_table', plugin_dir_url(__FILE__) . 'css/wp_payhere_table.css');
        wp_enqueue_script('wp_payhere_popupJQ', 'https://code.jquery.com/jquery-1.12.4.js');
        wp_enqueue_script('wp_payhere_popupJQUI', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js');
        wp_enqueue_script('wp_payhere_popup', plugin_dir_url(__FILE__) . 'js/payherePopup.js');
        wp_enqueue_script('wp_payherePopupAjax', plugin_dir_url(__FILE__) . 'js/payhereAjax.js');
        wp_localize_script('wp_payherePopupAjax', 'payhere', array('ajaxUrlPay' => admin_url('admin-ajax.php')));
    }

    public function payhere_payment_submition() {
        global $wpdb, $PayfirstName, $PaylastName, $PayeMail,$PayphoneNo, $Payaddress, $ItemName, $PaypostID, $PayCurrencyCode, $PaypostAmount;
        $PayfirstName = isset($_POST['PayfirstName']) ? sanitize_text_field($_POST['PayfirstName']) : '';
        $PaylastName = isset($_POST['PaylastName']) ? sanitize_text_field($_POST['PaylastName']) : '';
        $PayeMail = isset($_POST['PayeMail']) ? sanitize_text_field($_POST['PayeMail']) : '';
        $PayphoneNo = isset($_POST['PayphoneNo']) ? sanitize_text_field($_POST['PayphoneNo']) : '';
        $Payaddress = isset($_POST['Payaddress']) ? sanitize_text_field($_POST['Payaddress']) : '';
        $ItemName= isset($_POST['ItemName']) ? sanitize_text_field($_POST['ItemName']) : '';
        $PaypostID = isset($_POST['PaypostID']) ? sanitize_text_field($_POST['PaypostID']) : '';        
        $PayCurrencyCode = isset($_POST['PayCurrencyCode']) ? sanitize_text_field($_POST['PayCurrencyCode']) : '';
        $PaypostAmount = isset($_POST['PaypostAmount']) ? sanitize_text_field($_POST['PaypostAmount']) : '';

        $tablename = $wpdb->prefix . 'payhere';

//            $success = $wpdb->insert(
//            $htmlTable_name, array(
//        'htmlTable_Title' => $htmlTable_title,
//        'htmlTable_Description' => $htmlTable_Description,
//        'htmlTable_No_Rows' => $htmlTable_No_Rows,
//        'htmlTable_No_Colums' => $htmlTable_No_Colums
//            ), array(
//        '%s',
//        '%s',
//        '%d',
//        '%d'
//      ));
            
            $success = $wpdb->insert(
            $tablename, array(
            'First_name '=> $PayfirstName, 
            'Last_name ' => $PaylastName, 
            'Email ' => $PayeMail, 
            'phone ' => $PayphoneNo,
            'address ' => $Payaddress,            
            'order_id ' => $PaypostID,
            'items ' => $ItemName,
            'currency ' => $PayCurrencyCode,
            'amount ' => $PaypostAmount,
            'paymentsConfirm ' => ""
            ), array(
'%s','%s','%s','%d','%s','%d','%s','%s','%d','%s'
      ));
        
//        $wpdb->insert($tablename, $data);
//        

        
//        if($wpdb->insert($tablename, $data)){
//            $location = "https://www.google.lk/";
//            wp_redirect($location);
//        }


//        $wpdb->insert( $tablename, array( 'column' => 'foo', 'field' => 1337 ), array( '%s', '%d' ) );

//        $var = "this is a test";
        wp_send_json( $success );
        wp_die();
    }

}

$PayherePlugin = new PayherePlugin;

include(plugin_dir_path(__FILE__) . '/inc/install.php' );
//include(dirname(__FILE__) . '/wp-load.php' );
include(plugin_dir_path(__FILE__) . '/admin/payhere-connect.php' );
//include shortcodes
include(plugin_dir_path(__FILE__) . '/inc/payhere_shortcode.php');
//include widgets
//    include(plugin_dir_path(__FILE__) . '/inc/wp_location_widget.php');
include( '../../../wp-load.php' );
