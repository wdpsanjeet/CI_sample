<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    public function __construct() {
        parent::__construct();
    }

    function valid_url_format($str) {
        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $str)) {
            $this->set_message('valid_url_format', 'The URL you entered is not correctly formatted.');
            return FALSE;
        }

        return TRUE;
    }

    public function get_errors() {
        $error_arr = array();
        foreach ($this->_error_array as $key => $val) {
            array_push($error_arr, $val);
        }
        return $error_arr;
    }

    public function error_array() {
        return $this->_error_array;
    }

}
