<?php

class Settings{
    
    
    /**
     * static funtion to convert time to Bangladeshi local time.
     * @param void.
     * @return returns timestamp.
    */
    public static function getBdLocalTime(){
        date_default_timezone_set('Asia/Dhaka');
        return time();
    }
    
    public static $_payment_types = array('1'=>'Cash','2'=>'Cheque');
    
    public static $_month_full_name_for_datepicker = array('January', 'Februaru', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    
    public static $_user_types = array(
        '1' => 'Super User',
        '2' => 'Store Admin',
        '3' => 'Sales Operator',
    );
    
    public static $_cart_types = array(
        'sale' => '1',
        'purchase' => '2',
    );
    
    public static $_vat = 1.5;
    public static $_vat_mode = '%';
    public static $_discount = 0;
    public static $_discount_mode = '%';
    
    public static $_num_zeros_for_barcode = array(
        '0' => '000000',
        '1' => '00000',
        '2' => '0000',
        '3' => '000',
        '4' => '00',
        '5' => '0',
        '6' => '',
    );
    
    public static $_available_payment_options = array(
        0 => 'Cache',
        1 => 'Debit Card',
        2 => 'Credit Card',
    );
    
    public static $_available_card_options = array(
        0 => 'Visa',
        1 => 'Master Card',
        2 => 'AMEX',
        3 => 'DBBL Nexus',
    );
}

?>