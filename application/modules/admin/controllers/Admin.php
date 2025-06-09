<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author http://www.roytuts.com
 */
class Admin extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');

        if ($this->session->userdata('logged_in') && $this->session->userdata('admin_id')) {
            redirect('index.php/admin/dasboard');
        }
    }

    function index() {
        
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        if ($this->input->post('loginAdmin')) {
            
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $pwd = md5($this->input->post('password'));
                $conditions = array('email' => $email, 'password' => $pwd);
                if ($this->user_model->loginAsAdmin($conditions)) {
                    
                    $this->user_model->setAdminSession($conditions);
                    
                    redirect('index.php/admin/dasboard');
                } else {

                    $this->session->set_flashdata('flash_message', $this->user_model->admin_flash_message('error', 'EmailId/Password mismatch.'));
                }
            }
        }
        $this->load->view('login');
    }

}
