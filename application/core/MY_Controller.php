<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller {

    public $ajax_response;
    private $CI;
    function __construct() {
        parent::__construct();
        if (version_compare(CI_VERSION, '2.1.0', '<')) {
            $this->load->library('security');
        }
        if (!defined('IS_AJAX')) {
            if ($this->input->is_ajax_request() && !defined('IS_AJAX')) {
                define('IS_AJAX', TRUE);
            } else {
                define('IS_AJAX', FALSE);
            }
        }
        if (IS_AJAX) {
            $this->ajax_response = array(
                'is_login' => 0,
                'ok' => 1,
                'message' => array(),
                'data' => '',
            );
        }
        
        
        $this->session->set_userdata('user_lang', '');
        $this->config->set_item('language', 'english');
        $this->lang->load('information', 'english');
    }

    function render_ajax_response($type = "JSON") {
        if (IS_AJAX) {
            switch ($type) {
                case 'JSON':echo json_encode($this->ajax_response);
                    exit;
            }
        } else {
            redirect();
            exit;
        }
    }
    function is_logged_in(){
        if(get_cookie('user_id')!=''){
            $this->CI = & get_instance();
            $this->CI->load->database();
            return $this->CI->db->select('*')
                        ->from(TBL_USER_MASTER)->where('id', get_cookie('user_id'))->where('status!=', '3')->get()->row_object();
            
            
        }
    }
            function ajax_response($data) {
        echo json_encode($data);
    }

    function isAdmin() {
        $CI = & get_instance();
        return ($CI->session->userdata('admin_role') == 'admin' || $CI->session->userdata('admin_role') == 'staff') ? TRUE : FALSE;
    }

}