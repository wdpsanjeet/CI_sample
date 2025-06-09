<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function user_flash_message($type, $message) {
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

    function get_user_value($id) {
        return $this->db->select('*')
                        ->from(TBL_USER_MASTER)->where('id', $id)->where('status!=', '3')->get()->row_object();
    }
    function get_pricing_plans_by_id($plan_id) {
        return $this->db->select('*')
                        ->from(TBL_PRICINGPLAN)->where('plan_id', $plan_id)->get()->row_object();
    }
    function get_users($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_USER_MASTER)->where('status!=', '3');
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
    function updateUser($rid, $updateData = array()) {
        $this->db->where('id', $rid);
        $result = $this->db->update(TBL_USER_MASTER, $updateData);
        return $result;
    }
    function get_user_notification($user_id,$limit = '', $start = '', $searchQuery = '') {
        $data = [];
        $this->db->select('')
                ->from(TBL_USERNOTIFICATION)->where('user_id',$user_id);
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
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
    function get_sales($user_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('sm.*,om.org_name as org_name,cm.client_name as client_name')
                ->from(TBL_SALESMASTER .' as sm')->join(TBL_ORGANISATIONMASTER . ' as om','om.org_id=sm.org_id','left')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=sm.client_id','left')->where('sm.added_by',$user_id);
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
    
    function get_clients_by_org_id($org_id) {
        return $this->db->select('*')
                ->from(TBL_CLIENTMASTER)->where('org_id',$org_id)->get()->result_object();
    }
    function get_varthak_product($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from('varthak_product');
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
    
    function get_varthak_product_by_product_id($product_id) {
        return $this->db->select('*')
                ->from(TBL_PRODUCTMASTER)->where('product_id',$product_id)->get()->row_object();
    }
    
    
    
    
    
    
    
    
    
    
    function get_organisation_by_user_id($user_id) {
        return $this->db->select('*')
                ->from(TBL_ORGANISATIONMASTER)->where('user_id',$user_id)->get()->row_object();
    }
    function get_organisation_by_value($org_id) {
        return $this->db->select('*')
                ->from(TBL_ORGANISATIONMASTER)->where('org_id ',$org_id)->get()->row_object();
    }
    function get_organisation_default_by_value($org_id) {
        return $this->db->select('*')
                ->from(TBL_USER_MASTER)->where('org_id ',$org_id)->get()->row_object();
    }
    function get_all_organisation_except_logedin_user($user_id) {
        return $this->db->select('*')
                ->from(TBL_ORGANISATIONMASTER)->where('user_id <>',$user_id)->get()->result_object();
    }
    
    function all_organisation_by_userid($user_id) {
        return $this->db->select('*')
                        ->from(TBL_ORGANISATIONMASTER)->where('user_id', $user_id)->get()->result_object();
    }
    function insert_organisation($_data) {
        $this->db->insert(TBL_ORGANISATIONMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateOrganisation($org_id,$user_id, $updateData = array()) {

        $this->db->where('org_id', $org_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->update(TBL_ORGANISATIONMASTER, $updateData);

        return $result;
    }
    
    function updateOrganisationUser($org_id,$user_id, $updateData = array()) {

        $this->db->where('org_id', $org_id);
        $this->db->where('user_id', $user_id);
        $result = $this->db->update(TBL_ORGANISATIONUSER, $updateData);

        return $result;
    }
    
    function get_cms_global() {
        return $this->db->select('*')
                ->from(TBL_CMSDEFAULTGLOBAL)->get()->result_object();
    }
    
    function insert_cms_mgm_batch($bach_data){
        $this->db->insert_batch(TBL_CMS, $bach_data);
    }
    
    function get_permission_global() {
        return $this->db->select('*')
                ->from(TBL_ASSIGNPERMISSIONDEFAULT)->get()->result_object();
    }
    
    function insert_permission_batch($bach_data){
        $this->db->insert_batch(TBL_ASSIGNPERMISSION, $bach_data);
    }
    
    function resetDefaultOrganisation($user_id, $updateData = array()) {

        $this->db->where('user_id', $user_id);
        $result = $this->db->update(TBL_ORGANISATIONUSER, $updateData);

        return $result;
    }
    
    function setDefaultOrganisationUser($user_id, $updateData = array()) {

        $this->db->where('user_id', $user_id);
        $result = $this->db->update(TBL_ORGANISATIONUSER, $updateData);

        return $result;
    }
    
    function get_products($org_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRODUCTMASTER)->where('org_id', $org_id)->where('status!=', '3');
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
    
    function get_varthak_subcategory() {
        return $this->db->select('*')
                ->from(TBL_VARTHAKPRODUCTCATEGORY)->where('parent_id <>','0')->get()->result_object();
        
    }
    
    function insert_product($_data) {
        $this->db->insert(TBL_PRODUCTMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function get_varthak_product_value($product_id) {
        return $this->db->select('vp.*,vpc.category_name as category_name,vpc1.category_name as sub_category_name')
                        ->from(TBL_VARTHAKPRODUCT. ' as vp')->join(TBL_VARTHAKPRODUCTCATEGORY.' as vpc','vpc.category_id=vp.category_id','left')->join(TBL_VARTHAKPRODUCTCATEGORY.' as vpc1','vpc1.category_id=vp.subcategory_id','left')->where('vp.product_id', $product_id)->get()->row_object();
    }
    function get_parent_category_id_by_name($parent_category_name) {
        return $this->db->select('*')
                        ->from(TBL_PRODUCTCATEGORY)->where('category_name', $parent_category_name)->where('parent_id', '0')->get()->row_object();
    }
    
    function insert_category($_data) {
        $this->db->insert(TBL_PRODUCTCATEGORY, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function get_sub_category_id_by_name($parent_id,$sub_category_name) {
         return $this->db->select('*')
                        ->from(TBL_PRODUCTCATEGORY)->where('category_name', $sub_category_name)->where('parent_id', $parent_id)->get()->row_object();
         //echo $this->db->last_query();exit;
    }
    
    function get_product_value($id) {
        return $this->db->select('*')
                        ->from(TBL_PRODUCTMASTER)->where('product_id', $id)->where('status!=', '3')->get()->row_object();
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
    function updateProduct($rid, $updateData = array()) {
        $this->db->where('product_id', $rid);
        $result = $this->db->update(TBL_PRODUCTMASTER, $updateData);
        return $result;
    }
    
    function get_roles() {
        $data = [];
        $this->db->select('*')
                ->from(TBL_ROLEMASTER)->where('status', '1');
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function privilege_module() {
        $data = [];
        $this->db->select('*')
                ->from(TBL_PRIVILAGEMODULE)->where('status', '1');
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function insert_assign_permission($_data) {
        $this->db->insert(TBL_ASSIGNPERMISSION, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function deleteAssignPermission($org_id,$role_id) {
        $this->db->where('org_id', $org_id);
        $this->db->where('role_id', $role_id);
        $this->db->delete(TBL_ASSIGNPERMISSION);
    }
    
    function getAssignPermission($org_id,$role_id)
    {
        $data = [];
        $this->db->select("assinPer.*,privMod.type as type")
            ->from(TBL_ASSIGNPERMISSION.' as assinPer')->join(TBL_PRIVILAGEMODULE .' as privMod','privMod.module_id=assinPer.module_id','left')
            ->where('assinPer.org_id', $org_id)->where('assinPer.role_id', $role_id);

        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_staffs($org_id,$user_id, $limit = '', $start = '')
    {
        $data = [];
        $this->db->select("stf.*,rol.role_name as role_name,um.phone as phone")
            ->from(TBL_ORGANISATIONUSER.' as stf')->join(TBL_ROLEMASTER .' as rol','rol.role_id=stf.role_id','left')
            ->join(TBL_USER_MASTER .' as um','um.id=stf.user_id','left')
            ->where('stf.org_id', $org_id)->where('stf.status <>', '2');

        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_staff_value($id)
    {

        return $this->db->select('ou.*,um.phone as phone,um.email as email')
            ->from(TBL_ORGANISATIONUSER . ' as ou')->join(TBL_USER_MASTER .' as um','um.id=ou.user_id','left')->where('ou.org_user_id', $id)->get()->row_object();
    }
    
    function get_staff_access_module($user_id,$org_id)
    {

        return $this->db->select('ou.*,um.phone as phone,um.email as email')
            ->from(TBL_ORGANISATIONUSER . ' as ou')->join(TBL_USER_MASTER .' as um','um.id=ou.user_id','left')->where('ou.user_id', $user_id)->where('ou.org_id', $org_id)->get()->row_object();
    }
    
    function get_organisation_user($org_id,$user_id){
        return $this->db->select('*')
            ->from(TBL_ORGANISATIONUSER)->where('org_id', $org_id)->where('user_id', $user_id)->get()->row_object();
    }
    
    function rolesList()
    {
       return $this->db->select("RolMast.*")
                    ->from(TBL_ROLEMASTER .' as RolMast')
                    ->where('RolMast.status', '1')->get()->result_object();
    }
    
    function get_phone_value($phone)
    {

        return $this->db->select('*')
            ->from(TBL_USER_MASTER)->where('phone', $phone)->get()->row_object();
    }
    
    function get_staff_phone_exist_except_own($staff_id, $phone)
    {

        return $this->db->select('*')
            ->from(TBL_ORGANISATIONUSER .' as ou')->join(TBL_USER_MASTER .' as um','um.id=ou.user_id')
            ->where('org_user_id <>', $staff_id)
            ->where('um.phone', $phone)->get()->row_object();
    }
    
    function updateStaff($rid, $updateData = array()) {
        $this->db->where('staff_id', $rid);
        $result = $this->db->update(TBL_STAFFMASTER, $updateData);
        return $result;
    }
    
    function insert_user($_data) {
        $this->db->insert(TBL_USER_MASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function insertOrgUser($_data) {
        $this->db->insert(TBL_ORGANISATIONUSER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function get_orders($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '',$likeQuery='') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_ORDERMASTER .' as om')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=om.client_id')->where('om.org_id',$org_id);
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        if (!empty($likeQuery)) {
            $this->db->like('cm.client_name',$likeQuery,'both');
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
    
    function get_order_value($id) {
        return $this->db->select('*')
                        ->from(TBL_ORDERMASTER .' as om')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=om.client_id')->where('order_id', $id)->get()->row_object();
    }
    function updateOrder($rid, $updateData = array()) {
        $this->db->where('order_id', $rid);
        $result = $this->db->update(TBL_ORDERMASTER, $updateData);
        return $result;
    }
    
    function get_order_details($order_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_ORDERDETAIL .' as om')->join(TBL_PRODUCTMASTER . ' as pm','pm.product_id=om.product_id','left')->where('om.order_id',$order_id);
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
    
    function get_cms($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_CMS . ' as b')->where('org_id',$org_id);
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
    
    function get_cms_value($id) {
        return $this->db->select('*')
                        ->from(TBL_CMS)->where('cms_id', $id)->get()->row_object();
    }
    
    function updateCms($rid, $updateData = array()) {
        $this->db->where('cms_id', $rid);
        $result = $this->db->update(TBL_CMS, $updateData);
        return $result;
    }
    
    function get_blogs($org_id='',$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('b.*,bt.tag_name as tag_name')
                ->from(TBL_BLOGS . ' as b')->join(TBL_BLOGTAG . ' as bt','bt.tag_id=b.tag_id','left')->where('b.org_id',$org_id);
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
    
    function get_blog_value($id) {
        return $this->db->select('b.*,bt.tag_name as tag_name')
                        ->from(TBL_BLOGS.' as b')->join(TBL_BLOGTAG . ' as bt','bt.tag_id=b.tag_id')->where('b.blogs_id', $id)->get()->row_object();
    }
    
    function get_tag_value($tag_name) {
        return $this->db->select('*')
                        ->from(TBL_BLOGTAG)->where('tag_name', $tag_name)->get()->row_object();
    }
    
    function insert_blog_tag($_data) {
        $this->db->insert(TBL_BLOGTAG, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function updateBlog($rid, $updateData = array()) {
        $this->db->where('blogs_id', $rid);
        $result = $this->db->update(TBL_BLOGS, $updateData);
        return $result;
    }
    
    function insert_blog($_data) {
        $this->db->insert(TBL_BLOGS, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function get_tags($limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_BLOGTAG);
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
    /*Add Master Product*/
    function get_varthak_product_category_value_by_name($category_name) {
        return $this->db->select('*')
                        ->from('varthak_product_category')->where('category_name', $category_name)->where('parent_id', '0')->get()->row_object();
    }
    function insert_varthak_product_category($_data) {
        $this->db->insert('varthak_product_category', $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function get_varthak_product_sub_category_value_by_name($parent_id,$category_name) {
        return $this->db->select('*')
                        ->from('varthak_product_category')->where('category_name', $category_name)->where('parent_id', $parent_id)->get()->row_object();
    }
    function insert_varthak_product_sub_category($_data) {
        $this->db->insert('varthak_product_category', $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_varthak_product($_data) {
        $this->db->insert('varthak_product', $_data);
    }
    
    function get_all_organisation_contacts($keyword = null, $org_id)
    {
        $data = [];
        $page = $this->input->post('page');
        $limit = 10;
        $start  = $page == '' ? 0 : ($page - 1) * $limit;
        $this->db
            ->select("um.org_id as org_id, oc.name as name, um.phone as phone")
            ->from(TBL_ORGANISATIONCONTACTS . ' as oc')
            ->join(TBL_ORGANISATIONMASTER . ' as om', 'om.org_id=oc.fav_org_id')
            ->join(TBL_USER_MASTER . ' as um', 'om.user_id=um.id', 'left')
            ->where('oc.org_id', $org_id);

        if ($keyword != null) {
            $this->db->like('oc.name',  $keyword);
            $this->db->or_like('um.phone', $keyword);
        }

        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    function insertOrganisationContacts($data)
    {
        $this->db->db_debug = false;
        return $this->db->insert(TBL_ORGANISATIONCONTACTS, $data) ?
            $this->db->insert_id() : $this->db->error();
    }
    
    function get_sequence_invoice_id($org_id, $type)
    {
        if ($type == 'receive') {
            $this->db->select("1")
                ->from(TBL_SALESMASTER)
                ->where('org_id', $org_id);
            return "SO-" . sprintf('%06d', $this->db->get()->num_rows() + 1);
        } else {
            $this->db->select("1")
                ->from(TBL_PURCHASEMASTER)
                ->where('org_id', $org_id);
            return "PO-" . sprintf('%06d', $this->db->get()->num_rows() + 1);
        }
    }
    
    function insert_sales($_data) {
        $this->db->insert(TBL_SALESMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function insert_purchase($_data) {
        $this->db->insert(TBL_PURCHASEMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function insert_sales_detail($_data) {
        $this->db->insert(TBL_SALESDETAIL, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function insert_purchase_detail($_data) {
        $this->db->insert(TBL_PURCHASEDETAIL, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function update_sales_detail($sale_detail_id, $_data)
    {
        $this->db->where('sales_detail_id', $sale_detail_id);
        return $this->db->update(TBL_SALESDETAIL, $_data);
    }
    
    function updateSales($rid, $updateData = array()) {
        $this->db->where('sale_id', $rid);
        $result = $this->db->update(TBL_SALESMASTER, $updateData);
        return $result;
    }
    
    function updatePurchase($rid, $updateData = array()) {
        $this->db->where('purchase_id', $rid);
        $result = $this->db->update(TBL_PURCHASEMASTER, $updateData);
        return $result;
    }
    
    function get_sales_transaction_list($org_id, $order_status = null, $page = null, $due = false,  $approval = false)
    {
        $data = [];
        $limit = 10;
        $start  = $page == null ? 0 : ($page - 1) * $limit;
        $this->db->select(
            "sm.*,
            om.org_name as purchaser_org_name, 
            om2.org_name as seller_org_name"
        )
            ->from(TBL_SALESMASTER . ' as sm')
            ->where("sm.status !=", DELETE_STATUS)
            ->join(
                TBL_ORGANISATIONMASTER . ' as om',
                "om.org_id=sm.purchaser_org_id",
                'left'
            )
            ->join(
                TBL_ORGANISATIONMASTER . ' as om2',
                "om2.org_id=sm.org_id",
                'left'
            )->where('sm.org_id', $org_id);
        if ($order_status != null) {
            $this->db->where('sm.order_status', $order_status);
        }
        if ($due) {
            $this->db->where('sm.dues >', 0);
            $this->db->where('pm.status', INVOICE_ENABLE);
        }
        if ($approval) {
            $this->db->where_in('sm.order_status', [
                ORDER_REJECT_EDIT_APPROVAL_NOTIFY, ORDER_MERGE_APPROVAL_NOTIFY, ORDER_EDIT_APPROVAL_NOTIFY, ORDER_CREATED,
                ORDER_REJECT_ON_EDIT
            ]);
        } else {
            $this->db->where('sm.org_id', $org_id);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        $this->db->order_by('sm.added_at', 'DESC');
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_purchase_transaction_list($org_id, $saler_org_id = null, $order_status = null, $page = null, $due = false,  $approval = false)
    {
        $data = [];
        $limit = 10;
        $start  = $page == null ? 0 : ($page - 1) * $limit;
        $this->db->select(
            "pm.*,
            om2.org_name as purchaser_org_name, 
            om.org_name as seller_org_name"
        )
            ->from(TBL_PURCHASEMASTER . ' as pm')
            ->join(
                TBL_ORGANISATIONMASTER . ' as om',
                "om.org_id=pm.saler_org_id",
                'left'
            )
            ->join(
                TBL_ORGANISATIONMASTER . ' as om2',
                "om2.org_id=pm.org_id",
                'left'
            )->where("pm.status !=", DELETE_STATUS)
            ->where('pm.org_id', $org_id);
        if ($order_status != null) {
            $this->db->where('order_status', $order_status);
        }
        if ($saler_org_id != null) {
            $this->db->where('saler_org_id', $saler_org_id);
        }
        if ($due) {
            $this->db->where('pm.dues >', 0);
            $this->db->where('pm.status', INVOICE_ENABLE);
        }
        if ($approval) {
            $this->db->where_in('pm.order_status', [
                ORDER_REJECT_EDIT_APPROVAL_NOTIFY, ORDER_MERGE_APPROVAL_NOTIFY, ORDER_EDIT_APPROVAL_NOTIFY, ORDER_CREATED,
                ORDER_REJECT_ON_EDIT
            ]);
        } else {
            $this->db->where('pm.org_id', $org_id);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        $this->db->order_by('pm.added_at', 'DESC');
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function get_sales_value($sale_id)
    {
        return $this->db->select('sm.*, om.org_name as seller_org_name, om2.org_name as purchaser_org_name')
            ->from(TBL_SALESMASTER . ' as sm')
            ->join(
                TBL_ORGANISATIONMASTER . ' as om',
                "om.org_id=sm.purchaser_org_id",
                'left'
            )
            ->join(
                TBL_ORGANISATIONMASTER . ' as om2',
                "om2.org_id=sm.org_id",
                'left'
            )
            ->where("sm.status !=", DELETE_STATUS)
            ->where('sm.sale_id', $sale_id)->get()->row_object();
    }
    
    function getSaleDetails($sale_id)
    {
        $image_path = base_url() . 'uploads/varthak_product/';
        return $this->db->select(
            "sd.*, 
            pm.product_name, CONCAT('$image_path',pm.product_image) as product_image, 
            pm.quantity_unit"
        )
            ->from(TBL_SALESDETAIL . ' as sd')
            ->join(TBL_PRODUCTMASTER . ' as pm', 'pm.product_id=sd.product_id', 'left')
            ->where('sales_id', $sale_id)->get()->result_object();
    }
    
    function get_purchase_value($purchase_id)
    {
        return $this->db
            ->select('pm.*, om.org_name as seller_org_name, om2.org_name as purchase_org_name')
            ->from(TBL_PURCHASEMASTER . ' as pm')
            ->join(
                TBL_ORGANISATIONMASTER . ' as om',
                "om.org_id=pm.saler_org_id",
                'left'
            )
            ->join(
                TBL_ORGANISATIONMASTER . ' as om2',
                "om2.org_id=pm.org_id",
                'left'
            )
            ->where("pm.status !=", DELETE_STATUS)
            ->where('pm.purchase_id', $purchase_id)->get()->row_object();
    }
    
    function getPurchaseDetails($purchase_id)
    {
        $image_path = base_url() . 'uploads/varthak_product/';

        return $this->db
            ->select(
                "pd.*, pm.product_name, 
                CONCAT('$image_path',pm.product_image) as product_image, 
            pm.quantity_unit"
            )
            ->from(TBL_PURCHASEDETAIL . ' as pd')
            ->join(TBL_PRODUCTMASTER . ' as pm', 'pm.product_id=pd.product_id', 'left')
            ->where('purchase_id', $purchase_id)
            ->get()->result_object();
    }
    function insertPayment($data)
    {
        $this->db->db_debug = false;
        return $this->db->insert(TBL_PAYMENT, $data) ?
            $this->db->insert_id() : $this->db->error();
    }
    function insertReceivable($data)
    {
        $this->db->db_debug = false;
        return $this->db->insert(TBL_RECEIVABLE, $data) ?
            $this->db->insert_id() : $this->db->error();
    }
    function updatePayment($payment_id, $updateData = array())
    {
        $this->db->where('id', $payment_id);
        $result = $this->db->update(TBL_PAYMENT, $updateData);
        return $result;
    }
    function getReceivables(
        $org_id = null,
        $sale_id = null,
        $purchase_id = null,
        $limit = '',
        $start = '',
        $to_org_id = null
    ) {
        $data = [];
        $this->db->select("receivable.*, sm.sales_invoice, om.org_name")->from(TBL_RECEIVABLE)
            ->join(
                TBL_ORGANISATIONMASTER . ' as om',
                "om.org_id=receivable.to_org_id",
                'left'
            )
            ->join(TBL_SALESMASTER . ' as sm', 'sm.sale_id=receivable.invoice_id', 'left');
        if ($purchase_id != null) {
            $this->db->where('invoice_id', $purchase_id);
        }
        if ($org_id != null) {
            $this->db->where('receivable.org_id', $org_id);
        }
        if ($to_org_id != null) {
            $this->db->where('receivable.to_org_id', $to_org_id);
        }
        if ($sale_id != null) {
            $this->db->where('sm.sale_id', $sale_id)
                ->where("sm.status !=", DELETE_STATUS);
        }

        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function getPayments(
        $org_id = null,
        $sale_id = null,
        $purchase_id = null,
        $limit = '',
        $start = '',
        $to_org_id = null
    ) {
        $data = [];
        $this->db->select("pay.*, pm.purchase_invoice, om.org_name")->from(TBL_PAYMENT . ' as pay')
            ->join(
                TBL_ORGANISATIONMASTER . ' as om',
                "om.org_id=pay.to_org_id",
                'left'
            )
            ->join(TBL_PURCHASEMASTER . ' as pm', 'pm.purchase_id=pay.invoice_id', 'left');
        if ($purchase_id != null) {
            $this->db->where('invoice_id', $purchase_id);
        }
        if ($org_id != null) {
            $this->db->where('pay.org_id', $org_id);
        }
        if ($to_org_id != null) {
            $this->db->where('pay.to_org_id', $to_org_id);
        }
        if ($sale_id != null) {
            $this->db->where('pm.sales_master_id', $sale_id)
                ->where("pm.status !=", DELETE_STATUS);
        }

        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function getReceivableById($receivable_id)
    {
        return $this->db->select('*')
            ->from(TBL_RECEIVABLE)
            ->where('id', $receivable_id)
            ->where('status !=', DELETE_STATUS)
            ->get()->row_object();
    }
    
    function get_purchase_from_sales($sale_id)
    {
        return $this->db->select('*')
            ->from(TBL_PURCHASEMASTER)
            ->where("status !=", DELETE_STATUS)
            ->where('sales_master_id', $sale_id)->get()->row_object();
    }
    
    function get_sales_from_purchase($purchase_id)
    {
        return $this->db->select('*')
            ->from(TBL_SALESMASTER)
            ->where("status !=", DELETE_STATUS)
            ->where('purchase_master_id', $purchase_id)->get()->row_object();
    }
    
    function getPaymentById($payment_id)
    {
        return $this->db->select('*')
            ->from(TBL_PAYMENT)
            ->where('id', $payment_id)
            ->where('status !=', DELETE_STATUS)
            ->get()->row_object();
    }
    function updateReceivable($receivable_id, $updateData = array())
    {
        $this->db->where('id', $receivable_id);
        $result = $this->db->update(TBL_RECEIVABLE, $updateData);
        return $result;
    }
    function get_warehouse_value($id) {
        return $this->db->select('*')
                        ->from(TBL_WAREHOUSE)->where('warehouse_id', $id)->get()->row_object();
    }
    function get_warehouse($org_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_WAREHOUSE)->where('org_id',$org_id);
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
    function updateWarehouse($rid, $updateData = array()) {
        $this->db->where('warehouse_id', $rid);
        $result = $this->db->update(TBL_WAREHOUSE, $updateData);
        return $result;
    }
    function insert_warehouse($_data) {
        $this->db->insert(TBL_WAREHOUSE, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function get_client_deliveries_assigned_by_route($org_id,$trip_date,$route_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('dm.*')
                ->from(TBL_DELIVERIESMASTER .' as dm')->where('date',$trip_date)->where('dm.org_id',$org_id)->where('dm.is_assigned', '1')->where('route_id',$route_id)->order_by('route_id','ASC');
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
    function updatedeliveries($rid, $updateData = array()) {
        $this->db->where('deliveries_id', $rid);
        $result = $this->db->update(TBL_DELIVERIESMASTER, $updateData);
        return $result;
    }
    function get_deliveries_detail_for_return_warehouse($trip_date,$route_id) {
        return $this->db->select('')
                ->from(TBL_DELIVERIESMASTER .' as dm')->where('date',$trip_date)->where('route_id',$route_id)->get()->result_object();
    }
    function updateWarehouseReturn($trip_date,$route_id, $updateData = array()) {
        $this->db->where('date', $trip_date);
        $this->db->where('route_id', $route_id);
        $result = $this->db->update(TBL_DELIVERIESMASTER, $updateData);
        return $result;
    }
    function is_route_client_added($org_id,$route_name) {
        $result =  $this->db->select('COUNT(route_id) as TotNum')
                        ->from(TBL_CLIENTROUTE)->where('org_id', $org_id)->where('status', '1')->where('route_name', $route_name)->get()->row_object();
        if($result->TotNum>0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function insert_route($_data) {
        $this->db->insert(TBL_CLIENTROUTE, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function deleteDeliveries($org_id,$deliveries_id) {
        $this->db->where('org_id', $org_id);
        $this->db->where('deliveries_id', $deliveries_id);
        $this->db->delete(TBL_DELIVERIESMASTER);
    }
    function deleteRoute($org_id,$route_id) {
        $this->db->where('org_id', $org_id);
        $this->db->where('route_id', $route_id);
        $this->db->where('is_plan_confirmed', '0');
        $this->db->delete(TBL_DELIVERIESMASTER);
    }
    function get_delivery_order_by_deleveries_id($id) {
        return $this->db->select('dm.*,cm.client_address as client_address, cm.client_latitude as client_latitude, cm.client_longitude as client_longitude')
                ->from(TBL_DELIVERIESMASTER .' as dm')
                ->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dm.client_id','left')
                ->where('dm.deliveries_id',$id)->get()->row_object();
        
    }
    function get_trip_client_by_assigned_trip_id($assigned_trip_id){
        return $this->db->select('*')
                        ->from(TBL_DRIVERTRIPCLIENT)->where('assigned_trip_id', $assigned_trip_id)->order_by('order_list','ASC')->get()->result_object();
    }
    function get_trip_client_by_assigned_trip_id_total($assigned_trip_id){
        $result = $this->db->select('COUNT(driver_trip_clients_id) as TotNum')
                        ->from(TBL_DRIVERTRIPCLIENT)->where('assigned_trip_id', $assigned_trip_id)->order_by('order_list','ASC')->get()->row_object();
        return $result->TotNum;
    }
    function get_trip_detail_by_assigned_trip_id($assigned_trip_id){
        return $this->db->select('*')
                ->from(TBL_DRIVERASSIGNEDTRIP)
                ->where('assigned_trip_id',$assigned_trip_id)->get()->row_object();
    }
    function get_driver_trip_clients_by_driver_trip_clients_id($driver_trip_clients_id ) {
        return $this->db->select('dm.*,cm.company_name as company_name,cm.client_mobile as client_mobile,cm.client_address as client_address, cm.client_latitude as client_latitude, cm.client_longitude as client_longitude')
                ->from(TBL_DRIVERTRIPCLIENT .' as dm')
                ->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dm.client_id','left')
                ->where('dm.driver_trip_clients_id',$driver_trip_clients_id)->get()->row_object();
        
    }
    function get_driver_deliveries_status($driver_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('dtp.*,cm.company_name as company_name,cm.client_mobile as client_mobile,cm.client_address as client_address,cr.route_name as route_name,d.name as driver_name,dat.trip_start_time as trip_start_time, dat.trip_end_time as trip_end_time')
                ->from(TBL_DRIVERTRIPCLIENT .' as dtp')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dtp.client_id','left')->join(TBL_DRIVERASSIGNEDTRIP . ' as dat','dat.assigned_trip_id=dtp.assigned_trip_id','left')->join(TBL_CLIENTROUTE .' as cr','cr.route_id=dat.route_id','left')->join(TBL_DRIVERS .' as d','d.driver_id=dat.driver_id')->where('dat.driver_id',$driver_id);
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
    function get_drivers($org_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '',$likeQuery='') {
        $data = [];
        
        $this->db->select('*')
                ->from(TBL_DRIVERS)->where('org_id',$org_id)->where('status!=', '3');
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        if (!empty($likeQuery)) {
            $this->db->like('name',$likeQuery,'both');
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
    function get_driver_value($id) {
        return $this->db->select('*')
                        ->from(TBL_DRIVERS)->where('driver_id', $id)->where('status!=', '3')->get()->row_object();
    }
    function insert_driver_trip_client($_data) {
        $this->db->insert(TBL_DRIVERTRIPCLIENT, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_driver($_data) {
        $this->db->insert(TBL_DRIVERS, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateDriver($rid, $updateData = array()) {
        $this->db->where('driver_id', $rid);
        $result = $this->db->update(TBL_DRIVERS, $updateData);
        return $result;
    }
    function last_driver_deleveries($driver_id) {
        return $this->db->select('*')
                        ->from(TBL_DRIVERASSIGNEDTRIP)->where('driver_id', $driver_id)->where('is_trip_completed', '1')->order_by('assigned_date','DESC')->limit(1)->get()->row_object();
    }
    function get_drivers_text_search($org_id,$searchQuery = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_DRIVERS)->where('org_id',$org_id)->where('status!=', '3');
        if (!empty($searchQuery)) {
            $this->db->like($searchQuery);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    function get_client_deliveries($org_id,$trip_date,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('cm.*,dm.deliveries_id as deliveries_id')
                ->from(TBL_DELIVERIESMASTER .' as dm')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dm.client_id','left')->where('type','0')->where('date',$trip_date)->where('dm.org_id',$org_id)->where('dm.is_assigned', '0')->where('dm.is_plan_confirmed', '0');
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
    function get_customer_deliveries($org_id,$trip_date,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_DELIVERIESMASTER)->where('type','1')->where('date',$trip_date)->where('org_id',$org_id)->where('is_assigned', '0');
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
    function get_client_deliveries_trip_plan($org_id,$trip_date,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('cm.*,dm.warehouse_id as warehouse_id,dm.is_return_warehouse as is_return_warehouse,dm.trip_start_time as trip_start_time,dm.trip_end_time as trip_end_time,dm.order_list as order_list,dm.client_id as client_id, dm.driver_id as driver_id,dm.date as date,dm.deliveries_id as deliveries_id,dm.route_id as route_id, dm.type as type, dm.customer_name as customer_name, dm.mobile_number as mobile_number, dm.address as address,dm.is_driver_assigned,dm.customer_lat as customer_lat,dm.customer_long as customer_long,d.name as driver_name, d.phone as driver_phone')
                ->from(TBL_DELIVERIESMASTER .' as dm')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dm.client_id','left')->join(TBL_DRIVERS .' as d','d.driver_id=dm.driver_id','left')->where('dm.date',$trip_date)->where('dm.org_id',$org_id)->where('dm.is_plan_confirmed', '1')->order_by('route_id','ASC')->order_by('order_list','ASC');
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
    function get_clients_routes($org_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_CLIENTROUTE)->where('org_id',$org_id)->where('status!=', '3');
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
    function get_client_deliveries_assigned_by_route_not_confirmed($org_id,$trip_date,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('dm.*')
                ->from(TBL_DELIVERIESMASTER .' as dm')->where('date',$trip_date)->where('dm.org_id',$org_id)->where('dm.is_assigned', '1')->where('dm.is_plan_confirmed', '0')->order_by('route_id','ASC');
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
    function get_client_deliveries_assigned($org_id,$trip_date,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('cm.*,dm.deliveries_id as deliveries_id,dm.route_id as route_id, dm.type as type, dm.customer_name as customer_name, dm.mobile_number as mobile_number, dm.address as address,dm.is_driver_assigned,d.name as driver_name, d.phone as driver_phone')
                ->from(TBL_DELIVERIESMASTER .' as dm')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dm.client_id','left')->join(TBL_DRIVERS .' as d','d.driver_id=dm.driver_id','left')->where('date',$trip_date)->where('dm.org_id',$org_id)->where('dm.is_assigned', '1')->where('dm.is_plan_confirmed', '0')->order_by('route_id','ASC');
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
    function get_clients($org_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '',$likeQuery='') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_CLIENTMASTER)->where('org_id',$org_id)->where('status!=', '3');
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        if (!empty($likeQuery)) {
            $this->db->like('client_name',$likeQuery,'both');
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
    function insert_deliveries($_data) {
        $this->db->insert(TBL_DELIVERIESMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insert_dcustomer_importorder($_data) {
        $this->db->insert(TBL_CUSTOMERIMPORT, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function get_distinct_customer_importorder($org_id) {
        return $this->db->select('DISTINCT(customer_id) as customer_id')
                ->from(TBL_CUSTOMERIMPORT)->where('org_id',$org_id)->where('import_status', '0')->get()->result_object();
         
        
    }
    function get_customer_importorder($customer_id) {
        return $this->db->select('*')
                ->from(TBL_CUSTOMERIMPORT)->where('customer_id',$customer_id)->where('import_status', '0')->get()->result_object();
        
    }
    function update_customer_importorder($org_id,$customer_id, $updateData = array()) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('org_id', $org_id);
        $result = $this->db->update(TBL_CUSTOMERIMPORT, $updateData);
        //echo $this->db->last_query();exit;
        return $result;
    }
    function is_deliveries_client_added($client_id,$date) {
        $result =  $this->db->select('COUNT(deliveries_id) as TotNum')
                        ->from(TBL_DELIVERIESMASTER)->where('client_id', $client_id)->where('is_plan_confirmed', '0')->where('date', $date)->get()->row_object();
        if($result->TotNum>0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function get_clients_text_search($org_id,$searchQuery = '') {
        $data = [];
        $this->db->select('*')
                ->from(TBL_CLIENTMASTER)->where('org_id',$org_id)->where('status!=', '3');
        if (!empty($searchQuery)) {
            $this->db->like($searchQuery);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        
        $data['result'] = $this->db->get()->result_object();
        //echo $this->db->last_query();exit;
        return $data;
    }
    function get_client_value($id) {
        return $this->db->select('*')
                        ->from(TBL_CLIENTMASTER)->where('client_id', $id)->where('status!=', '3')->get()->row_object();
    }
    function insert_client($_data) {
        $this->db->insert(TBL_CLIENTMASTER, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateClient($rid, $updateData = array()) {
        $this->db->where('client_id', $rid);
        $result = $this->db->update(TBL_CLIENTMASTER, $updateData);
        return $result;
    }
    function last_client_deleveries($client_id) {
        return $this->db->select('*')
                        ->from(TBL_DRIVERTRIPCLIENT)->where('client_id', $client_id)->order_by('delivered_at','DESC')->limit(1)->get()->row_object();
    }
    function get_client_deliveries_status($client_id,$limit = '', $start = '', $searchQuery = '', $columnName = '', $columnSortOrder = '') {
        $data = [];
        $this->db->select('dtp.*,cm.company_name as company_name,cm.client_mobile as client_mobile,cm.client_address as client_address,cr.route_name as route_name,d.name as driver_name')
                ->from(TBL_DRIVERTRIPCLIENT .' as dtp')->join(TBL_CLIENTMASTER . ' as cm','cm.client_id=dtp.client_id','left')->join(TBL_DRIVERASSIGNEDTRIP . ' as dat','dat.assigned_trip_id=dtp.assigned_trip_id','left')->join(TBL_CLIENTROUTE .' as cr','cr.route_id=dat.route_id','left')->join(TBL_DRIVERS .' as d','d.driver_id=dat.driver_id')->where('dtp.client_id',$client_id);
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
    function is_all_driver_assigned_to_trip($org_id,$trip_date) {
        $this->db->select('COUNT(dm.deliveries_id) as TotNum,')
                ->from(TBL_DELIVERIESMASTER .' as dm')->where('date',$trip_date)->where('dm.org_id',$org_id)->where('dm.is_driver_assigned', '0');
        $result = $this->db->get()->row_object();
        if($result->TotNum>0){
            return false;
        }else{
            return true;
        }
    }
    function updatePlanConform($org_id, $trip_date, $updateData = array()) {
        $this->db->where('org_id', $org_id);
        $this->db->where('date', $trip_date);
        $result = $this->db->update(TBL_DELIVERIESMASTER, $updateData);
        return $result;
    }
    function insert_assign_trip($_data) {
        $this->db->insert(TBL_DRIVERASSIGNEDTRIP, $_data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateAssignTrip($assigned_trip_id, $updateData = array()) {
        $this->db->where('assigned_trip_id', $assigned_trip_id);
        $result = $this->db->update(TBL_DRIVERASSIGNEDTRIP, $updateData);
        return $result;
    }
    function get_trips_deliveries($org_id,$limit = '', $start = '', $searchQuery = '') {
        $data = [];
        $this->db->select('dat.*,d.name as driver_name,d.phone as driver_phone,rt.route_name as route_name')
                ->from(TBL_DRIVERASSIGNEDTRIP . ' as dat')->join(TBL_DRIVERS .' as d','d.driver_id=dat.driver_id','left')->join(TBL_CLIENTROUTE . ' as rt','rt.route_id=dat.route_id','left')->where('dat.org_id',$org_id);
        if (!empty($searchQuery)) {
            $this->db->where($searchQuery);
        }
        $cl = clone $this->db;
        $data['total'] = $cl->get()->num_rows();
        if (!empty($limit)) {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('assigned_date', 'DESC');
        $data['result'] = $this->db->get()->result_object();
        return $data;
    }
    
    function insert_location_tbl($_data) {
        $this->db->insert('location_tbl', $_data);
    }
    
    /*End Master Product*/
}
