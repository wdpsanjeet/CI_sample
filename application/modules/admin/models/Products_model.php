<?php

class Products_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_products_value($id) {
        return $this->db->select('*')
                        ->from(TBL_PRODUCTS)->where('products_id', $id)->get()->row_object();
    }
    
    function get_products($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTS);
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
    
    function insert_products($products_data) {
        $this->db->insert(TBL_PRODUCTS, $products_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function updateProducts($rid, $updateData = array()) {
        $this->db->where('products_id', $rid);
        $result = $this->db->update(TBL_PRODUCTS, $updateData);
        return $result;
    }
    
    function deleteProducts($rid) {
        $this->db->where('products_id', $rid);
        $result = $this->db->delete(TBL_PRODUCTS);
        return $result;
    }

}
