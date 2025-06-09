<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Drivers extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('drivers_model');
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
                $searchQuery = " (d.name like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->drivers_model->get_cms($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    if ($role->status == '1') {
                        $status = 'Active';
                    } else {
                        $status = 'In-active';
                    }
                    $data[] = array(
                        'driver_id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'phone' => $role->phone,
                        'name' => $role->name,
                        'company_code' => $role->company_code,
                        'added_at' => date('d/m/Y / g:i A', strtotime($role->added_at)),
                        'status' => $status,
                        'action' => '<a href="' . base_url('index.php/admin/drivers/edit/' . $role->driver_id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>'
                        . '<a href="javascript:void(0);" data-href="' . base_url('index.php/admin/drivers/delete/' . $role->driver_id) . '" onclick="deleteBlog(this);" data-name="' . $role->driver_id . '" data-tb="drivers" class="btn btn-danger" style="color:#fff">Delete</a>'
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
        $this->load->view('drivers/list', $data);
//        <a href="' . base_url('admin/cms/edit/' . $role->id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>
    }

    public function edit_drivers($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('flash_errmsg', 'The cms details not found.');
            redirect('cms');
        }
        $data = array();
        $data['model'] = $this->drivers_model->get_cms_value($id);
        if (empty($data['model'])) {
            $this->session->set_flashdata('flash_errmsg', 'The cms details not found.');
            redirect('index.php/admin/cms');
        }
        $this->load->view('drivers/edit_drivers', $data);
    }

    public function add_drivers() {
        $data = array();
        $this->load->view('drivers/edit_drivers', $data);
    }

    public function store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $error = '';
            $this->load->library('form_validation');
            $this->form_validation->set_rules('phone', 'phone ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('name', 'name ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('company_code', 'company code ', 'trim|required|xss_clean'); 
            $this->form_validation->set_rules('truck_number', 'truck number ', 'trim|required|xss_clean');
            $cid = $this->input->post('cid') ?? '';

            if ($this->form_validation->run() == TRUE && $flag === 0) {

                if (empty($error)) {
                    $_data = array(
                        'phone' => $this->input->post('phone'),
                        'company_code' => $this->input->post('company_code'),
                        'name' => $this->input->post('name'),
                        'truck_number' => $this->input->post('truck_number'),
                        'status' => $this->input->post('status'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    if (!empty($cid)) {
                        $driverDetails = $this->drivers_model->get_driver_exist_phone($cid, $this->input->post('phone'));
                        if (empty($driverDetails)) {
                            $this->drivers_model->updateDrivers($cid, $_data);
                            $this->response['message'] = " updated successfully.";
                            $this->response['status'] = 200;
                        } else {
                            $error = 'Driver account already exist.';
                            $this->response['status'] = 400;
                        }
                    } else {
                        $_data['added_at'] = date('Y-m-d H:i:s');
                        $driverDetails = $this->drivers_model->get_driver_by_phone($this->input->post('phone'));
                        if (empty($driverDetails)) {
                            $this->drivers_model->insertDrivers($_data);
                            $this->response['message'] = "A new drivers created successfully.";
                            $this->response['status'] = 200;
                        } else {
                            $this->response['message'] = 'Driver account already exist.';
                            $this->response['status'] = 400;
                        }
                    }
                } else {
                    $this->response['message'] = $error;
                    $this->response['status'] = 400;
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                if ($flag === 1) {
                    $error_msgs['video_image'] = 'Video image needed.';
                }
                if (!empty($error)) {
                    $error_msgs['video_image'] = $error;
                }
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function delete_drivers($id) {
        if ($this->input->is_ajax_request()) {
            $model = $this->drivers_model->get_cms_value($id);
            if (!empty($model)) {
                $this->drivers_model->deleteDrivers($model->driver_id);
                $this->response['message'] = "Drivers deleted successfully.";
                $this->response['status'] = 200;
            } else {
                $this->response['message'] = 'The drivers details not found.';
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

}

?>