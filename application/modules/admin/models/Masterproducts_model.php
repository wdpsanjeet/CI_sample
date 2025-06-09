<?php

class Masterproducts_model extends CI_Model {

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

    
    function get_masterproducts_value($id) {
        return $this->db->select('*')
                        ->from(TBL_VARTHAKPRODUCT)->where('product_id', $id)->get()->row_object();
    }
    function get_masterproducts($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('vp.*,catid.category_name as category_name,subcatid.category_name as subcategory_name')
                ->from(TBL_VARTHAKPRODUCT . ' as vp')->join(TBL_VARTHAKPRODUCTCATEGORY . ' as catid','catid.category_id=vp.category_id','left')->join(TBL_VARTHAKPRODUCTCATEGORY . ' as subcatid','subcatid.category_id=vp.subcategory_id','left');
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
    function updateMasterproducts($rid, $updateData = array()) {
        $this->db->where('product_id', $rid);
        $result = $this->db->update(TBL_VARTHAKPRODUCT, $updateData);
        return $result;
    }
    
    function insertMasterproducts($_data) {
        $this->db->insert(TBL_VARTHAKPRODUCT, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function get_master_category() {
        return $this->db->select('*')
                        ->from(TBL_VARTHAKPRODUCTCATEGORY)->where('parent_id', '0')->get()->result_object();
    }
    function get_master_sub_category($category_id) {
        return $this->db->select('*')
                        ->from(TBL_VARTHAKPRODUCTCATEGORY)->where('parent_id', $category_id)->get()->result_object();
    }
    
    function insertMasterCategory($_data){
        $this->db->insert(TBL_VARTHAKPRODUCTCATEGORY, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function isProductNumExist($product_number){
        $result = $this->db->select('COUNT(product_id) as TotNum')
                        ->from(TBL_VARTHAKPRODUCT)->where('product_number', $product_number)->get()->row_object();
        if($result->TotNum>0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function isProductNumExistExceptSelf($sid,$product_number){
        $result = $this->db->select('COUNT(product_id) as TotNum')
                        ->from(TBL_VARTHAKPRODUCT)->where('product_number', $product_number)->where('product_id <>', $sid)->get()->row_object();
        if($result->TotNum>0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
