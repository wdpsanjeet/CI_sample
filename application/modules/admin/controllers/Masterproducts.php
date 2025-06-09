<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Masterproducts extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('masterproducts_model');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('admin_role') != '0') {
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
                $searchQuery = " (vp.product_number like '%" . $searchValue . "%' or vp.item_name like '%" . $searchValue . "%' or catid.category_name like '%" . $searchValue . "%' or subcatid.category_name like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->masterproducts_model->get_masterproducts($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $img = '<img src="' . base_url('uploads/varthak_product/') . $role->image_name . '" style="height:75px;width:100%" />';
                    $data[] = array(
                        'id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'image_name' => $img,
                        'product_number' => $role->product_number,
                        'item_name' => $role->item_name,
                        'category_name' => $role->category_name,
                        'subcategory_name' => $role->subcategory_name,
                        'nature_of_goods' => !empty($role->nature_of_goods) ? $role->nature_of_goods : 'N/A',
                        'action' => '<a href="' . base_url('index.php/admin/masterproducts/edit/' . $role->product_id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>'
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
        $this->load->view('masterproducts/list', $data);
    }
    
    public function add_masterproducts() {
        
        $data = array();
        $data['category'] = $this->masterproducts_model->get_master_category();
        $this->load->view('masterproducts/add', $data);
    }

    public function edit_masterproducts($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('flash_errmsg', 'The masterproducts details not found.');
            redirect('masterproducts');
        }
        $data = array();
        $data['model'] = $this->masterproducts_model->get_masterproducts_value($id);
        if (empty($data['model'])) {
            $this->session->set_flashdata('flash_errmsg', 'The masterproducts details not found.');
            redirect('index.php/admin/masterproducts');
        }
        $data['category'] = $this->masterproducts_model->get_master_category();
        $data['subcategory'] = $this->masterproducts_model->get_master_sub_category($data['model']->category_id);
        $this->load->view('masterproducts/add', $data);
    }

    public function domasterproducts() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_number', 'product number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('item_name', 'item name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('search_name', 'search name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('category_id', 'category id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('subcategory_id', 'subcategory id', 'trim|required|xss_clean');
            $sid = $this->input->post('sid') ?? '';

            if ($this->form_validation->run() == TRUE && $flag === 0) {
                if (!empty($sid) && is_numeric($sid)) {
                    //update
                    if ($this->masterproducts_model->isProductNumExistExceptSelf($sid, $this->input->post('product_number'))) {
                        $_data = array(
                            'product_number' => $this->input->post('product_number'),
                            'item_name' => $this->input->post('item_name'),
                            'search_name' => $this->input->post('search_name'),
                            'category_id' => $this->input->post('category_id'),
                            'subcategory_id' => $this->input->post('subcategory_id'),
                            'brand' => $this->input->post('brand'),
                            'quantity' => $this->input->post('quantity'),
                            'unit' => $this->input->post('unit'),
                            'selling_price' => $this->input->post('selling_price'),
                            'purchase_price' => $this->input->post('purchase_price'),
                            'item_group' => $this->input->post('item_group'),
                            'product_hsn' => $this->input->post('product_hsn'),
                            'EAN' => $this->input->post('EAN'),
                            'shelf_life' => $this->input->post('shelf_life'),
                            'is_batchable' => $this->input->post('is_batchable'),
                            'is_bom_item' => $this->input->post('is_bom_item'),
                            'gst_percentage' => $this->input->post('gst_percentage'),
                            'material_type' => $this->input->post('material_type'),
                            'nature_of_goods_code' => $this->input->post('nature_of_goods_code'),
                            'nature_of_goods' => $this->input->post('nature_of_goods'),
                            'active' => $this->input->post('active'),
                            'stock_qty' => $this->input->post('stock_qty'),
                            'stock_value' => $this->input->post('stock_value'),
                        );
                        if (isset($_FILES['image_name']['name']) && ($_FILES['image_name']['name'] != '')) {

                            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                                $error = 'This file have some problem.';
                            } else {
                                $allowed = array('png', 'jpg', 'gif', 'jpeg');
                                $extension = pathinfo($_FILES['image_name']['name'], PATHINFO_EXTENSION);
                                if (!in_array(strtolower($extension), $allowed)) {
                                    $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                                } else {
                                    $image_name = $this->input->post('product_number') . '.' . $extension;

                                    $config = array(
                                        'upload_path' => "./uploads/varthak_product/",
                                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                        'overwrite' => TRUE,
                                        'file_name' => $image_name,
                                    );
                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('image_name')) {
                                        $error = array('error' => $this->upload->display_errors());
                                        //print_r($error);exit;
                                    }
                                }
                            }
                        }
                        if (isset($image_name)) {
                            $_data['image_name'] = $image_name;
                        }
                        $this->masterproducts_model->updateMasterproducts($sid,$_data);
                        $this->response['message'] = "Item updated successfully.";
                        $this->response['status'] = 200;
                    } else {
                        $this->response['message'] = "Product number already exist.";
                        $this->response['status'] = 400;
                    }
                } else {
                    //insert
                    if ($this->masterproducts_model->isProductNumExist($this->input->post('product_number'))) {
                        $_data = array(
                            'product_number' => $this->input->post('product_number'),
                            'item_name' => $this->input->post('item_name'),
                            'search_name' => $this->input->post('search_name'),
                            'category_id' => $this->input->post('category_id'),
                            'subcategory_id' => $this->input->post('subcategory_id'),
                            'brand' => $this->input->post('brand'),
                            'quantity' => $this->input->post('quantity'),
                            'unit' => $this->input->post('unit'),
                            'selling_price' => $this->input->post('selling_price'),
                            'purchase_price' => $this->input->post('purchase_price'),
                            'item_group' => $this->input->post('item_group'),
                            'product_hsn' => $this->input->post('product_hsn'),
                            'EAN' => $this->input->post('EAN'),
                            'shelf_life' => $this->input->post('shelf_life'),
                            'is_batchable' => $this->input->post('is_batchable'),
                            'is_bom_item' => $this->input->post('is_bom_item'),
                            'gst_percentage' => $this->input->post('gst_percentage'),
                            'material_type' => $this->input->post('material_type'),
                            'nature_of_goods_code' => $this->input->post('nature_of_goods_code'),
                            'nature_of_goods' => $this->input->post('nature_of_goods'),
                            'active' => $this->input->post('active'),
                            'stock_qty' => $this->input->post('stock_qty'),
                            'stock_value' => $this->input->post('stock_value'),
                        );
                        if (isset($_FILES['image_name']['name']) && ($_FILES['image_name']['name'] != '')) {

                            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                                $error = 'This file have some problem.';
                            } else {
                                $allowed = array('png', 'jpg', 'gif', 'jpeg');
                                $extension = pathinfo($_FILES['image_name']['name'], PATHINFO_EXTENSION);
                                if (!in_array(strtolower($extension), $allowed)) {
                                    $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                                } else {
                                    $image_name = $this->input->post('product_number') . '.' . $extension;

                                    $config = array(
                                        'upload_path' => "./uploads/varthak_product/",
                                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                        'overwrite' => TRUE,
                                        'file_name' => $image_name,
                                    );
                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);
                                    if (!$this->upload->do_upload('image_name')) {
                                        $error = array('error' => $this->upload->display_errors());
                                        //print_r($error);exit;
                                    }
                                }
                            }
                        }
                        if (isset($image_name)) {
                            $_data['image_name'] = $image_name;
                        }
                        $this->masterproducts_model->insertMasterproducts($_data);
                        $this->response['message'] = "Item created successfully.";
                        $this->response['status'] = 200;
                    } else {
                        $this->response['message'] = "Product number already exist.";
                        $this->response['status'] = 400;
                    }
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function get_subcategory() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_id', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $sub_category = $this->masterproducts_model->get_master_sub_category($this->input->post('category_id'));
                $optionHTML = '';
                foreach ($sub_category as $list) {
                    $optionHTML .= '<option value="' . $list->category_id . '">' . $list->category_name . '</option>';
                }
                $this->response['message'] = $optionHTML;
                $this->response['status'] = 200;

//                $this->response['redirectUrl'] = base_url('user');
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function add_category() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('new_category', 'new category ', 'trim|required|min_length[1]|max_length[100]|xss_clean');

            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $_data = array(
                    'category_name' => $this->input->post('new_category'),
                    'parent_id' => 0,
                );
                $insert_id = $this->masterproducts_model->insertMasterCategory($_data);
                $optionHTML = '<option value="' . $insert_id . '" selected="selected">' . $this->input->post('new_category') . '</option>';
                $this->response['message'] = $optionHTML;
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function add_subcategory() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('new_subcategory', 'new sub category ', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('parent_id', 'parent id ', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $_data = array(
                    'category_name' => $this->input->post('new_subcategory'),
                    'parent_id' => $this->input->post('parent_id'),
                );
                $insert_id = $this->masterproducts_model->insertMasterCategory($_data);
                $optionHTML = '<option value="' . $insert_id . '" selected="selected">' . $this->input->post('new_subcategory') . '</option>';
                $this->response['message'] = $optionHTML;
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

}

?>