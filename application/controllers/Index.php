<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author http://www.roytuts.com
 */
class Index extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $data = array();
        $data['metatitle'] = 'Varthak - Easy-to-use Accounting App and Payment Solution - Download Varthak';
        $data['metadescription'] = 'Varthak.io is the easiest and most productive financial planning application. We help SMEs, shopkeepers, and business owners in keeping digital business records and automating our sales entries. Download Varthak.io and take control of your finances today.';
        $data['metakeyword'] = 'accounting app, financial planning application, payments gateway, financial planning software, payment solution, online payment solutions, fintech solutions, digital payment solutions, best financial planning apps';
        $this->load->view('index', $data);
    }

    function policy() {
        $data = array();
        $data['metatitle'] = 'Varthak - Privacy Policy';
        $data['metadescription'] = 'Please read our privacy policy here to know how we handle and protect your information.';
        $data['metakeyword'] = 'personal finance software, sap accounting software, personal accounting software';
        $this->load->view('policy', $data);
    }

    function about_us() {
        $data = array();
        $data['metatitle'] = 'About us - Varthak';
        $data['metadescription'] = 'Varthak.io is the easiest and most productive financial planning application. We help SMEs, shopkeepers, and business owners in keeping digital business records and automating our sales entries.';
        $data['metakeyword'] = 'best free accounting software, bookkeeping app, payment platform, fintech';
        $this->load->view('about_us', $data);
    }

    function contact_us() {
        $data = array();
        $data['metatitle'] = 'Varthak - Contact Us and Help Page';
        $data['metadescription'] = 'If you have any questions or concerns about Varthak.io get in touch today. You can contact us by phone on ********** or through this page.';
        $data['metakeyword'] = 'accounts solution app, best accounting app for android, accounting application software';
        $this->load->view('contact_us', $data);
    }

    function contact_form_store() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('email_id', 'email id', 'trim|required|valid_email|xss_clean', array('required' => 'You must provide your %s.', 'valid_email' => 'Please use valid %s.'));
            $this->form_validation->set_rules('message', 'subject ', 'trim|required|min_length[20]|max_length[255]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('comment', 'comment ', 'trim|required|min_length[20]|max_length[255]|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    'visitor_name' => $this->input->post('name'),
                    'email_id' => $this->input->post('email_id'),
                    'subject' => $this->input->post('message'),
                    'comment' => $this->input->post('comment'),
                    'added_at' => date('Y-m-d H:i:s')
                );
                //print_r($_data);exit;
                $this->user_model->insert_contact_us($_data);
                //send mail to support@varthak.io
                $replacedata['Name'] = $this->input->post('name');
                $replacedata['email'] = $reply_to = $this->input->post('email_id');
                $replacedata['message'] = $this->input->post('message');
                $subject = 'Varthak:: Visitor Enquiry';
                $body = $this->load->view('email_template/contact_us', $replacedata, TRUE);
                //echo $body;exit;
                //$this->all_function->send_mail($this->all_function->get_slug_by_id('9'), $reply_to, $subject, $body);
                $phpMailer = new PHPMailer(true);
                $phpMailer->isSMTP();
                $phpMailer->Host = "smtp.zoho.in";
                $phpMailer->SMTPAuth = true;
                $phpMailer->Username = "praveenm@flaplive.com";
                $phpMailer->Password = "BNGt2QXSxXnQ";
                $phpMailer->SMTPSecure = "tls";
                $phpMailer->Port = 587;
                $phpMailer->isHTML(true);
                $phpMailer->CharSet = "UTF-8";
                $phpMailer->setFrom("support@varthak.io", "NoReply Support");

                $phpMailer->addAddress('support@varthak.io');
                $phpMailer->Subject = $subject;
                $phpMailer->Body = $body;
                $phpMailer->send();

                //send mail to visitor welcome email
                $replacedata['Name'] = $this->input->post('name');
                $replacedata['email'] = $reply_to = $this->input->post('email_id');
                $replacedata['message'] = $this->input->post('message');
                $subject = 'Varthak:: Visitor Enquiry';
                $body = $this->load->view('email_template/contact_us_visitor', $replacedata, TRUE);
                //echo $body;exit;
                //$this->all_function->send_mail($this->input->post('email_id'), 'support@varthak.io', $subject, $body);
                $phpMailer1 = new PHPMailer(true);
                $phpMailer1->isSMTP();
                $phpMailer1->Host = "smtp.zoho.in";
                $phpMailer1->SMTPAuth = true;
                $phpMailer1->Username = "praveenm@flaplive.com";
                $phpMailer1->Password = "BNGt2QXSxXnQ";
                $phpMailer1->SMTPSecure = "tls";
                $phpMailer1->Port = 587;
                $phpMailer1->isHTML(true);
                $phpMailer1->CharSet = "UTF-8";
                $phpMailer1->setFrom("support@varthak.io", "NoReply Support");

                $phpMailer1->addAddress($this->input->post('email_id'));
                $phpMailer1->Subject = $subject;
                $phpMailer1->Body = $body;
                $phpMailer1->send();

                $this->response['message'] = "Your message has been sent to Varthak support person,They will conatct you very soon.";
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function news_subscription_form() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email_id', 'email id', 'trim|required|valid_email|xss_clean', array('required' => 'You must provide your %s.', 'valid_email' => 'Please use valid %s.'));

            if ($this->form_validation->run() == TRUE) {
                $_data = array(
                    'email_id' => $this->input->post('email_id'),
                    'added_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->user_model->insert_news_subscription($_data);
                //send mail to support@varthak.io
                $replacedata['email'] = $reply_to = $this->input->post('email_id');
                $subject = 'Varthak:: News Letter Subscription';
                $body = $this->load->view('email_template/news_subscription', $replacedata, TRUE);
                //echo $body;exit;
                //$this->all_function->send_mail($this->all_function->get_slug_by_id('9'), $reply_to, $subject, $body);
                $phpMailer = new PHPMailer(true);
                $phpMailer->isSMTP();
                $phpMailer->Host = "smtp.zoho.in";
                $phpMailer->SMTPAuth = true;
                $phpMailer->Username = "praveenm@flaplive.com";
                $phpMailer->Password = "BNGt2QXSxXnQ";
                $phpMailer->SMTPSecure = "tls";
                $phpMailer->Port = 587;
                $phpMailer->isHTML(true);
                $phpMailer->CharSet = "UTF-8";
                $phpMailer->setFrom("support@varthak.io", "NoReply Support");

                $phpMailer->addAddress('support@varthak.io');
                $phpMailer->Subject = $subject;
                $phpMailer->Body = $body;
                $phpMailer->send();

                //send mail to news letter subscriber
                $replacedata['email'] = $this->input->post('email_id');
                $subject = 'Varthak:: News Letter Subscription';
                $body = $this->load->view('email_template/news_subscriber', $replacedata, TRUE);
                //echo $body;exit;
                //$this->all_function->send_mail($this->input->post('email_id'), 'support@varthak.io', $subject, $body);
                $phpMailer1 = new PHPMailer(true);
                $phpMailer1->isSMTP();
                $phpMailer1->Host = "smtp.zoho.in";
                $phpMailer1->SMTPAuth = true;
                $phpMailer1->Username = "praveenm@flaplive.com";
                $phpMailer1->Password = "BNGt2QXSxXnQ";
                $phpMailer1->SMTPSecure = "tls";
                $phpMailer1->Port = 587;
                $phpMailer1->isHTML(true);
                $phpMailer1->CharSet = "UTF-8";
                $phpMailer1->setFrom("support@varthak.io", "NoReply Support");

                $phpMailer1->addAddress($this->input->post('email_id'));
                $phpMailer1->Subject = $subject;
                $phpMailer1->Body = $body;
                $phpMailer1->send();

                $this->response['message'] = "Your message has been sent to Varthak support person,They will conatct you very soon.";
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 400;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function signup() {
        $data = array();
        $data['metatitle'] = 'Sign Up - Varthak';
        $data['metadescription'] = 'You can signup here.';
        $data['metakeyword'] = 'best free accounting software, accounting application software';
        $this->load->view('signup', $data);
    }

    function login() {
        $data = array();
        $data['metatitle'] = 'Sign In - Varthak';
        $data['metadescription'] = 'You can login here.';
        $data['metakeyword'] = 'best free accounting software, accounting application software';
        $this->load->view('login', $data);
    }

    function forgot_password() {
        $data = array();
        $data['metatitle'] = 'Forgot password - Varthak';
        $data['metadescription'] = 'You can recover your password here.';
        $data['metakeyword'] = 'best free accounting software, accounting application software';
        $this->load->view('forgot_password', $data);
    }

    function dologin() {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $phone = $this->input->post('phone');
                $userDetails = $this->user_model->get_active_user_phone_value($phone);
                if (!empty($userDetails)) {
                    $opt = $this->send_otp($userDetails->id, $phone);
                    $this->response['otp'] = $opt;
                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
                    $this->response['otp_verification'] = '0';
                } else {
                    $this->response['message'] = array('phone' => "Phone number not registered.");

                    $this->response['status'] = 400;
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

    function resend_otp() {
        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $phone = $this->input->post('phone');
            $userDetails = $this->user_model->get_active_user_phone_value($phone);
            if (!empty($userDetails)) {
                $opt = $this->send_otp($userDetails->id, $phone);
                $this->response['otp'] = $opt;
                $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                $this->response['status'] = 200;
            } else {
                $this->response['message'] = array('phone' => "Phone number not registered.");

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

    function otp_verification() {

        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('otp', 'otp ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {
            $phone = $this->input->post('phone');
            $otp = $this->input->post('otp');
            $userDetails = $this->user_model->get_active_user_phone_value($phone);

            if (!empty($userDetails)) {
                if ($userDetails->otp == $otp) {
                    $_data = array(
                        "otp" => '',
                        "otp_verified" => '1',
                        "status" => '1',
                        "updated_at" => date('Y-m-d H:i:s')
                    );

                    $this->user_model->updateUser($userDetails->id, $_data);
                    $conditions = array('phone' => $userDetails->phone, 'status' => '1');
                    $this->user_model->setUserSession($conditions);
                    $userDomain = $this->user_model->get_email_value($userDetails->email);
                    $this->response['message'] = 'logged in!';
                    $this->response['status'] = 200;
                    if ($userDomain->sub_domain == 'greenarrow') {
                        $this->response['email'] = $userDetails->email;
                        $this->response['password'] = $userDetails->password;
                        $this->response['subdomain'] = $userDomain->sub_domain;
                        $this->response['subdomain_login'] = base_url() . $userDomain->sub_domain . '/do-client-login.html';
                    } else {
                        $this->response['subdomain'] = '';
                    }
                    $this->response['otp_verification'] = '1';
                } else {
                    $this->response['message'] = array('otp' => 'wrong OTP');

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

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->set_userdata('user_id', '');
        $this->session->sess_destroy();
        redirect('');
    }

    public function dosignup() {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $phone = $this->input->post('phone');

                $userDetails = $this->user_model->get_phone_value($phone);

                if (!empty($userDetails)) {
                    if ($userDetails->status == '0') {
                        $opt = $this->send_otp($userDetails->id, $this->input->post('phone'));

                        $this->response['message'] = "Otp has been sent to your mobile number, please verify it.";
                        $this->response['org_info'] = '0';
                        $this->response['status'] = 200;
                    } else if ($userDetails->status == '1') {
                        $this->response['message'] = array('phone' => 'you already registered, please login from login page.');
                        $this->response['status'] = 500;
                    }
                } else {

                    $user_data = array(
                        'phone' => $this->input->post('phone'),
                        'status' => '0',
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

                    $this->user_model->updateUser($insert_id, array('company_code' => $company_code, 'org_id' => $org_insert_id));
                    $this->user_model->updateOrganisation($org_insert_id, array('company_code' => $company_code));

                    $opt = $this->send_otp($insert_id, $this->input->post('phone'));

                    $this->response['otp'] = $opt;
                    $this->response['org_info'] = '0';
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
                    // Default User for Demo Login
                    $_client_data= array(
                        'user_id' => $insert_id,
                        'org_id' => $org_insert_id,
                        'company_name' => 'Demo Company',
                        'client_name' => 'Demo User',
                        'manager_name' => 'Demo Manager',
                        'client_email' => 'demo@demo.com',
                        'client_mobile' => '9999999999',
                        'otp' => '1234',
                        'otp_verified' => '1',
                        'address_line_1' => '36/5 Somasandrapalya Road, ',
                        'address_line_2' => '27th Main Rd, Bengaluru, Karnataka 560102',
                        'client_address' => '36/5 Somasandrapalya Road, 27th Main Rd, Bengaluru, Karnataka 560102',
                        'client_area' => 'Somasandrapalya Road',
                        'client_city' => 'Bengaluru',
                        'client_state' => 'Karnataka',
                        'client_pincode' => '560102',
                        'personal_pic' => '',
                        'client_latitude' => '12.922476090214873',
                        'client_longitude' => '77.65129831068094',
                        'added_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'status' => '1',
                        'shop_phone' => '9999999999',
                        'shop_name' => 'Demo',
                        'shop_location' => '36/5 Somasandrapalya Road, 27th Main Rd, Bengaluru, Karnataka 560102',
                        'shop_address' => '36/5 Somasandrapalya Road, 27th Main Rd, Bengaluru, Karnataka 560102',
                        'shop_latitude' => '12.922476090214873',
                        'shop_longitude' => '77.65129831068094',
                        'shop_type' => '1',
                        'delivery_start_time' => '02:08:10',
                        'delivery_end_time' => '07:21:31',
                        'gst_number' => '123456789',
                        'is_whatapp_yes' => '1',
                    );
                    $this->user_model->insertClient($_client_data);
                    //END Global
                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
                }
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    function signupotp_verification() {

        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('otp', 'otp ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {
            $phone = $this->input->post('phone');
            $otp = $this->input->post('otp');
            $userDetails = $this->user_model->get_phone_value($phone);

            if (!empty($userDetails)) {
                if ($userDetails->otp == $otp) {
                    $_data = array(
                        "updated_at" => date('Y-m-d H:i:s')
                    );

                    $this->user_model->updateUser($userDetails->id, $_data);
                    $this->response['org_info'] = '1';
                    $this->response['message'] = 'update your organisation detail.';
                    $this->response['status'] = 200;

                    $this->response['otp_verification'] = '1';
                } else {
                    $this->response['message'] = array('otp' => 'wrong OTP');

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

    function create_company_at_registration() {
        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('company_name', 'company name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('business_nature', 'nature of business ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('email', 'email ', 'trim|required|valid_email|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == true) {
            $phone = $this->input->post('phone');
            $userDetails = $this->user_model->get_phone_value($phone);
            //$sub_domain = $userDetails->sub_domain;
            $brand_name = preg_replace("/[^a-zA-Z]+/", "", $this->input->post('company_name'));
            $exist_brandObj = $this->user_model->get_user_brand_exist($brand_name);
            if (empty($exist_brandObj)) {
                $sub_domain = $brand_name;
            } else {
                $sub_domain = $brand_name . $userDetails->id;
            }
            $user_data = array(
                'email' => $this->input->post('email'),
                'company_name' => $this->input->post('company_name'),
                'name' => $this->input->post('name'),
                'business_nature' => $this->input->post('business_nature'),
                'sub_domain' => $sub_domain,
                'status' => '1',
            );
            $this->user_model->updateUser($userDetails->id, $user_data);
            $org_data = array(
                'org_name' => $this->input->post('company_name'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->user_model->updateOrganisation($userDetails->org_id, $org_data);
            //add only in organisation
            $_data = array(
                "org_id" => $userDetails->org_id,
                "user_id" => $userDetails->id,
                "username" => $this->input->post('name'),
                "role_id" => '1',
                "added_by" => $userDetails->id,
                "last_updated_by" => $userDetails->id,
                "status" => '2',
                "added_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s'),
            );
            $this->user_model->insertOrgUser($_data);

            $conditions = array('phone' => $userDetails->phone, 'status' => '1');
            $this->user_model->setUserSession($conditions);
            $userDomain = $this->user_model->get_email_value($userDetails->email);
            $this->response['org_info'] = 'verified';
            $this->response['message'] = 'logged in!';
            $this->response['message'] = "Your account has been updated successfully!";
            $this->response['status'] = 200;
        } else {
            $error_msgs = $this->form_validation->error_array();
            $this->response['message'] = $error_msgs;
            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    public function verify_email() {
        $email_code = base64_decode($this->input->get('id'));
        $userDetails = $this->user_model->get_email_code_value($email_code);
        if (!empty($userDetails)) {
            $this->user_model->updateUser($userDetails->id, array('email_code' => '', 'email_verified' => '1', 'status' => '1'));
            $this->session->set_flashdata('flash_success', 'Email verified, please login to use Varthak.');
            redirect('login');
        }
    }

    function pricing() {
        $data = array();
        $data['metatitle'] = 'Varthak - Pricing Plan';
        $data['metadescription'] = 'Reduce your company credit risk, increase sales and improve marketing performance with Varthak pricing plan. Contact us today.';
        $data['metakeyword'] = 'credit card processing, financial planning tool, financial planning app, best accounting app';
        $this->load->view('pricing', $data);
    }

    private function send_otp($user_id, $phone) {

        $user_data['otp'] = rand(900000, 999999);//'123456';

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

        $this->user_model->updateUser($user_id, $user_data);



        return $user_data['otp'];

        exit();
    }

}
