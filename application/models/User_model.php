<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insert_contact_us($_data) {
        $this->db->insert(TBL_CONTACTUS, $_data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insert_news_subscription($_data) {
        $this->db->insert(TBL_NEWSSUBSCRIPTION, $_data);

        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insert_user($_data) {
        $this->db->insert(TBL_USER_MASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function insert_organisation($_data) {
        $this->db->insert(TBL_ORGANISATIONMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function get_phone_value($phone) {

        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('phone', $phone)->get()->row_object();
    }

    function get_active_user_phone_value($phone) {

        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('phone', $phone)->where('status', '1')->get()->row_object();
    }

    function get_email_value($email) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('email', $email)->get()->row_object();
    }

    function get_email_code_value($email_code) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('email_code', $email_code)->get()->row_object();
    }

    function get_reset_password_code_value($reset_password_code) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('reset_password_code', $reset_password_code)->get()->row_object();
    }

    function updateUser($rid, $updateData = array()) {
        $this->db->where('id', $rid);
        $result = $this->db->update(TBL_USER_MASTER, $updateData);
        return $result;
    }

    function get_user_addresses($user_id) {
        return $this->db->select('*')
                        ->from(TBL_ADDRESSES)->where('user_id', $user_id)->get()->result_object();
    }

    function get_user_address_value($id) {
        return $this->db->select('*')
                        ->from(TBL_ADDRESSES)->where('address_id', $id)->get()->row_object();
    }

    function get_user_value($id) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('id', $id)->where('status!=', '3')->get()->row_object();
    }

    function loginAsUser($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $this->db->select('id');
        $result = $this->db->get(TBL_USER_MASTER);

        if ($result->num_rows() > 0)
            return true;
        else
            return false;
    }

    function setUserSession($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('*');
        $result = $this->db->get(TBL_USER_MASTER);
        if ($result->num_rows() > 0) {

            $row = $result->row();
            $values = array('user_id' => $row->id, 'org_id' => $row->org_id, 'user_name' => $row->name, 'user_email' => $row->email, 'company_code' => $row->company_code,'accessType'=>'','sub_domain'=>$row->sub_domain, 'logged_in' => TRUE);
        }
        $this->session->set_userdata($values);
    }

    function updateOrganisation($org_id, $updateData = array()) {

        $this->db->where('org_id', $org_id);

        $result = $this->db->update(TBL_ORGANISATIONMASTER, $updateData);

        return $result;
    }

    function get_staff_phone_value($phone) {

        return $this->db->select('*')
                        ->from(TBL_STAFFMASTER)->where('phone', $phone)->get()->row_object();
    }

    function updateStaff($rid, $updateData = array()) {
        $this->db->where('staff_id', $rid);
        $result = $this->db->update(TBL_STAFFMASTER, $updateData);
        return $result;
    }

    function setStaffUserSession($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('*');
        $result = $this->db->get(TBL_STAFFMASTER);
        if ($result->num_rows() > 0) {

            $row = $result->row();
            $this->db->where(array('org_id' => $row->org_id));

            $this->db->select('*');
            $result = $this->db->get(TBL_USER_MASTER)->row();

            $values = array('user_id' => $row->staff_id, 'org_id' => $row->org_id, 'user_name' => $row->first_name, 'user_email' => $row->email_id, 'company_code' => $result->company_code,'accessType'=>'staff', 'logged_in' => TRUE);
        }
        $this->session->set_userdata($values);
    }
    
    function insertOrgUser($_data) {
        $this->db->insert(TBL_ORGANISATIONUSER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    // Default Setup
    function get_cms_global() {
        return $this->db->select('*')
                ->from(TBL_CMSDEFAULTGLOBAL)->get()->result_object();
    }
    
    function insert_cms_mgm_batch($bach_data){
        $this->db->insert_batch(TBL_CMS, $bach_data);
    }
    
    function get_user_brand_exist($brand_name)
    {

        return $this->db->select('*')
            ->from(TBL_USER_MASTER)
            ->where('sub_domain', $brand_name)->get()->row_object();
    }
    
    function get_permission_global() {
        return $this->db->select('*')
                ->from(TBL_ASSIGNPERMISSIONDEFAULT)->get()->result_object();
    }
    
    function insert_permission_batch($bach_data){
        $this->db->insert_batch(TBL_ASSIGNPERMISSION, $bach_data);
    }
    
    function insertClient($data) {

        $this->db->insert(TBL_CLIENTMASTER, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
}
