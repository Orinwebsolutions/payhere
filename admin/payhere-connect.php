<?php
class payhereConnect {

    public static function payhereOptions() {
        global $wpdb;
        $db_tableName = $wpdb->prefix . "options";
        $sql = "SELECT option_value FROM $db_tableName WHERE option_name like 'payment_method_payhere';"; 
        $payhereOptions_Result = $wpdb->get_results($sql);
        return $payhereOptions_Result;
    }
    
    public static function payhereOptionsID() {
        global $wpdb;
        $db_tableName = $wpdb->prefix . "options";
        $sql = "SELECT option_id FROM $db_tableName WHERE option_name like 'payment_method_payhere';"; 
        $payhereOptionsID_Result = $wpdb->get_results($sql);
        return $payhereOptionsID_Result;
    }

}