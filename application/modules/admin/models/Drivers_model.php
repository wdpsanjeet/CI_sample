<?php

class Drivers_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_cms_value($id) {
        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('driver_id', $id)->get()->row_object();
    }
    
    function get_cms($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('d.*')
                ->from(TBL_DRIVERS . ' as d')->where('d.status <>','3');
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
    
    function updateDrivers($rid, $updateData = array()) {
        $this->db->where('driver_id', $rid);
        $result = $this->db->update(TBL_DRIVERS, $updateData);
        return $result;
    }
    
    function insertDrivers($drivers_data) {
        $this->db->insert(TBL_DRIVERS, $drivers_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function deleteDrivers($rid) {
        $this->db->where('driver_id', $rid);
        $result = $this->db->delete(TBL_DRIVERS);
        return $result;
    }
    
    function get_driver_by_phone($phone) {
        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('phone', $phone)->get()->row_object();
    }
    function get_driver_exist_phone($id,$phone) {
        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('driver_id <>', $id)->where('phone', $phone)->get()->row_object();
    }

}
