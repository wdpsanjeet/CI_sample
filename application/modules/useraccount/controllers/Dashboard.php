<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Dashboard extends MY_Controller {

    private $response = array();
    private $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        if (!$this->session->userdata('user_id')) {
            redirect('');
        }
        $org_id = $this->session->userdata('org_id');
        //echo $org_id;
        $roleObj = $this->user_model->get_staff_access_module($this->session->userdata('user_id'), $org_id);
        //print_r($roleObj);
        $this->data['role_id'] = $role_id = $roleObj->role_id;

        $this->data['permission_access'] = $this->user_model->getAssignPermission($org_id, $role_id);
        //print_r($this->data['permission_access']);
        //exit;
        $this->data['menu'] = array();
        if ($this->data['permission_access']['total'] > 0) {
            foreach ($this->data['permission_access']['result'] as $list) {
                $this->data['menu'][$list->module_id] = $list->view_status;
            }
        }
        $this->data['userDetailInfo'] = $this->user_model->get_user_value($this->session->userdata('user_id'));
        //print_r($this->data['permission_access']);
        //exit;
    }

    private function isPermissionModuleAccess($module_id, $type) {
        $access_level = array('view' => false, 'add' => false, 'edit' => false, 'delete' => false);
        if ($this->data['permission_access']['total'] > 0) {
            foreach ($this->data['permission_access']['result'] as $list) {
                if ($list->module_id == $module_id) {
                    if ($list->view_status == '1') {
                        $access_level['view'] = true;
                    }
                    if ($list->add_status == '1') {
                        $access_level['add'] = true;
                    }
                    if ($list->edit_status == '1') {
                        $access_level['edit'] = true;
                    }
                    if ($list->delete_status == '1') {
                        $access_level['delete'] = true;
                    }
                }
            }
        }
        //echo $access_level[$type];exit;
        if (!$access_level[$type]) {
            redirect('useraccount/dashboard');
        } else {
            return $access_level;
        }
        //return $access_level;
    }

    function index() {
        $this->data['access_level'] = array();
        $this->data['page_title'] = 'Dashboard';
        $this->load->view('dashboard', $this->data);
    }

    function editProfile() {
        $this->data['page_title'] = 'Profile Setting';
        $user_id = $this->session->userdata('user_id');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->form_validation->set_error_delimiters('', '');
        $this->data['user'] = $this->user_model->get_user_value($user_id);
        $this->data['verify_status'] = '';
        if ($this->input->post('updatePersonalinfo')) {

            $this->form_validation->set_rules('name', 'name', 'required|trim|xss_clean');
            $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|xss_clean');
            if ($this->form_validation->run()) {
                $updateData = array();

                $updateData['name'] = $this->input->post('name');
                $updateData['email'] = $this->input->post('email');
                if (isset($_FILES['thumbnail']['name']) && ($_FILES['thumbnail']['name'] != '')) {

                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $filename = 'profile_' . rand(10, 500) . time() . '.' . $extension;

                            $config = array(
                                'upload_path' => "./uploads/profile_img/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $filename,
                            );
                            $this->load->library('upload', $config);
                            $this->upload->do_upload('thumbnail');
                        }
                    }
                }
                if (isset($filename)) {
                    $updateData['profile_pic'] = $filename;
                }
                $this->user_model->updateUser($user_id, $updateData);
                $this->session->set_flashdata('flash_message', $this->user_model->user_flash_message('success', $this->lang->line('updated_success')));
                redirect('useraccount/editProfile?tab=personal');
            }
        }
        $this->load->view('editProfile', $this->data);
    }

    function notifications() {
        $this->data['page_title'] = 'Notification';
        $user_id = $this->session->userdata('user_id');
        $this->data['notification'] = $this->user_model->get_user_notification($user_id);
        $this->load->view('notifications', $this->data);
    }

    function support() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_SUPPORT_ID, MODULE_ACCESS_TYPE_VIEW);
        //print_r($this->data['access_level']);exit;
        $this->data['page_title'] = '';
        $user_id = $this->session->userdata('user_id');
        $this->data['user_detail'] = $this->user_model->get_user_value($user_id);
        $this->load->view('support', $this->data);
    }

    function dosupport() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email_id', 'email ', 'trim|required|valid_email|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('ticket_subject', 'Ticket subject ', 'trim|required|min_length[10]|max_length[255]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('comment', 'problem ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "email_id" => $this->input->post('email_id'),
                    "ticket_subject" => $this->input->post('ticket_subject'),
                    "comment" => $this->input->post('comment'),
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "status" => '1',
                );
                $this->user_model->insert_ticket($_data);
                $this->response['message'] = 'Your ticket has been sent to Brandket support person,They will conatct you very soon.';

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function addFavCustomer() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('phone', 'Phone ', 'trim|required|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required|min_length[3]|max_length[255]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('name', 'Name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $phone = $this->input->post('phone');
                $name = $this->input->post('name');
                $company_name = $this->input->post('company_name');
                $user_id = $this->session->userdata('user_id');
                $org_id = $this->session->userdata('org_id');
                $userDetails = $this->user_model->get_phone_value($phone);
                if (!empty($userDetails)) {
                    //add in favorite
                    $org_insert_id = $userDetails->org_id;
                    $contact_data = array(
                        'fav_org_id' => $org_insert_id,
                        'org_id' => $org_id,
                        'name' => $name,
                        'added_by' => $user_id,
                        'added_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d'),
                    );
                    $contact_insert_id = $this->user_model->insertOrganisationContacts($contact_data);
                } else {
                    $user_data = array(
                        'company_name' => $company_name,
                        'name' => $name,
                        'business_nature' => 'personal',
                        'phone' => $phone,
                        'status' => '0',
                        'added_at' => date('Y-m-d H:i:s'),
                        'subscription_date' => date('Y-m-d'),
                        'expired_date' => date('Y-m-d', strtotime("+30 days")),
                    );
                    $insert_id = $this->user_model->insert_user($user_data);

                    //insert organisation information
                    $org_data = array(
                        'user_id' => $insert_id,
                        'added_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    $org_insert_id = $this->user_model->insert_organisation($org_data);
                    $company_code = $org_insert_id . $this->all_function->randomNumber(10 - strlen($org_insert_id));

                    $this->user_model->updateUser($insert_id, array('company_code' => $company_code, 'org_id' => $org_insert_id));
                    $this->user_model->updateOrganisation($org_insert_id, $insert_id,array('company_code' => $company_code));
                    //Default Setting for Varthak information
                    //CMS Done
                    $global_cms_list = $this->user_model->get_cms_global();
                    $global_cms_arr = array();
                    foreach ($global_cms_list as $list) {
                        $global_cms_arr[] = array('org_id' => $org_insert_id, 'page_name' => $list->page_name, 'section' => $list->section, 'type' => $list->type, 'cms_data' => $list->cms_data);
                    }
                    $this->user_model->insert_cms_mgm_batch($global_cms_arr);
                    //End CMS
                    // Role Done
                    $global_permission_list = $this->user_model->get_permission_global();
                    $global_permission_arr = array();
                    foreach ($global_permission_list as $list) {
                        $global_permission_arr[] = array('org_id' => $org_insert_id, 'role_id' => $list->role_id, 'module_id' => $list->module_id, 'view_status' => $list->view_status, 'add_status' => $list->add_status, 'edit_status' => $list->edit_status, 'delete_status' => $list->delete_status);
                    }
                    $this->user_model->insert_permission_batch($global_permission_arr);
                    // End Role
                    //END Global
                    $contact_data = array(
                        'fav_org_id' => $org_insert_id,
                        'org_id' => $org_id,
                        'name' => $company_name,
                        'added_by' => $user_id,
                        'added_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d'),
                    );
                    $contact_insert_id = $this->user_model->insertOrganisationContacts($contact_data);
                }
                $this->response['FavHTMLOpt'] = '<option value="' . $org_insert_id . '">' . $name . '</option>';
                $this->response['message'] = 'new business added successfully.';

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function sales() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_SALES_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Sales';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['sales'] = $this->user_model->get_sales_transaction_list($org_id);
        $this->load->view('sales', $this->data);
    }

    function get_receivables() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_SALES_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Payments Receivables';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        //$to_org_id = $this->input->post('to_org_id');
        //$is_receive = $this->input->post('is_receive');
        //$isReceive = $is_receive == '1' ? true : false;

        $page = $this->input->post('page');
        $purchase_id = $this->input->post('invoice_id');
        $sale_id = $this->input->post('sale_id');
        $limit = 10;
        $start = $page == '' ? 0 : ($page - 1) * $limit;
        $this->data['payments'] = $this->user_model->getReceivables($org_id, $sale_id, $purchase_id, $limit, $start, null);
        $this->load->view('receivable', $this->data);
    }

    function get_payments() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_SALES_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Payments Receivables';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        //$to_org_id = $this->input->post('to_org_id');
        //$is_receive = $this->input->post('is_receive');
        //$isReceive = $is_receive == '1' ? true : false;

        $page = $this->input->post('page');
        $purchase_id = $this->input->post('invoice_id');
        $sale_id = $this->input->post('sale_id');
        $limit = 10;
        $start = $page == '' ? 0 : ($page - 1) * $limit;
        $this->data['payments'] = $this->user_model->getPayments($org_id, $sale_id, $purchase_id, $limit, $start, null);
        $this->load->view('payments', $this->data);
    }

    function confirmPayment() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'payment id', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('is_receive', 'Pay Receive Flag', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('approve', 'Approve ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $user_id = $this->session->userdata('user_id');
                $id = $this->input->post('id');
                $approve = $this->input->post('approve');
                $is_receive = $this->input->post('is_receive');
                $isReceive = $is_receive == '1' ? true : false;
                $common_data = array(
                    "updated_at" => date('Y-m-d H:i:s'),
                    "last_updated_by" => $user_id,
                );
                $approve = $approve == 1 ? 1 : -1;
                $isApproved = $approve == 1 ? true : false;
                $updateData = array_merge($common_data, array(
                    'payment_status' => $isApproved ? PAYMENT_APPROVED : PAYMENT_REJECTED
                ));
                $this->db->trans_start();
                if ($isReceive) {
                    //Revert the purchase side of the receivable (3rd party)
                    $receivableDetail = $this->user_model->getReceivableById($id);
                    $this->handleNullCheck($receivableDetail, "Invalid Receivable Entry");
                    if ($receivableDetail->payment_status == $approve) {
                        //$this->handleOKResponse("Receivable already Approved/Rejected");
                        $this->response['message'] = 'Receivable already Approved/Rejected';
                        $this->response['status'] = 500;
                    }
                    $purchaseObj = $this->user_model->get_purchase_from_sales($receivableDetail->invoice_id);
                    $this->handleNullCheck($purchaseObj, "Invalid Purchase Entry");
                    if (!$isApproved && $receivableDetail->payment_status == PAYMENT_APPROVAL_REQUIRED) {
                        $purchaseUpdateData = array_merge($common_data, array(
                            'paid' => $purchaseObj->paid - $receivableDetail->amount,
                            'dues' => $purchaseObj->dues + $receivableDetail->amount,
                        ));
                        $this->user_model->updatePurchase($purchaseObj->purchase_id, $purchaseUpdateData);
                    }
                    $paymentDetail = $this->user_model->getPaymentById($receivableDetail->payment_master_id);
                    $this->handleNullCheck($paymentDetail, "Invalid Payment Entry");
                    if ($isApproved && $paymentDetail->payment_status == PAYMENT_EDIT_APPROVAL_REQUIRED) {
                        $purchaseUpdateData = array_merge($common_data, array(
                            'paid' => $purchaseObj->paid - $paymentDetail->amount + $receivableDetail->amount,
                            'dues' => $purchaseObj->dues + $paymentDetail->amount - $receivableDetail->amount,
                        ));
                        $this->user_model->updatePurchase($purchaseObj->purchase_id, $purchaseUpdateData);
                    }
                    $this->user_model->updatePayment(
                            $receivableDetail->payment_master_id, array_merge($updateData, array("amount" => $receivableDetail->amount))
                    );
                    $this->user_model->updateReceivable($id, $updateData);
                } else {
                    //Revert the sales side of the payment (3rd party)
                    $paymentDetail = $this->user_model->getPaymentById($id);
                    $this->handleNullCheck($paymentDetail, "Invalid Payment Entry");
                    if ($paymentDetail->payment_status == $approve) {
                        $this->response['message'] = 'Receivable already Approved/Rejected';
                        $this->response['status'] = 500;
                        //$this->handleOKResponse("Receivable already Approved/Rejected");
                    }
                    $salesObj = $this->user_model->get_sales_from_purchase($paymentDetail->invoice_id);
                    $this->handleNullCheck($salesObj, "Invalid Sale Entry");
                    if (!$isApproved && $paymentDetail->payment_status == PAYMENT_APPROVAL_REQUIRED) {
                        $salesUpdateData = array_merge($common_data, array(
                            'paid' => $salesObj->paid - $paymentDetail->amount,
                            'dues' => $salesObj->dues + $paymentDetail->amount,
                        ));
                        $this->user_model->updateSales($salesObj->sale_id, $salesUpdateData);
                    }
                    $receivableDetail = $this->user_model->getReceivableById($paymentDetail->receivable_master_id);
                    $this->handleNullCheck($paymentDetail, "Invalid Payment Entry");
                    if ($isApproved && $receivableDetail->payment_status == PAYMENT_EDIT_APPROVAL_REQUIRED) {
                        $salesUpdateData = array_merge($common_data, array(
                            'paid' => $salesObj->paid - $receivableDetail->amount + $paymentDetail->amount,
                            'dues' => $salesObj->dues + $receivableDetail->amount - $paymentDetail->amount,
                        ));
                        $this->user_model->updateSales($salesObj->sale_id, $salesUpdateData);
                    }
                    $this->user_model->updateReceivable(
                            $paymentDetail->receivable_master_id, array_merge($updateData, array("amount" => $paymentDetail->amount))
                    );
                    $this->user_model->updatePayment($id, $updateData);
                }
                $this->db->trans_commit();
                $this->response['message'] = 'Payment updated.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function add_sales() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_SALES_ID, MODULE_ACCESS_TYPE_ADD);
        $this->data['page_title'] = 'Sales';
        $this->data['page_type'] = 'Add Sales';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['organisations'] = $this->user_model->get_all_organisation_except_logedin_user($user_id);
        $this->data['fav_contacts'] = $this->user_model->get_all_organisation_contacts(NULL, $org_id);
        //print_r($this->data['fav_contacts']);exit;
        $this->data['products'] = $this->user_model->get_products($org_id);
        $this->load->view('add_sales', $this->data);
    }

    function edit_sales($sale_id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_SALES_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Sales';
        $this->data['page_type'] = 'Edit Sales';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['organisations'] = $this->user_model->get_all_organisation_except_logedin_user($user_id);
        $this->data['sales_detail'] = $this->user_model->get_sales_value($sale_id);
        $this->data['items'] = $this->user_model->getSaleDetails($sale_id);
        $this->load->view('edit_sales', $this->data);
    }

    function doaddsales() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('client_org_id', 'business id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('advance_amount', 'advance payment  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('due_date', 'due date  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('payment_type', 'payment type  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $user_id = $this->session->userdata('user_id');
                $self_org_id = $this->session->userdata('org_id');
                $client_org_id = $this->input->post('client_org_id');
                $client_detail = $this->user_model->get_organisation_default_by_value($client_org_id);

                $advance_payment = $this->input->post('advance_amount');
                $due_date = $this->input->post('due_date');
                $payment_type = $this->input->post('payment_type');
                $client_phone = $client_detail->phone;
                $invoice_date = date('Y-m-d H:i:s');
                $name = $client_detail->name;
                $note = $this->input->post('note');
                $isPurchase = false;

                $nextPurchaseId = $this->user_model->get_sequence_invoice_id($client_org_id, 'pay');
                $nextSaleId = $this->user_model->get_sequence_invoice_id($self_org_id, 'receive');
                $sales_invoice_id = $nextSaleId;
                $purchase_invoice_id = $nextPurchaseId;
                $sale_org_id = $self_org_id;
                $purchase_org_id = $client_org_id;
                $approver_sale_org_id = null;
                $approver_purchase_org_id = $client_org_id;
                $common_sale_data = array(
                    "paid" => $advance_payment,
                    "due_date" => $due_date,
                    "payment_type" => $payment_type,
                    "client_phone" => $client_phone,
                    "total_price" => '',
                    "name" => $name,
                    "delivery_date" => '',
                    "shipping_address" => '',
                    "shipping_latitude" => '',
                    "shipping_longitude" => '',
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "added_by" => $user_id,
                    "last_updated_by" => $user_id,
                    "invoice_date" => $invoice_date,
                    "note" => $note,
                    "advance_amount" => $advance_payment
                );
                $_sales_data = array_merge(
                        array(
                    "org_id" => $sale_org_id,
                    "order_status" => !$isPurchase ? ORDER_APPROVED : ORDER_CREATED,
                    "status" => !$isPurchase ? INVOICE_ENABLE : INVOICE_DISABLE,
                    "purchaser_org_id" => $purchase_org_id,
                    "sales_invoice" => $sales_invoice_id,
                    "purchase_master_id" => '',
                    "approver_org" => $approver_sale_org_id,
                        ), $common_sale_data
                );
                $this->db->trans_start();
                $sales_insert_id = $this->user_model->insert_sales($_sales_data);
                $this->handleDBError($sales_insert_id, "Unable to add new sale entry");

                $_purchase_data = array_merge(
                        array(
                    "org_id" => $purchase_org_id,
                    "saler_org_id" => $sale_org_id,
                    "order_status" => $isPurchase ? ORDER_APPROVED : ORDER_CREATED,
                    "status" => $isPurchase ? INVOICE_ENABLE : INVOICE_DISABLE,
                    "purchase_invoice" => $purchase_invoice_id,
                    "sales_master_id" => $sales_insert_id,
                    "approver_org" => $approver_purchase_org_id,
                        ), $common_sale_data
                );
                $purchase_insert_id = $this->user_model->insert_purchase($_purchase_data);
                $this->handleDBError($purchase_insert_id, "Unable to add purchase entry");
                //$cartObj = $this->user_model->getCartItems($user_id);
                $grand_total = 0;
                foreach ($_POST['product_id'] as $key => $cart_items) {
                    $common_sale_details = array();
                    $_sales_detail_data = array();
                    $_purchase_detail_data = array();
                    $total_price = $_POST['quantity'][$key] * $_POST['price'][$key];
                    $grand_total += $total_price;
                    $common_sale_details = array(
                        "quantity" => $_POST['quantity'][$key],
                        "product_id" => $cart_items,
                        "product_price" => $_POST['price'][$key],
                        "total_price" => $total_price,
                        "item_status" => '0',
                        "added_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                        "added_by" => $user_id,
                        "last_updated_by" => $user_id
                    );
                    $_sales_detail_data = array_merge(
                            array(
                        "sales_id" => $sales_insert_id,
                            ), $common_sale_details
                    );
                    $sales_detail_id = $this->user_model
                            ->insert_sales_detail($_sales_detail_data);
                    $this->handleDBError($sales_detail_id, "Unable to add new sales entry");

                    $_purchase_detail_data = array_merge(
                            array(
                        "purchase_id" => $purchase_insert_id,
                        "sales_detail_id" => $sales_detail_id
                            ), $common_sale_details
                    );
                    $purchase_detail_id = $this->user_model
                            ->insert_purchase_detail($_purchase_detail_data);
                    $this->handleDBError($purchase_detail_id, "Unable to add new purchase entry");

                    $this->user_model->update_sales_detail(
                            $sales_detail_id, array('purchase_detail_id' => $purchase_detail_id)
                    );
                }
                $this->user_model->updateSales(
                        $sales_insert_id, array(
                    'purchase_master_id' => $purchase_insert_id,
                    'total_price' => $grand_total,
                    'dues' => $grand_total - $advance_payment
                        )
                );
                $this->user_model->updatePurchase(
                        $purchase_insert_id, array(
                    'total_price' => $grand_total,
                    'dues' => $grand_total - $advance_payment
                        )
                );
                //$this->user_model->clear_cart($user_id);
                $this->response['sales_id'] = $sales_insert_id;
                $this->response['purchase_id'] = $purchase_insert_id;
                $this->response['message'] = "Your invoice created successfully.";
                $this->response['status'] = 200;
                $this->db->trans_complete();
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function confirmSales() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('sale_id', 'Invoice  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('isApproved', 'approval  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $approve = $this->input->post('isApproved');
                $invoice_id = $this->input->post('sale_id');
                $user_id = $this->session->userdata('user_id');
                $isApproved = $approve == 1 ? true : false;
                //$isPurchase = false;
                $this->db->trans_start();
                $salesObj = $this->user_model->get_sales_value($invoice_id);
                $this->handleNullCheck($salesObj, "Invalid Sale entry");
                $purchaseObj = $this->user_model->get_purchase_value(
                        $salesObj->purchase_master_id
                );
                $this->handleNullCheck($purchaseObj, "Invalid Purchase entry");
                $_common_data = array(
                    "updated_at" => date('Y-m-d H:i:s'),
                    "last_updated_by" => $user_id
                );
                $p_status_new = $p_status = $purchaseObj->order_status;
                $s_status_new = $s_status = $salesObj->order_status;
                if ($isApproved) {
                    if ($p_status == ORDER_APPROVED && $s_status == ORDER_EDIT_APPROVAL_NOTIFY) {
                        $s_status_new = ORDER_APPROVED;
                        $this->_updatePurchase($p_status_new, $purchaseObj, $_common_data);
                        $this->_copySalesFromPurchase($s_status_new, $salesObj, $purchaseObj);
                    } else if ($p_status == ORDER_EDIT_ON_REJECT && $s_status == ORDER_REJECT_EDIT_APPROVAL_NOTIFY) {
                        $s_status_new = $p_status_new = ORDER_APPROVED;
                        $this->_updatePurchase($p_status_new, $purchaseObj, $_common_data);
                        $this->_copySalesFromPurchase($s_status_new, $salesObj, $purchaseObj);
                    } else {
                        $s_status_new = ORDER_APPROVED;
                        $p_status_new = ORDER_APPROVED;
                        $this->_updatePurchase($p_status_new, $purchaseObj, $_common_data);
                        $this->_copySalesFromPurchase($s_status_new, $salesObj, $purchaseObj);
                    }
                } else {
                    $s_status_new = ORDER_REJECTED;
                    $p_status_new = ORDER_REJECTED;
                    $this->_updateSales($s_status_new, $salesObj, $_common_data);
                    $this->_updatePurchase($p_status_new, $purchaseObj, $_common_data);
                }
                $this->response['message'] = "Your invoice updated successfully.";
                $this->response['status'] = 200;
                $this->db->trans_commit();
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function getclientbyorgid() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('org_id', 'enable status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $clients = $this->user_model->get_clients_by_org_id($this->input->post('org_id'));
                $customer_list_HTML = '<option value="">Select customer/vendor</option>';
                foreach ($clients as $list) {
                    $customer_list_HTML .= '<option value="' . $list->client_id . '">' . $list->client_name . '</option>';
                }
                $this->response['customer_list_HTML'] = $customer_list_HTML;
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function getproductdetailbyid() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $productDetailObj = $this->user_model->get_varthak_product_by_product_id($this->input->post('product_id'));

                $this->response['selling_price'] = $productDetailObj->price;
                $this->response['quantity'] = '1';
                $this->response['total_price'] = $productDetailObj->price;
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function purchase() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_PURCHASE_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Purchase';
        $this->data['privilege_module'] = '2';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $orgn_obj = $this->user_model->get_organisation_by_user_id($user_id);
        $this->data['purchase'] = $this->user_model->get_purchase_transaction_list($org_id);
        $this->load->view('purchase', $this->data);
    }

    function add_purchase() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_PURCHASE_ID, MODULE_ACCESS_TYPE_ADD);
        $this->data['page_title'] = 'Purchase';
        $this->data['page_type'] = 'Add Purchase';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['organisations'] = $this->user_model->get_all_organisation_except_logedin_user($user_id);
        $this->data['fav_contacts'] = $this->user_model->get_all_organisation_contacts(NULL, $org_id);
        $this->data['products'] = $this->user_model->get_products($org_id);
        $this->load->view('add_purchase', $this->data);
    }

    function edit_purchase($purchase_id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_PURCHASE_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Purchase';
        $this->data['page_type'] = 'Edit Purchase';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['organisations'] = $this->user_model->get_all_organisation_except_logedin_user($user_id);
        $this->data['purchase_detail'] = $this->user_model->get_purchase_value($purchase_id);
        $this->data['items'] = $this->user_model->getPurchaseDetails($purchase_id);
        $this->load->view('edit_purchase', $this->data);
    }

    function doaddpurchase() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('client_org_id', 'business id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('advance_amount', 'advance payment  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('due_date', 'due date  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('payment_type', 'payment type  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $user_id = $this->session->userdata('user_id');
                $self_org_id = $this->session->userdata('org_id');
                $client_org_id = $this->input->post('client_org_id');
                $client_detail = $this->user_model->get_organisation_default_by_value($client_org_id);

                $advance_payment = $this->input->post('advance_amount');
                $due_date = $this->input->post('due_date');
                $payment_type = $this->input->post('payment_type');
                $client_phone = $client_detail->phone;
                $invoice_date = date('Y-m-d H:i:s');
                $name = $client_detail->name;
                $note = $this->input->post('note');
                $isPurchase = true;

                $nextPurchaseId = $this->user_model->get_sequence_invoice_id($self_org_id, 'pay');
                $nextSaleId = $this->user_model->get_sequence_invoice_id($client_org_id, 'receive');
                $purchase_invoice_id = $nextPurchaseId;
                $sales_invoice_id = $nextSaleId;
                $sale_org_id = $client_org_id;
                $purchase_org_id = $self_org_id;
                $approver_sale_org_id = $client_org_id;
                $approver_purchase_org_id = null;

                $common_sale_data = array(
                    "paid" => $advance_payment,
                    "due_date" => $due_date,
                    "payment_type" => $payment_type,
                    "client_phone" => $client_phone,
                    "total_price" => '',
                    "name" => $name,
                    "delivery_date" => '',
                    "shipping_address" => '',
                    "shipping_latitude" => '',
                    "shipping_longitude" => '',
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "added_by" => $user_id,
                    "last_updated_by" => $user_id,
                    "invoice_date" => $invoice_date,
                    "note" => $note,
                    "advance_amount" => $advance_payment
                );
                $_sales_data = array_merge(
                        array(
                    "org_id" => $sale_org_id,
                    "order_status" => !$isPurchase ? ORDER_APPROVED : ORDER_CREATED,
                    "status" => !$isPurchase ? INVOICE_ENABLE : INVOICE_DISABLE,
                    "purchaser_org_id" => $purchase_org_id,
                    "sales_invoice" => $sales_invoice_id,
                    "purchase_master_id" => '',
                    "approver_org" => $approver_sale_org_id,
                        ), $common_sale_data
                );
                $this->db->trans_start();
                $sales_insert_id = $this->user_model->insert_sales($_sales_data);
                $this->handleDBError($sales_insert_id, "Unable to add new sale entry");

                $_purchase_data = array_merge(
                        array(
                    "org_id" => $purchase_org_id,
                    "saler_org_id" => $sale_org_id,
                    "order_status" => $isPurchase ? ORDER_APPROVED : ORDER_CREATED,
                    "status" => $isPurchase ? INVOICE_ENABLE : INVOICE_DISABLE,
                    "purchase_invoice" => $purchase_invoice_id,
                    "sales_master_id" => $sales_insert_id,
                    "approver_org" => $approver_purchase_org_id,
                        ), $common_sale_data
                );
                $purchase_insert_id = $this->user_model->insert_purchase($_purchase_data);
                $this->handleDBError($purchase_insert_id, "Unable to add purchase entry");
                //$cartObj = $this->user_model->getCartItems($user_id);
                $grand_total = 0;
                foreach ($_POST['product_id'] as $key => $cart_items) {
                    $common_sale_details = array();
                    $_sales_detail_data = array();
                    $_purchase_detail_data = array();
                    $total_price = $_POST['quantity'][$key] * $_POST['price'][$key];
                    $grand_total += $total_price;
                    $common_sale_details = array(
                        "quantity" => $_POST['quantity'][$key],
                        "product_id" => $cart_items,
                        "product_price" => $_POST['price'][$key],
                        "total_price" => $total_price,
                        "item_status" => '0',
                        "added_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                        "added_by" => $user_id,
                        "last_updated_by" => $user_id
                    );
                    $_sales_detail_data = array_merge(
                            array(
                        "sales_id" => $sales_insert_id,
                            ), $common_sale_details
                    );
                    $sales_detail_id = $this->user_model
                            ->insert_sales_detail($_sales_detail_data);
                    $this->handleDBError($sales_detail_id, "Unable to add new sales entry");

                    $_purchase_detail_data = array_merge(
                            array(
                        "purchase_id" => $purchase_insert_id,
                        "sales_detail_id" => $sales_detail_id
                            ), $common_sale_details
                    );
                    $purchase_detail_id = $this->user_model
                            ->insert_purchase_detail($_purchase_detail_data);
                    $this->handleDBError($purchase_detail_id, "Unable to add new purchase entry");

                    $this->user_model->update_sales_detail(
                            $sales_detail_id, array('purchase_detail_id' => $purchase_detail_id)
                    );
                }
                $this->user_model->updateSales(
                        $sales_insert_id, array(
                    'purchase_master_id' => $purchase_insert_id,
                    'total_price' => $grand_total,
                    'dues' => $grand_total - $advance_payment
                        )
                );
                $this->user_model->updatePurchase(
                        $purchase_insert_id, array(
                    'total_price' => $grand_total,
                    'dues' => $grand_total - $advance_payment
                        )
                );
                //$this->user_model->clear_cart($user_id);
                $this->response['sales_id'] = $sales_insert_id;
                $this->response['purchase_id'] = $purchase_insert_id;
                $this->response['message'] = "Your invoice created successfully.";
                $this->response['status'] = 200;
                $this->db->trans_complete();
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function confirmPurchase() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('purchase_id', 'Invoice  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('isApproved', 'approval  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $approve = $this->input->post('isApproved');
                $invoice_id = $this->input->post('purchase_id');
                $user_id = $this->session->userdata('user_id');
                $isApproved = $approve == 1 ? true : false;
                //$isPurchase = false;
                $this->db->trans_start();
                $purchaseObj = $this->user_model->get_purchase_value($invoice_id);
                $this->handleNullCheck($purchaseObj, "Invalid Purchase entry");
                $salesObj = $this->user_model->get_sales_value(
                        $purchaseObj->sales_master_id
                );
                $this->handleNullCheck($salesObj, "Invalid Sale entry");
                $_common_data = array(
                    "updated_at" => date('Y-m-d H:i:s'),
                    "last_updated_by" => $user_id
                );
                $p_status_new = $p_status = $purchaseObj->order_status;
                $s_status_new = $s_status = $salesObj->order_status;
                if ($isApproved) {
                    if ($p_status == ORDER_APPROVED && $s_status == ORDER_EDIT_APPROVAL_NOTIFY) {
                        $p_status_new = ORDER_APPROVED;
                        $this->_updateSales($s_status_new, $salesObj, $_common_data);
                        $this->_copyPurchaseFromSales($p_status_new, $purchaseObj, $salesObj);
                    } else if ($p_status == ORDER_EDIT_ON_REJECT && $s_status == ORDER_REJECT_EDIT_APPROVAL_NOTIFY) {
                        $p_status_new = $p_status_new = ORDER_APPROVED;
                        $this->_copyPurchaseFromSales($p_status_new, $purchaseObj, $salesObj);
                        $this->_updateSales($s_status_new, $salesObj, $_common_data);
                    } else {
                        $p_status_new = $s_status_new = ORDER_APPROVED;
                        $this->_copyPurchaseFromSales($p_status_new, $purchaseObj, $salesObj);
                        $this->_updateSales($s_status_new, $salesObj, $_common_data);
                    }
                } else {
                    $p_status_new = ORDER_REJECTED;
                    $s_status_new = ORDER_REJECT_ON_EDIT;
                    $this->_updatePurchase($p_status_new, $purchaseObj, $_common_data);
                    $this->_updateSales($s_status_new, $salesObj, $_common_data);
                }
                $this->response['message'] = "Your invoice updated successfully.";
                $this->response['status'] = 200;
                $this->db->trans_commit();
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function addPayment() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('invoice_id', 'Invoice id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('amount', 'amount', 'trim|required|greater_than[0]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('due_date', 'date', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('type', 'payment type', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('is_receive', 'Pay Receive Flag', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $amount = $this->input->post('amount');
                $invoice_id = $this->input->post('invoice_id');
                $user_id = $this->session->userdata('user_id');
                $type = $this->input->post('type');
                $date = $this->input->post('due_date');
                $note = $this->input->post('note');
                $is_receive = $this->input->post('is_receive');
                $isReceive = $is_receive == '1' ? true : false;
                $this->db->trans_start();
                if ($isReceive) {
                    $salesObj = $this->user_model->get_sales_value($invoice_id);
                    $this->handleNullCheck($salesObj, "Invalid Sale Entry");
                    $purchaseObj = $this->user_model->get_purchase_value($salesObj->purchase_master_id);
                    $this->handleNullCheck($purchaseObj, "Invalid Purchase Entry");
                    $from_org_id = $salesObj->org_id;
                    $to_org_id = $purchaseObj->org_id;
                } else {
                    $purchaseObj = $this->user_model->get_purchase_value($invoice_id);
                    $this->handleNullCheck($purchaseObj, "Invalid Purchase Entry");
                    $salesObj = $this->user_model->get_sales_value($purchaseObj->sales_master_id);
                    $this->handleNullCheck($salesObj, "Invalid Sale Entry");
                    $from_org_id = $purchaseObj->org_id;
                    $to_org_id = $salesObj->org_id;
                }

                $updateData = array(
                    'paid' => $salesObj->paid + $amount,
                    'dues' => $salesObj->dues - $amount
                );
                $this->handleDBError($this->user_model->updateSales(
                                $salesObj->sale_id, $updateData
                        ), "Unable to update Sales data");
                $updateData = array(
                    'paid' => $purchaseObj->paid + $amount,
                    'dues' => $purchaseObj->dues - $amount
                );
                $this->handleDBError($this->user_model->updatePurchase(
                                $purchaseObj->purchase_id, $updateData
                        ), "Unable to update Purchase data");

                $common_data = array(
                    'amount' => $amount,
                    'date' => $date,
                    'type' => $type,
                    "note" => $note,
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "added_by" => $user_id,
                    "last_updated_by" => $user_id,
                );
                $payment_data = array_merge($common_data, array(
                    'org_id' => !$isReceive ? $purchaseObj->org_id : $salesObj->org_id,
                    'to_org_id' => !$isReceive ? $salesObj->org_id : $purchaseObj->org_id,
                    "reference_id" => "PAY-" . time(),
                    'invoice_id' => $purchaseObj->purchase_id,
                    'payment_status' => !$isReceive ? PAYMENT_CREATED : PAYMENT_APPROVAL_REQUIRED,
                ));
                $insert_payment_id = $this->user_model->insertPayment($payment_data);
                $this->handleDBError($insert_payment_id, "Unable to insert payment");
                $receivable_data = array_merge($common_data, array(
                    'org_id' => $isReceive ? $salesObj->org_id : $purchaseObj->org_id,
                    'to_org_id' => $isReceive ? $purchaseObj->org_id : $salesObj->org_id,
                    "reference_id" => "REC-" . time(),
                    'invoice_id' => $salesObj->sale_id,
                    'payment_status' => $isReceive ? PAYMENT_CREATED : PAYMENT_APPROVAL_REQUIRED,
                    'payment_master_id' => $insert_payment_id
                ));
                $insert_receivable_id = $this->user_model->insertReceivable($receivable_data);
                $this->handleDBError($insert_receivable_id, "Unable to insert receivable");

                $this->handleDBError($this->user_model->updatePayment(
                                $insert_payment_id, array('receivable_master_id' => $insert_receivable_id)
                        ), "Unable to update payment data");
                $this->response['payment_id'] = $insert_payment_id;
                $this->response['receivable_id'] = $insert_receivable_id;
                $this->db->trans_commit();
                $this->response['message'] = "Payment made successfully.";
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function organisationlist() {
        $this->data['page_title'] = 'Organisation';
        $user_id = $this->session->userdata('user_id');
        $this->data['organisation'] = $this->user_model->all_organisation_by_userid($user_id);
        $this->load->view('organisation', $this->data);
    }

    function add_organisation() {
        $this->data['page_title'] = 'Organisation';
        $this->data['page_type'] = 'Add Organisation';
        $this->load->view('add_organisation', $this->data);
    }

    function doaddorganisation() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('org_name', 'Organisation name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {
                //insert organisation information
                $user_id = $this->session->userdata('user_id');
                $org_data = array(
                    'user_id' => $user_id,
                    'org_name' => $this->input->post('org_name'),
                    'added_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $org_insert_id = $this->user_model->insert_organisation($org_data);
                $_data = array(
                    "org_id" => $org_insert_id,
                    "user_id" => $user_id,
                    "username" => '',
                    "role_id" => '1',
                    "added_by" => $user_id,
                    "last_updated_by" => $user_id,
                    "status" => '1',
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $this->user_model->insertOrgUser($_data);
                
                $company_code = $org_insert_id . $this->all_function->randomNumber(10 - strlen($org_insert_id));
                $this->user_model->resetDefaultOrganisation($user_id, array('default_organisation' => '0'));
                $this->user_model->updateOrganisation($org_insert_id, $user_id, array('company_code' => $company_code));
                $this->user_model->setDefaultOrganisationUser($user_id, array('default_organisation' => '1'));
                //Default Setting for Varthak information
                    //CMS Done
                    $global_cms_list = $this->user_model->get_cms_global();
                    $global_cms_arr = array();
                    foreach ($global_cms_list as $list) {
                        $global_cms_arr[] = array('org_id' => $org_insert_id, 'page_name' => $list->page_name, 'section' => $list->section, 'type' => $list->type, 'cms_data' => $list->cms_data);
                    }
                    $this->user_model->insert_cms_mgm_batch($global_cms_arr);
                    //End CMS
                    // Role Done
                    $global_permission_list = $this->user_model->get_permission_global();
                    $global_permission_arr = array();
                    foreach ($global_permission_list as $list) {
                        $global_permission_arr[] = array('org_id' => $org_insert_id, 'role_id' => $list->role_id, 'module_id' => $list->module_id, 'view_status' => $list->view_status, 'add_status' => $list->add_status, 'edit_status' => $list->edit_status, 'delete_status' => $list->delete_status);
                    }
                    $this->user_model->insert_permission_batch($global_permission_arr);
                    // End Role
                    // Default Setting for Varthak information
                $this->response['message'] = 'organisation added successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function reset0rganisation() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('org_id', 'Organisation name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                //insert organisation information
                $user_id = $this->session->userdata('user_id');

                $this->user_model->resetDefaultOrganisation($user_id, array('default_organisation' => '0'));
                $this->user_model->updateOrganisationUser($this->input->post('org_id'), $user_id, array('default_organisation' => '1'));
                //$this->user_model->updateUser($user_id, array('org_id' => $this->input->post('org_id')));
                $this->session->set_userdata('org_id', $this->input->post('org_id'));
                $organisationObj = $this->user_model->get_organisation_by_value($this->input->post('org_id'));
                $this->session->set_userdata('company_code', $organisationObj->company_code);
                $this->response['message'] = 'organisation added successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function products() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_PRODUCT_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Products';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['products'] = $this->user_model->get_products($org_id);
        //print_r($this->data['products']);exit;
        $this->load->view('products', $this->data);
    }

    function add_product() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_PRODUCT_ID, MODULE_ACCESS_TYPE_ADD);
        $this->data['page_title'] = 'Add Products';
        $this->data['page_type'] = 'Add Products';
        $this->data['category'] = $this->user_model->get_varthak_subcategory();
        //print_r($this->data['category']);exit;
        $this->data['varthak_products'] = $this->user_model->get_varthak_product();
        $this->load->view('add_product', $this->data);
    }

    function products_topitem_status_update() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('enable_status', 'enable status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "is_topitem" => $this->input->post('enable_status'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $cid_arr = explode('topitem_', $this->input->post('product_id'));
                $cid = $cid_arr[1];
                $this->user_model->updateProduct($cid, $_data);
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function products_hotitem_status_update() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('enable_status', 'enable status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "is_hotoffer" => $this->input->post('enable_status'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $cid_arr = explode('hotitem_', $this->input->post('product_id'));
                $cid = $cid_arr[1];
                $this->user_model->updateProduct($cid, $_data);
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function products_popular_status_update() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('enable_status', 'enable status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "is_popular" => $this->input->post('enable_status'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $cid_arr = explode('popular_', $this->input->post('product_id'));
                $cid = $cid_arr[1];
                $this->user_model->updateProduct($cid, $_data);
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function searchproductbycategoryid() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $searchQuery['subcategory_id'] = $this->input->post('id');
                $varthak_products = $this->user_model->get_varthak_product('', '', $searchQuery);
                $html = '';
                foreach ($varthak_products['result'] as $list) {
                    $html .= '<div class="sc-fePcYi jszvzQ">
                              <div class="sc-ePYyfT bqXZKj">
                                  <label class="sc-XhUPp kiNLFp">
                                      <input type="checkbox" name="product_id[]" value="' . $list->product_id . '" class="sc-ikPAkQ ceimHt">
                                      
                                  </label>
                                  <img src="' . base_url() . 'uploads/varthak_product/' . $list->image_name . '" alt="' . $list->item_name . '" class="sc-iyjaVZ hNreIX">
                                  <div class="sc-iMZFOo cBfRCw">
                                      ' . $list->item_name . '
                                  </div>
                                      
                              </div>
                              <p class="sc-hFNyKf eKdlPh">₹' . $list->selling_price . '</p>
                          </div>';
                }
                $this->response['message'] = $html;

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function doaddmasterproduct() {
        if ($this->input->is_ajax_request()) {
            $product_ids = $this->input->post('product_id');
            $org_id = $this->session->userdata('org_id');
            foreach ($product_ids as $product_id) {
                //print_r($list);exit;
                $masterproductObj = $this->user_model->get_varthak_product_value($product_id);
                $master_category_name = $masterproductObj->category_name;
                $master_categoryObj = $this->user_model->get_parent_category_id_by_name($master_category_name);
                if (isset($master_categoryObj->product_category_id)) {
                    $parent_id = $master_categoryObj->product_category_id;
                } else {
                    $parent_id = $this->user_model->insert_category(array('category_name' => $master_category_name));
                }
                $master_sub_category_name = $masterproductObj->sub_category_name;
                $master_sub_categoryObj = $this->user_model->get_sub_category_id_by_name($parent_id, $master_sub_category_name);
                //print_r($master_sub_categoryObj);exit;
                if (isset($master_sub_categoryObj->product_category_id)) {
                    $product_category_id = $master_sub_categoryObj->product_category_id;
                } else {
                    $product_category_id = $this->user_model->insert_category(array('org_id' => $org_id, 'category_name' => $master_sub_category_name, 'parent_id' => $parent_id, 'thumbnail' => 'tomatonaturalgourmetvegetables_63702921.png'));
                }
                //exit;
                $org_id = $this->session->userdata('org_id');
                $_data = array(
                    "org_id" => $org_id,
                    "category_id" => $product_category_id,
                    "product_name" => $masterproductObj->item_name,
                    "product_description" => $masterproductObj->search_name,
                    "small_note" => $masterproductObj->search_name,
                    "price" => $masterproductObj->selling_price,
                    "gst_percentage" => $masterproductObj->gst_percentage,
                    "discount_percentage" => 0,
                    "quantity_val" => $masterproductObj->quantity,
                    "quantity_unit" => $masterproductObj->unit,
                    "product_image" => $masterproductObj->image_name,
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "status" => '1',
                );

                $this->user_model->insert_product($_data);
                //$this->response['message'] = 'product added successfully.'
            }


            $this->response['status'] = 200;
        }
        echo json_encode($this->response);
        exit();
    }

    function edit_product($id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_PRODUCT_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Products';
        $this->data['page_type'] = 'Edit Products';
        $this->data['model'] = $this->user_model->get_product_value($id);
        $this->data['category'] = $this->user_model->get_category();
        if (empty($this->data['model'])) {
            redirect('useraccount/products');
        }
        $this->load->view('edit_product', $this->data);
    }

    function doaddproduct() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('category_id', 'category id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('product_name', 'product name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('product_description', 'product_description ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('small_note', 'small note ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('price', 'price ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('quantity_val', 'quantity val ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "category_id" => $this->input->post('category_id'),
                    "product_name" => $this->input->post('product_name'),
                    "product_description" => $this->input->post('product_description'),
                    "small_note" => $this->input->post('small_note'),
                    "price" => $this->input->post('price'),
                    "discount_percentage" => $this->input->post('discount_percentage'),
                    "quantity_val" => $this->input->post('quantity_val'),
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "status" => '1',
                );
                if (!empty($cid)) {
                    $this->user_model->updateProduct($cid, $_data);
                    $this->response['message'] = " updated successfully.";
                } else {
                    //$_data['user_id'] = $this->session->userdata('user_id');
                    $this->user_model->insert_product($_data);
                    $this->response['message'] = 'product added successfully.';
                }

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function getLatLong($address) {
        if (!empty($address)) {
//Formatted address
            $formattedAddr = str_replace(' ', '+', $address);
//Send request and receive json data by address 
            $geocodeFromAddr = file_get_contents
                    ('https://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=false' . '&key=' . GOGGLE_MAP_KEY);
            $output = json_decode($geocodeFromAddr);
//Get latitude and longitute from json data
            $data['latitude'] = $output->results[0]->geometry->location->lat;
            $data['longitude'] = $output->results[0]->geometry->location->lng;
//Return latitude and longitude of the given address
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    function get_staff() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_STAFF_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Staff';
        $this->data['page_type'] = 'Staff List';
        $user_id = $this->session->userdata('user_id');
        $org_id = $this->session->userdata('org_id');
        $this->data['staffs'] = $this->user_model->get_staffs($org_id, $user_id);
        $this->load->view('staffs', $this->data);
    }

    function add_staff() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_STAFF_ID, MODULE_ACCESS_TYPE_ADD);
        $this->data['page_title'] = 'Staff';
        $this->data['page_type'] = 'Add Staff';
        $this->data['roles'] = $this->user_model->rolesList();
        $this->load->view('edit_staff', $this->data);
    }

    function edit_staff($staff_id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_STAFF_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Staff';
        $this->data['page_type'] = 'Edit Staff';
        $this->data['roles'] = $this->user_model->rolesList();
        $this->data['model'] = $this->user_model->get_staff_value($staff_id);
        $this->load->view('edit_staff', $this->data);
    }

    function doaddstaff() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('role_id', 'role id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('username', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('email_id', 'email id ', 'trim|required|valid_email|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('phone', 'phone ', 'trim|required|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {

                if ($cid != '') {
                    $this->response['message'] = array('phone' => 'Staff add new in your organisation or update phone number by staff.');
                    $this->response['status'] = 500;
                } else {
                    $staffDetails = $this->user_model->get_phone_value($this->input->post('phone'));
                    if (empty($staffDetails)) {
                        //insert in user master, organisation master and  organisation user

                        $user_data = array(
                            'phone' => $this->input->post('phone'),
                            'name' => $this->input->post('username'),
                            'email' => $this->input->post('email_id'),
                            'business_nature' => 'Personal',
                            'status' => '1',
                            'added_at' => date('Y-m-d H:i:s'),
                            'subscription_date' => date('Y-m-d'),
                            'expired_date' => date('Y-m-d', strtotime("+30 days")),
                        );
                        $insert_id = $this->user_model->insert_user($user_data);

                        //insert organisation information
                        $org_data = array(
                            'user_id' => $insert_id,
                            //'company_code' => $company_code,
                            'added_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $org_insert_id = $this->user_model->insert_organisation($org_data);
                        $company_code = $org_insert_id . $this->all_function->randomNumber(10 - strlen($org_insert_id));
                        $sub_domain = $this->input->post('username') . 'Per' . $insert_id;

                        $this->user_model->updateUser($insert_id, array('company_code' => $company_code, 'org_id' => $org_insert_id, 'sub_domain' => $sub_domain));
                        $this->user_model->updateOrganisation($org_insert_id, $insert_id, array('company_code' => $company_code, 'org_name' => $company_code));
                        //Default Setting for Varthak information
                        //CMS Done
                        $global_cms_list = $this->user_model->get_cms_global();
                        $global_cms_arr = array();
                        foreach ($global_cms_list as $list) {
                            $global_cms_arr[] = array('org_id' => $org_insert_id, 'page_name' => $list->page_name, 'section' => $list->section, 'type' => $list->type, 'cms_data' => $list->cms_data);
                        }
                        $this->user_model->insert_cms_mgm_batch($global_cms_arr);
                        //End CMS
                        // Role Done
                        $global_permission_list = $this->user_model->get_permission_global();
                        $global_permission_arr = array();
                        foreach ($global_permission_list as $list) {
                            $global_permission_arr[] = array('org_id' => $org_insert_id, 'role_id' => $list->role_id, 'module_id' => $list->module_id, 'view_status' => $list->view_status, 'add_status' => $list->add_status, 'edit_status' => $list->edit_status, 'delete_status' => $list->delete_status);
                        }
                        $this->user_model->insert_permission_batch($global_permission_arr);

                        // End Role
                        //END Global
                        //add only in new organisation
                        $_data = array(
                            "org_id" => $org_insert_id,
                            "user_id" => $insert_id,
                            "username" => $this->input->post('username'),
                            "role_id" => '1',
                            "added_by" => $this->session->userdata('user_id'),
                            "last_updated_by" => $this->session->userdata('user_id'),
                            "status" => '2',
                            "added_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        );
                        $this->user_model->insertOrgUser($_data);

                        //add also in existing organisation
                        $_data = array(
                            "org_id" => $this->session->userdata('org_id'),
                            "user_id" => $insert_id,
                            "username" => $this->input->post('username'),
                            "role_id" => $this->input->post('role_id'),
                            "added_by" => $this->session->userdata('user_id'),
                            "last_updated_by" => $this->session->userdata('user_id'),
                            "status" => '1',
                            "added_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        );
                        $this->user_model->insertOrgUser($_data);


                        $this->response['message'] = 'staff added successfully.';

                        $this->response['status'] = 200;
                    } else {
                        $user_id = $staffDetails->id;
                        $org_id = $this->session->userdata('org_id');
                        $staffOrgObj = $this->user_model->get_organisation_user($org_id, $user_id);
                        if (empty($staffOrgObj)) {
                            //add only in organisation
                            $_data = array(
                                "org_id" => $org_id,
                                "user_id" => $user_id,
                                "username" => $this->input->post('username'),
                                "role_id" => $this->input->post('role_id'),
                                "added_by" => $this->session->userdata('user_id'),
                                "last_updated_by" => $this->session->userdata('user_id'),
                                "status" => '1',
                                "added_at" => date('Y-m-d H:i:s'),
                                "updated_at" => date('Y-m-d H:i:s'),
                            );
                            $this->user_model->insertOrgUser($_data);
                            $this->response['message'] = 'staff added successfully.';
                            $this->response['status'] = 200;
                        } else {
                            $this->response['message'] = array('phone' => 'Staff already added in your organisation.');
                            $this->response['status'] = 500;
                        }
                    }
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function roles() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_ROLEPERMISSION_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Roles';
        $this->data['page_type'] = 'Roles List';
        $this->data['roles'] = $this->user_model->get_roles();
        $this->load->view('roles', $this->data);
    }

    function role_permission($role_id = '') {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_ROLEPERMISSION_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Assign Permission';
        $this->data['page_type'] = 'Roles';
        $this->data['role_id'] = $role_id;
        $org_id = $this->session->userdata('org_id');
        $this->data['privilege_module'] = $this->user_model->privilege_module();
        //$this->data['assign_permission'] = $this->user_model->assign_permission($org_id,$role_id);
        $this->load->view('role_permission', $this->data);
    }

    function doaddpermission() {
        if ($this->input->is_ajax_request()) {
            $module_id_arr = $_POST['module_id'];
            $role_id = $this->input->post('role_id');
            $org_id = $this->session->userdata('org_id');
            if (count($module_id_arr)) {
                $this->user_model->deleteAssignPermission($org_id, $role_id);
                foreach ($module_id_arr as $module_id) {
                    $view_status = (isset($_POST['module_view'][$module_id]) && $_POST['module_view'][$module_id] == 1) ? '1' : '0';
                    $add_status = (isset($_POST['module_add'][$module_id]) && $_POST['module_add'][$module_id] == 1) ? '1' : '0';
                    $edit_status = (isset($_POST['module_edit'][$module_id]) && $_POST['module_edit'][$module_id] == 1) ? '1' : '0';
                    $delete_status = (isset($_POST['module_delete'][$module_id]) && $_POST['module_delete'][$module_id] == 1) ? '1' : '0';
                    $_data = array(
                        "org_id" => $org_id,
                        "role_id" => $role_id,
                        "module_id" => $module_id,
                        "view_status" => $view_status,
                        "add_status" => $add_status,
                        "edit_status" => $edit_status,
                        "delete_status" => $delete_status,
                    );
                    $this->user_model->insert_assign_permission($_data);
                }
            }




            $this->response['message'] = 'permission added successfully.';

            $this->response['status'] = 200;
        }
        echo json_encode($this->response);
        exit();
    }

    function order_mgm() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_ORDERMANAGEMENT_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Order';
        $org_id = $this->session->userdata('org_id');
        $searchQuery = array();
        $likeQuery = '';
        $this->data['filterOrderStatus'] = $filterOrderStatus = $this->input->get('filterOrderStatus');
        $this->data['filterClientName'] = $filterClientName = $this->input->get('filterClientName');

        if ($filterOrderStatus != 'All') {
            if ($filterOrderStatus == 'New') {
                $searchQuery['order_status'] = '1';
            } elseif ($filterOrderStatus == 'Confirmed') {
                $searchQuery['order_status'] = '2';
            } elseif ($filterOrderStatus == 'Delivered') {
                $searchQuery['order_status'] = '3';
            } elseif ($filterOrderStatus == 'Cancel') {
                $searchQuery['order_status'] = '3';
            }
        }

        if ($filterClientName != '') {
            $likeQuery = $filterClientName;
        }
        $this->data['cms'] = $this->user_model->get_orders($org_id, '', '', $searchQuery, '', '', $likeQuery);
        //exit('1');
        $this->load->view('orders', $this->data);
    }

    function edit_order($id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_ORDERMANAGEMENT_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Order';
        $this->data['page_type'] = 'Edit Order';
        $this->data['model'] = $this->user_model->get_order_value($id);
        $this->data['order_detail'] = $this->user_model->get_order_details($id);
        if (empty($this->data['model'])) {
            redirect('useraccount/orders');
        }
        $this->load->view('add_order', $this->data);
    }

    function doaddorder() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_status', 'status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            //$this->form_validation->set_rules('delivery_date', 'delivery date ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $order_status = $this->input->post('order_status');
                $client_id = $this->input->post('client_id');
                $cid = $this->input->post('cid');
                $date = $this->input->post('delivery_date');
                if ($order_status == '2') {
                    $orderObj = $this->user_model->get_order_value($cid);
                    $_data = array(
                        "org_id" => $orderObj->org_id,
                        "client_id" => $orderObj->client_id,
                        "date" => $date,
                        "added_at" => date('Y-m-d H:i:s')
                    );
                    $this->user_model->insert_deliveries($_data);
                    $_order_data = array(
                        "order_status" => '2',
                        "delivery_date" => $date,
                        "updated_at" => date('Y-m-d H:i:s')
                    );
                    $this->user_model->updateOrder($cid, $_order_data);
                } elseif ($order_status == '4') {
                    $_order_data = array(
                        "order_status" => '4',
                        "updated_at" => date('Y-m-d H:i:s')
                    );
                    $this->user_model->updateOrder($cid, $_order_data);
                }
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function cms_mgm() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_CMSMANAGEMENT_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'CMS';
        $org_id = $this->session->userdata('org_id');
        $this->data['cms'] = $this->user_model->get_cms($org_id);
        $this->load->view('cms', $this->data);
    }

    function edit_cms($id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_CMSMANAGEMENT_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'CMS';
        $this->data['page_type'] = 'Edit CMS';
        $this->data['model'] = $this->user_model->get_cms_value($id);
        if (empty($this->data['model'])) {
            redirect('useraccount/cms');
        }
        $this->load->view('add_cms', $this->data);
    }

    function doaddcms() {
        if ($this->input->is_ajax_request()) {
            $cid = $this->input->post('cid') ?? '';
            $_data = array(
                "cms_data" => $this->input->post('cms_data'),
            );
            $this->user_model->updateCms($cid, $_data);

            //blog image
            if (isset($_FILES['banner']['name']) && ($_FILES['banner']['name'] != '')) {
                if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                    $error = 'This file have some problem.';
                } else {
                    $allowed = array('png', 'jpg', 'gif', 'jpeg');
                    $extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extension), $allowed)) {
                        $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                    } else {
                        $filename = 'banner_' . rand(10, 500) . time() . '.' . $extension;

                        $config1 = array(
                            'upload_path' => "./uploads/banners/original/",
                            'allowed_types' => "gif|jpg|png|jpeg|pdf",
                            'overwrite' => TRUE,
                            'file_name' => $filename,
                        );
                        $this->load->library('upload', $config1);
                        $this->upload->initialize($config1);
                        $this->upload->do_upload('banner');
                    }
                }
                $cms_data = array(
                    'cms_data' => $filename,
                );
                $this->user_model->updateCms($cid, $cms_data);
            }
            $this->response['message'] = " updated successfully.";

            $this->response['status'] = 200;
        }
        echo json_encode($this->response);
        exit();
    }

    function blogs() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_VIEW);
        $this->data['page_title'] = 'Blogs';
        $org_id = $this->session->userdata('org_id');
        $user_id = $this->session->userdata('user_id');
        $this->data['blogs'] = $this->user_model->get_blogs($org_id);
        $this->load->view('blogs', $this->data);
    }

    function add_blogs() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_ADD);
        $this->data['page_title'] = 'Blogs';
        $this->data['page_type'] = 'Add Blogs';
        $this->data['tags'] = $this->user_model->get_tags();
        $this->load->view('add_blogs', $this->data);
    }

    function edit_blogs($id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Blogs';
        $this->data['page_type'] = 'Edit Blogs';
        $this->data['model'] = $this->user_model->get_blog_value($id);
        $this->data['tags'] = $this->user_model->get_tags();
        if (empty($this->data['model'])) {
            redirect('useraccount/blogs');
        }
        $this->load->view('add_blogs', $this->data);
    }

    function doaddblogs() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('tag_name', 'tag name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('title', 'product name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('description', 'product_description ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('added_by', 'small note ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {
                $tag_obj = $this->user_model->get_tag_value($this->input->post('tag_name'));
                if (is_object($tag_obj)) {
                    $tag_id = $tag_obj->tag_id;
                } else {
                    // insert new tag
                    $_tag_data = array(
                        "tag_name" => $this->input->post('tag_name'),
                        "org_id" => $this->session->userdata('org_id')
                    );
                    $tag_id = $this->user_model->insert_blog_tag($_tag_data);
                }
                $_data = array(
                    "tag_id" => $tag_id,
                    "title" => $this->input->post('title'),
                    "description" => $this->input->post('description'),
                    "added_by" => $this->input->post('added_by'),
                    "added_date" => date('Y-m-d H:i:s'),
                    "org_id" => $this->session->userdata('org_id')
                );

                if (isset($_FILES['added_by_img']['name']) && ($_FILES['added_by_img']['name'] != '')) {

                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['added_by_img']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $added_by_img = 'added_by_img_' . rand(10, 500) . time() . '.' . $extension;

                            $config = array(
                                'upload_path' => "./uploads/blogs/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $added_by_img,
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('added_by_img')) {
                                $error = array('error' => $this->upload->display_errors());
                                //print_r($error);exit;
                            }
                        }
                    }
                }
                //blog image
                if (isset($_FILES['thumbnail']['name']) && ($_FILES['thumbnail']['name'] != '')) {
                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $blog_img = 'blog_pic_' . rand(10, 500) . time() . '.' . $extension;

                            $config1 = array(
                                'upload_path' => "./uploads/blogs/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $blog_img,
                            );
                            $this->load->library('upload', $config1);
                            $this->upload->initialize($config1);
                            $this->upload->do_upload('thumbnail');
                        }
                    }
                }
                if (isset($added_by_img)) {
                    $_data['added_by_img'] = $added_by_img;
                }
                if (isset($blog_img)) {
                    $_data['thumbnail'] = $blog_img;
                }
                if (!empty($cid)) {
                    $this->user_model->updateBlog($cid, $_data);
                    $this->response['message'] = " updated successfully.";
                } else {
                    //$_data['user_id'] = $this->session->userdata('user_id');
                    $this->user_model->insert_blog($_data);
                    $this->response['message'] = 'blog added successfully.';
                }

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    

    function subscriptions() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Subscription Management';
        $user_id = $this->session->userdata('user_id');
        $this->data['user_detail'] = $user_detail = $this->user_model->get_user_value($user_id);
        $this->data['user_exist_plan'] = $this->user_model->get_pricing_plans_by_id($user_detail->plan_id);
        $this->load->view('subscriptions', $this->data);
    }

    function update_subscriptions() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_EDIT);
        $user_id = $this->session->userdata('user_id');
        $expired_date = date('Y-m-d', strtotime("+30 days"));
        $this->user_model->updateUser($user_id, array('plan_id' => 2, 'expired_date' => $expired_date, 'subscription_date' => date('Y-m-d')));
        redirect('useraccount/subscriptions');
    }

    function warehouse() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Warehouse';
        $org_id = $this->session->userdata('org_id');
        $this->data['clients'] = $this->user_model->get_warehouse($org_id);
        $this->load->view('warehouse', $this->data);
    }

    function add_warehouse() {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Warehouse';
        $this->data['page_type'] = 'Add Warehouse';
        $this->load->view('add_warehouse', $this->data);
    }

    function edit_warehouse($id) {
        $this->data['access_level'] = $this->isPermissionModuleAccess(MODULE_BLOGS_ID, MODULE_ACCESS_TYPE_EDIT);
        $this->data['page_title'] = 'Warehouse';
        $this->data['page_type'] = 'Edit Warehouse';
        $this->data['model'] = $this->user_model->get_warehouse_value($id);
        if (empty($data['model'])) {
            redirect('useraccount/warehouse');
        }
        $this->load->view('add_warehouse', $this->data);
    }

    function doaddwarehouse() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('warehouse_name', 'warehouse name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('warehouse_address', 'warehouse address ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('warehouse_lat', 'warehouse geo location ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('warehouse_long', 'warehouse geo location ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "warehouse_name" => $this->input->post('warehouse_name'),
                    "warehouse_address" => $this->input->post('warehouse_address'),
                    "warehouse_lat" => $this->input->post('warehouse_lat'),
                    "warehouse_long" => $this->input->post('warehouse_long'),
                    "added_at" => date('Y-m-d H:i:s')
                );
                if (!empty($cid)) {
                    $this->user_model->updateWarehouse($cid, $_data);
                    $this->response['message'] = " updated successfully.";
                } else {
                    $_data['org_id'] = $this->session->userdata('org_id');
                    $this->user_model->insert_warehouse($_data);
                    $this->response['message'] = 'warehouse added successfully.';
                }

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function deliverieswarehouseallocation() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('assigned_route_warehouse', 'assigned route  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('warehouse', 'warehouse  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $org_id = $this->session->userdata('org_id');
                $assigned_route = $this->input->post('assigned_route_warehouse');
                $warehouse = $this->input->post('warehouse');
                $trip_date_arr = explode('/', $this->input->post('trip_date'));
                $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
                $client_deliveries_allocation = $this->user_model->get_client_deliveries_assigned_by_route($org_id, $trip_date, $assigned_route);
                foreach ($client_deliveries_allocation['result'] as $list) {
                    $this->user_model->updatedeliveries($list->deliveries_id, array('warehouse_id' => $warehouse));
                }

                $this->response['route_driver'] = array('route_id' => $assigned_route);
                $this->response['message'] = 'warehouse assigned successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function updatewarehousereturn() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('trip_date', 'trip date  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('route_id', 'route id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $trip_date_arr = explode('/', $this->input->post('trip_date'));
                $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
                $route_id = $this->input->post('route_id');
                $returnResult = $this->user_model->get_deliveries_detail_for_return_warehouse($trip_date, $route_id);
                if (count($returnResult) > 0) {
                    $is_return_warehouse = $returnResult[0]->is_return_warehouse;
                    if ($is_return_warehouse == '0') {
                        $updateData['is_return_warehouse'] = '1';
                    } else {
                        $updateData['is_return_warehouse'] = '0';
                    }
                    $this->user_model->updateWarehouseReturn($trip_date, $route_id, $updateData);
                }
                $this->response['message'] = 'deliveries added successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function doaddroute() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('route_name', 'route name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                if ($this->user_model->is_route_client_added($this->session->userdata('org_id'), $this->input->post('route_name'))) {
                    $_data = array(
                        "org_id" => $this->session->userdata('org_id'),
                        "route_name" => $this->input->post('route_name'),
                        "added_at" => date('Y-m-d H:i:s'),
                    );
                    $inserted_id = $this->user_model->insert_route($_data);
                    $this->response['route_list'] = array('route_id' => $inserted_id, 'route_name' => $this->input->post('route_name'));
                    $this->response['message'] = 'route added successfully.';
                    $this->response['status'] = 200;
                } else {
                    $this->response['message'] = array('route_name' => 'Route name already exist, please choose other name.');
                    $this->response['status'] = 500;
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function assigndeleiveriesroute() {
        foreach ($_POST['deliveries_master'] as $deliveries_id => $route_id) {
            $_updatedata = array(
                "route_id" => $route_id,
                'is_assigned' => '1'
            );
            $this->user_model->updatedeliveries($deliveries_id, $_updatedata);
        }
        $this->data['action_url'] = base_url('useraccount/trips');
        $this->data['trip_date'] = $this->input->post('trip_date');
        $this->load->view('assigndeleiveriesroute', $this->data);
    }
    
    function deleteroutedeliveries() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $org_id = $this->session->userdata('org_id');
                $deliveries_id = $this->input->post('id');
                $this->user_model->deleteDeliveries($org_id, $deliveries_id);

                $this->response['message'] = 'driver deleted successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function deleteroute() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $org_id = $this->session->userdata('org_id');
                $route_id = $this->input->post('id');
                $this->user_model->deleteRoute($org_id, $route_id);

                $this->response['message'] = 'route deleted successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function show_route_map_by_routeid() {
        $data = [];
        $deleveries_ids = json_decode($this->input->post('deleveries_ids'));
        $routes = array();
        $gid = 1;
        $j = 1;
        $is_return = false;
        foreach ($deleveries_ids as $id) {
            $deleveriesObj = $this->user_model->get_delivery_order_by_deleveries_id($id);
            if ($deleveriesObj->type == 0) {
                $location_address = $deleveriesObj->client_address;
                $latitude = $deleveriesObj->client_latitude;
                $longitude = $deleveriesObj->client_longitude;
            } else {
                $location_address = $deleveriesObj->address;
                $latitude = $deleveriesObj->customer_lat;
                $longitude = $deleveriesObj->customer_long;
            }
            if ($deleveriesObj->warehouse_id != 0 && $j == 1) {
                $warehouseObj = $warehouseReturnObj = $this->user_model->get_warehouse_value($deleveriesObj->warehouse_id);
                $routes[] = array("gid" => "$gid",
                    "address" => "Warehouse : " . $warehouseObj->warehouse_address,
                    "latitude" => $warehouseObj->warehouse_lat,
                    "longitude" => $warehouseObj->warehouse_long);
                $gid++;
            }
            if ($deleveriesObj->is_return_warehouse != 0 && $j == 1) {
                $is_return = true;
            }
            $routes[] = array("gid" => "$gid",
                "address" => $location_address,
                "latitude" => $latitude,
                "longitude" => $longitude);
            $gid++;
            $j++;
        }
        if ($is_return) {
            $routes[] = array("gid" => "$gid",
                "address" => "Warehouse : " . $warehouseReturnObj->warehouse_address,
                "latitude" => $warehouseReturnObj->warehouse_lat,
                "longitude" => $warehouseReturnObj->warehouse_long);
        }
        $data['routes'] = $routes;
        echo json_encode($data);
        exit();
    }
    
    function show_route_map_by_deliveries() {
        $data = [];
        $deleveries_id = $this->input->post('deleveries_id');
        $routes = array();
        $deleveriesObj = $this->user_model->get_delivery_order_by_deleveries_id($deleveries_id);
        if ($deleveriesObj->type == 0) {
            $location_address = $deleveriesObj->client_address;
            $latitude = $deleveriesObj->client_latitude;
            $longitude = $deleveriesObj->client_longitude;
        } else {
            $location_address = $deleveriesObj->address;
            $latitude = $deleveriesObj->customer_lat;
            $longitude = $deleveriesObj->customer_long;
        }
        $routes[] = array("gid" => "1",
            "address" => $location_address,
            "latitude" => $latitude,
            "longitude" => $longitude);

        $data['routes'] = $routes;
        echo json_encode($data);
        exit();
    }
    
    function show_route_map_for_livetracking() {
        $data = [];
        $assigned_trip_id = $this->input->post('route_id');
        $deleveries_ids = $this->user_model->get_trip_client_by_assigned_trip_id($assigned_trip_id);
        $deleveries_total = $this->user_model->get_trip_client_by_assigned_trip_id_total($assigned_trip_id);
        $trip_details = $this->user_model->get_trip_detail_by_assigned_trip_id($assigned_trip_id);
        $routes = array();
        $gid = 1;
        $j = 1;
        if ($trip_details->is_return_warehouse == '1') {
            $progress_bar_percentage = (int) (100 / ($deleveries_total + 2));
        } else {
            $progress_bar_percentage = (int) (100 / ($deleveries_total + 1));
        }

        $progres_li_text = '';
        $progres_lower_text = '<li style="width: ' . $progress_bar_percentage . '%;"><span>Warehouse</span></li>';
        $progres_lower_text .= '<li style="width: ' . $progress_bar_percentage . '%;"><span>Start</span></li>';
        if ($trip_details->is_trip_started == '1') {
            $progres_li_text .= '<li class="completed" style="width: ' . $progress_bar_percentage . '%;"><span class="completed"></span></li>';
        } else {
            $progres_li_text .= '<li class="inprogress" style="width: ' . $progress_bar_percentage . '%;"><span class="inprogress"></span></li>';
        }
        foreach ($deleveries_ids as $list) {
            $deleveriesObj = $this->user_model->get_driver_trip_clients_by_driver_trip_clients_id($list->driver_trip_clients_id);
            if ($deleveriesObj->type == 0) {
                $company_name = $deleveriesObj->company_name;
                $client_mobile = $deleveriesObj->client_mobile;
                $location_address = $deleveriesObj->client_address;
                $latitude = $deleveriesObj->client_latitude;
                $longitude = $deleveriesObj->client_longitude;
            } else {
                $company_name = $deleveriesObj->customer_name;
                $client_mobile = $deleveriesObj->mobile_number;
                $location_address = $deleveriesObj->address;
                $latitude = $deleveriesObj->customer_lat;
                $longitude = $deleveriesObj->customer_long;
            }
            if ($deleveriesObj->trip_status == '1') {
                $progres_li_text .= '<li class="completed" style="width: ' . $progress_bar_percentage . '%;"><span class="completed"></span></li>';
            } else {
                $progres_li_text .= '<li class="inprogress" style="width: ' . $progress_bar_percentage . '%;"><span class="inprogress"></span></li>';
            }
            if ($trip_details->is_return_warehouse == '0') {
                if (count($deleveries_ids) == $j) {
                    $progres_lower_text .= '<li style="margin-left: -77px;width: 69px;"><span>Loc ' . $j . ' End</span></li>';
                } else {
                    $progres_lower_text .= '<li style="width: ' . $progress_bar_percentage . '%;"><span>Loc ' . $j . ' End</span></li>';
                }
            } else {
                $progres_lower_text .= '<li style="width: ' . $progress_bar_percentage . '%;"><span>Loc ' . $j . ' End</span></li>';
            }


            if ($trip_details->warehouse_id != 0 && $j == 1) {
                $warehouseObj = $this->user_model->get_warehouse_value($trip_details->warehouse_id);
                $routes[] = array("gid" => "$gid",
                    "company_number" => '0',
                    "company_name" => '',
                    "client_mobile" => '',
                    "distance" => 0.00,
                    "address" => "Warehouse : " . $warehouseObj->warehouse_address,
                    "amount" => 0.00,
                    "total_time" => '',
                    "latitude" => $warehouseObj->warehouse_lat,
                    "longitude" => $warehouseObj->warehouse_long);
                $gid++;
            }
            $routes[] = array("gid" => "$gid",
                "company_number" => $j,
                "company_name" => $company_name,
                "client_mobile" => $client_mobile,
                "distance" => number_format((float) $deleveriesObj->distance, 2, '.', ''),
                "address" => $location_address,
                "amount" => (number_format((float) $deleveriesObj->distance, 2, '.', '') * 2) . '',
                "total_time" => intdiv($deleveriesObj->total_time, 60) . 'hrs ' . ($deleveriesObj->total_time % 60) . ' min',
                "latitude" => $latitude,
                "longitude" => $longitude);
            $gid++;
            $j++;
        }
        if ($trip_details->is_trip_completed == '1') {
            if ($trip_details->is_return_warehouse == '1') {
                $progres_li_text .= '<li class="completed" style="width: ' . $progress_bar_percentage . '%;"><span class="completed"></span></li>';
            } else {
                $progres_li_text .= '<li class="completed" style="width: 0%;"><span class="completed"></span></li>';
            }
        } else {
            if ($trip_details->is_return_warehouse == '1') {
                $progres_li_text .= '<li class="inprogress" style="width: ' . $progress_bar_percentage . '%;"><span class="inprogress"></span></li>';
            } else {
                $progres_li_text .= '<li class="inprogress" style="width: 0%;"><span class="inprogress"></span></li>';
            }
        }
        $data['routes'] = $routes;
        if ($trip_details->is_return_warehouse == '1') {
            $progres_lower_text .= '<li style="margin-left: -25px;"><span>Warehouse</span></li>';
        }
        $data['progress_bar'] = '<ul class="progress_bar">' . $progres_li_text . '</ul>
<ul class="progress_bar_text">' . $progres_lower_text . ' </ul>';
        echo json_encode($data);
        exit();
    }
    
    function routes($driver_id) {
        
        $this->data['page_title'] = 'Routes';
        $this->data['deliveries'] = $this->user_model->get_driver_deliveries_status($driver_id);
        $this->load->view('routes', $this->data);
    }
    
    function show_map_route() {
        echo json_encode(array(array('rider_location' => array('lat' => '17.396899227178984', 'lng' => '78.4406125250291')), array('rider_location' => array('lat' => '17.412788008367077', 'lng' => '78.46481677917949'))));
        exit();
        //$this->load->view('add_warehouse', $data);
    }
    
    function drivers() {
        $searchQuery = array();
        $likeQuery = '';
        $this->data['page_title'] = 'Drivers';
        $this->data['filterDriverStatus'] = $filterDriverStatus = $this->input->get('filterDriverStatus');
        $this->data['filterDriverPaymentStatus'] = $filterDriverPaymentStatus = $this->input->get('filterDriverPaymentStatus');
        $this->data['filterDriverOnlineStatus'] = $filterDriverOnlineStatus = $this->input->get('filterDriverOnlineStatus');
        $this->data['filterDriverName'] = $filterDriverName = $this->input->get('filterDriverName');

        if ($filterDriverStatus != 'All') {
            if ($filterDriverStatus == 'Enabled') {
                $searchQuery['status'] = '1';
            } elseif ($filterDriverStatus == 'Disabled') {
                $searchQuery['status'] = '0';
            }
        }
        if ($filterDriverOnlineStatus != 'All') {
            if ($filterDriverOnlineStatus == 'Yes') {
                $searchQuery['online_status'] = '1';
            } elseif ($filterDriverOnlineStatus == 'No') {
                $searchQuery['online_status'] = '0';
            }
        }
        if ($filterDriverName != '') {
            $likeQuery = $filterDriverName;
        }
        //echo $likeQuery;exit;
        $org_id = $this->session->userdata('org_id');
        $this->data['drivers'] = $this->user_model->get_drivers($org_id, $limit = '', $start = '', $searchQuery, '', '', $likeQuery);
        $this->load->view('drivers', $this->data);
    }
    
    function add_driver() {
        $this->data['page_title'] = 'Add Driver';
        $this->load->view('add_driver', $this->data);
    }

    function edit_driver($driver_id) {
        $this->data['page_title'] = 'Edit Driver';
        $this->data['model'] = $this->user_model->get_driver_value($driver_id);
        if (empty($this->data['model'])) {
            redirect('useraccount/drivers');
        }
        $this->load->view('add_driver', $this->data);
    }

    function doadddriver() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('truck_number', 'truck number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('company_code', 'company code ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "name" => $this->input->post('name'),
                    "phone" => $this->input->post('phone'),
                    "truck_number" => $this->input->post('truck_number'),
                    "company_code" => $this->input->post('company_code'),
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                    "status" => '1',
                );
                if (isset($_FILES['personal_pic']['name']) && ($_FILES['personal_pic']['name'] != '')) {

                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['personal_pic']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $filename = 'personal_pic_' . rand(10, 500) . time() . '.' . $extension;

                            $config = array(
                                'upload_path' => "./uploads/profile_img/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $filename,
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('personal_pic')) {
                                $error = array('error' => $this->upload->display_errors());
                                //print_r($error);exit;
                            }
                        }
                    }
                }

                //blogger image
                if (isset($_FILES['truck_pic']['name']) && ($_FILES['truck_pic']['name'] != '')) {
                    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                        $error = 'This file have some problem.';
                    } else {
                        $allowed = array('png', 'jpg', 'gif', 'jpeg');
                        $extension = pathinfo($_FILES['truck_pic']['name'], PATHINFO_EXTENSION);
                        if (!in_array(strtolower($extension), $allowed)) {
                            $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                        } else {
                            $blogger_img = 'truck_pic_' . rand(10, 500) . time() . '.' . $extension;

                            $config1 = array(
                                'upload_path' => "./uploads/truck_img/original/",
                                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                                'overwrite' => TRUE,
                                'file_name' => $blogger_img,
                            );
                            $this->load->library('upload', $config1);
                            $this->upload->initialize($config1);
                            $this->upload->do_upload('truck_pic');
                        }
                    }
                }
                if (isset($filename)) {
                    $_data['personal_pic'] = $filename;
                }
                if (isset($blogger_img)) {
                    $_data['truck_pic'] = $blogger_img;
                }
                if (!empty($cid)) {
                    $this->user_model->updateDriver($cid, $_data);
                    $this->response['message'] = " updated successfully.";
                } else {
                    $_data['org_id'] = $this->session->userdata('org_id');
                    $this->user_model->insert_driver($_data);
                    $this->response['message'] = 'driver added successfully.';
                }

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function drivers_status_update() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('enable_status', 'enable status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "status" => $this->input->post('enable_status'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $cid_arr = explode('test_', $this->input->post('driver_id'));
                $cid = $cid_arr[1];
                $this->user_model->updateDriver($cid, $_data);
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function view_driver($driver_id) {
        $this->data['page_title'] = 'Driver Details';
        $this->data['model'] = $this->user_model->get_driver_value($driver_id);
        $this->data['LastDeliveryDate'] = $this->user_model->last_driver_deleveries($driver_id);
        $this->data['driver_id'] = $driver_id;
        $this->load->view('view_driver', $this->data);
    }
    
    function doadddriver_search() {
        if ($this->input->is_ajax_request()) {
            $org_id = $this->session->userdata('org_id');
            $searchField = $this->input->post('searchField');
            if (trim($searchField) == '') {
                $drivers = $this->user_model->get_drivers_text_search($org_id);
            } else {
                $drivers = $this->user_model->get_drivers_text_search($org_id, array('name' => $searchField));
            }

            $html = '';
            if ($drivers['total'] != 0) {
                $i = 0;

                foreach ($drivers['result'] as $list) {
                    if (($i % 2) == 0 || $i == 0) {
                        $html .= '<div class="row top-row">';
                    }
                    $html .= '<div class="col-md-6">
        			<div class="form-check">
                                    <input type="radio" class="form-check-input" name="drivers" id="exampleRadiosDriver_' . $list->driver_id . '" value="' . $list->driver_id . '">
                                    <label class="form-check-label" for="exampleRadiosDriver_' . $list->driver_id . '">' . $list->name . '&nbsp;' . $list->phone . '</label>
        			</div>
        		</div>';
                    $i++;
                    if (($i % 2) == 0) {
                        $html .= '</div>';
                    }
                }
                if (($drivers['total'] % 2) != 0) {
                    $html .= '</div>';
                }
                $this->response['status'] = 200;
                $this->response['html'] = $html;
            } else {
                $this->response['status'] = 200;
                $this->response['html'] = $html;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function deliveriesdriverallocation() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('assigned_route', 'assigned route  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('drivers', 'driver  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $org_id = $this->session->userdata('org_id');
                $assigned_route = $this->input->post('assigned_route');
                $drivers = $this->input->post('drivers');
                $driver_detail = $this->user_model->get_driver_value($drivers);
                $trip_date_arr = explode('/', $this->input->post('trip_date'));
                $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
                $client_deliveries_allocation = $this->user_model->get_client_deliveries_assigned_by_route($org_id, $trip_date, $assigned_route);
                foreach ($client_deliveries_allocation['result'] as $list) {
                    $this->user_model->updatedeliveries($list->deliveries_id, array('driver_id' => $drivers, 'is_driver_assigned' => '1'));
                }

                $this->response['route_driver'] = array('route_id' => $assigned_route, 'driver_detail' => $driver_detail->name . ' ' . $driver_detail->phone);
                $this->response['message'] = 'driver added successfully.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function trips() {
        $this->data['page_title'] = 'Trips';
        $this->data['trip_date'] = '';
        $this->data['added_client_deliveries'] = array('total' => 0, 'result' => array());
        $this->data['added_customer_deliveries'] = array('total' => 0, 'result' => array());
        $org_id = $this->session->userdata('org_id');
        $trip_date = $this->input->post('trip_date');

        if ($trip_date != '') {
            $this->data['trip_date'] = $this->input->post('trip_date');
            $trip_date_arr = explode('/', $this->input->post('trip_date'));
            $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
            $this->data['added_client_deliveries'] = $this->user_model->get_client_deliveries($org_id, $trip_date);
            $this->data['added_customer_deliveries'] = $this->user_model->get_customer_deliveries($org_id, $trip_date);
            $this->data['client_deliveries_trip'] = $this->user_model->get_client_deliveries_trip_plan($org_id, $trip_date);
            if ($this->data['added_client_deliveries']['total'] != 0 || $this->data['added_customer_deliveries']['total'] != 0) {
                $this->data['clients'] = $this->user_model->get_clients($org_id);
                $this->data['routes'] = $this->user_model->get_clients_routes($org_id);
                $this->load->view('trips', $this->data);
            } else {
                $this->data['added_client_deliveries_assigned_not_confirmed'] = $this->user_model->get_client_deliveries_assigned_by_route_not_confirmed($org_id, $trip_date);
                $this->data['added_client_deliveries_assigned'] = $this->user_model->get_client_deliveries_assigned($org_id, $trip_date);
                if ($this->data['added_client_deliveries_assigned_not_confirmed']['total'] > 0) {
                    $this->data['clients'] = $this->user_model->get_clients($org_id);
                    $this->data['drivers'] = $this->user_model->get_drivers($org_id);
                    $this->data['warehouse'] = $this->user_model->get_warehouse($org_id);
                    $this->load->view('deliveries_allocation', $this->data);
                } else {
                    $this->data['clients'] = $this->user_model->get_clients($org_id);
                    $this->data['routes'] = $this->user_model->get_clients_routes($org_id);
                    $this->load->view('trips', $this->data);
                }
            }
        } else {
            $this->data['clients'] = $this->user_model->get_clients($org_id);
            $this->data['routes'] = $this->user_model->get_clients_routes($org_id);
            $this->load->view('trips', $this->data);
        }
    }
    
    function doaddhoc() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('trip_date', 'trip date  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('order_id', 'order id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('customer_name', 'customer name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('mobile_number', 'mobile number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('pin_code', 'pin code ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('address', 'address ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('order_detail', 'order detail ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('customer_latitude', 'customer latitude ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('customer_longitude', 'customer longitude ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $trip_date_arr = explode('/', $this->input->post('trip_date'));
                $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
                $trip_start_time = date("H:i:s", strtotime($this->input->post('trip_start_time')));

                $_data = array(
                    "org_id" => $this->session->userdata('org_id'),
                    "type" => '1',
                    "date" => $trip_date,
                    "time" => $trip_start_time,
                    "added_at" => date('Y-m-d H:i:s'),
                    "order_id" => $this->input->post('order_id'),
                    "customer_name" => $this->input->post('customer_name'),
                    "mobile_number" => $this->input->post('mobile_number'),
                    "pin_code" => $this->input->post('pin_code'),
                    "address" => $this->input->post('address'),
                    "order_detail" => $this->input->post('order_detail'),
                    "customer_lat" => $this->input->post('customer_latitude'),
                    "customer_long" => $this->input->post('customer_longitude'),
                );
                $this->user_model->insert_deliveries($_data);
                $this->response['message'] = 'deliveries added successfully for customer.';
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function doimportcustomerorder() {
        if ($this->input->is_ajax_request()) {

            $path = 'uploads/customer_order/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|csv';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadFile')) {
                $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            if (empty($error)) {
                if (!empty($data['upload_data']['file_name'])) {
                    $import_xls_file = $data['upload_data']['file_name'];
                } else {
                    $import_xls_file = 0;
                }
                $inputFileName = $path . $import_xls_file;

                try {
                    $inputFileType = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);

                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($inputFileType)); ///Read the file
                    $reader->setReadDataOnly(true);
                    $date_arr = array();
                    $worksheetData = $reader->listWorksheetInfo($inputFileName); ///List all sheets inside the excel file

                    if (sizeof($worksheetData) > 0) : ///Check has any sheet or not
                        $sheetName = $worksheetData[0]['worksheetName']; ///Get the sheet name
                        $reader->setLoadSheetsOnly($sheetName); ///Load the sheet name
                        $spreadsheet = $reader->load($inputFileName); ///Load the sheet
                        $worksheet1 = $spreadsheet->getActiveSheet();
                        $worksheetData1 = $worksheet1->toArray(); ///Get the data from active sheet
                        //print_r($worksheetData1);exit;
                        $flag = true;
                        $i = 0;
                        $trip_date_arr = explode('/', $this->input->post('trip_date'));
                        $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
                        //$trip_start_time = date("H:i:s", strtotime($this->input->post('trip_start_time')));
                        $org_id = $this->session->userdata('org_id');
                        foreach ($worksheetData1 as $value) {
                            if ($flag) {
                                $flag = false;
                                continue;
                            }
                            $order_date = $value[0];
                            $order_number = $value[1];
                            $status = $value[2];
                            $customer_id = $value[3];
                            $customer_name = $value[4];
                            $quantity_order = $value[5];
                            $quantity_invoiced = $value[6];
                            $quantity_cancel = $value[7];
                            $quantity_packed = $value[8];
                            $usage_unit = $value[9];
                            $warehouse_name = $value[10];
                            $sub_total = $value[11];
                            $total = $value[12];
                            $cash_collect = $value[13];
                            $billing_address = $value[14];
                            $billing_city = $value[15];
                            $billing_state = $value[16];
                            $billing_country = $value[17];
                            $billing_code = $value[18];
                            $billing_phone = $value[19];
                            $shipping_address = $value[20];
                            $shipping_city = $value[21];
                            $shipping_state = $value[22];
                            $shipping_country = $value[23];
                            $shipping_code = $value[24];
                            $shipping_phone = $value[25];
                            $_data = array(
                                "org_id" => $org_id,
                                "order_date" => $order_date,
                                "order_number" => $order_number,
                                "status" => $status,
                                "customer_id" => $customer_id,
                                "customer_name" => $customer_name,
                                "quantity_order" => $quantity_order,
                                "quantity_invoiced" => $quantity_invoiced,
                                "quantity_cancel" => $quantity_cancel,
                                "quantity_packed" => $quantity_packed,
                                "usage_unit" => $usage_unit,
                                "warehouse_name" => $warehouse_name,
                                "sub_total" => $sub_total,
                                "total" => $total,
                                "cash_collect" => $cash_collect,
                                "billing_address" => $billing_address,
                                "billing_city" => $billing_city,
                                "billing_state" => $billing_state,
                                "billing_country" => $billing_country,
                                "billing_code" => $billing_code,
                                "billing_phone" => $billing_phone,
                                "shipping_address" => $shipping_address,
                                "shipping_city" => $shipping_city,
                                "shipping_state" => $shipping_state,
                                "shipping_country" => $shipping_country,
                                "shipping_code" => $shipping_code,
                                "shipping_phone" => $shipping_phone,
                                "added_at" => date('Y-m-d H:i:s'),
                            );
                            //print_r($_data);exit;
                            $this->user_model->insert_dcustomer_importorder($_data);
                            $i++;
                        }
                        unlink($inputFileName);
                        $customer_ids = $this->user_model->get_distinct_customer_importorder($org_id);
                        //print_r($customer_ids);exit;
                        foreach ($customer_ids as $list) {
                            $customer_orders = $this->user_model->get_customer_importorder($list->customer_id);

                            if (trim($customer_orders[0]->shipping_address) == '') {
                                $address = $customer_orders[0]->billing_address;
                                $final_address = trim($address);
                                $final_address = ltrim($final_address, '#');
                                if (trim($customer_orders[0]->billing_city) != '') {
                                    $final_address .= ', ' . trim($customer_orders[0]->billing_city);
                                }
                                if (trim($customer_orders[0]->billing_state) != '') {
                                    $final_address .= ', ' . trim($customer_orders[0]->billing_state);
                                }
                                if (trim($customer_orders[0]->billing_code) != '') {
                                    $final_address .= '-' . trim($customer_orders[0]->billing_code);
                                    $pin_code = $customer_orders[0]->billing_code;
                                }
                                if (trim($customer_orders[0]->billing_country) != '') {
                                    $final_address .= ', ' . trim($customer_orders[0]->billing_country);
                                }
                            } else {
                                $address = $customer_orders[0]->shipping_address;
                                $final_address = trim($address);
                                $final_address = ltrim($final_address, '#');
                                if (trim($customer_orders[0]->shipping_city) != '') {
                                    $final_address .= ', ' . trim($customer_orders[0]->shipping_city);
                                }
                                if (trim($customer_orders[0]->shipping_state) != '') {
                                    $final_address .= ', ' . trim($customer_orders[0]->shipping_state);
                                }
                                if (trim($customer_orders[0]->shipping_code) != '') {
                                    $final_address .= '-' . trim($customer_orders[0]->shipping_code);
                                    $pin_code = $customer_orders[0]->shipping_code;
                                }
                                if (trim($customer_orders[0]->shipping_country) != '') {
                                    $final_address .= ', ' . trim($customer_orders[0]->shipping_country);
                                }
                            }

                            //$final_address='2031 7th main D block 2nd stage, Bangalore, Karnataka-560010, India';
                            $latLong = $this->getLatLong($final_address);
                            $latitude = $latLong['latitude'] ? $latLong['latitude'] : 'Not found';
                            $longitude = $latLong['longitude'] ? $latLong['longitude'] : 'Not found';
                            $customer_name = $customer_orders[0]->customer_name;
                            if (trim($customer_orders[0]->shipping_phone) != '') {
                                $mobile_number = $customer_orders[0]->shipping_phone;
                            } else {
                                $mobile_number = $customer_orders[0]->billing_phone;
                            }
                            $order_id = '';
                            foreach ($customer_orders as $orders) {
                                $order_id .= $orders->order_number . ',';
                            }
                            $order_list = rtrim($order_id, ',');
                            $order_detail = '';
                            $_data1 = array();
                            $_data1 = array(
                                "org_id" => $org_id,
                                "type" => '1',
                                "date" => $trip_date,
                                "time" => '',
                                "added_at" => date('Y-m-d H:i:s'),
                                "order_id" => $order_list,
                                "customer_name" => $customer_name,
                                "mobile_number" => $mobile_number,
                                "pin_code" => $pin_code,
                                "address" => $address,
                                "order_detail" => $order_detail,
                                "customer_lat" => $latitude,
                                "customer_long" => $longitude,
                            );
                            //print_r($_data);exit;
                            $this->user_model->insert_deliveries($_data1);
                            $updateData = array(
                                "import_status" => '1',
                            );
                            $this->user_model->update_customer_importorder($org_id, $list->customer_id, $updateData);
                        }
                        $this->response['message'] = 'order import successfully';
                        $this->response['status'] = 200;
                    else :
                    //$this->session->set_flashdata('flash_errmsg', 'The file is not valid.');
                    endif;
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
            } else {
                $this->response['message'] = $error['error'];
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function doadddeliveries() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('trip_date', 'trip date  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $trip_date_arr = explode('/', $this->input->post('trip_date'));
                $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
                //$trip_start_time = date("H:i:s", strtotime($this->input->post('trip_start_time')));
                if (isset($_POST['deliveries'])) {
                    foreach ($_POST['deliveries'] as $deliverie) {


                        if ($this->user_model->is_deliveries_client_added($deliverie, $trip_date)) {
                            $_data = array(
                                "org_id" => $this->session->userdata('org_id'),
                                "client_id" => $deliverie,
                                "date" => $trip_date,
//                            "time" => $trip_start_time,
                                "added_at" => date('Y-m-d H:i:s'),
                            );
                            $this->user_model->insert_deliveries($_data);
                        }
                    }
                    $this->response['message'] = 'deliveries added successfully.';
                    $this->response['status'] = 200;
                } else {
                    $this->response['message']['trip_date'] = 'Please select deliveries.';
                    $this->response['status'] = 500;
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function doadddeliveries_search() {
        if ($this->input->is_ajax_request()) {
            $org_id = $this->session->userdata('org_id');
            $searchField = $this->input->post('searchField');
            if (trim($searchField) == '') {
                $clients = $this->user_model->get_clients_text_search($org_id);
            } else {
                $clients = $this->user_model->get_clients_text_search($org_id, array('company_name' => $searchField));
            }

            $html = '';
            if ($clients['total'] != 0) {
                $i = 0;

                foreach ($clients['result'] as $list) {
                    if (($i % 3) == 0 || $i == 0) {
                        $html .= '<div class="row top-row">';
                    }
                    $html .= '<div class="col-md-4">
        			<div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="deliveries[]" id="exampleCheck' . $list->client_id . '" value="' . $list->client_id . '">
                                        <label class="form-check-label" for="exampleCheck' . $list->client_id . '">' . $list->company_name . '</label>
                                        <p>' . $list->client_address . '</p>
        			</div>
        		</div>';
                    $i++;
                    if (($i % 3) == 0) {
                        $html .= '</div>';
                    }
                }
                if (($clients['total'] % 3) != 0) {
                    $html .= '</div>';
                }
                $this->response['status'] = 200;
                $this->response['html'] = $html;
            } else {
                $this->response['status'] = 200;
                $this->response['html'] = $html;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function confirmplan() {
        if ($this->input->is_ajax_request()) {
            $org_id = $this->session->userdata('org_id');
            $user_id = $this->session->userdata('user_id');
            //print_r($_POST);exit;
            $trip_date_arr = explode('/', $this->input->post('trip_date'));
            $trip_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
            if ($this->user_model->is_all_driver_assigned_to_trip($org_id, $trip_date)) {
                $trip_start_arr = $_POST['trip_start'];
                $trip_end_arr = $_POST['trip_end'];
                foreach ($_POST['order_list'] as $key1 => $order_list) {
                    $list_order = 1;
                    $trip_start_time = date('H:i:s', strtotime($trip_start_arr[$key1]));
                    $trip_end_time = date('H:i:s', strtotime($trip_end_arr[$key1]));
                    foreach ($order_list as $key2 => $val) {
                        $this->user_model->updatedeliveries($key2, array('order_list' => $list_order, 'trip_start_time' => $trip_start_time, 'trip_end_time' => $trip_end_time));
                        $list_order++;
                    }
                }
                $this->user_model->updatePlanConform($org_id, $trip_date, array('is_plan_confirmed' => '1'));
                $client_deliveries_trip = $this->user_model->get_client_deliveries_trip_plan($org_id, $trip_date);
                if ($client_deliveries_trip['total'] != 0) {
                    $current_route = 0;
                    $i = 0;
                    $insert_id = 0;
                    $total_distance = 0;
                    foreach ($client_deliveries_trip['result'] as $list) {
                        $_data1 = array();
                        $_data2 = array();
                        if ($current_route != $list->route_id) {
                            $_data1 = array(
                                'org_id' => $org_id,
                                'driver_id' => $list->driver_id,
                                'assigned_date' => $list->date,
                                'warehouse_id' => $list->warehouse_id,
                                'is_return_warehouse' => $list->is_return_warehouse,
                                'route_id' => $list->route_id,
                                'trip_start_time' => $list->trip_start_time,
                                'trip_end_time' => $list->trip_end_time,
                                'added_at' => date('Y-m-d H:i:s')
                            );
                            $insert_id = $this->user_model->insert_assign_trip($_data1);
                            $warehouse_obj = $this->user_model->get_warehouse_value($list->warehouse_id);
                            $addr1_lat = $warehouse_obj->warehouse_lat;
                            $addr1_long = $warehouse_obj->warehouse_long;
                            $total_distance = 0;
                        }



                        if ($list->type == 0) {
                            $client_id = $list->client_id;
                            $customer_name = '';
                            $mobile_number = '';
                            $address = '';
                            $customer_lat = '';
                            $customer_long = '';
                            $nextaddr2_lat = $list->client_latitude;
                            $nextaddr2_long = $list->client_longitude;
                        } else {
                            $client_id = 0;
                            $customer_name = $list->customer_name;
                            $mobile_number = $list->mobile_number;
                            $address = $list->address;
                            $customer_lat = $list->customer_lat;
                            $customer_long = $list->customer_long;
                            $nextaddr2_lat = $customer_lat;
                            $nextaddr2_long = $customer_long;
                        }
                        $addr2_lat = $nextaddr2_lat;
                        $addr2_long = $nextaddr2_long;
                        //distance between 2 points
                        $distance = $this->distance($addr1_lat, $addr1_long, $addr2_lat, $addr2_long, 'K');
                        $total_distance += $distance;
                        $_data2 = array(
                            'assigned_trip_id' => $insert_id,
                            'user_id' => $user_id,
                            'org_id' => $org_id,
                            'client_id' => $client_id,
                            'delivered_at' => date('Y-m-d H:i:s', strtotime($list->date)),
                            'type' => $list->type,
                            'customer_name' => $customer_name,
                            'mobile_number' => $mobile_number,
                            'address' => $address,
                            'customer_lat' => $customer_lat,
                            'customer_long' => $customer_long,
                            'distance' => $distance,
                            'order_list' => $list->order_list
                        );
                        $this->user_model->insert_driver_trip_client($_data2);
                        $current_route = $list->route_id;
                        $i++;
                        $addr1_lat = $addr2_lat;
                        $addr1_long = $addr2_long;
                        if (isset($client_deliveries_trip['result'][$i]->route_id)) {
                            if ($list->route_id != $client_deliveries_trip['result'][$i]->route_id) {
                                //update total distance of trip
                                $this->user_model->updateAssignTrip($insert_id, array('total_distance' => $total_distance));
                            }
                        } else {
                            $this->user_model->updateAssignTrip($insert_id, array('total_distance' => $total_distance));
                        }
                    }
                }
                $this->response['message'] = 'plan successfully confirmed.';
                $this->response['status'] = 200;
            } else {
                $this->response['message'] = 'Please assign all trip to driver.';
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }
    
    function live_tracking() {
        $this->data['page_title'] = 'Live Tracking';
        $org_id = $this->session->userdata('org_id');

        $trip_date = $this->input->post('trip_date');
        if ($trip_date != '') {
            $trip_date_arr = explode('/', $trip_date);
            //print_r($trip_date_arr);exit;
            $mysql_date = $trip_date_arr[2] . '-' . $trip_date_arr[0] . '-' . $trip_date_arr[1];
            $searchQuery['assigned_date'] = $mysql_date;
            $this->data['trip_date'] = $this->input->post('trip_date');
        } else {
            $searchQuery['assigned_date'] = date('Y-m-d');
            $this->data['trip_date'] = '';
        }
        $this->data['driver_trips'] = $this->user_model->get_trips_deliveries($org_id, '', '', $searchQuery);
        $this->load->view('live_tracking', $this->data);
    }
    
    function clients() {
        $this->data['page_title'] = 'Clients';
        $likeQuery = '';
        $data['filterClientName'] = $filterClientName = $this->input->get('filterClientName');

        if ($filterClientName != '') {
            $likeQuery = $filterClientName;
        }
        $org_id = $this->session->userdata('org_id');
        $this->data['clients'] = $this->user_model->get_clients($org_id, '', '', '', '', '', $likeQuery);
        $this->load->view('clients', $this->data);
    }

    function add_client() {
        $this->data['page_title'] = 'Client';
        $this->data['page_type'] = 'Add Client';
        $this->load->view('add_client', $this->data);
    }

    function edit_client($id) {
        $this->data['page_title'] = 'Client';
        $this->data['page_type'] = 'Edit Client';
        $this->data['model'] = $this->user_model->get_client_value($id);
        if (empty($this->data['model'])) {
            redirect('useraccount/clients');
        }
        $this->load->view('add_client', $this->data);
    }

    function doaddclient() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('company_name', 'company name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_name', 'client name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('manager_name', 'manager name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('gst_number', 'gst number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_area', 'client area ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_pincode', 'client pincode ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_mobile', 'client mobile ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_address', 'client address ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_city', 'client city ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_state', 'client state ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_latitude', 'client geo location ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_longitude', 'client geo location ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $cid = $this->input->post('cid') ?? '';
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "company_name" => $this->input->post('company_name'),
                    "client_name" => $this->input->post('client_name'),
                    "client_mobile" => $this->input->post('client_mobile'),
                    "client_address" => $this->input->post('client_address'),
                    "manager_name" => $this->input->post('manager_name'),
                    "gst_number" => $this->input->post('gst_number'),
                    "client_area" => $this->input->post('client_area'),
                    "client_pincode" => $this->input->post('client_pincode'),
                    "client_city" => $this->input->post('client_city'),
                    "client_state" => $this->input->post('client_state'),
                    "client_latitude" => $this->input->post('client_latitude'),
                    "client_longitude" => $this->input->post('client_longitude'),
                    "added_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                if (!empty($cid)) {
                    $this->user_model->updateClient($cid, $_data);
                    $this->response['message'] = " updated successfully.";
                } else {
                    $_data['user_id'] = $this->session->userdata('user_id');
                    $_data['org_id'] = $this->session->userdata('org_id');
                    $this->user_model->insert_client($_data);
                    $this->response['message'] = 'client added successfully.';
                }

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function clients_status_update() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('enable_status', 'enable status  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    "status" => $this->input->post('enable_status'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $cid_arr = explode('test_', $this->input->post('client_id'));
                $cid = $cid_arr[1];
                $this->user_model->updateClient($cid, $_data);
                $this->response['message'] = " updated successfully.";

                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function view_client($client_id) {
        $this->data['page_title'] = 'Client Details';
        $this->data['model'] = $this->user_model->get_client_value($client_id);
        $this->data['LastDeliveryDate'] = $this->user_model->last_client_deleveries($client_id);
        $this->data['client_id'] = $client_id;
        if (empty($this->data['model'])) {
            redirect('useraccount/clients');
        }
        $this->load->view('view_client', $this->data);
    }
    
    function deliveries($client_id) {
        $this->data['page_title'] = 'Deliveries';
        $this->data['deliveries'] = $this->user_model->get_client_deliveries_status($client_id);
        $this->load->view('deliveries', $this->data);
    }

    function varthakproductimport() {

        //exit('1');
        $path = 'uploads/varthak_product/';
        $import_xls_file = 'ItemMasterV1.xlsx';
        $inputFileName = $path . $import_xls_file;


        try {

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst('xlsx')); ///Read the file
            $reader->setReadDataOnly(true);
            $date_arr = array();
            $worksheetData = $reader->listWorksheetInfo($inputFileName); ///List all sheets inside the excel file

            if (sizeof($worksheetData) > 0) : ///Check has any sheet or not
                $sheetName = $worksheetData[0]['worksheetName']; ///Get the sheet name

                $reader->setLoadSheetsOnly($sheetName); ///Load the sheet name
                $spreadsheet = $reader->load($inputFileName); ///Load the sheet
                $worksheet1 = $spreadsheet->getActiveSheet();
                $worksheetData1 = $worksheet1->toArray(); ///Get the data from active sheet
                //print_r($worksheetData1);exit;
                $flag = true;
                $i = 0;
                foreach ($worksheetData1 as $value) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }
                    //print_r($value);exit;

                    $product_number = $value[0];
                    $item_name = $value[1];
                    $search_name = $value[2];
                    $category_name = $value[3];
                    $categoryObj = $this->user_model->get_varthak_product_category_value_by_name($category_name);
                    if (isset($categoryObj->category_id)) {
                        $category_id = $categoryObj->category_id;
                    } else {
                        $category_id = $this->user_model->insert_varthak_product_category(array('category_name' => $category_name));
                    }
                    $subcategory_name = $value[4];
                    $subcategoryObj = $this->user_model->get_varthak_product_sub_category_value_by_name($category_id, $subcategory_name);
                    if (isset($subcategoryObj->category_id)) {
                        $subcategory_id = $subcategoryObj->category_id;
                    } else {
                        $subcategory_id = $this->user_model->insert_varthak_product_sub_category(array('parent_id' => $category_id, 'category_name' => $subcategory_name));
                    }
                    $brand = $value[5];
                    $quantity = $value[6];
                    $unit = $value[7];
                    $selling_price = $value[8];
                    $purchase_price = $value[9];
                    //$image_name = $value[10];

                    $item_group = $value[11];
                    $product_hsn = $value[12];
                    $barcode = $value[13];
                    $EAN = $value[14];
                    $shelf_life = $value[15];
                    $is_batchable = $value[16];
                    $is_bom_item = $value[17];
                    $gst_percentage = $value[18];
                    $material_type = $value[19];
                    $nature_of_goods_code = $value[20];
                    $nature_of_goods = $value[21];
                    $active_name = $value[22];
                    if ($active_name == 'YES') {
                        $active = '1';
                    } else {
                        $active = '0';
                    }
                    $stock_qty = $value[23];
                    $stock_value = $value[24];
                    $_data = array(
                        "product_number" => $product_number,
                        "item_name" => $item_name,
                        "search_name" => $search_name,
                        "category_id" => $category_id,
                        "subcategory_id" => $subcategory_id,
                        "brand" => $brand,
                        "quantity" => $quantity,
                        "unit" => $unit,
                        "selling_price" => $selling_price,
                        "purchase_price" => $purchase_price,
                        "image_name" => $product_number . '.jpg',
                        "item_group" => $item_group,
                        "product_hsn" => $product_hsn,
                        "barcode" => $barcode,
                        "EAN" => $EAN,
                        "shelf_life" => $shelf_life,
                        "is_batchable" => $is_batchable,
                        "is_bom_item" => $is_bom_item,
                        "gst_percentage" => $gst_percentage,
                        "material_type" => $material_type,
                        "nature_of_goods_code" => $nature_of_goods_code,
                        "nature_of_goods" => $nature_of_goods,
                        "active" => $active,
                        "stock_qty" => $stock_qty,
                        "stock_value" => $stock_value,
                    );
                    //print_r($_data);exit;
                    $this->user_model->insert_varthak_product($_data);
                    $i++;
                }

                echo 'order import successfully';
            else :
            //$this->session->set_flashdata('flash_errmsg', 'The file is not valid.');
            endif;
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
    }

    function handleDBError($return_id, $message) {
        if (is_array($return_id)) {
            $this->response['message'] = $message;
            $this->handleKOResponse();
        }
    }

    function handleKOResponse($statusCode = HTTP_BAD_REQUEST, $error_message = null) {
        $this->response['status'] = $statusCode;
        if ($error_message != null) {
            $this->response['errorMessage'] = $error_message;
        }
        $this->output
                ->set_status_header($statusCode)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
        exit();
    }

    private function _updateField($newValue, $defaultValue) {
        return $newValue == null ? $defaultValue : $newValue;
    }

    private function _updateSales($order_status, $salesObj, $_common_data, $_sales_data = array()) {
        $status_update = array('order_status' => $order_status);
        if ($salesObj->order_status == ORDER_CREATED && $order_status == ORDER_APPROVED) {
            $status_update = array_merge($status_update, array("status" => INVOICE_ENABLE));
        }
        $this->user_model->updateSales($salesObj->sale_id, array_merge(
                        $_sales_data, $_common_data, $status_update
        ));
    }

    private function _updatePurchase($order_status, $purchaseObj, $_common_data, $_purchase_data = array()) {
        $status_update = array('order_status' => $order_status);
        if ($purchaseObj->order_status == ORDER_CREATED && $order_status == ORDER_APPROVED) {
            $status_update = array_merge($status_update, array("status" => INVOICE_ENABLE));
        }
        $this->user_model->updatePurchase($purchaseObj->purchase_id, array_merge(
                        $_purchase_data, $_common_data, $status_update
        ));
    }

    function handleNullCheck($obj, $message, $status = HTTP_BAD_REQUEST) {
        if ($obj == null) {
            $this->handleError($message, $status);
        }
    }

    private function _copySalesFromPurchase($order_status, $salesObj, $purchaseObj) {
        $_sales_data = array(
            "paid" => $purchaseObj->paid,
            "due_date" => $purchaseObj->due_date,
            "dues" => $purchaseObj->dues,
            "payment_type" => $purchaseObj->payment_type,
            "client_phone" => $purchaseObj->client_phone,
            "total_price" => $purchaseObj->total_price,
            "name" => $purchaseObj->name,
            "delivery_date" => $purchaseObj->delivery_date,
            "shipping_address" => $purchaseObj->shipping_address,
            "shipping_latitude" => $purchaseObj->shipping_latitude,
            "shipping_longitude" => $purchaseObj->shipping_longitude,
            "order_status" => $order_status,
            "updated_at" => date('Y-m-d H:i:s'),
            "last_updated_by" => $purchaseObj->last_updated_by,
            "invoice_date" => $purchaseObj->invoice_date,
            "note" => $purchaseObj->note,
            "advance_amount" => $purchaseObj->advance_amount
        );
        if ($salesObj->order_status == ORDER_CREATED && $order_status == ORDER_APPROVED) {
            $_sales_data = array_merge($_sales_data, array("status" => INVOICE_ENABLE));
        }
        $this->user_model->updateSales($salesObj->sale_id, $_sales_data);
    }

    private function _copyPurchaseFromSales($order_status, $purchaseObj, $salesObj) {
        $_purchase_data = array(
            "paid" => $salesObj->paid,
            "due_date" => $salesObj->due_date,
            "dues" => $salesObj->dues,
            "payment_type" => $salesObj->payment_type,
            "client_phone" => $salesObj->client_phone,
            "total_price" => $salesObj->total_price,
            "name" => $salesObj->name,
            "delivery_date" => $salesObj->delivery_date,
            "shipping_address" => $salesObj->shipping_address,
            "shipping_latitude" => $salesObj->shipping_latitude,
            "shipping_longitude" => $salesObj->shipping_longitude,
            "order_status" => $order_status,
            "updated_at" => date('Y-m-d H:i:s'),
            "last_updated_by" => $salesObj->last_updated_by,
            "invoice_date" => $salesObj->invoice_date,
            "note" => $salesObj->note,
            "advance_amount" => $salesObj->advance_amount
        );
        if ($purchaseObj->order_status == ORDER_CREATED && $order_status == ORDER_APPROVED) {
            $_purchase_data = array_merge($_purchase_data, array("status" => INVOICE_ENABLE));
        }
        $this->user_model->updatePurchase($purchaseObj->purchase_id, $_purchase_data);
    }
    
    function doimportlocation() {

            $path = 'uploads/varthak_product/';
        $import_xls_file = 'Redcliffe.xlsx';
        $inputFileName = $path . $import_xls_file;


        try {

            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst('xlsx')); ///Read the file
            $reader->setReadDataOnly(true);
            $date_arr = array();
            $worksheetData = $reader->listWorksheetInfo($inputFileName); ///List all sheets inside the excel file

            if (sizeof($worksheetData) > 0) : ///Check has any sheet or not
                $sheetName = $worksheetData[0]['worksheetName']; ///Get the sheet name

                $reader->setLoadSheetsOnly($sheetName); ///Load the sheet name
                $spreadsheet = $reader->load($inputFileName); ///Load the sheet
                $worksheet1 = $spreadsheet->getActiveSheet();
                $worksheetData1 = $worksheet1->toArray(); ///Get the data from active sheet
                //print_r($worksheetData1);exit;
                $flag = true;
                $i = 0;
                foreach ($worksheetData1 as $value) {
                    if ($i<1) {
                        $i++;
                        continue;
                    }
                    //print_r($value);exit;

                    $pincode = $value[1];
                    $city = $value[0];
                    
                    $_data = array(
                        "pincode" => $pincode,
                        "city" => $city,
                        "state" => '',
                        "locality"=>'',
                    );
                    //print_r($_data);exit;
                    $this->user_model->insert_location_tbl($_data);
                    $i++;
                }

                echo 'order import successfully';
            else :
            //$this->session->set_flashdata('flash_errmsg', 'The file is not valid.');
            endif;
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
            
    }

}
