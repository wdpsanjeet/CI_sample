<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('cms_model');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('admin_role')!='0') {
            redirect('admin');
        }
    }

    public function index() {
        $data = array();
        if ($this->input->is_ajax_request()) {
            // Datatables Variables
            $searchQuery = '';
            $draw = intval($this->input->get("draw"));
            $start = intval($this->input->get("start"));
            $length = intval($this->input->get("length"));
            $columnIndex = $this->input->get('order')[0]['column']; // Column index
            $columnName = $this->input->get('columns')[$columnIndex]['data'];
            $columnSortOrder = $this->input->get('order')[0]['dir']; // asc or desc
            $searchValue = $this->input->get('search')['value']; // Search value
            if (!empty($searchValue)) {
                $searchQuery = " (section like '%" . $searchValue . "%' or page_name like '%" . $searchValue . "%' or type like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->cms_model->get_cms($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    if($role->type=='text'){
                        $cms_data = $this->all_function->limit_HTMLtext($role->cms_data,'4');
                    }elseif($role->type=='image'){
                        $cms_data = '<image src="'. site_url() . 'uploads/banners/original/' . $role->cms_data .'" style="max-height: 50px;"/>';
                    }elseif($role->type=='video'){
                        $cms_data = $role->cms_data;//preg_replace('/width="560" height="315"/', 'width="100" height="100"', $role->cms_data);
                    }elseif($role->type=='rating'){
                        $cms_data = $role->cms_data;//preg_replace('/width="560" height="315"/', 'width="100" height="100"', $role->cms_data);
                    }
                    $data[] = array(
                        'cms_id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'page_name' => $role->page_name,
                        'section' => $role->section,
                        'type' => $role->type,
                        'cms_data' => $cms_data,
                        'action' => '<a href="' . base_url('index.php/admin/cms/edit/' . $role->cms_id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>'
                    );
                }
            }
            $output = array(
                "draw" => $draw,
                "recordsTotal" => (int) $roles['total'],
                "recordsFiltered" => (int) $roles['total'],
                "data" => $data
            );
            echo json_encode($output);
            exit();
        }
        $this->load->view('cms/list', $data);
//        <a href="' . base_url('admin/cms/edit/' . $role->id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>
    }
    

    public function edit_cms($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('flash_errmsg', 'The cms details not found.');
            redirect('cms');
        }
        $data = array();
        $data['model'] = $this->cms_model->get_cms_value($id);
        if (empty($data['model'])) {
            $this->session->set_flashdata('flash_errmsg', 'The cms details not found.');
            redirect('index.php/admin/cms');
        }
        $this->load->view('cms/edit_cms', $data);
    }

    public function store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $sid = $this->input->post('sid');
            if (isset($_POST['content'])) {
                $cms_data = array(
                    'cms_data' => $this->input->post('content'),
                );
                $this->cms_model->updateCms($sid, $cms_data);
                $this->response['message'] = "Content updated successfully.";
            }
            if (isset($_FILES['banner']['name']) && ($_FILES['banner']['name'] != '')) {
                if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                    $error = 'This file have some problem.';
                } else {
                    $allowed = array('gif','png', 'jpg', 'gif', 'jpeg');
                    $extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extension), $allowed)) {
                        $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                    } else {
                        $filename = 'banner_' . rand(10, 500) . time() . '.' . $extension;
                        $config = array(
                            'upload_path' => "./uploads/banners/original/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'overwrite' => TRUE,
                            'file_name' => $filename,
//                            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
//                            'max_height' => "768",
//                            'max_width' => "1024"
                        );
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                            if (!$this->upload->do_upload('banner'))
                            {
                               $error = array('error' => $this->upload->display_errors());
                               //print_r($error);exit;
                            }
                        
                        $cms_data = array(
                            'cms_data' => $filename,
                        );
                        $this->cms_model->updateCms($sid, $cms_data);
                        $this->response['message'] = "Banner updated successfully.";
                    }
                }
            }
            $this->response['status'] = 200;

//                $this->response['redirectUrl'] = base_url('cms');

            echo json_encode($this->response);
            exit();
        }
    }


}

?>