<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Index extends MY_Controller {

    private $response = array();

    function __construct() {

        parent::__construct();

        $this->load->model('index_model');

        $this->load->library('form_validation');

        $header = apache_request_headers();

        $Authorization = trim($header['Authorization']);

        if ($Authorization != 'Basic YnJhbmRrZXRzYXR5YW4=') {

            $this->response['message'] = 'Invalid auth key.';

            $this->response['status'] = 400;

            echo json_encode($this->response);

            exit();
        }
    }

    function registration() {

        $this->load->helper('file');

        $this->form_validation->set_rules('company_name', 'company name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_mobile', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('shop_phone', 'Contact number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_name', 'manager name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_address_1', 'address ', 'trim|required', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_area', 'area', 'trim|required', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_city', 'city ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_state', 'state ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_pincode', 'pinecode ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('shop_type', 'shop type ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('gst_number', 'gst number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('agree_tc', 'T & C ', 'trim|required|xss_clean', array('required' => 'You must agree %s.'));
        $this->form_validation->set_rules('domain_name', 'domain name ', 'trim|required|xss_clean', array('required' => 'You must agree %s.'));
        if ($this->form_validation->run() == TRUE) {

            $client_mobile = $this->input->post('client_mobile');

            $userDetails = $this->index_model->get_client_phone_value($client_mobile);

            if (!empty($userDetails)) {
                if ($userDetails->status == '0') {
                    $opt = $this->send_otp($userDetails->client_id, $this->input->post('client_mobile'));

                    $this->response['otp'] = $opt;

                    $user_details = array("org_id" => $userDetails->org_id, "client_id" => $userDetails->client_id, "company_name" => $this->input->post('company_name'), "client_mobile" => $this->input->post('client_mobile'), "client_name" => $this->input->post('client_name'), "status" => '1');

                    $this->response['userDetails'] = $user_details;

                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
                } else {
                    $this->response['message'] = 'user already exist.';

                    $this->response['status'] = 400;
                }
            } else {
                $orgDetails = $this->index_model->get_organisation_data($this->input->post('domain_name'));
                if (!empty($orgDetails)) {
                    $client_address_1 = $this->input->post('client_address_1');
                    $client_address_2 = $this->input->post('client_address_2');
                    $client_address = $client_address_1;
                    if ($client_address_2 != '') {
                        $client_address .= ', ' . $client_address_2;
                    }
                    $_data = array(
                        "company_name" => $this->input->post('company_name'),
                        "user_id" => $orgDetails->id,
                        "org_id" => $orgDetails->org_id,
                        "client_name" => $this->input->post('client_name'),
                        "client_mobile" => $this->input->post('client_mobile'),
                        "shop_phone" => $this->input->post('shop_phone'),
                        "client_address" => $client_address,
                        "address_line_1" => $client_address_1,
                        "address_line_2" => $client_address_2,
                        "client_city" => $this->input->post('client_city'),
                        "client_state" => $this->input->post('client_state'),
                        "client_area" => $this->input->post('client_area'),
                        "client_latitude" => $this->input->post('client_latitude'),
                        "client_longitude" => $this->input->post('client_longitude'),
                        "client_pincode" => $this->input->post('client_pincode'),
                        "gst_number" => $this->input->post('gst_number'),
                        "shop_type" => $this->input->post('shop_type'),
                        'is_whatapp_yes' => $this->input->post('is_whatapp_yes'),
                        "status" => '1',
                        "added_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    );

                    $insert_id = $this->index_model->insertClient($_data);

                    $userDetails = $this->index_model->get_client_value($insert_id);

                    $this->response['userDetails'] = $userDetails;

                    $this->response['message'] = "Registration successfull.";

                    $this->response['status'] = 200;
                }else{
                    $this->response['message'] = 'organisation not exist.';

                    $this->response['status'] = 400;
                }
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function login() {



        $this->form_validation->set_rules('client_mobile', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('domain_name', 'domain name ', 'trim|required|xss_clean', array('required' => 'You must agree %s.'));


        if ($this->form_validation->run() == TRUE) {

            $client_mobile = $this->input->post('client_mobile');
            if ($client_mobile == '9999999999') {
                $orgDetails = $this->index_model->get_organisation_data($this->input->post('domain_name'));
                $userDetails = $this->index_model->get_active_phone_value($orgDetails->org_id,$client_mobile);
                $this->response['otp'] = '1234';

                $this->response['userDetails'] = $userDetails;

                $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                $this->response['status'] = 200;
            } else {
                $orgDetails = $this->index_model->get_organisation_data($this->input->post('domain_name'));
                if (!empty($orgDetails)) {
                $userDetails = $this->index_model->get_active_phone_value($orgDetails->org_id,$client_mobile);

                if (!empty($userDetails)) {

                    $opt = $this->send_otp($userDetails->client_mobile, $client_mobile);

                    $this->response['otp'] = $opt;

                    $this->response['userDetails'] = $userDetails;

                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
                } else {
                    $opt = $this->only_send_otp($client_mobile);

                    $this->response['otp'] = $opt;
                    $this->response['message'] = 'Not registered.';

                    $this->response['status'] = 400;                   //redirect('admin/login');
                }
                }else{
                    $this->response['message'] = 'organisation not exist.';

                    $this->response['status'] = 400;
                }
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 500;
        }

        echo json_encode($this->response);

        exit();
    }

    function user_shipping_detail() {



        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));



        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');

            $userDetails = $this->index_model->get_user_shipping_detail($client_id);

            if (!empty($userDetails)) {


                $this->response['userAddressDetails'] = $userDetails;

                $this->response['message'] = "This is your shipping detail.";

                $this->response['status'] = 200;
            } else {
                $this->response['message'] = 'Invalid client ID.';

                $this->response['status'] = 400;                   //redirect('admin/login');
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function update_user_shipping_detail() {

        $this->form_validation->set_rules('client_id', 'client id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_address_1', 'Address line ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_area', 'Area ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_city', 'city ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_state', 'state ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_pincode', 'pincode ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $_data = array(
                "client_address" => $this->input->post('client_address_1') . ', ' . $this->input->post('client_address_2'),
                "address_line_1" => $this->input->post('client_address_1'),
                "address_line_2" => $this->input->post('client_address_2'),
                "client_area" => $this->input->post('client_area'),
                "client_city" => $this->input->post('client_city'),
                "client_state" => $this->input->post('client_state'),
                "client_pincode" => $this->input->post('client_pincode')
            );





            $this->index_model->updateClient($this->input->post('client_id'), $_data);

            $this->response['message'] = "Your shipping detail updated.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function resend_otp() {



        $this->form_validation->set_rules('client_mobile', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));
        


        if ($this->form_validation->run() == TRUE) {

            $client_mobile = $this->input->post('client_mobile');

            $userDetails = $this->index_model->get_client_phone_value($client_mobile);

            if (!empty($userDetails)) {
                if($client_mobile=='9999999999'){
                    $opt='1234';
                }else{
                    $opt = $this->send_otp($userDetails->client_id, $client_mobile);
                }
                

                $this->response['otp'] = $opt;

                $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                $this->response['status'] = 200;
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function otp_verification() {

        $this->form_validation->set_rules('client_id', 'client id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('domain_name', 'domain name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {
            $clientDetails = $this->index_model->get_client_value($this->input->post('client_id'));
            if($clientDetails->client_mobile=='9999999999'){
                    $_data = array(
                        "otp_verified" => '1',
                        "status" => '1',
                        "updated_at" => date('Y-m-d H:i:s')
                    );
                }else{
                    $_data = array(
                        "otp" => '',
                        "otp_verified" => '1',
                        "status" => '1',
                        "updated_at" => date('Y-m-d H:i:s')
                    );
                }

            $this->index_model->updateClient($this->input->post('client_id'), $_data);

            $this->response['message'] = "Your account has been activated successfully.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function update_profile() {

        $this->load->helper('file');

        $this->form_validation->set_rules('client_id', 'client id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_mobile', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_email', 'email ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('company_name', 'company name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        //$this->form_validation->set_rules('shop_phone', 'Contact number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('client_address_1', 'address ', 'trim|required', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('client_area', 'area', 'trim|required', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('client_city', 'city ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('client_state', 'state ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('client_pincode', 'pinecode ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('shop_type', 'shop type ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('gst_number', 'gst number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $client_mobile = $this->input->post('client_mobile');

            $client_id = $this->input->post('client_id');

            $userExistDetails = $this->index_model->phone_exist_except_self($client_id, $client_mobile);

            //print_r($userDetails);exit;

            if (empty($userExistDetails)) {

                $userDetails = $this->index_model->get_user_value($client_id);

                $client_address_1 = $this->input->post('client_address_1');
                $client_address_2 = $this->input->post('client_address_2');
                $client_address = $client_address_1;
                if ($client_address_2 != '') {
                    $client_address .= ', ' . $client_address_2;
                }

                $_data = array(
                    "client_name" => $this->input->post('client_name'),
                    "client_mobile" => $this->input->post('client_mobile'),
                    "client_email" => $this->input->post('client_email'),
                    "company_name" => $this->input->post('company_name'),
                    "shop_phone" => $this->input->post('shop_phone'),
                    "client_address" => $client_address,
                    "address_line_1" => $client_address_1,
                    "address_line_2" => $client_address_2,
                    //"client_area" => $this->input->post('client_area'),
                    //"client_city" => $this->input->post('client_city'),
                    //"client_state" => $this->input->post('client_state'),
                    //"client_pincode" => $this->input->post('client_pincode'),
                    //"shop_type" => $this->input->post('shop_type'),
                    "gst_number" => $this->input->post('gst_number'),
                    "updated_at" => date('Y-m-d H:i:s')
                );



                $this->index_model->updateClient($client_id, $_data);

                //$opt = $this->send_otp($driver_id, $phone);
                //$this->response['otp'] = $opt;

                $userDetails = array("client_id" => $client_id, "client_name" => $this->input->post('client_name'), "client_mobile" => $this->input->post('client_mobile'), "client_email" => $this->input->post('client_email'), "company_name"=>$this->input->post('company_name'), "client_address"=>$this->input->post('client_address'), "gst_number"=>$this->input->post('gst_number'));

                $this->response['userDetails'] = $userDetails;

                $this->response['message'] = "Your account has been updated successfully.";

                $this->response['status'] = 200;
            } else {

                $this->response['message'] = 'phone number already registered.';

                $this->response['status'] = 400;
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function update_profilepicture() {

        $this->load->helper('file');

        $this->form_validation->set_rules('client_id', 'client id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));



        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');

            $extension = pathinfo($_FILES['personal_pic']['name'], PATHINFO_EXTENSION);

            $personal_pic_filename = 'personal_pic_' . rand(10, 500) . time() . '.' . $extension;

            $config = array(
                'upload_path' => "./uploads/profile_img/original/",
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => TRUE,
                'file_name' => $personal_pic_filename,
            );

            $this->load->library('upload', $config);

            $this->upload->initialize($config);

            $this->upload->do_upload('personal_pic');

            $_data = array(
                "updated_at" => date('Y-m-d H:i:s')
            );

            if (isset($personal_pic_filename)) {

                $_data['personal_pic'] = $personal_pic_filename;
            }

            $this->index_model->updateClient($client_id, $_data);

            $userDetails = array("personal_pic" => base_url() . 'uploads/profile_img/original/' . $personal_pic_filename);

            $this->response['userDetails'] = $userDetails;

            $this->response['message'] = "Your profile picture updated successfully.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    private function send_otp($client_id, $phone) {

        $user_data['otp'] = rand(9000, 9999);//'1234';//

        //send SMS

        $postRequest = array(
            'mobileNo' => $phone,
            'otp' => $user_data['otp']
        );



        $cURLConnection = curl_init('https://api.flaplive.com/v1/feast-eat/generate-otp');

        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);

        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);



        $apiResponse = curl_exec($cURLConnection);

        curl_close($cURLConnection);

        $user_data['updated_at'] = date('Y-m-d H:i:s');

        $this->index_model->updateClient($client_id, $user_data);



        return $user_data['otp'];

        exit();
    }

    private function only_send_otp($phone) {

        $user_data['otp'] = rand(9000, 9999);//'1234';//

        //send SMS

        $postRequest = array(
            'mobileNo' => $phone,
            'otp' => $user_data['otp']
        );



        $cURLConnection = curl_init('https://api.flaplive.com/v1/feast-eat/generate-otp');

        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);

        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);



        $apiResponse = curl_exec($cURLConnection);

        curl_close($cURLConnection);

        return $user_data['otp'];

        exit();
    }

    function shop_type() {



        $shopType = $this->index_model->get_shop_type();

        $this->response['shopType'] = $shopType;

        $this->response['message'] = "This is your shop.";

        $this->response['status'] = 200;

        echo json_encode($this->response);

        exit();
    }

    function shop_update() {



        $this->form_validation->set_rules('client_id', 'client ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('shop_phone', 'phone ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('shop_name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('shop_location', 'location ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('shop_address', 'address ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('shop_type', 'shop type ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('delivery_start_time', 'prefered delivery start time ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('delivery_end_time', 'prefered delivery end time ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));


        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');
            $_data = array(
                //'shop_phone' => $this->input->post('shop_phone'),
                //'shop_name' => $this->input->post('shop_name'),
                'shop_location' => $this->input->post('shop_location'),
                'shop_address' => $this->input->post('shop_address'),
                    //'shop_type' => $this->input->post('shop_type'),
                    //'delivery_start_time' => $this->input->post('delivery_start_time'),
                    //'delivery_end_time' => $this->input->post('delivery_end_time'),
                    //'is_whatapp_yes' => $this->input->post('is_whatapp_yes'),
            );
            $this->index_model->updateClient($client_id, $_data);
            $this->response['message'] = "shop detail is updated.";
            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function category_type() {


        $this->form_validation->set_rules('org_id', 'org id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {
        $categoryType = $this->index_model->get_category_type($this->input->post('org_id'));

        $this->response['categoryType'] = $categoryType;

        $this->response['message'] = "This is your category.";

        $this->response['status'] = 200;
        }else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }
        echo json_encode($this->response);

        exit();
    }

    function category_featured_type() {


        $this->form_validation->set_rules('org_id', 'org id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {
        $categoryType = $this->index_model->get_featured_category_type($this->input->post('org_id'));

        $this->response['categoryType'] = $categoryType;

        $this->response['message'] = "This is your featured category.";

        $this->response['status'] = 200;
        }else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }
        echo json_encode($this->response);

        exit();
    }

    function product_by_category() {
        $this->form_validation->set_rules('org_id', 'org id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('product_category_id', 'product category id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('page', 'page number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $product_category_id = $this->input->post('product_category_id');
            $page = $this->input->post('page');
            if ($page == 1) {
                $limit = 10;
                $start = 0;
            } else {
                $limit = 10;
                $start = ($page - 1) * $limit;
            }
            $products = $this->index_model->get_product_by_category_id($this->input->post('org_id'),$product_category_id, $limit, $start);

            $this->response['products'] = $products;

            $this->response['message'] = "This is your products.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function product_by_name() {
        $this->form_validation->set_rules('org_id', 'org id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('product_name', 'product name  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('page', 'page number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $product_name = $this->input->post('product_name');
            $page = $this->input->post('page');
            if ($page == 1) {
                $limit = 10;
                $start = 0;
            } else {
                $limit = 10;
                $start = ($page - 1) * $limit;
            }
            $products = $this->index_model->get_product_by_product_name($this->input->post('org_id'),$product_name, $limit, $start);

            $this->response['products'] = $products;

            $this->response['message'] = "This is your products.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function get_top_items() {
        $this->form_validation->set_rules('org_id', 'org id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('page', 'page number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {
            $client_id = $this->input->post('client_id');
            $page = $this->input->post('page');
            if ($page == 1) {
                $limit = 10;
                $start = 0;
            } else {
                $limit = 10;
                $start = ($page - 1) * $limit;
            }
            $products = $this->index_model->get_top_products($this->input->post('org_id'),$client_id, $limit, $start);

            $this->response['products'] = $products;

            $this->response['message'] = "This is your products.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function get_popular_products() {
        $this->form_validation->set_rules('org_id', 'org id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('page', 'page number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {
            $client_id = $this->input->post('client_id');
            $page = $this->input->post('page');
            if ($page == 1) {
                $limit = 10;
                $start = 0;
            } else {
                $limit = 10;
                $start = ($page - 1) * $limit;
            }
            $products = $this->index_model->get_popular_products($this->input->post('org_id'),$client_id, $limit, $start);

            $this->response['products'] = $products;

            $this->response['message'] = "This is your products.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function add_cart() {

        $this->load->helper('file');

        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('quantity', 'quantity ', 'trim|required|greater_than[0]|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');
            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity');
            if ($quantity > 0) {
                $cartDetails = $this->index_model->get_client_cart_value($client_id, $product_id);

                if (!empty($cartDetails)) {

                    $updateData = array(
                        'quantity' => $quantity
                    );
                    $this->index_model->updateCart($client_id, $product_id, $updateData);

                    $this->response['message'] = "your cart updated.";

                    $this->response['status'] = 200;
                    //exit('1');
                } else {

                    $_data = array(
                        "client_id" => $client_id,
                        "product_id" => $product_id,
                        "quantity" => $quantity,
                        "added_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    );

                    $insert_id = $this->index_model->insertCart($_data);

                    $this->response['message'] = "Item added to your cart.";

                    $this->response['status'] = 200;
                    //exit('2');
                }
            } else {

                $this->response['message'] = "Item added to your cart.";

                $this->response['status'] = 500;
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function remove_cart() {

        $this->load->helper('file');

        $this->form_validation->set_rules('cart_id', 'cart id', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $cart_id = $this->input->post('cart_id');
            $this->index_model->deleteCart($cart_id);
            $this->response['message'] = "Item deleted to your cart.";
            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function get_cart() {

        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');
            $cart_items = $this->index_model->get_cart_details($client_id);

            $this->response['cartItems'] = $cart_items;

            $this->response['message'] = "This is your  cart products.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function submit_order() {
        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('payment_type', 'payment type ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');
            $cart_items = $this->index_model->get_cart_details($client_id);
            $userDetails = $this->index_model->get_user_value($client_id);
            //echo $this->input->post('org_id');exit;
            $_data = array(
                'client_id' => $this->input->post('client_id'),
                'org_id' => $this->input->post('org_id'),
                'payment_type' => $this->input->post('payment_type'),
                'shipping_address' => $userDetails->client_address . ', ' . $userDetails->client_area . ', ' . $userDetails->client_city . ', ' . $userDetails->client_state . '-' . $userDetails->client_pincode,
                'billing_address' => $userDetails->client_address,
                'billing_city' => $userDetails->client_city,
                'billing_state' => $userDetails->client_state,
                'billing_pincode' => $userDetails->client_pincode,
                'order_status' => '1',
                'added_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $insert_id = $this->index_model->insertOrder($_data);
            $total_price = 0;
            foreach ($cart_items as $list) {
                $gst_price = ($list->price * $list->quantity * $list->gst_percentage) / 100;
                $total_price += ($list->price * $list->quantity) + $gst_price;
                $_order_data = array(
                    'order_id' => $insert_id,
                    'product_id' => $list->product_id,
                    'quantity' => $list->quantity,
                    'product_price' => $list->price,
                    "gst_price" => $gst_price,
                    'total_price' => ($list->price * $list->quantity) + $gst_price,
                );
                $this->index_model->insertOrderDetail($_order_data);
                //$order_price += $total_price;
            }
            $invoice_id = $insert_id . $this->all_function->randomNumber(10 - strlen($insert_id));
            $_order_data = array(
                'invoice_id' => $invoice_id,
                'total_price' => $total_price,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->index_model->updateOrder($insert_id, $_order_data);
            $this->index_model->empty_client_cart_item($client_id);
            $this->response['invoice_id'] = "$invoice_id";
            $this->response['message'] = "This is your  invoice id of your order";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function update_order() {
        $this->form_validation->set_rules('invoice_id', 'invoice id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('order_status', 'order status ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('transaction_id', 'transaction id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $invoice_id = $this->input->post('invoice_id');
            $order_status = $this->input->post('order_status'); //1= success_payment , 4= cancel order or failed
            $transaction_id = $this->input->post('transaction_id');
            $_order = array(
                'order_status' => $order_status,
                'transaction_id' => $transaction_id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->index_model->updateOrderByInvoiceID($invoice_id, $_order);
            $this->response['message'] = "Your order has been placed.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }



        echo json_encode($this->response);

        exit();
    }

    function get_orders() {
        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('order_status', 'order status ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('page', 'page number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');
            $order_status = $this->input->post('order_status'); //1=order placed,2=order confirmed,3=order deivered
            $page = $this->input->post('page');
            if ($page == 1) {
                $limit = 50;
                $start = 0;
            } else {
                $limit = 10;
                $start = ($page - 1) * $limit;
            }
            $orderList = $this->index_model->get_order_list($client_id, $order_status, $limit, $start);

            $this->response['orderList'] = $orderList;

            $this->response['message'] = "This is your  order list.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function get_order_detail() {
        $this->form_validation->set_rules('order_id', 'order_id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $order_id = $this->input->post('order_id');
            $orderList = $this->index_model->get_order_detail_list($order_id);

            $this->response['orderDetailList'] = $orderList;

            $this->response['message'] = "This is your  order detail product list.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function get_order_invoice() {
        $this->form_validation->set_rules('order_id', 'order_id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $order_id = $this->input->post('order_id');

            $orderDetail = $this->index_model->get_order_value($order_id);

            $orderItems = $this->index_model->get_order_detail_list($order_id);
            $description = '';
            foreach ($orderItems as $list) {
                $description .= $list->product_name . ' ' . $list->quantity_val . $list->quantity_unit . ' ' . $list->quantity . ' Pice, ';
            }
            $description = rtrim($description, ',');
            $this->response['invoiceDetail'] = (object) array('bill_to' => $orderDetail->billing_address . ',' . $orderDetail->billing_city . '-' . $orderDetail->billing_pincode, 'ship_to' => $orderDetail->shipping_address, 'invoice_id' => $orderDetail->invoice_id, 'invoice_date' => date('d/m/Y', strtotime($orderDetail->added_at)), 'due_date' => date('d/m/Y', strtotime($orderDetail->updated_at)), 'invoice_total' => $orderDetail->total_price, 'description' => $description);

            $this->response['message'] = "This is your  invoice.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function notification() {



        $this->form_validation->set_rules('client_id', 'client id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));



        if ($this->form_validation->run() == TRUE) {

            $client_id = $this->input->post('client_id');

            $clientNoti = $this->index_model->get_notification_by_client_id($client_id);

            if (!empty($clientNoti)) {
                $i = 1;
                foreach ($clientNoti as $list) {
                    $notifications[] = array('message' => $list->notification);
                    $i++;
                }
                $this->response['notifications'] = $notifications;

                $this->response['message'] = "This is your notification.";

                $this->response['status'] = 200;
            } else {

                $this->response['message'] = 'you have not any notification';

                $this->response['status'] = 400;                   //redirect('admin/login');
            }
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function convertDigit($digit) {
        switch ($digit) {
            case "1":
                return "One";
            case "2":
                return "Two";
            case "3":
                return "Three";
            case "4":
                return "Four";
            case "5":
                return "Five";
            case "6":
                return "Six";
            case "7":
                return "Seven";
            case "8":
                return "Eight";
            case "9":
                return "Nine";
        }
    }

}
