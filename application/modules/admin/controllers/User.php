<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
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
                $searchQuery = " (name like '%" . $searchValue . "%' or phone like '%" . $searchValue . "%' or email like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->user_model->get_users($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $data[] = array(
                        'id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'name' => $role->name,
                        'email' => $role->email,
                        'phone' => $role->phone,
                        'postal_code' => $role->postal_code,
                        'updated_at' => !empty($role->updated_at) ? date('d M,Y', strtotime($role->updated_at)) : 'N/A',
                        'action' => '<a href="' . base_url($role->sub_domain . '/index') . '.html"  class="btn btn-primary" target="_blank">View Web <i class="ti-view"></i></a>'
                        . '<a href="' . base_url('index.php/admin/user/edit/' . $role->id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>
                     <a href="javascript:void(0);" data-href="' . base_url('index.php/admin/user/delete/' . $role->id) . '" onclick="deleteRole(this);" data-name="' . $role->id . '" data-tb="user" class="btn btn-danger" style="color:#fff">Delete</a>'
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
        $this->load->view('user/list', $data);
//        <a href="' . base_url('admin/user/edit/' . $role->id) . '"  class="btn btn-success">Edit <i class="ti-pencil"></i></a>
    }

    public function view_id($id) {
        $data = array();
        $data['model'] = $model = $this->user_model->get_user_value($id);
        $this->load->view('user/view_id', $data);
    }

    public function delete_user($id) {
        if ($this->input->is_ajax_request()) {
            $model = $this->user_model->get_user_value($id);
            if (!empty($model)) {
                $this->user_model->updateUser($model->id, array('status' => '3', 'updated_at' => date('Y-m-d')));
                $this->response['message'] = "User deleted successfully.";
                $this->response['status'] = 200;
            } else {
                $this->response['message'] = 'The user details not found.';
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function edit_user($id) {
        if (!is_numeric($id)) {
            $this->session->set_flashdata('flash_errmsg', 'The user details not found.');
            redirect('user');
        }
        $data = array();
        $data['model'] = $this->user_model->get_user_value($id);
        if (empty($data['model'])) {
            $this->session->set_flashdata('flash_errmsg', 'The user details not found.');
            redirect('index.php/admin/user');
        }
        $this->load->view('user/add_user', $data);
    }

    public function store() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $this->form_validation->set_rules('sub_domain', 'sub domain', 'trim|required|min_length[1]|max_length[100]|xss_clean');
            $sid = $this->input->post('sid') ?? '';

            if ($this->form_validation->run() == TRUE && $flag === 0) {
                if ($this->user_model->isUniquePhone($sid, $this->input->post('phone'))) {
                    if ($this->user_model->isUniqueDomain($sid, $this->input->post('sub_domain'))) {
                        $user_data = array(
                            'name' => $this->input->post('name'),
                            'phone' => $this->input->post('phone'),
                            'email' => $this->input->post('email'),
                            'sub_domain' => $this->input->post('sub_domain'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        if (!empty($sid) && is_numeric($sid)) {
                            $this->user_model->updateUser($sid, $user_data);
                            $orgObj = $this->user_model->get_user_value($sid);
                            $org_id = $orgObj->org_id;
                            $this->response['message'] = "updated successfully.";
                        }
                        $this->response['status'] = 200;
                    } else {
                        $this->response['message'] = array('sub_domain' => 'company brand sub domain already exist.');
                        $this->response['status'] = 500;
                    }
                } else {
                    $this->response['message'] = array('phone' => 'phone number already exist.');
                    $this->response['status'] = 500;
                }


//                $this->response['redirectUrl'] = base_url('user');
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function user_email_check($str, $sid) {
        if (!empty($str)) {
            $res = $this->user_model->checkStaffEmail($str, $sid);
            if (!empty($res)) {
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    public function getAllUsers() {
        if ($this->input->is_ajax_request()) {
            $searchValue = $_POST["keyword"]; // Search value
            if (!empty($searchValue)) {
                $searchQuery = " (agency_name like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->user_model->get_autocomplete_users($searchQuery);
            $html = '<ul id="user-list">';
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $html .= '<li data-id="' . $role->id . '" data-val="' . $role->agency_name . '" data-discount="' . $role->discount . '" data-address="' . $role->address . '" data-gstin="' . $role->gstin . '" data-pan_no="' . $role->pan_no . '" data-state="' . $role->state_name . '" data-state_code="' . $role->state_id . '">' . $role->agency_name . '</li>';
                }
            }
            $html .= '</ul>';
            echo $html;
            exit();
        }
    }

    public function getAllStates() {
        if ($this->input->is_ajax_request()) {
            $searchValue = $_POST["keyword"]; // Search value
            if (!empty($searchValue)) {
                $searchQuery = " (name like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->state_model->get_autocomplete_state($searchQuery);
            $html = '<ul id="state-list">';
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $html .= '<li data-id="' . $role->id . '" data-val="' . $role->name . '">' . $role->name . '</li>';
                }
            }
            $html .= '</ul>';
            echo $html;
            exit();
        }
    }

    public function getValue() {
        if ($this->input->is_ajax_request()) {
            $id = $_POST['id'];
            $model = $this->user_model->get_user_value($id);
            if (!empty($model)) {
                $this->response['form_type'] = $model->form_type;
                $this->response['discount'] = $model->discount;
                $this->response['status'] = 200;
            } else {
                $this->response['message'] = 'The design not found.';
                $this->response['status'] = 400;
            }
            echo json_encode($this->response);
            exit();
        }
    }

}

?>