<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public $_item_per_page = 20;
    public $_pagi = array('current_page' => '', 'items_per_page' => '', 'total_page' => '', 'total_items' => '', 'item_from' => '', 'item_to' => '', 'data' => '');
    private $filter_data = array();

    function __construct() {
        parent::__construct();
    }

    public function clear_pagi() {
        $this->_pagi = array('current_page' => '', 'total_page' => '', 'total_items' => '', 'item_from' => '', 'item_to' => '', 'data' => '', 'items_per_page' => '');
    }

    public function create_pagination($object, $limit = NULL) {
        $this->clear_pagi();
        $page = 1;
        if (is_null($limit)) {
            $limit = $this->_item_per_page;
        }
        if ($this->input->get("page") != '') {
            $page = (int) $this->input->get("page") > 0 ? (int) $this->input->get("page") : 1;
        }

        $object1 = clone $object;
        $this->_pagi['total_items'] = $object1->count_all_results();

        $start_offset = ($page - 1) * $limit;
        $object->limit($limit, $start_offset);
        //fetc result
        $data = $object->get()->result_object();

        $this->_pagi['items_per_page'] = $limit;
        $this->_pagi['total_page'] = ceil($this->_pagi['total_items'] / $limit);
        $this->_pagi['current_page'] = $page;
        $this->load->vars('__current_page', $page);
        $this->_pagi['item_from'] = $start_offset + ($this->_pagi['total_items'] > 0 ? 1 : 0);

        $this->_pagi['item_to'] = $start_offset + (count($data) < $limit ? count($data) : $limit);
        $this->_pagi['data'] = $data;
        return (object) $this->_pagi;
    }

    private function _get_pagi_data() {
        return $this->_pagi;
    }

    private function update($table, $pk, $arg) {
        $this->db->where($pk, $arg[1])->update($table, $arg[0]);
        return $this->db->affected_rows();
    }

    private function count($table, $where = array()) {
        $this->db->select('*');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $sql = $this->db->get($table);
        return $sql->num_rows;
    }

    private function fetch($table, $where = array()) {
        $this->db->select('*');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $sql = $this->db->get($table);
        if ($sql->num_rows == 1) {
            return $sql->row();
        } else {
            return $sql->result_object();
        }
    }

    protected function fetch_by_order_limit($table, $where = array(), $order = array(), $limit_form = null, $tot_display = null) {
        $this->db->select('*');
        if (!empty($where)) {
            $this->db->where($where);
        }
        if (!empty($order)) {
            $this->db->order_by($order[0], $order[1]);
        }
        if ($limit_form != null && $tot_display != null) {
            $this->db->limit($tot_display, $limit_form);
        }
        $sql = $this->db->get($table);
        if ($sql->num_rows == 1) {
            return $sql->row();
        } else if ($sql->num_rows > 1) {
            return $sql->result_object();
        } else {
            return null;
        }
    }

    private function insert_into($table, $data) {
        $this->db->insert($table, $data);
    }

    function delete($tbl, $where, $Hard = FALSE) {
        if ($Hard) {
            //delete
            $this->db->where($where);
            $this->db->delete($tbl);
        } else {
            //update
            $this->db->where($where);
            $this->db->update($tbl, array('Status' => '3'));
        }
    }

    function select_field($sTableName, $sSelect, $where) {
        $rs = $this->db->select($sSelect)
                ->from($sTableName)
                ->where($where)
                ->get()
                ->row();
        if (!empty($rs)) {
            $s = $rs->{$sSelect};
        } else {
            $s = '';
        }
        return $s;
    }

    function __call($name, $arguments) {
        $method_type = '';
        if (substr($name, 0, 7) === 'update_') {
            $method_type = 'update';
            $name = str_replace("update_", "", $name);
            $arg = explode("_by_", $name);
            if (count($arg) == 2) {
                return $this->update($arg[0], $arg[1], $arguments);
            } else {
                show_error("Invalid {$method_type} function...");
            }
        } elseif (substr($name, 0, 6) === 'fetch_') { //fetch_{tbl_name}_by_{column_name}(){$val}
            $method_type = 'fetch';
            $name = str_replace("fetch_", "", $name);
            $arg = explode("_by_", $name);
            if (count($arg) == 2) {
                $where = array(
                    $arg[1] => $arguments[0],
                );
                return $this->fetch($arg[0], $where);
            } elseif (count($arg) == 1) {
                return $this->fetch($arg[0]);
            } else {
                show_error("Invalid {$method_type} function...");
            }
        } elseif (substr($name, 0, 6) === 'count_') {
            $method_type = 'count';
            $name = str_replace("count_", "", $name);
            $arg = explode("_by_", $name);
            if (count($arg) == 2) {
                $where = array(
                    $arg[1] => $arguments[0],
                );
                return $this->count($arg[0], $where);
            } elseif (count($arg) == 1) {
                return $this->count($arg[0], $arguments[0]);
            } else {
                show_error("Invalid {$method_type} function...");
            }
        } elseif (substr($name, 0, 12) === 'insert_into_') {
            $table_name = str_replace("insert_into_", "", $name);
            $data = $arguments[0];
            $this->insert_into($table_name, $data);
            return $this->db->insert_id();
        } elseif (substr($name, 0, 7) === 'delete_') {
            //delete_table_name_by_FieldName($Field,$hard_del);
            //delete_table_name_where(array('id'=>'','user_id'=>''),$hard_del);
            $name = str_replace("delete_", "", $name);
            $arg = explode("_by_", $name);
            $arg2 = explode("_where", trim($name));
            if (count($arg) == 2) {
                $where = array(
                    $arg[1] => $arguments[0],
                );
                $hard = isset($arguments[1]) ? $arguments[1] : FALSE;
                return $this->delete($arg[0], $where, $hard);
            } elseif (count($arg2) == 2) {
                $hard = isset($arguments[1]) ? $arguments[1] : FALSE;
                return $this->delete($arg2[0], $arguments[0], $hard);
            } else {
                show_error("Invalid delete function...");
            }
        } elseif (substr($name, 0, 4) === 'get_') {//get_ColumnName_from_TableName($where);
            $name = str_replace("get_", "", $name);
            list($Select) = explode('_', $name);
            $name = explode('_', $name);
            array_shift($name);
            array_shift($name);
            $sTableName = implode("_", $name);
            return $this->select_field($sTableName, $Select, $arguments[0]);
        }
    }

    public function set_filter_data($data) {
        $this->filter_data = $data;
    }

    public function get_filter_data() {
        return $this->filter_data;
    }

}