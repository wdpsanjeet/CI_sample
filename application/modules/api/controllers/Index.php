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

        $this->form_validation->set_rules('name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('truck_number', 'truck number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        //$this->form_validation->set_rules('personal_pic', '', 'trim|required', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('truck_pic', '', 'trim|required', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('company_code', 'company code ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        //$this->form_validation->set_rules('company_code', 'company code ', 'callback_companycode_validation');


        if ($this->form_validation->run() == TRUE) {

            $phone = $this->input->post('phone');

            $userDetails = $this->index_model->get_phone_value($phone);

            if (!empty($userDetails)) {
                if ($userDetails->status == '0') {
                    $opt = $this->send_otp($userDetails->driver_id, $this->input->post('phone'));

                    $this->response['otp'] = $opt;

                    $user_details = array("driver_id" => $userDetails->driver_id, "company_code" => $this->input->post('company_code'), "phone" => $this->input->post('phone'), "name" => $this->input->post('name'), "truck_number" => $this->input->post('truck_number'), "personal_pic" => base_url() . '/uploads/profile_img/original/' . $userDetails->personal_pic, "truck_pic" => base_url() . '/uploads/truck_img/original/' . $userDetails->truck_pic, "status" => '0',"org_id" => $userDetails->org_id);

                    $this->response['userDetails'] = $user_details;

                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
                } else {
                    $this->response['message'] = 'user already exist.';

                    $this->response['status'] = 400;
                }
            } else {

                $response = $this->index_model->get_company_code_value($this->input->post('company_code'));
                if ($response) {
                    $this->response['message'] = array('invalid company code');

                    $this->response['status'] = 400;
                } else {
                    $org_id = $this->index_model->get_company_code_value_data($this->input->post('company_code'));
                    $_data = array(
                        "company_code" => $this->input->post('company_code'),
                        "org_id" => $org_id,
                        "phone" => $this->input->post('phone'),
                        "name" => $this->input->post('name'),
                        "truck_number" => $this->input->post('truck_number'),
                        "status" => '0',
                        "added_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s')
                    );

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

                    $extension1 = pathinfo($_FILES['truck_pic']['name'], PATHINFO_EXTENSION);

                    $truck_pic_filename = 'truck_pic_' . rand(10, 500) . time() . '.' . $extension1;

                    $config1 = array(
                        'upload_path' => "./uploads/truck_img/original/",
                        'allowed_types' => "gif|jpg|png|jpeg",
                        'overwrite' => TRUE,
                        'file_name' => $truck_pic_filename,
                    );

                    $this->load->library('upload', $config1);

                    $this->upload->initialize($config1);

                    $this->upload->do_upload('truck_pic');

                    if (isset($personal_pic_filename)) {

                        $_data['personal_pic'] = $personal_pic_filename;
                    }

                    if (isset($truck_pic_filename)) {

                        $_data['truck_pic'] = $truck_pic_filename;
                    }



                    $insert_id = $this->index_model->insertDriver($_data);

                    $opt = $this->send_otp($insert_id, $this->input->post('phone'));

                    $this->response['otp'] = $opt;

                    $userDetails = array("driver_id" => $insert_id, "company_code" => $this->input->post('company_code'), "phone" => $this->input->post('phone'), "name" => $this->input->post('name'), "truck_number" => $this->input->post('truck_number'), "personal_pic" => base_url() . '/uploads/profile_img/original/' . $personal_pic_filename, "truck_pic" => base_url() . '/uploads/truck_img/original/' . $truck_pic_filename, "status" => '0',"org_id" => $org_id);

                    $this->response['userDetails'] = $userDetails;

                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
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



        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $phone = $this->input->post('phone');

            if ($phone == '9999999999') {
                $userDetails = $this->index_model->get_active_phone_value($phone);
                $this->response['otp'] = '1234';

                $this->response['userDetails'] = $userDetails;

                $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                $this->response['status'] = 200;
            } else {
                $userDetails = $this->index_model->get_active_phone_value($phone);

                if (!empty($userDetails)) {

                    $opt = $this->send_otp($userDetails->driver_id, $phone);

                    $this->response['otp'] = $opt;

                    $this->response['userDetails'] = $userDetails;

                    $this->response['message'] = "Otp has been sent to your mobile number, please verify.";

                    $this->response['status'] = 200;
                } else {

                    $this->response['message'] = 'Not registered.';

                    $this->response['status'] = 400;                   //redirect('admin/login');
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

    function resend_otp() {



        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $phone = $this->input->post('phone');

            $userDetails = $this->index_model->get_phone_value($phone);

            if (!empty($userDetails)) {

                $opt = $this->send_otp($userDetails->driver_id, $phone);

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

        $this->form_validation->set_rules('driver_id', 'driver id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $_data = array(
                "otp" => '',
                "otp_verified" => '1',
                "status" => '1',
                "updated_at" => date('Y-m-d H:i:s')
            );

            $this->index_model->updateDriver($this->input->post('driver_id'), $_data);

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

        $this->form_validation->set_rules('driver_id', 'driver id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('name', 'name ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('phone', 'phone ', 'trim|required|is_natural|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('truck_number', 'truck number ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        $this->form_validation->set_rules('company_code', 'company code ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $phone = $this->input->post('phone');

            $driver_id = $this->input->post('driver_id');

            $userExistDetails = $this->index_model->phone_exist_except_self($driver_id, $phone);

            //print_r($userDetails);exit;

            if (empty($userExistDetails)) {

                $userDetails = $this->index_model->get_user_value($driver_id);

                $user_truck_pic_path = base_url() . 'uploads/truck_img/original/' . $userDetails->truck_pic;

                $_data = array(
                    "company_code" => $this->input->post('company_code'),
                    "phone" => $this->input->post('phone'),
                    "name" => $this->input->post('name'),
                    "truck_number" => $this->input->post('truck_number'),
                    "updated_at" => date('Y-m-d H:i:s')
                );

//echo $_FILES['truck_pic']['name'];exit;

                if (isset($_FILES['truck_pic']['name']) && ($_FILES['truck_pic']['name'] != '')) {

                    $allowed = array('png', 'jpg', 'gif', 'jpeg');

                    $extension = pathinfo($_FILES['truck_pic']['name'], PATHINFO_EXTENSION);

                    //exit;

                    if (!in_array(strtolower($extension), $allowed)) {

                        $error = 'Only the png,jpeg,jpg,gif type of file supported.';
                    } else {

                        $truck_pic_filename = 'truck_pic_' . rand(10, 500) . time() . '.' . $extension;

                        $config = array(
                            'upload_path' => "./uploads/truck_img/original/",
                            'allowed_types' => "gif|jpg|png|jpeg",
                            'overwrite' => TRUE,
                            'file_name' => $truck_pic_filename,
                        );

                        $this->load->library('upload', $config);

                        $this->upload->initialize($config);

                        $this->upload->do_upload('truck_pic');

                        //unset($config);
                    }
                }

                if (empty($error)) {

                    if (isset($truck_pic_filename)) {

                        $_data['truck_pic'] = $truck_pic_filename;

                        $user_truck_pic_path = base_url() . 'uploads/truck_img/original/' . $truck_pic_filename;
                    }



                    $this->index_model->updateDriver($driver_id, $_data);

                    //$opt = $this->send_otp($driver_id, $phone);
                    //$this->response['otp'] = $opt;

                    $userDetails = array("driver_id" => $driver_id, "company_code" => $this->input->post('company_code'), "phone" => $this->input->post('phone'), "name" => $this->input->post('name'), "truck_number" => $this->input->post('truck_number'), "truck_pic" => $user_truck_pic_path);

                    $this->response['userDetails'] = $userDetails;

                    $this->response['message'] = "Your account has been updated successfully.";

                    $this->response['status'] = 200;
                } else {

                    $this->response['message'] = $error;

                    $this->response['status'] = 400;
                }
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

        $this->form_validation->set_rules('driver_id', 'driver id  ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');

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

            $this->index_model->updateDriver($driver_id, $_data);

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

    private function send_otp($user_id, $phone) {

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

        $this->index_model->updateDriver($user_id, $user_data);

        return $user_data['otp'];

        exit();
    }

    function personal_pic_check($str) {

        $allowed_mime_type_arr = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');

        $mime = get_mime_by_extension($_FILES['personal_pic']['name']);

        if (isset($_FILES['personal_pic']['name']) && $_FILES['personal_pic']['name'] != "") {

            if (in_array($mime, $allowed_mime_type_arr)) {

                return true;
            } else {

                $this->form_validation->set_message('personal_pic_check', 'Please select only jpg/png file.');

                return false;
            }
        } else {

            $this->form_validation->set_message('personal_pic_check', 'Please choose a file to upload.');

            return false;
        }
    }

    function truck_pic_check($str) {

        $allowed_mime_type_arr = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');

        $mime = get_mime_by_extension($_FILES['truck_pic']['name']);

        if (isset($_FILES['truck_pic']['name']) && $_FILES['truck_pic']['name'] != "") {

            if (in_array($mime, $allowed_mime_type_arr)) {

                return true;
            } else {

                $this->form_validation->set_message('truck_pic_check', 'Please select only jpg/png file.');

                return false;
            }
        } else {

            $this->form_validation->set_message('truck_pic_check', 'Please choose a file to upload.');

            return false;
        }
    }

    function active_trip() {



        $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');

            $activeTrip = $this->index_model->get_active_trip_by_drive_id($driver_id);

            if (!empty($activeTrip)) {
                $i = 1;
                $trips = array();
                foreach ($activeTrip as $list) {
                    $trip_location = array();
                    $j = 1;
                    $trip_locObj = $this->index_model->get_active_trip_detail_by_assigned_trip_id($list->assigned_trip_id);
                    foreach ($trip_locObj as $loc) {
                        $trip_location[] = array('location' => 'Location ' . $this->convertDigit($j), 'driver_trip_clients_id' => $loc->driver_trip_clients_id, 'client_trip_status' => $loc->client_trip_status, 'client_name' => $loc->client_name, 'client_address' => $loc->client_address, 'client_mobile' => $loc->client_mobile, 'client_latitude' => $loc->client_latitude, 'client_longitude' => $loc->client_longitude);
                        $j++;
                    }
                    $trips[] = array('trip-name' => 'Trip ' . $this->convertDigit($i), 'assigned_trip_id' => $list->assigned_trip_id, 'driver_accepted' => $list->driver_accepted, 'trip-location' => $trip_location);
                    $i++;
                }
                $this->response['activeTrip'] = $trips;

                $this->response['message'] = "This is your active trip.";

                $this->response['status'] = 200;
            } else {

                $this->response['message'] = 'No active trip.';

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

    function trip_locations_by_assigned_trip_id() {



        $this->form_validation->set_rules('assigned_trip_id', 'assigned trip id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $assigned_trip_id = $this->input->post('assigned_trip_id');
            $trip_location = array();
            $j = 1;
            $trip_locObj = $this->index_model->get_active_trip_detail_by_assigned_trip_id($assigned_trip_id);
            foreach ($trip_locObj as $loc) {
                $trip_location[] = array('location' => 'Location ' . $this->convertDigit($j), 'driver_trip_clients_id' => $loc->driver_trip_clients_id, 'client_trip_status' => $loc->client_trip_status, 'client_name' => $loc->client_name, 'client_address' => $loc->client_address, 'client_mobile' => $loc->client_mobile, 'client_latitude' => $loc->client_latitude, 'client_longitude' => $loc->client_longitude);
                $j++;
            }
            $this->response['activeTripLocations'] = $trip_location;
            //start API changed
            $warehouseLocation = $this->index_model->get_warehouse_return_and_location_detail_by_assigned_trip_id($assigned_trip_id);
            $this->response['warehouseLocation'] = array('warehouse_address' => $warehouseLocation->warehouse_address, 'client_latitude' => $warehouseLocation->warehouse_lat, 'client_longitude' => $warehouseLocation->warehouse_long);
            $this->response['isTripReturn'] = $warehouseLocation->is_return_warehouse; //1=return,0= not return
            //end API changed
            $this->response['message'] = "This is your trip locations.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function active_trip_update() {



        $this->form_validation->set_rules('assigned_trip_id', 'assigned trip id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('driver_accepted', 'driver acceptance ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $assigned_trip_id = $this->input->post('assigned_trip_id');
            $_data = array(
                'driver_accepted' => $this->input->post('driver_accepted'),
            );
            $this->index_model->active_trip_update($assigned_trip_id, $_data);
            $this->response['message'] = "trip is updated.";
            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function update_client_trip() {



        $this->form_validation->set_rules('driver_trip_clients_id', 'driver trip clients id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('client_trip_status', 'client trip status ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('distance', 'distance ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('total_time', 'total_time ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $driver_trip_clients_id = $this->input->post('driver_trip_clients_id');
            $_data = array(
                'trip_status' => $this->input->post('client_trip_status'),
                'distance' => $this->input->post('distance'),
                'total_time' => $this->input->post('total_time'),
            );
            $this->index_model->update_client_trip($driver_trip_clients_id, $_data);
            $deleveriesObj = $this->index_model->get_driver_trip_clients_by_driver_trip_clients_id($driver_trip_clients_id);
            if ($deleveriesObj->type == 0) {
                $company_name = $deleveriesObj->company_name;
                $client_mobile = $deleveriesObj->client_mobile;
                $location_address = $deleveriesObj->client_address;
            } else {
                $company_name = $deleveriesObj->customer_name;
                $client_mobile = $deleveriesObj->mobile_number;
                $location_address = $deleveriesObj->address;
            }
            $_data1 = array(
                'user_id' => $this->input->post('client_trip_status'),
                'notification' => $deleveriesObj->driver_name . ' DROP OFF the delivery for client ' . $company_name . '. Please re-very from client, Client mobile number is ' . $client_mobile . '.',
                'added_at' => date('Y-m-d H:i:s'),
            );
            $this->index_model->insert_user_notification($_data1);
            $this->response['message'] = "trip is updated.";
            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function update_trip_completed() {
        $this->form_validation->set_rules('assigned_trip_id', 'assigned trip id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $assigned_trip_id = $this->input->post('assigned_trip_id');
            $_data = array(
                'is_trip_completed' => '1',
            );
            $this->index_model->active_trip_update($assigned_trip_id, $_data);
            $tripObj = $this->index_model->get_driver_assigned_trip_by_trip_id($assigned_trip_id);
            $total_amount = 2 * $tripObj->total_distance;
            $_Pdata = array(
                'assigned_trip_id' => $this->input->post('assigned_trip_id'),
                'total_kilometer' => $tripObj->total_distance,
                'total_amount' => $total_amount,
                'payment_status' => '0',
            );
            $this->index_model->insert_payment($_Pdata);
            $this->response['message'] = "trip is completed.";
            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function start_trip() {
        $this->form_validation->set_rules('assigned_trip_id', 'assigned trip id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $assigned_trip_id = $this->input->post('assigned_trip_id');
            $_data = array(
                'is_trip_started' => '1',
            );
            $this->index_model->active_trip_update($assigned_trip_id, $_data);

            $this->response['message'] = "trip is started.";
            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function past_trip() {



        $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');

            $pastTrip = $this->index_model->get_past_trip_by_drive_id($driver_id);

            if (!empty($pastTrip)) {
                $i = 1;
                $past_trip = array();
                foreach ($pastTrip as $list) {
                    $tipDetailObj = $this->index_model->get_trip_detail_by_assigned_trip_id($list->assigned_trip_id);
                    $past_trip[] = array('message' => 'You have completed the trip of ' . $tipDetailObj->total_kilometer . ' KM on ' . date('d/m/Y', strtotime($list->assigned_date)) . ' and your trip payment is ' . $tipDetailObj->total_amount);
                    $i++;
                }
                $this->response['pastTrip'] = $past_trip;

                $this->response['message'] = "This is your past trip.";

                $this->response['status'] = 200;
            } else {

                $this->response['message'] = 'No past trip.';

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

    function notification() {



        $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');

            $driverNoti = $this->index_model->get_notification_by_drive_id($driver_id);

            if (!empty($driverNoti)) {
                $i = 1;
                $past_trip = array();
                foreach ($driverNoti as $list) {
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

    function get_payments() {



        $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));

        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');
            $filter['from_date'] = $this->input->post('from_date');
            $filter['to_date'] = $this->input->post('to_date');
            $filter['payment_status'] = $this->input->post('payment_status');

            $paymentTrip = $this->index_model->get_payments_by_drive_id($driver_id, $filter);

            if (!empty($paymentTrip)) {

                $this->response['tripPayments'] = $paymentTrip;

                $this->response['message'] = "This is your trip payments.";

                $this->response['status'] = 200;
            } else {

                $this->response['message'] = 'No active trip.';

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

    function payment_request() {
        $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');
            $_data = array(
                'driver_id' => $driver_id,
                'message' => 'driver requested you for payment',
                'added_at' => date('Y-m-d H:i:s')
            );
            $this->index_model->insertPaymentrequest($_data);

            $this->response['message'] = "Your request has been sent to company.";

            $this->response['status'] = 200;
        } else {

            $error_msgs = $this->form_validation->error_array();

            $this->response['message'] = $error_msgs;

            $this->response['status'] = 400;
        }

        echo json_encode($this->response);

        exit();
    }

    function online_status_update() {
        $this->form_validation->set_rules('driver_id', 'driver id ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        $this->form_validation->set_rules('online_status', 'online status ', 'trim|required|xss_clean', array('required' => 'You must provide your %s.'));
        if ($this->form_validation->run() == TRUE) {

            $driver_id = $this->input->post('driver_id');
            $_data = array(
                'online_status' => $this->input->post('online_status')
            );
            $this->index_model->updateDriver($driver_id, $_data);

            $this->response['message'] = "Your status has been updated.";

            $this->response['status'] = 200;
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
