<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('products_model');
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
                $searchQuery = " (title like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->products_model->get_products($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $thumbnail = '<image src="'. site_url() . 'uploads/products/original/' . $role->thumbnail .'" style="max-height: 50px;"/>';
                    $data[] = array(
                        'products_id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'thumbnail' => $thumbnail,
                        'title' => $role->title,
                        'description' => $role->description,
                        'action' => '<a href="' . base_url('index.php/admin/products/edit/' . $role->products_id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>'
                        . '<a href="javascript:void(0);" data-href="' . base_url('index.php/admin/products/delete/' . $role->products_id) . '" onclick="deleteBlog(this);" data-name="' . $role->products_id . '" data-tb="products" class="btn btn-danger" style="color:#fff">Delete</a>'
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
        $this->load->view('products/list', $data);
//        <a href="' . base_url('admin/products/edit/' . $role->id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>
    }

    public function edit_products($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('flash_errmsg', 'The products details not found.');
            redirect('products');
        }
        $data = array();
        $data['model'] = $this->products_model->get_products_value($id);
        if (empty($data['model'])) {
            $this->session->set_flashdata('flash_errmsg', 'The products details not found.');
            redirect('index.php/admin/products');
        }
        $this->load->view('products/edit_products', $data);
    }

    public function add_products() {
        $data = array();
        $this->load->view('products/edit_products', $data);
    }

    public function store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $error = '';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'title ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');

            $cid = $this->input->post('cid') ?? '';
            
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                
                if (isset($_FILES['thumbnail']['name']) && ($_FILES['thumbnail']['name'] != '')) {
                    
                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $filename = 'blog_' . rand(10, 500) . time() . '.' . $extension;
                            
                            $config = array(
                                'upload_path' => "./uploads/products/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $filename,
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('thumbnail'))
                            {
                               $error = array('error' => $this->upload->display_errors());
                               //print_r($error);exit;
                            }
                        }
                    }
                }
                
                //end blogger image
                if (empty($error)) {
                    $_data = array(
                        'title' => $this->input->post('title'),
                        'description' => $this->input->post('description'),
                    );
                    if (isset($filename)) {
                        $_data['thumbnail'] = $filename;
                    }
                    if (!empty($cid)) {
                        $this->products_model->updateProducts($cid, $_data);
                        $this->response['message'] = " updated successfully.";
                    } else {
                        $this->products_model->insert_products($_data);
                        $this->response['message'] = "A new product created successfully.";
                    }

                    $this->response['status'] = 200;
                    //$this->response['redirectUrl'] = base_url('article');
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                if ($flag === 1) {
                    $error_msgs['thumbnail'] = 'Thumbnail image needed.';
                }
                if (!empty($error)) {
                    $error_msgs['thumbnail'] = $error;
                }
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }
    
    
   
   public function delete_products($id) {
        if ($this->input->is_ajax_request()) {
            $model = $this->products_model->get_products_value($id);
            if (!empty($model)) {
                $this->products_model->deleteProducts($model->products_id);
                $this->response['message'] = "Products deleted successfully.";
                $this->response['status'] = 200;
            } else {
                $this->response['message'] = 'The blog details not found.';
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }
}

?>