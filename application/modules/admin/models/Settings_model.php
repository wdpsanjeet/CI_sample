<?php

class Settings_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function updateSettings($rid, $updateData = array()) {
        $this->db->where('slug_name', $rid);
        $result = $this->db->update(TBL_SETTINGS, $updateData);
        return $result;
    }
    
    function get_all_settings() {
        return $this->db->select('*')
                        ->from(TBL_SETTINGS)->order_by('order_num','ASC')->get()->result_object();
    }
    
    function get_presentation_value($id) {
        return $this->db->select('*')
                        ->from(TBL_PRESENTATION)->where('presentation_id', $id)->get()->row_object();
    }
    function updatePresentation($rid, $updateData = array()) {
        $this->db->where('presentation_id', $rid);
        $result = $this->db->update(TBL_PRESENTATION, $updateData);
        return $result;
    }
}
