<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Logout extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $this->user_model->clearAdminSession();

        $this->session->set_flashdata('flash_message', $this->user_model->admin_flash_message('success', 'Successfully logout'));
        redirect('index.php/admin');
    }

//End of index function
}