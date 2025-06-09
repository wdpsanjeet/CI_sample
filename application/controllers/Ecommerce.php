<?php

//use PHPMailer\PHPMailer\PHPMailer;
//require 'vendor/autoload.php';
(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of site
 *
 * @author http://www.roytuts.com
 */
class Ecommerce extends MY_Controller {

    private $response = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Ecommerce/user_model');
        $this->load->library('pagination');
    }

    function index($domain_name) {
        $data = array();
        $data['title'] = '';
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        //print_r($orgObj);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['all_sub_category'] = $this->user_model->get_sub_category($org_id);
        $data['featured_category'] = $this->user_model->get_featured_category($org_id);
        $data['all_hotoffer'] = $this->user_model->get_hotoffer_products($org_id);
        //echo $org_id;
        $data['all_top_popular_product'] = $this->user_model->get_either_top_popular_products($org_id);
        
        //print_r($data['all_top_popular_product']);exit;
        $this->load->view('ecommerce/index', $data);
    }

    function about_us($domain_name) {
        $data = array();
        $data['title'] = '';
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['recent_blogs'] = $this->user_model->get_blogs($org_id, '', '3', '0', '', 'added_date', 'DESC');
        $this->load->view('ecommerce/about_us', $data);
    }

    function blogs($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['title'] = $title = $this->input->get('title');
        $data['recent_blogs'] = $this->user_model->get_blogs($org_id, '', '3', '0', '', 'added_date', 'DESC');
        $data['all_blogs'] = $this->user_model->get_blogs($org_id, '', '', '', $title, 'added_date', 'DESC');
        $data['all_tags'] = $this->user_model->get_tags($org_id);
        $this->load->view('ecommerce/blogs', $data);
    }

    function blog_details($domain_name, $blog_id, $blog_title) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['blog_detail'] = $this->user_model->get_blogs_value($blog_id);
        if (empty($data['blog_detail'])) {
            redirect('blogs');
        }
        $data['all_tags'] = $this->user_model->get_tags($org_id);
        $data['recent_blogs'] = $this->user_model->get_blogs($org_id, '', '3', '0', '', 'added_date', 'DESC');
        $data['all_comments'] = $this->user_model->get_comments($blog_id);
        $this->load->view('ecommerce/blog_detail', $data);
    }

    function blog_tags($domain_name, $tag_id, $tag_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['tag_id'] = $tag_id;
        $data['title'] = $title = $this->input->get('title');
        $data['recent_blogs'] = $this->user_model->get_blogs($org_id, '', '3', '0', '', 'added_date', 'DESC');
        $data['all_blogs'] = $this->user_model->get_blogs($org_id, $tag_id, '', '', $title, 'added_date', 'DESC');
        $data['all_tags'] = $this->user_model->get_tags($org_id);
        $this->load->view('ecommerce/blogs', $data);
    }

    function contact_us($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $this->load->view('ecommerce/contact_us', $data);
    }

    function login($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $this->load->view('ecommerce/login', $data);
    }

    function dologin($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('client_mobile', 'client mobile ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $orgObj = $this->user_model->get_organisation_data($domain_name);
                if (isset($orgObj->org_id)) {
                    $data['org_id'] = $org_id = $orgObj->org_id;
                    $data['domain_name'] = $domain_name;
                    $client_mobile = $this->input->post('client_mobile');
                    $userDetails = $this->user_model->get_phone_value($org_id, $client_mobile);
                    if (empty($userDetails)) {
                        $error_msgs = array('client_mobile' => "number not registered, please signup through signup page");
                        $this->response['message'] = $error_msgs;
                        $this->response['status'] = 500;
                    } else {
                        $this->send_otp($userDetails->client_id, $this->input->post('client_mobile'));
                        $this->response['message'] = array('otp' => "Otp has been sent to your mobile number, please verify.");
                        $this->response['status'] = 200;
                    }
                } else {
                    $error_msgs = array('client_mobile' => "Organisation incorrect");
                    $this->response['message'] = $error_msgs;
                    $this->response['status'] = 500;
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

    public function logout($domain_name) {
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $this->session->unset_userdata('user_id');
            $this->session->set_userdata('user_id', '');
            $this->session->sess_destroy();
            redirect($domain_name . '/index.html');
        } else {
            redirect();
        }
    }

    function signup($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $this->load->view('ecommerce/signup', $data);
    }

    public function dosignup($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('client_mobile', 'client mobile ', 'trim|required|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $orgObj = $this->user_model->get_organisation_data($domain_name);
                if (isset($orgObj->org_id)) {
                    $data['org_id'] = $org_id = $orgObj->org_id;
                    $data['domain_name'] = $domain_name;

                    $client_mobile = $this->input->post('client_mobile');
                    $userDetails = $this->user_model->get_phone_value($org_id, $client_mobile);
                    if (empty($userDetails)) {
                        $user_data = array(
                            'user_id' => $orgObj->id,
                            'org_id' => $org_id,
                            'client_mobile' => $this->input->post('client_mobile'),
                            'status' => '0',
                            'added_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $insert_id = $this->user_model->insert_client($user_data);
                        $this->send_otp($insert_id, $this->input->post('client_mobile'));
                        $success = array('otp' => "Otp has been sent to your mobile number, please verify.");
                        $this->response['message'] = $success;
                        $this->response['status'] = 200;
                    } else {
                        if ($userDetails->status == '0') {
                            $this->send_otp($userDetails->client_id, $this->input->post('client_mobile'));
                            $this->response['message'] = "Otp has been sent to your mobile number, please verify.";
                            $this->response['status'] = 200;
                        } else {
                            //check profile is updated or not
                            if ($userDetails->company_name == '') {
                                //navigate user to update company information
                                $conditions = array('client_id' => $userDetails->client_id);
                                $this->user_model->setClientSession($conditions);
                                $this->response['message'] = "update company information.";
                                $this->response['status'] = 300;
                            } else {
                                //navigate to home page
                                $this->response['message'] = "login successfully.";
                                $this->response['status'] = 100;
                            }
                        }
                    }
                } else {
                    $error_msgs = array('client_mobile' => 'Please use organisation.');
                    $this->response['message'] = $error_msgs;
                    $this->response['status'] = 500;
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

    public function verify_otp($domain_name) {
        if ($this->input->is_ajax_request()) {
            $phone = $this->input->post('client_mobile');
            $otp = $this->input->post('otp');

            $orgObj = $this->user_model->get_organisation_data($domain_name);
            if (isset($orgObj->org_id)) {
                $data['org_id'] = $org_id = $orgObj->org_id;
                $data['domain_name'] = $domain_name;
                $user_model = $this->user_model->get_phone_value($org_id, $phone);
                if ($user_model->otp != $otp) {
                    $this->response['message'] = "Incorrect OTP";
                    $this->response['status'] = 400;
                } else {
                    $user_data['otp'] = '';
                    $user_data['status'] = '1';
                    $user_data['otp_verified'] = '1';
                    $user_data['updated_at'] = date('Y-m-d H:i:s');
                    $this->user_model->updateClient($user_model->client_id, $user_data);
                    $this->response['message'] = "OTP verified successfully.";
                    $conditions = array('client_id' => $user_model->client_id);
                    $this->user_model->setClientSession($conditions);

                    $this->response['status'] = 300;
                    //$this->response['redirectUrl'] = base_url('signin');
                }
            } else {
                $this->response['message'] = "Incorrect organisation";
                $this->response['status'] = 400;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    public function login_verify_otp($domain_name) {
        if ($this->input->is_ajax_request()) {
            $phone = $this->input->post('client_mobile');
            $otp = $this->input->post('otp');
            $orgObj = $this->user_model->get_organisation_data($domain_name);
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $user_model = $this->user_model->get_phone_value($org_id, $phone);
            //print_r($user_model);exit;
            if ($user_model->otp != $otp) {
                $this->response['message'] = "Incorrect OTP";
                $this->response['status'] = 400;
            } else {
                $user_data['otp'] = '';
                $user_data['status'] = '1';
                $user_data['otp_verified'] = '1';
                $user_data['updated_at'] = date('Y-m-d H:i:s');
                $this->user_model->updateClient($user_model->client_id, $user_data);
                $this->response['message'] = "OTP verified successfully.";
                $conditions = array('client_id' => $user_model->client_id);
                $this->user_model->setClientSession($conditions);
                if ($user_model->company_name == '') {
                    $this->response['status'] = 300;
                } elseif ($user_model->shop_name == '') {
                    $this->response['status'] = 100;
                } else {
                    $this->response['status'] = 600;
                }

                //$this->response['redirectUrl'] = base_url('signin');
            }
            echo json_encode($this->response);
            exit();
        }
    }

    function resend_otp($domain_name) {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('client_mobile', 'phone ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $orgObj = $this->user_model->get_organisation_data($domain_name);
                if (isset($orgObj->org_id)) {
                    $data['org_id'] = $org_id = $orgObj->org_id;
                    $data['domain_name'] = $domain_name;
                    $phone = $this->input->post('client_mobile');
                    $userDetails = $this->user_model->get_phone_value($org_id, $phone);
                    if (!empty($userDetails)) {
                        $postRequest = array(
                            'mobileNo' => $phone,
                            'otp' => $userDetails->otp
                        );

                        $cURLConnection = curl_init('https://api.flaplive.com/v1/feast-eat/generate-otp');
                        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
                        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                        curl_exec($cURLConnection);
                        curl_close($cURLConnection);
                        $this->response['otp'] = $userDetails->otp;
                        $this->response['message'] = "Otp has been sent to your mobile number, please verify.";
                        $this->response['status'] = 200;
                    } else {
                        $this->response['message'] = 'Not registered.';
                        $this->response['status'] = 400;                   //redirect('admin/login');
                    }
                } else {
                    $this->response['message'] = "Incorrect organisation";
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

    function updatecompanyinfo($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['shop_type'] = $this->user_model->get_shop_type();
        $data['states'] = $this->user_model->get_state_type();
        $this->load->view('ecommerce/update_client_company_information', $data);
    }

    public function doupdatecompanyinfo($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('company_name', 'company name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('shop_phone', 'Contact number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_address_1', 'Address line ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_area', 'Area ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_city', 'city ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_state', 'state ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_pincode', 'pincode ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('shop_type', 'shop type ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_latitude', 'Geo Location ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            //$this->form_validation->set_rules('gst_number', 'gst_number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('tc_check', 'T & C ', 'trim|required|xss_clean', array('required' => 'You must select %s.'));
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $orgObj = $this->user_model->get_organisation_data($domain_name);
                if (isset($orgObj->org_id)) {
                    $data['org_id'] = $org_id = $orgObj->org_id;
                    $data['domain_name'] = $domain_name;
                    $phone = $this->session->userdata('client_mobile');
                    $user_model = $this->user_model->get_active_phone_value($org_id, $phone);

                    $user_data['company_name'] = $this->input->post('company_name');
                    $user_data['client_name'] = $this->input->post('client_name');
                    $user_data['shop_phone'] = $this->input->post('shop_phone');
                    $user_data['client_address'] = $this->input->post('client_address_1') . ', ' . $this->input->post('client_address_2');
                    $user_data['address_line_1'] = $this->input->post('client_address_1');
                    $user_data['address_line_2'] = $this->input->post('client_address_2');
                    $user_data['client_area'] = $this->input->post('client_area');
                    $user_data['client_city'] = $this->input->post('client_city');
                    $user_data['client_state'] = $this->input->post('client_state');
                    $user_data['client_pincode'] = $this->input->post('client_pincode');
                    $user_data['shop_type'] = $this->input->post('shop_type');
                    $user_data['gst_number'] = $this->input->post('gst_number');
                    $user_data['is_whatapp_yes'] = $this->input->post('is_whatapp_yes');

                    $final_address = $user_data['client_address'] . ', ' . $user_data['client_city'] . ', ' . $user_data['client_state'] . '-' . $user_data['client_pincode'];
                    //$latLong = $this->getLatLong($final_address);
                    //$user_data['client_latitude'] = $latLong['latitude'] ? $latLong['latitude'] : 'Not found';
                    //$user_data['client_longitude'] = $latLong['longitude'] ? $latLong['longitude'] : 'Not found';
                    $user_data['client_latitude'] = $this->input->post('client_latitude');
                    $user_data['client_longitude'] = $this->input->post('client_longitude');

                    $user_data['updated_at'] = date('Y-m-d H:i:s');

                    $this->user_model->updateClient($user_model->client_id, $user_data);

                    $conditions = array('client_id' => $user_model->client_id);
                    $this->user_model->setClientSession($conditions);
                    $this->response['message'] = "update shop information";
                    $this->response['status'] = 200;
                } else {
                    $error_msgs = array('tc_check' => 'Incorrect organisation');
                    $this->response['message'] = $error_msgs;
                    $this->response['status'] = 500;
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

    function my_account($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $client_id = $this->session->userdata('client_id');
        if ($client_id == '') {
            redirect(base_url());
        }
        $data['userDetail'] = $this->user_model->get_client_value($client_id);
        $this->load->view('ecommerce/my_account', $data);
    }

    public function update_account($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('client_mobile', 'phone number ', 'trim|required|min_length[10]|max_length[10]|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('client_email', 'email ', 'trim|required|valid_email|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $phone = $this->session->userdata('client_mobile');
                $orgObj = $this->user_model->get_organisation_data($domain_name);
                if (isset($orgObj->org_id)) {
                    $data['org_id'] = $org_id = $orgObj->org_id;
                    $data['domain_name'] = $domain_name;
                    $user_model = $this->user_model->get_active_phone_value($org_id, $phone);

                    $client_mobile = $this->input->post('client_mobile');

                    $client_id = $this->session->userdata('client_id');

                    $userExistDetails = $this->user_model->phone_exist_except_self($org_id, $client_id, $client_mobile);

                    //print_r($userDetails);exit;

                    if (empty($userExistDetails)) {
                        $otp = $this->input->post('otp');
                        if ($otp != '') {
                            // first verify OTP then update
                            $userDetail = $this->user_model->get_client_value($client_id);
                            if ($userDetail->otp == $otp) {
                                $user_data['client_mobile'] = $this->input->post('client_mobile');
                                $user_data['client_email'] = $this->input->post('client_email');
                                $user_data['updated_at'] = date('Y-m-d H:i:s');
                                $user_data['otp'] = '';

                                $this->user_model->updateClient($client_id, $user_data);
                                $this->response['message'] = "profile updated successfully.";
                                $this->response['status'] = 200;
                            } else {
                                $this->response['message'] = array('otp' => 'Please enter correct OTP.');
                                $this->response['status'] = 500;
                            }
                        } else {
                            $this->send_otp($client_id, $this->input->post('client_mobile'));
                            $this->response['message'] = array('otp' => 'OTP sent to your new mobile number.');
                            $this->response['status'] = 400;
                        }
                    } else {
                        $this->response['message'] = array('client_mobile' => 'phone number already registered.');
                        $this->response['status'] = 500;
                    }
                } else {
                    $this->response['message'] = array('client_mobile' => 'Incorrect Organisation.');
                    $this->response['status'] = 500;
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

    function get_city_list($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('id', 'state ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            if ($this->form_validation->run() == TRUE && $flag === 0) {
                $id = $this->input->post('id');
                $city_list = $this->user_model->get_city_type($id);
                $html = '';
                foreach ($city_list as $list) {
                    $html .= '<option value="' . $list->city_name . '">' . $list->city_name . '</option>';
                }
                $this->response['html'] = $html;
                $this->response['status'] = 200;
            } else {
                $error_msgs = $this->form_validation->error_array();
                $this->response['message'] = $error_msgs;
                $this->response['status'] = 500;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    function cart($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $client_id = $this->session->userdata('client_id');
        $data['cart_items'] = $this->user_model->get_carts($client_id);
        $this->load->view('ecommerce/cart', $data);
    }

    function add_to_cart($domain_name) {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('quantity', 'quantity ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
            $this->form_validation->set_rules('product_id', 'product_id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $client_id = $this->session->userdata('client_id');
                if ($client_id == '') {
                    $this->response['message'] = ' Please signin before any activaty!';
                    $this->response['status'] = 500;
                } else {
                    if ($this->input->post('quantity') > 0) {
                        $_data = array(
                            "client_id" => $client_id,
                            "product_id" => (int) $this->input->post('product_id'),
                            "quantity" => (int) $this->input->post('quantity'),
                            "added_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s'),
                        );
                        $this->user_model->delete_client_cart_item($client_id, $this->input->post('product_id'));
                        $insert_id = $this->user_model->insert_cart($_data);
                        $cart_items_detail = $this->user_model->get_cart_value($insert_id);
                        //$cart_tot_price =$this->user_model->get_cart_total_value($client_id);
                        $this->response['item_total_price'] = 'INR ' . number_format(($cart_items_detail->price * $cart_items_detail->quantity - ($cart_items_detail->price * $cart_items_detail->quantity * $cart_items_detail->discount_percentage / 100) + ($cart_items_detail->price * $cart_items_detail->quantity * $cart_items_detail->gst_percentage / 100)), 2, '.', '');
                        $cart_items = $this->user_model->get_carts($client_id);
                        $total_price = 0;
                        foreach ($cart_items['result'] as $list) {
                            $item_total_price = number_format(($list->price * $list->quantity - ($list->price * $list->quantity * $list->discount_percentage / 100) + ($list->price * $list->quantity * $list->gst_percentage / 100)), 2, '.', '');
                            $total_price += $item_total_price;
                        }
                        $shipping_charge = ($total_price > 500) ? '0' : '50';
                        $this->response['cart_tot_price'] = number_format(($total_price), 2, '.', '');
                        $this->response['shipping_charges'] = number_format(($shipping_charge), 2, '.', '');
                        $this->response['order_amount'] = number_format(($total_price + $shipping_charge), 2, '.', '');
                        $this->response['message'] = 'Item added successfully to your cart.';
                        $this->response['status'] = 200;
                    } else {
                        $this->response['message'] = 'you can delete item.';
                        $this->response['status'] = 500;
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

    function remove_to_cart($domain_name) {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('product_id', 'product_id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $client_id = $this->session->userdata('client_id');
                $this->user_model->delete_client_cart_item($client_id, $this->input->post('product_id'));
                $cart_items = $this->user_model->get_carts($client_id);
                $total_price = 0;
                foreach ($cart_items['result'] as $list) {
                    $item_total_price = number_format(($list->price * $list->quantity - ($list->price * $list->quantity * $list->discount_percentage / 100) + ($list->price * $list->quantity * $list->gst_percentage / 100)), 2, '.', '');
                    $total_price += $item_total_price;
                }
                $shipping_charge = ($total_price > 500) ? '0' : '50';
                $this->response['cart_tot_price'] = number_format($total_price, 2, '.', '');
                $this->response['shipping_charges'] = number_format(($shipping_charge), 2, '.', '');
                $this->response['order_amount'] = number_format(($total_price + $shipping_charge), 2, '.', '');
                $this->response['message'] = 'Item deleted successfully.';
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

    function place_cart_order($domain_name) {
        if ($this->input->is_ajax_request()) {

            $orgObj = $this->user_model->get_organisation_data($domain_name);
            if (isset($orgObj->org_id)) {
                $data['org_id'] = $org_id = $orgObj->org_id;
                $data['domain_name'] = $domain_name;
                $client_id = $this->session->userdata('client_id');
                $cart_items = $this->user_model->get_carts($client_id);
                if ($cart_items['total'] > 0) {
                    $clientDetail = $this->user_model->get_client_value($client_id);
                    $_data = array(
                        "client_id" => $client_id,
                        "invoice_id" => time(),
                        "transaction_id" => time(),
                        "payment_type" => '3',
                        "org_id" => $org_id,
                        "shipping_address" => $clientDetail->client_address . ', ' . $clientDetail->client_area . ', ' . $clientDetail->client_city . ', ' . $clientDetail->client_state . '-' . $clientDetail->client_pincode,
                        //"shipping_city" => $clientDetail->shop_address,
                        //"shipping_state" => $clientDetail->shop_address,
                        //"shipping_pincode" => $clientDetail->shop_address,
                        "billing_address" => $clientDetail->client_address,
                        "billing_city" => $clientDetail->client_city,
                        "billing_state" => $clientDetail->client_state,
                        "billing_pincode" => $clientDetail->client_pincode,
                        "order_status" => '1',
                        "added_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                    );
                    $insert_id = $this->user_model->insert_order($_data);
                    $total_price = 0;
                    foreach ($cart_items['result'] as $list) {
                        $gst_price = ($list->price * $list->quantity * $list->gst_percentage) / 100;
                        $total_price += ($list->price * $list->quantity) + $gst_price;

                        $_order_detail_data = array();
                        $_order_detail_data = array(
                            "order_id" => $insert_id,
                            "product_id" => $list->product_id,
                            "quantity" => $list->quantity,
                            "product_price" => $list->price,
                            "gst_price" => $gst_price,
                            "total_price" => ($list->price * $list->quantity) + $gst_price,
                        );
                        $this->user_model->insert_order_detail($_order_detail_data);
                    }
                    $this->user_model->updateOrder($insert_id, array('total_price' => $total_price));
                    $this->user_model->empty_client_cart_item($client_id);
                    $this->response['message'] = 'Order has been placed to your cart.';
                    $this->response['status'] = 200;
                } else {
                    $this->response['message'] = 'Please add items in your cart before place the order.';
                    $this->response['status'] = 500;
                }
            } else {
                $this->response['message'] = 'Incorrect organisation.';
                $this->response['status'] = 500;
            }
        }
        echo json_encode($this->response);
        exit();
    }

    function products($domain_name = '', $page_number = '') {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['product_title'] = $product_title = $this->input->get('product_title');
        $data['order_by'] = $order_by = $this->input->get('order_by');
        $data['order_column'] = $order_column = $this->input->get('order_column');
        $data['max_price'] = $max_price = $this->input->get('max_price');
        $data['rating'] = $rating = $this->input->get('rating');
        $data['gst_status'] = $gst_status = $this->input->get('gst_status');
        $data['all_sub_category'] = $this->user_model->get_sub_category($org_id);

        $data['all_products'] = $this->user_model->get_products($org_id, '', '', '', $order_column, $order_by, $product_title, $max_price, $rating);
        $config['total_rows'] = $data['all_products']['total'];
        $data['total_count'] = $config['total_rows'];
        $config['suffix'] = '';
        $data['page_links'] = '';
        if ($config['total_rows'] > 0) {
            $page_number = $this->uri->segment(3);

            if ($page_number > 0) {
                $config['base_url'] = base_url() . $domain_name . '/products';
            } else {
                $config['base_url'] = base_url() . $domain_name . '/products';
            }
            if (empty($page_number))
                $page_number = 1;
            $offset = ($page_number - 1) * $this->pagination->per_page;
            $this->user_model->setPageNumber($this->pagination->per_page);
            $this->user_model->setOffset($offset);
            $this->pagination->cur_page = $page_number;
            $config['attributes'] = array('class' => 'page-link');
            $this->pagination->initialize($config);
            $data['page_links'] = $this->pagination->create_links();
            if ($page_number == 2) {
                // print_r($data['page_links']);exit;
            }
            $data['all_products'] = $this->user_model->get_products($org_id, '', '', '', $order_column, $order_by, $product_title, $max_price, $rating);
        }


        $data['featured_category'] = $this->user_model->get_featured_category($org_id);
        $this->load->view('ecommerce/products', $data);
    }

    function products_by_category($domain_name = '', $category_id, $category_title, $page_number = '') {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['category_id'] = $category_id;
        $data['category_title'] = $category_title;
        $data['product_title'] = $product_title = $this->input->get('product_title');
        $data['order_by'] = $order_by = $this->input->get('order_by');
        $data['order_column'] = $order_column = $this->input->get('order_column');
        $data['max_price'] = $max_price = $this->input->get('max_price');
        $data['rating'] = $rating = $this->input->get('rating');
        $data['gst_status'] = $gst_status = $this->input->get('gst_status');
        $data['all_sub_category'] = $this->user_model->get_sub_category($org_id);
        $data['all_products'] = $this->user_model->get_products($org_id, '', '', array('category_id' => $category_id), $order_column, $order_by, $product_title, $max_price, $rating);
        //$data['all_products'] = $this->user_model->get_products('', '', '', $order_column, $order_by, $product_title, $max_price, $rating);
        $config['total_rows'] = $data['all_products']['total'];
        $data['total_count'] = $config['total_rows'];
        $config['suffix'] = '';
        if ($config['total_rows'] > 0) {
            $page_number = $this->uri->segment(5);

            if ($page_number > 0) {
                $config['base_url'] = base_url() . $domain_name . '/products-by-category/' . $category_id . '/' . $category_title;
            } else {
                $config['base_url'] = base_url() . $domain_name . '/products-by-category/' . $category_id . '/' . $category_title;
            }
            if (empty($page_number))
                $page_number = 1;
            $offset = ($page_number - 1) * $this->pagination->per_page;
            $this->user_model->setPageNumber($this->pagination->per_page);
            $this->user_model->setOffset($offset);
            $this->pagination->cur_page = $page_number;
            $config['attributes'] = array('class' => 'page-link');
            $this->pagination->initialize($config);
            $data['page_links'] = $this->pagination->create_links();
            if ($page_number == 2) {
                // print_r($data['page_links']);exit;
            }
            $data['all_products'] = $this->user_model->get_products($org_id, '', '', array('category_id' => $category_id), $order_column, $order_by, $product_title, $max_price, $rating);
        }


        $data['featured_category'] = $this->user_model->get_featured_category($org_id);
        //print_r($data['all_products']);exit;
        $this->load->view('ecommerce/products', $data);
    }

    function product_detail($domain_name = '', $product_id, $title) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $data['productDetail'] = $this->user_model->get_product_value($org_id, $product_id);
        //print_r($data['productDetail']);exit;
        if (empty($data['productDetail'])) {
            redirect(base_url($domain_name) . '/index.html');
        }
        $data['product_comments'] = $this->user_model->get_product_comments($org_id, $product_id, '', '', '', 'added_at', 'DESC');
        $this->load->view('ecommerce/product_detail', $data);
    }

    function order_list($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $client_id = $this->session->userdata('client_id');
        if ($client_id == '') {
            redirect(base_url($domain_name . 'index.html'));
        }
        $data['orders'] = $this->user_model->get_orders($client_id);
        $this->load->view('ecommerce/order_list', $data);
    }

    function order_detail($domain_name, $order_id) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $client_id = $this->session->userdata('client_id');
        if ($client_id == '') {
            redirect(base_url($domain_name . 'index.html'));
        }
        $data['orderDetail'] = $this->user_model->get_order_value($order_id, $client_id);
        if (empty($data['orderDetail'])) {
            redirect(base_url($domain_name . '/index.html'));
        }
        $data['orderItems'] = $this->user_model->get_order_items($order_id);
        $this->load->view('ecommerce/order_detail', $data);
    }

    function cancel_order($domain_name) {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('order_id', 'order id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

            if ($this->form_validation->run() == TRUE) {
                $client_id = $this->session->userdata('client_id');
                $this->user_model->updateOrder($this->input->post('order_id'), array('order_status' => '4', 'updated_at' => date('Y-m-d H:i:s')));
                $this->response['message'] = 'Order has been cancelled.';
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

    function wish_list($domain_name) {
        $data = array();
        $orgObj = $this->user_model->get_organisation_data($domain_name);
        if (isset($orgObj->org_id)) {
            $data['org_id'] = $org_id = $orgObj->org_id;
            $data['domain_name'] = $domain_name;
            $data['title'] = $domain_name;
        } else {
            redirect();
        }
        $client_id = $this->session->userdata('client_id');
        if ($client_id == '') {
            redirect(base_url($domain_name . 'index.html'));
        }
        $data['all_favorites'] = $this->user_model->get_favorites($client_id);
        $data['featured_category'] = $this->user_model->get_featured_category($org_id);
        $this->load->view('ecommerce/wish_list', $data);
    }

    public function makeitfavorite($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $user_data['client_id'] = $this->session->userdata('client_id');
            if ($user_data['client_id'] != '') {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
                if ($this->form_validation->run() == TRUE && $flag === 0) {
                    $user_data['product_id'] = $this->input->post('product_id');
                    if ($this->user_model->is_product_added_favorite($user_data['product_id'], $user_data['client_id'])) {
                        $this->response['message'] = "Product is already added in your favorite list.";
                        $this->response['status'] = 500;
                    } else {
                        $this->user_model->insert_client_favorite($user_data);
                        $this->response['message'] = "Product is added in your favorite list.";
                        $this->response['status'] = 200;
                    }
                } else {
                    $this->response['message'] = "Please login or register in the website before add to any product in your favorite list.";
                    ;
                    $this->response['status'] = 500;
                }
            } else {
                $this->response['message'] = "Please login or register in the website before add to any product in your favorite list.";
                $this->response['status'] = 500;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    public function removeitfavorite($domain_name) {
        if ($this->input->is_ajax_request()) {
            $flag = 0;
            $client_id = $this->session->userdata('client_id');
            if ($client_id != '') {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
                if ($this->form_validation->run() == TRUE && $flag === 0) {
                    $product_id = $this->input->post('product_id');
                    if ($this->user_model->is_product_added_favorite($product_id, $client_id)) {
                        $this->user_model->delete_client_favorite($client_id, $product_id);
                        $this->response['message'] = "Product is deleted from your favorite list.";
                        $this->response['status'] = 200;
                    } else {
                        $this->response['message'] = "Product is not added in your favorite list.";
                        $this->response['status'] = 200;
                    }
                } else {
                    $this->response['message'] = "Please login or register in the website before add to any product in your favorite list.";
                    ;
                    $this->response['status'] = 500;
                }
            } else {
                $this->response['message'] = "Please login or register in the website before add to any product in your favorite list.";
                $this->response['status'] = 500;
            }
            echo json_encode($this->response);
            exit();
        }
    }

    private function send_otp($client_id, $phone) {

        $user_data['otp'] = rand(9000, 9999);//'1234';//

        //send SMS

        $postRequest = array(
            'mobileNo' => $phone,
            'otp' => $user_data['otp']
        );



//        $cURLConnection = curl_init('https://api.flaplive.com/v1/feast-eat/generate-otp');
//
//        curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
//
//        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
//
//
//
//        $apiResponse = curl_exec($cURLConnection);
//
//        curl_close($cURLConnection);

        $user_data['updated_at'] = date('Y-m-d H:i:s');

        $this->user_model->updateClient($client_id, $user_data);



        return $user_data['otp'];

        exit();
    }

}
