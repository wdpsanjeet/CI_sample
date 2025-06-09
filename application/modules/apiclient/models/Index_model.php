<?php

class Index_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }
    
    function get_organisation_data($sub_domain) {

        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('sub_domain', $sub_domain)->where('status','1')->get()->row_object();
    }
    
    function get_client_phone_value($phone) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('client_mobile', $phone)->get()->row_object();
    }
    function get_client_value($client_id) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('client_id', $client_id)->get()->row_object();
    }
    
    function get_client_cart_value($client_id,$product_id) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTCARTMASTER)->where('client_id', $client_id)->where('product_id', $product_id)->get()->row_object();
    }
    
    function get_order_value($order_id) {

        return $this->db->select('*')
                        ->from(TBL_ORDERMASTER)->where('order_id', $order_id)->get()->row_object();
    }

    function get_active_phone_value($org_id,$phone) {
        $image_path= base_url().'uploads/profile_img/original/';
        return $this->db->select("client_id,org_id,user_id,company_name,client_name,manager_name,client_email,client_mobile,otp,otp_verified,client_address,client_area,client_city,client_state,client_pincode,CONCAT('$image_path',personal_pic) as personal_pic,client_latitude,client_longitude,added_at,updated_at,status,shop_phone,shop_name,shop_location,shop_address,shop_latitude,shop_longitude,shop_type,delivery_start_time,delivery_end_time,gst_number,is_whatapp_yes")
                        ->from(TBL_CLIENTMASTER)->where('client_mobile', $phone)->where('status', '1')->where('org_id', $org_id)->get()->row_object();
    }

    function insertClient($data) {

        $this->db->insert(TBL_CLIENTMASTER, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    
    function insertCart($data) {

        $this->db->insert(TBL_CLIENTCARTMASTER, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    
    function empty_client_cart_item($client_id) {
        $this->db->where('client_id',$client_id);
        $this->db->delete(TBL_CLIENTCARTMASTER);
    }
    
    function insertOrder($data) {

        $this->db->insert(TBL_ORDERMASTER, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }
    
    function insertOrderDetail($data) {

        $this->db->insert(TBL_ORDERDETAIL, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function phone_exist_except_self($user_id, $phone) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('client_mobile', $phone)->where('client_id <>', $user_id)->get()->row_object();
    }

    function updateClient($client_id, $updateData = array()) {

        $this->db->where('client_id', $client_id);

        $result = $this->db->update(TBL_CLIENTMASTER, $updateData);

        return $result;
    }
    
    function updateCart($client_id,$product_id, $updateData = array()) {

        $this->db->where('client_id', $client_id);
        $this->db->where('product_id', $product_id);

        $result = $this->db->update(TBL_CLIENTCARTMASTER, $updateData);

        return $result;
    }
    
    function deleteCart($cart_id) {
        $this->db->where('cart_id', $cart_id);
        $result = $this->db->delete(TBL_CLIENTCARTMASTER);

        return $result;
    }
    
    function updateOrder($order_id,$updateData = array()) {

        $this->db->where('order_id', $order_id);
        $result = $this->db->update(TBL_ORDERMASTER, $updateData);

        return $result;
    }
    
    function updateOrderByInvoiceID($invoice_id,$updateData = array()) {

        $this->db->where('invoice_id', $invoice_id);
        $result = $this->db->update(TBL_ORDERMASTER, $updateData);

        return $result;
    }

    function get_user_value($user_id) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('client_id', $user_id)->where('status', '1')->get()->row_object();
    }
    
    function get_user_shipping_detail($user_id) {

        return $this->db->select('address_line_1, address_line_2, client_area, client_city, client_state, client_pincode')
                        ->from(TBL_CLIENTMASTER)->where('client_id', $user_id)->where('status', '1')->get()->row_object();
    }
    
    function get_cart_details($client_id){
        $image_path= base_url().'uploads/varthak_product/';
        
        return $this->db->select("pm.product_id as product_id,pm.category_id as category_id,pm.product_name as product_name,pm.product_description as product_description,CONCAT('$image_path',pm.product_image) as product_image, pm.small_note as small_note,pm.avg_rate as avg_rate,pm.price as price,pm.quantity_val as quantity_val,pm.quantity_unit as quantity_unit,pm.added_at as added_at,pm.updated_at as updated_at,pm.is_popular as is_popular,pm.is_topitem as is_topitem,pm.status as status,pm.gst_percentage as gst_percentage,cm.quantity as quantity,cm.cart_id as cart_id")
                        ->from(TBL_CLIENTCARTMASTER .' as cm')->join(TBL_PRODUCTMASTER .' as pm','pm.product_id=cm.product_id','left')
                        ->where('cm.client_id', $client_id)->get()->result_object();
    }
    
    function get_order_list($client_id,$order_status,$limit,$start){
        $data = [];
        $this->db->select('*')
                        ->from(TBL_ORDERMASTER)
                        ->where('client_id', $client_id);
        if($order_status!=''){
            $this->db->where('order_status', $order_status);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('added_at', 'DESC');
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_order_detail_list($order_id){
        $image_path= base_url().'uploads/varthak_product/';
        return $this->db->select("pm.product_name as product_name,CONCAT('$image_path',pm.product_image) as product_image,pm.quantity_val as quantity_val,pm.quantity_unit as quantity_unit,od.product_price as product_price,od.quantity as quantity")
                        ->from(TBL_ORDERDETAIL. ' as od')
                        ->join(TBL_PRODUCTMASTER. ' as pm','pm.product_id=od.product_id','left')
                        ->where('order_id', $order_id)->get()->result_object();
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

        $result = $this->db->select('id')
                        ->from(TBL_USER_MASTER)->where('company_code', $company_code)->get()->row_object();
            return $result->id;
    }
    
    function get_shop_type(){
        $image_path= base_url().'uploads/shop_type/';
        return $this->db->select("shop_type as shop_type, type_name as type_name, CONCAT('$image_path',type_image) as type_image")
                        ->from(TBL_SHOPTYPE)->get()->result_object();
    }
    
    function get_category_type($org_id){
        $image_path= base_url().'uploads/category_image/thumbnail/';
        return $this->db->select("product_category_id,category_name,CONCAT('$image_path',thumbnail) as thumbnail,is_featured,status")
                        ->from(TBL_PRODUCTCATEGORY)->where('org_id',$org_id)->get()->result_object();
    }
    
    function get_featured_category_type($org_id){
        $image_path= base_url().'uploads/category_image/thumbnail/';
        return $this->db->select("product_category_id,category_name,CONCAT('$image_path',thumbnail) as thumbnail,is_featured,status")
                        ->from(TBL_PRODUCTCATEGORY)->where('org_id',$org_id)->where('is_featured','1')->get()->result_object();
    }
    
    function get_product_by_category_id($org_id,$product_category_id,$limit = '', $start = ''){
        $data = [];
        $image_path= base_url().'uploads/varthak_product/';
        $this->db->select("pm.product_id as product_id,pm.category_id as category_id,pm.product_name as product_name,pm.product_description as product_description,CONCAT('$image_path',pm.product_image) as product_image, pm.small_note as small_note,pm.avg_rate as avg_rate,pm.price as price,pm.quantity_val as quantity_val,pm.quantity_unit as quantity_unit,pm.added_at as added_at,pm.updated_at as updated_at,pm.is_popular as is_popular,pm.is_topitem as is_topitem,pm.status as status")
                        ->from(TBL_PRODUCTMASTER . ' as pm' )->join(TBL_PRODUCTCATEGORY . ' as pc','pc.product_category_id=pm.category_id','left')
                ->where('pm.category_id',$product_category_id)->where('pm.org_id',$org_id);
             $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_product_by_product_name($org_id,$product_name,$limit = '', $start = ''){
        $data = [];
        $image_path= base_url().'uploads/varthak_product/';
        $this->db->select("pm.product_id as product_id,pm.category_id as category_id,pm.product_name as product_name,pm.product_description as product_description,CONCAT('$image_path',pm.product_image) as product_image, pm.small_note as small_note,pm.avg_rate as avg_rate,pm.price as price,pm.quantity_val as quantity_val,pm.quantity_unit as quantity_unit,pm.added_at as added_at,pm.updated_at as updated_at,pm.is_popular as is_popular,pm.is_topitem as is_topitem,pm.status as status")
                        ->from(TBL_PRODUCTMASTER . ' as pm' )->where('pm.org_id',$org_id)
                ->like('pm.product_name',$product_name,'both');
             $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_top_products($org_id,$client_id,$limit = '', $start = ''){
        $data = [];
        $image_path= base_url().'uploads/varthak_product/';
        $this->db->select("pm.product_id as product_id,pm.category_id as category_id,pm.product_name as product_name,pm.product_description as product_description,CONCAT('$image_path',pm.product_image) as product_image, pm.small_note as small_note,pm.avg_rate as avg_rate,pm.price as price,pm.quantity_val as quantity_val,pm.quantity_unit as quantity_unit,pm.added_at as added_at,pm.updated_at as updated_at,pm.is_popular as is_popular,pm.is_topitem as is_topitem,pm.status as status,cm.quantity as cart_quantity")
                        ->from(TBL_PRODUCTMASTER . ' as pm' )->join(TBL_CLIENTCARTMASTER . ' as cm','cm.product_id=pm.product_id and cm.client_id='.$client_id,'left outer')
                ->where('pm.is_topitem','1')->where('pm.org_id',$org_id);
             $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_popular_products($org_id,$client_id,$limit = '', $start = ''){
        $data = [];
        $image_path= base_url().'uploads/varthak_product/';
        $this->db->select("pm.product_id as product_id,pm.category_id as category_id,pm.product_name as product_name,pm.product_description as product_description,CONCAT('$image_path',pm.product_image) as product_image, pm.small_note as small_note,pm.avg_rate as avg_rate,pm.price as price,pm.quantity_val as quantity_val,pm.quantity_unit as quantity_unit,pm.added_at as added_at,pm.updated_at as updated_at,pm.is_popular as is_popular,pm.is_topitem as is_topitem,pm.status as status,cm.quantity as cart_quantity")
                        ->from(TBL_PRODUCTMASTER . ' as pm' )->join(TBL_CLIENTCARTMASTER . ' as cm','cm.product_id=pm.product_id and cm.client_id='.$client_id,'left outer')
                ->where('pm.is_popular','1')->where('pm.org_id',$org_id);
             $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_notification_by_client_id($client_id){
        return $this->db->select('*')
                        ->from(TBL_CLIENTNOTIFICATION)
                        ->where('client_id', $client_id)->order_by('added_at','DESC')->get()->result_object();
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
