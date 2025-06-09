<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('blogs_model');
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
                $searchQuery = " (title like '%" . $searchValue . "%' or added_by like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->blogs_model->get_blogs($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $thumbnail = '<image src="'. site_url() . 'uploads/blogs/original/' . $role->thumbnail .'" style="max-height: 50px;"/>';
                    $data[] = array(
                        'blogs_id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'thumbnail' => $thumbnail,
                        'title' => $role->title,
                        'added_by' => $role->added_by,
                        'added_date' => date('d M Y', strtotime($role->added_date)),
                        'action' => '<a href="' . base_url('index.php/admin/blogs/edit/' . $role->blogs_id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>'
                        . '<a href="javascript:void(0);" data-href="' . base_url('index.php/admin/blogs/delete/' . $role->blogs_id) . '" onclick="deleteBlog(this);" data-name="' . $role->blogs_id . '" data-tb="blogs" class="btn btn-danger" style="color:#fff">Delete</a>'
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
        $this->load->view('blogs/list', $data);
//        <a href="' . base_url('admin/blogs/edit/' . $role->id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>
    }

    public function edit_blogs($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('flash_errmsg', 'The blogs details not found.');
            redirect('blogs');
        }
        $data = array();
        $data['model'] = $this->blogs_model->get_blogs_value($id);
        if (empty($data['model'])) {
            $this->session->set_flashdata('flash_errmsg', 'The blogs details not found.');
            redirect('index.php/admin/blogs');
        }
        $this->load->view('blogs/edit_blogs', $data);
    }

    public function add_blogs() {
        $data = array();
        $this->load->view('blogs/edit_blogs', $data);
    }

    public function store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $error = '';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'title ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('description', 'description', 'trim|required|xss_clean');
            $this->form_validation->set_rules('added_by', 'blogs_ans', 'trim|required|xss_clean');

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
                                'upload_path' => "./uploads/blogs/original/",
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
                
                //blogger image
                if (isset($_FILES['added_by_img']['name']) && ($_FILES['added_by_img']['name'] != '')) {
                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['added_by_img']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $blogger_img = 'profile_' . rand(10, 500) . time() . '.' . $extension;
                            
                            $config1 = array(
                                'upload_path' => "./uploads/blogs/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $blogger_img,
                            );
                            $this->load->library('upload', $config1);
                            $this->upload->initialize($config1);
                            $this->upload->do_upload('added_by_img');
                        }
                    }
                }
                //end blogger image
                if (empty($error)) {
                    $_data = array(
                        'title' => $this->input->post('title'),
                        'description' => $this->input->post('description'),
                        'added_by' => $this->input->post('added_by'),
                        'added_date' => date('Y-m-d H:i:s')
                    );
                    if (isset($filename)) {
                        $_data['thumbnail'] = $filename;
                    }
                    if (isset($blogger_img)) {
                        $_data['added_by_img'] = $blogger_img;
                    }
                    if (!empty($cid)) {
                        $this->blogs_model->updateBlogs($cid, $_data);
                        $this->response['message'] = " updated successfully.";
                    } else {
                        $this->blogs_model->insert_blogs($_data);
                        $this->response['message'] = "A new blog created successfully.";
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
    
    
   
   public function delete_blogs($id) {
        if ($this->input->is_ajax_request()) {
            $model = $this->blogs_model->get_blogs_value($id);
            if (!empty($model)) {
                $this->blogs_model->deleteBlogs($model->blogs_id);
                $this->response['message'] = "Blogs deleted successfully.";
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