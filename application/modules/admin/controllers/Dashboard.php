<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        if (!$this->session->userdata('admin_id')) {
            redirect('index.php/admin/login');
        }
    }

    function index() {
        $conditions = array();
        $this->load->view('dashboard');
    }

    function editProfile() {
        $adminid = $this->session->userdata('admin_id');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_error_delimiters('', '');

        if ($this->input->post('updatePersonalinfo')) {

            $this->form_validation->set_rules('admin_name', 'name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|xss_clean');
            if ($this->form_validation->run()) {
                $updateData = array();

                $updateData['admin_name'] = $this->input->post('admin_name');
                $updateData['email'] = $this->input->post('email');

                $updateKey = array('admins.id' => $adminid);

                $this->user_model->updateAdmin($updateKey, $updateData);
                $this->session->set_flashdata('flash_message', $this->user_model->admin_flash_message('success', $this->lang->line('updated_success')));
                redirect('index.php/admin/editProfile?tab=personal');
            }
        }
        if ($this->input->post('updatePassword')) {
            //Set rules
            $this->form_validation->set_rules('old_password', 'old password ', 'required|trim|xss_clean');
            $this->form_validation->set_rules('password', 'password', 'required|trim|xss_clean');
            $this->form_validation->set_rules('confirm_password', 'confirm password', 'required|trim|xss_clean');

            if ($this->form_validation->run() == TRUE) {

                //prepare update data
                $updateData = array();
                $old_password = $this->input->post('old_password');
                if ($this->user_model->isOldPasswordCorrect($adminid, $old_password)) {
                    $updateData['password'] = md5($this->input->post('password'));
                    $updateKey = array('admins.id' => $adminid);
                    $this->user_model->updateAdmin($updateKey, $updateData);

                    //Notification message
                    $this->session->set_flashdata('flash_succmsg', 'Your password has been updated.');
                    redirect('index.php/admin/editProfile?tab=contacts');
                    //redirect('edit-profile?tab=contacts');
                } else {
                    $this->session->set_flashdata('flash_errmsg', 'Your old password is not correct.');
                    redirect('index.php/admin/editProfile?tab=contacts');
                }
            }
        }
        $condition = array('admins.id' => $adminid);
        $data = $this->user_model->viewAdmin($condition);
        $outputData['admin'] = $data[0];

        $this->load->view('editProfile', $outputData);
    }

    

}
