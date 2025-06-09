<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('settings_model');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('admin_role')!='0') {
            redirect('admin');
        }
    }

    public function index() {

        $data = array();
        $data['all_settings'] = $this->settings_model->get_all_settings();
        $this->load->view('settings/edit_settings', $data);
    }

    public function store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $error = '';
            $all_settings = $this->settings_model->get_all_settings();
            foreach ($all_settings as $k => $v) {
                $_data = array(
                    'slug_data' => $this->input->post($v->slug_name),
                );
                $this->settings_model->updateSettings($v->slug_name, $_data);
            }
            $this->response['message'] = " updated successfully.";

            $this->response['status'] = 200;
            //$this->response['redirectUrl'] = base_url('article');

            echo json_encode($this->response);
            exit();
        }
    }
    public function presentation_update() {

        $data = array();
        $data['model'] = $this->settings_model->get_presentation_value('1');
        $this->load->view('settings/edit_presentation', $data);
    }
    public function presentation_store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $error = '';

            $cid = $this->input->post('cid') ?? '';

                if (isset($_FILES['presentation_doc']['name']) && ($_FILES['presentation_doc']['name'] != '')) {
                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                            $extension = pathinfo($_FILES['presentation_doc']['name'], PATHINFO_EXTENSION);
                            $doc_filename = 'presentation_doc_' . rand(10, 500) . time() . '.' . $extension;
                            
                            $config = array(
                                'upload_path' => "./uploads/presentation/documents/",
                                'allowed_types' => "gif|jpg|png|doc|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $doc_filename,
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            $this->upload->do_upload('presentation_doc');
                    }
                }
                
                
                if (empty($error)) {
                    if (isset($doc_filename)) {
                        $_data['presentation_doc'] = $doc_filename;
                    }
                    if (!empty($cid)) {
                        $this->settings_model->updatePresentation($cid, $_data);
                        $this->response['message'] = "Presentation updated successfully.";
                    } 

                    $this->response['status'] = 200;
                    //$this->response['redirectUrl'] = base_url('article');
                }
           
            echo json_encode($this->response);
            exit();
        }
    }
}

?>