<?php

class Blogs_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_blogs_value($id) {
        return $this->db->select('*')
                        ->from(TBL_BLOGS)->where('blogs_id', $id)->get()->row_object();
    }
    
    function get_blogs($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_BLOGS);
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
    
    function insert_blogs($blogs_data) {
        $this->db->insert(TBL_BLOGS, $blogs_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function updateBlogs($rid, $updateData = array()) {
        $this->db->where('blogs_id', $rid);
        $result = $this->db->update(TBL_BLOGS, $updateData);
        return $result;
    }
    
    function deleteBlogs($rid) {
        $this->db->where('blogs_id', $rid);
        $result = $this->db->delete(TBL_BLOGS);
        return $result;
    }

}
