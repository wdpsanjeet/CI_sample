<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contactus extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('contactus_model');
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
                $searchQuery = " (first_name like '%" . $searchValue . "%' or email_id like '%" . $searchValue . "%' or last_name like '%" . $searchValue . "%') ";
            }
            $data = array();
            $roles = $this->contactus_model->get_contacts($length, $start, $searchQuery, $columnName, $columnSortOrder);
            if (sizeof($roles['result']) > 0) {
                foreach ($roles['result'] as $i => $role) {
                    $data[] = array(
                        'contact_id' => ($start == 0) ? ++$i : $start + ( ++$i),
                        'first_name' => $role->first_name,
                        'last_name' => $role->last_name,
                        'email_id' => $role->email_id,
                        'message' => $role->message,
                        'comment' => $role->comment,
                        'added_at' => date('d M Y', strtotime($role->added_at))
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
        $this->load->view('contactus/list', $data);
    }
}

?>