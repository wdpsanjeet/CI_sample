<?php

class Index_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    function get_phone_value($phone) {

        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('phone', $phone)->get()->row_object();
    }

    function get_active_phone_value($phone) {

        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('phone', $phone)->where('status', '1')->get()->row_object();
    }

    function insertDriver($data) {

        $this->db->insert(TBL_DRIVERS, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    
    function insertPaymentrequest($data) {

        $this->db->insert(TBL_DRIVERREQUEST, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function phone_exist_except_self($user_id, $phone) {

        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('phone', $phone)->where('driver_id <>', $user_id)->get()->row_object();
    }

    function updateDriver($driver_id, $updateData = array()) {

        $this->db->where('driver_id', $driver_id);

        $result = $this->db->update(TBL_DRIVERS, $updateData);

        return $result;
    }

    function get_user_value($user_id) {

        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('driver_id', $user_id)->where('status', '1')->get()->row_object();
    }
    
    function get_active_trip_by_drive_id($driver_id){
        return $this->db->select('distinct(dat.assigned_trip_id) as assigned_trip_id,dat.driver_accepted as driver_accepted')
                        ->from(TBL_DRIVERASSIGNEDTRIP .' as dat')->join(TBL_DRIVERTRIPCLIENT .' as dtc','dtc.assigned_trip_id=dat.assigned_trip_id','left')
                        ->join(TBL_CLIENTMASTER .' as cm','cm.client_id=dtc.client_id','left')
                        ->where('dat.driver_id', $driver_id)->where('is_trip_completed', '0')->get()->result_object();
    }
    
    function get_active_trip_detail_by_assigned_trip_id($assigned_trip_id){
        return $this->db->select('dat.assigned_trip_id as assigned_trip_id,dat.driver_accepted as driver_accepted,dtc.trip_status as client_trip_status,dtc.driver_trip_clients_id as driver_trip_clients_id, cm.client_address as client_address,cm.client_mobile as client_mobile,cm.client_latitude as client_latitude,cm.client_longitude as client_longitude,cm.client_name')
                        ->from(TBL_DRIVERASSIGNEDTRIP .' as dat')->join(TBL_DRIVERTRIPCLIENT .' as dtc','dtc.assigned_trip_id=dat.assigned_trip_id','left')
                        ->join(TBL_CLIENTMASTER .' as cm','cm.client_id=dtc.client_id','left')
                        ->where('is_trip_completed', '0')->where('dat.assigned_trip_id',$assigned_trip_id)->order_by('dtc.order_list')->get()->result_object();
    }
    
    function get_warehouse_return_and_location_detail_by_assigned_trip_id($assigned_trip_id){
        return $this->db->select('wh.warehouse_address as warehouse_address, wh.warehouse_lat as warehouse_lat,wh.warehouse_long as warehouse_long,dat.is_return_warehouse as is_return_warehouse')
                        ->from(TBL_DRIVERASSIGNEDTRIP .' as dat')->join(TBL_WAREHOUSE .' as wh','wh.warehouse_id=dat.warehouse_id','left')
                        ->where('dat.assigned_trip_id',$assigned_trip_id)->get()->row_object();
    }
    
    function active_trip_update($assigned_trip_id, $updateData = array()) {

        $this->db->where('assigned_trip_id', $assigned_trip_id);

        $result = $this->db->update(TBL_DRIVERASSIGNEDTRIP, $updateData);

        return $result;
    }
    
    function update_client_trip($driver_trip_clients_id, $updateData = array()) {

        $this->db->where('driver_trip_clients_id', $driver_trip_clients_id);

        $result = $this->db->update(TBL_DRIVERTRIPCLIENT, $updateData);

        return $result;
    }
    
    function insert_payment($data) {

        $this->db->insert(TBL_TRIPPAYMENT, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    
    function get_payments_by_drive_id($driver_id,$filter=array()){
        $this->db->select('tp.total_kilometer as total_kilometer, tp.total_amount as total_amount, tp.total_paid as total_paid, tp.payment_status as payment_status')
                        ->from(TBL_TRIPPAYMENT .' as tp')->join(TBL_DRIVERASSIGNEDTRIP .' as dat','dat.assigned_trip_id=tp.assigned_trip_id','left')
                        ->where('dat.driver_id', $driver_id)->where('dat.is_trip_completed', '1');
        if(isset($filter['from_date']) && $filter['from_date']!=''){
          $this->db->where('dat.assigned_date >=', $filter['from_date']);  
        }
        if(isset($filter['to_date']) && $filter['to_date']!=''){
          $this->db->where('dat.assigned_date <=', $filter['to_date']);  
        }
        if(isset($filter['payment_status']) && $filter['payment_status']!=''){
          $this->db->where('tp.payment_status', $filter['payment_status']);  
        }
        return $this->db->get()->result_object();
    }
    
    function get_company_code_value($company_code) {

        $result = $this->db->select('COUNT(id) as TotNum')
                        ->from(TBL_USER_MASTER)->where('company_code', $company_code)->get()->row_object();
        if($result->TotNum=='0'){
            return true;
        }else{
            return false;
        }
    }
    
    function get_company_code_value_data($company_code) {

        $result = $this->db->select('org_id')
                        ->from(TBL_USER_MASTER)->where('company_code', $company_code)->get()->row_object();
            return $result->org_id;
    }
    
    function get_past_trip_by_drive_id($driver_id){
        return $this->db->select('*')
                        ->from(TBL_DRIVERASSIGNEDTRIP .' as dat')
                        ->where('dat.driver_id', $driver_id)->where('dat.is_trip_completed', '1')->order_by('assigned_date','DESC')->get()->result_object();
    }
    
    function get_trip_detail_by_assigned_trip_id($assigned_trip_id){
        return $this->db->select('*')
                        ->from(TBL_TRIPPAYMENT)
                        ->where('assigned_trip_id', $assigned_trip_id)->get()->row_object();
    }
    
    function get_notification_by_drive_id($driver_id){
        return $this->db->select('*')
                        ->from(TBL_DRIVERNOTIFICATION)
                        ->where('driver_id', $driver_id)->order_by('added_at','DESC')->get()->result_object();
    }
    
    function get_driver_assigned_trip_by_trip_id($assigned_trip_id) {

        return $this->db->select('*')
                        ->from(TBL_DRIVERASSIGNEDTRIP)->where('assigned_trip_id', $assigned_trip_id)->get()->row_object();
    }
    
    function insert_user_notification($data) {

        $this->db->insert(TBL_USERNOTIFICATION, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    
    function get_driver_trip_clients_by_driver_trip_clients_id($driver_trip_clients_id ) {
        return $this->db->select('dm.*,cm.company_name as company_name,cm.client_mobile as client_mobile,cm.client_address as client_address,d.name as driver_name')
                ->from(TBL_DRIVERTRIPCLIENT .' as dm')
                ->join(TBL_DRIVERASSIGNEDTRIP . ' as dat','dat.assigned_trip_id=dm.assigned_trip_id','left')
                ->join(TBL_DRIVERS .' as d','d.driver_id=dat.driver_id','left')
                ->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dm.client_id','left')
                ->where('dm.driver_trip_clients_id',$driver_trip_clients_id)->get()->row_object();
        
    }

}
