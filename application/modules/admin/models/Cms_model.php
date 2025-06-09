<?php

class Cms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_cms_value($id) {
        return $this->db->select('*')
                        ->from(TBL_CMS)->where('cms_id', $id)->get()->row_object();
    }
    
    function get_cms($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_CMS);
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
    
    function updateCms($rid, $updateData = array()) {
        $this->db->where('cms_id', $rid);
        $result = $this->db->update(TBL_CMS, $updateData);
        return $result;
    }

}
