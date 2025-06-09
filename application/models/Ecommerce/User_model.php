<?php

class User_model extends CI_Model {
    private $_limit;
    private $_pageNumber;
    private $_offset;
    function __construct() {
        parent::__construct();
    }
    
    function get_organisation_data($sub_domain) {

        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('sub_domain', $sub_domain)->where('status','1')->get()->row_object();
    }
 
    public function setLimit($limit) {
        $this->_limit = $limit;
    }
 
    public function setPageNumber($pageNumber) {
        $this->_pageNumber = $pageNumber;
    }
 
    public function setOffset($offset) {
        $this->_offset = $offset;
    }

    function get_active_phone_value($org_id,$phone) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('org_id', $org_id)->where('client_mobile', $phone)->where('status','1')->get()->row_object();
    }
    
    function get_phone_value($org_id='',$phone) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('org_id', $org_id)->where('client_mobile', $phone)->get()->row_object();
    }
    
    function get_client_value($client_id) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('client_id', $client_id)->get()->row_object();
    }
    
    function phone_exist_except_self($org_id,$user_id, $phone) {

        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('org_id', $org_id)->where('client_mobile', $phone)->where('client_id <>', $user_id)->get()->row_object();
    }
    
    function get_order_value($order_id,$client_id) {

        return $this->db->select('*')
                        ->from(TBL_ORDERMASTER)->where('client_id', $client_id)->where('order_id', $order_id)->get()->row_object();
    }
    
    function get_order_items($order_id) {
        return $this->db->select('*')
                ->from(TBL_ORDERDETAIL .' as od')->join(TBL_PRODUCTMASTER . ' as pm','pm.product_id=od.product_id','left')->where('od.order_id',$order_id)->get()->result_object();
        
    }
    
    function get_cart_value($cart_id) {
        return $this->db->select('*')
                ->from(TBL_CLIENTCARTMASTER .' as cm')->join(TBL_PRODUCTMASTER . ' as pm','pm.product_id=cm.product_id','left')->where('cm.cart_id ',$cart_id)->get()->row_object();
        
    }
    
    function get_cart_total_value($client_id) {
        $result= $this->db->select('SUM(cm.quantity*pm.price) as TotPrice')
                ->from(TBL_CLIENTCARTMASTER .' as cm')->join(TBL_PRODUCTMASTER . ' as pm','pm.product_id=cm.product_id','left')->where('cm.client_id ',$client_id)->get()->row_object();
        //echo $this->db->last_query();exit;
return $result->TotPrice;
    }

    function insert_contact_us($_data) {
        $this->db->insert(TBL_CONTACTUS, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_client_favorite($_data) {
        $this->db->insert(TBL_CLIENTFAVORITE, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_comment($_data) {
        $this->db->insert(TBL_BLOGCOMMENT, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_product_comment($_data) {
        $this->db->insert(TBL_PRODUCTCOMMENT, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function delete_client_favorite($client_id,$product_id) {
        $this->db->where('client_id',$client_id);
        $this->db->where('product_id',$product_id);
        $this->db->delete(TBL_CLIENTFAVORITE);
    }
    
    function is_product_added_favorite($product_id,$client_id) {

        $result= $this->db->select('COUNT(favorite_id) as TotNum')
                        ->from(TBL_CLIENTFAVORITE)->where('client_id', $client_id)->where('product_id', $product_id)->get()->row_object();
        if($result->TotNum>0){
            return true;
        }else{
            return false;
        }
    }
    
    function is_comment_added($email_id,$blog_id) {

        $result= $this->db->select('COUNT(comment_id) as TotNum')
                        ->from(TBL_BLOGCOMMENT)->where('blog_id', $blog_id)->where('email_id', $email_id)->get()->row_object();
        if($result->TotNum>0){
            return false;
        }else{
            return true;
        }
    }
    function is_product_comment_added($email_id,$product_id) {

        $result= $this->db->select('COUNT(comment_id) as TotNum')
                        ->from(TBL_PRODUCTCOMMENT)->where('product_id', $product_id)->where('email_id', $email_id)->get()->row_object();
        if($result->TotNum>0){
            return false;
        }else{
            return true;
        }
    }
    
    function insert_cart($_data) {
        $this->db->insert(TBL_CLIENTCARTMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_order($_data) {
        $this->db->insert(TBL_ORDERMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateOrder($order_id, $updateData = array()) {

        $this->db->where('order_id', $order_id);

        $result = $this->db->update(TBL_ORDERMASTER, $updateData);

        return $result;
    }
    function insert_order_detail($_data) {
        $this->db->insert(TBL_ORDERDETAIL, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function delete_client_cart_item($client_id,$product_id) {
        $this->db->where('client_id',$client_id);
        $this->db->where('product_id',$product_id);
        $this->db->delete(TBL_CLIENTCARTMASTER);
    }
    function empty_client_cart_item($client_id) {
        $this->db->where('client_id',$client_id);
        $this->db->delete(TBL_CLIENTCARTMASTER);
    }
    function get_carts($client_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_CLIENTCARTMASTER . ' as cm')->join(TBL_PRODUCTMASTER . ' as pm','pm.product_id=cm.product_id','left')->where('client_id',$client_id);
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
    
    function get_orders($client_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_ORDERMASTER)->where('client_id',$client_id);
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
    
    //writing for frontend
    function get_blogs($org_id='',$tag_id='', $limit = '', $start = '', $searchtitle = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('b.*,bt.tag_name as tag_name')
                ->from(TBL_BLOGS . ' as b')->join(TBL_BLOGTAG . ' as bt','bt.tag_id=b.tag_id','left');
        if($org_id!=''){
            $this->db->where('b.org_id',$org_id);
        }
        if($tag_id!=''){
            $this->db->where('b.tag_id',$tag_id);
        }
        if (!empty($searchtitle)) {
            $this->db->like('b.title',$searchtitle,'both');
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
    
    function get_category($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTCATEGORY);
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
        //echo $this->db->last_query();exit;
        return $data;
    }
    
    function get_sub_category($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTCATEGORY)->where('org_id',$org_id)->where('parent_id <>','0');
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
        //echo $this->db->last_query();exit;
        return $data;
    }
    
   function get_products($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '',$liketitle='',$max_price='',$rating='') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTMASTER);
        if (!empty($org_id)) {
            $this->db->where('org_id',$org_id);
        }
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        if (!empty($max_price)) {
            $this->db->where('price <=',$max_price);
        }
        if (!empty($rating)) {
            $this->db->where('avg_rate >=',$rating);
        }
        if(!empty($liketitle)){
            $this->db->like('product_name',$liketitle,'both');
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        $this->db->limit($this->_pageNumber, $this->_offset);
        if (!empty($columnName) && !empty($columnSortOrder)) {
            $this->db->order_by($columnName, $columnSortOrder);
        }
        $data['result'] = $this->db->get()->result_object();
        //echo $this->db->last_query();exit;
        return $data;
    }
    
    function get_hotoffer_products($org_id = '',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '',$liketitle='',$max_price='',$rating='') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTMASTER)->where('is_hotoffer','1');
        if (!empty($org_id)) {
            $this->db->where('org_id',$org_id);
        }
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        if (!empty($max_price)) {
            $this->db->where('price <=',$max_price);
        }
        if (!empty($rating)) {
            $this->db->where('avg_rate >=',$rating);
        }
        if(!empty($liketitle)){
            $this->db->like('product_name',$liketitle,'both');
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
        //echo $this->db->last_query();exit;
        return $data;
    }
    
    function get_either_top_popular_products($org_id='') {
        $data = [];
        $where = "(org_id='$org_id' and (is_topitem = '1' or is_popular='1'))";
        $this->db->select('*')
                ->from(TBL_PRODUCTMASTER);
        if (!empty($org_id)) {
            $this->db->where($where);
        }
        //$this->db->or_where('is_topitem','1',FALSE);
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        
        $data['result'] = $this->db->get()->result_object();
        //echo $this->db->last_query();exit;
        return $data;
    }
    
    function get_favorites($client_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('pm.*,cf.favorite_id as favorite_id')
                ->from(TBL_CLIENTFAVORITE . ' as cf')->join(TBL_PRODUCTMASTER . ' as pm', 'pm.product_id=cf.product_id', 'left')->where('cf.client_id',$client_id);
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
    
    
    function get_product_value($org_id,$id) {
        return $this->db->select('*')
                        ->from(TBL_PRODUCTMASTER . ' as p')->join(TBL_PRODUCTCATEGORY . ' as pc','pc.product_category_id=p.category_id','left')->where('p.product_id', $id)->where('p.status!=', '3')->get()->row_object();
    }
    function get_blogs_value($id) {
        return $this->db->select('b.*,bt.tag_name as tag_name')
                        ->from(TBL_BLOGS . ' as b')->join(TBL_BLOGTAG . ' as bt','bt.tag_id=b.tag_id','left')->where('blogs_id', $id)->get()->row_object();
    }
    
    function insert_user($_data) {
        $this->db->insert(TBL_USER_MASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function insert_client($_data) {
        $this->db->insert(TBL_CLIENTMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateClient($client_id, $updateData = array()) {

        $this->db->where('client_id', $client_id);

        $result = $this->db->update(TBL_CLIENTMASTER, $updateData);

        return $result;
    }
    function get_email_value($email) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('email', $email)->get()->row_object();
    }
    function get_email_code_value($email_code) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('email_code', $email_code)->get()->row_object();
    }
    function get_reset_password_code_value($reset_password_code) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('reset_password_code', $reset_password_code)->get()->row_object();
    }
    function updateUser($rid, $updateData = array()) {
        $this->db->where('id', $rid);
        $result = $this->db->update(TBL_USER_MASTER, $updateData);
        return $result;
    }
    function get_user_addresses($user_id) {
        return $this->db->select('*')
                ->from(TBL_ADDRESSES)->where('user_id',$user_id)->get()->result_object();
        
    }
    function get_user_address_value($id) {
        return $this->db->select('*')
                        ->from(TBL_ADDRESSES)->where('address_id', $id)->get()->row_object();
    }
    
    function get_user_value($id) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('id', $id)->where('status!=', '3')->get()->row_object();
    }
    
    function get_pricing_plans($plan_type='') {
        $this->db->select('*')
                        ->from(TBL_PRICINGPLAN);
        if($plan_type!=''){
            $this->db->where('plan_type', $plan_type);
        }
        return $this->db->get()->result_object();
    }
    
    function get_pricing_plans_by_id($plan_id) {
        return $this->db->select('*')
                        ->from(TBL_PRICINGPLAN)->where('plan_id', $plan_id)->get()->row_object();
    }
    
    function loginAsUser($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $this->db->select('id');
        $result = $this->db->get(TBL_USER_MASTER);

        if ($result->num_rows() > 0)
            return true;
        else
            return false;
    }
    
    function setUserSession($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('*');
        $result = $this->db->get(TBL_USER_MASTER);
        if ($result->num_rows() > 0) {

            $row = $result->row();
            $values = array('user_id' => $row->id, 'user_name' => $row->name, 'user_email' => $row->email,'company_code' => $row->company_code, 'logged_in' => TRUE);
            
        }
        $this->session->set_userdata($values);
    }
    
    
    function insert_order_log($_data) {
        $this->db->insert('order_log', $_data);
    }
    
    function updateSubscriptionInvoiceID($invoice_id, $updateData = array()) {
        $this->db->where('invoice_id', $invoice_id);
        $result = $this->db->update(TBL_SUBSCRIPTIONHISTORY, $updateData);
        return $result;
    }
    
    function get_subscription_detail_by_invoiveid($invoice_id) {
        return $this->db->select('*')
                        ->from(TBL_SUBSCRIPTIONHISTORY)->where('invoice_id', $invoice_id)->get()->row_object();
    }
    
    function insert_subscription_data($_data) {
        $this->db->insert(TBL_SUBSCRIPTIONHISTORY, $_data);
    }
    
    function setClientSession($conditions = array()) {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('*');
        $result = $this->db->get(TBL_CLIENTMASTER);
        if ($result->num_rows() > 0) {

            $row = $result->row();
            $values = array('client_id' => $row->client_id, 'client_name' => $row->client_name, 'client_email' => $row->client_email,'client_mobile' => $row->client_mobile, 'Clientlogged_in' => TRUE);
            
        }
        $this->session->set_userdata($values);
    }
    
    function get_shop_type(){
        return $this->db->select('*')
                        ->from(TBL_SHOPTYPE)->get()->result_object();
    }
    
    function get_tags($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_BLOGTAG)->where('org_id',$org_id);
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
    
    function get_comments($blog_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_BLOGCOMMENT)->where('blog_id',$blog_id);
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
    
    function get_product_comments($org_id='',$product_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTCOMMENT)->where('product_id',$product_id);
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
    
    function update_product_rating($product_id,$rating){
        $this->db->query("UPDATE ".TBL_PRODUCTMASTER." SET `avg_rate` = (avg_rate+$rating)/2 WHERE product_id='$product_id'");
    }
    
    function get_featured_category($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTCATEGORY)->where('is_featured','1');
        if (!empty($org_id)) {
            $this->db->where('org_id',$org_id);
        }
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
        //echo $this->db->last_query();exit;
        return $data;
    }
    
    function get_state_type(){
        return $this->db->select('DISTINCT(city_state) as city_state')
                        ->from(TBL_CITIES)->get()->result_object();
    }
    
    function get_city_type($state_name){
        return $this->db->select('DISTINCT(city_name) as city_name')
                        ->from(TBL_CITIES)->where('city_state',$state_name)->get()->result_object();
    }
    
}
