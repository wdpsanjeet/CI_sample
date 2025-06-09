<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function admin_flash_message($type, $message) {
        switch ($type) {
            case 'success':
                $data = '<div class="message"><div class="success">' . $message . '</div></div>';
                break;
            case 'error':
                $data = '<div class="message"><div class="error">' . $message . '</div></div>';
                break;
        }
        return $data;
    }

    function loginAsAdmin($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $this->db->select('admins.id');
        $result = $this->db->get(TBL_ADMIN);

        if ($result->num_rows() > 0)
            return true;
        else
            return false;
    }

    function setAdminSession($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('*');
        $result = $this->db->get(TBL_ADMIN);
        if ($result->num_rows() > 0) {

            $row = $result->row();
            $values = array('admin_id' => $row->id, 'admin_name' => $row->admin_name, 'email' => $row->email, 'logged_in' => TRUE, 'admin_role' => $row->role);
            
        }
        $this->session->set_userdata($values);
    }

    function viewAdmin($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('*');
        $result = $this->db->get(TBL_ADMIN);
        return $result->result();
    }

    function updateAdmin($conditions = array(), $updateData = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $result = $this->db->update(TBL_ADMIN, $updateData);
        return $result;
    }

    function clearAdminSession() {

        $array_items = array('admin_id' => '', 'logged_in_admin' => '', 'admin_role' => '');
        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
    }

    function isOldPasswordCorrect($user_id, $old_password) {
        $result = $this->db->select('count(id) as TotNum')
                        ->from('admins')
                        ->where('id', $user_id)->where('password', md5($old_password))->get()->result_array();
        $TotNum = $result[0]['TotNum'];
        if ($TotNum > 0) {
            return true;
        } else {
            return false;
        }
    }

    

    function checkStaffEmail($email, $sid) {
        $this->db->select('COUNT(*)')
                ->from(TBL_ADMIN);
        if (!empty($sid) && is_numeric($sid)) {
            $this->db->where('id!=', $sid);
        }
        return $this->db->where('email', $email)->where('status!=', '3')->get()->row_array()['COUNT(*)'];
    }

    function insert_staff($staff_data) {
        $this->db->insert(TBL_ADMIN, $staff_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function updateStaff($rid, $updateData = array()) {
        $this->db->where('id', $rid);
        $result = $this->db->update(TBL_ADMIN, $updateData);
        return $result;
    }

    function get_staff_value($id) {
        return $this->db->select('*')
                        ->from(TBL_ADMIN)->where('id', $id)->where('status!=', '3')->get()->row_object();
    }
    function get_user_value($id) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('id', $id)->where('status!=', '3')->get()->row_object();
    }
    function get_users($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_USER_MASTER)->where('status!=', '3');
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        if (!empty($columnName) && !empty($columnSortOrder)) {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    function updateUser($rid, $updateData = array()) {
        $this->db->where('id', $rid);
        $result = $this->db->update(TBL_USER_MASTER, $updateData);
        return $result;
    }
    
    function isUniquePhone($user_id,$phone){
        $result = $this->db->select('COUNT(id) as TotNum')
                        ->from(TBL_USER_MASTER)->where('phone', $phone)->where('id!=', $user_id)->get()->row_object();
        if($result->TotNum>0){
            return false;
        }else{
            return true;
        }
    }
    
    function isUniqueDomain($user_id,$sub_domain){
        $result = $this->db->select('COUNT(id) as TotNum')
                        ->from(TBL_USER_MASTER)->where('sub_domain', $sub_domain)->where('id!=', $user_id)->get()->row_object();
        if($result->TotNum>0){
            return false;
        }else{
            return true;
        }
    }
}
