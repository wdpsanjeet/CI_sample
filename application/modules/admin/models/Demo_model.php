<?php

class Demo_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function get_demos($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_DEMOREQUEST .'');
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


}
