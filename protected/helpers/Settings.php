<?php

class Settings {

    /**
     * static funtion to convert time to Bangladeshi local time.
     * @param void.
     * @return returns timestamp.
     */
    public static function getBdLocalTime() {
        date_default_timezone_set('Asia/Dhaka');
        return time();
    }

    public static $_payment_types = array('1' => 'Cash', '2' => 'Cheque');
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
    public static $_discount_mode = '';
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
        0 => 'Cash',
        1 => 'Debit Card',
        2 => 'Credit Card',
    );
    public static $_available_card_options = array(
        0 => 'Visa',
        1 => 'Master Card',
        2 => 'AMEX',
        3 => 'DBBL Nexus',
    );

    public static function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 1)
            return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getToken($length, $b_alpha_num = true) {
        $token = "";
        
        $codeAlphabet = '';
        if ($b_alpha_num) {
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        }

        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[self::crypto_rand_secure(0, $max)];
        }
        return $token;
    }

}

?>