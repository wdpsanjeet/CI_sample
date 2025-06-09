<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_function {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($string)); // Removes special chars.
    }

    function randomNumber($length) {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    function random_strings($length_of_string) {

        // String of all alphanumeric character 
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shufle the $str_result and returns substring 
        // of specified length 
        $result = substr(str_shuffle($str_result), 0, $length_of_string);
        $strspecial_result = $result . '!@#$()_/|*';
        return substr(str_shuffle($strspecial_result), 0, $length_of_string + 3);
    }

    function random_stringsNumber($length_of_string) {

        // String of all alphanumeric character 
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    function redirectPreviousPage() {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: http://' . $_SERVER['SERVER_NAME']);
        }

        exit;
    }

    function limit_HTMLtext($HTML, $limit) {
        $text = strip_tags($HTML);
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    function send_mail($to_emailid, $reply_to, $mail_subject, $body) {
        $to = $to_emailid;
        $subject = $mail_subject;
        $from = 'support@varthak.io';
        $reply_to = 'support@varthak.io';

// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $reply_to . "\r\n" .
                'X-Mailer: Varthak/';

// Compose a simple HTML email message
        $message = $body;

// Sending email
        if (@mail($to, $subject, $message, $headers)) {
            return '1';
        } else {
            return '0';
        }
    }

    function get_tips_by_type_value($id) {
        return $this->CI->db->select('*')
                        ->from(TBL_TIPS)->where('tips_type_id', $id)->get()->result();
    }

    function get_cms_by_page_section_type($org_id='',$page = '', $section = '', $type = 'text') {
        $obj = $this->CI->db->select('*')
                        ->from(TBL_CMS)->where('org_id', $org_id)->where('page_name', $page)
                        ->where('section', $section)
                        ->where('type', $type)->get()->row_object();

        if (is_object($obj) > 0) {
            if ($type == 'image') {
                return site_url() . 'uploads/banners/original/' . $obj->cms_data;
            } elseif ($type == 'rating') {
                $star_html = '';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $obj->cms_data) {
                        $star_html .= '<i class="fa fa-star" aria-hidden="true"></i>';
                    } else {
                        $star_html .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                    }
                }
                return $star_html;
            } else {
                return $obj->cms_data;
            }
        } else {
            return '';
        }
    }

    function get_slug_by_id($id = '') {
        $obj = $this->CI->db->select('*')
                        ->from(TBL_SETTINGS)->where('set_id', $id)->get()->row_object();

        if (is_object($obj) > 0) {
            return $obj->slug_data;
        } else {
            return '';
        }
    }

    function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch ($unit) {
            case 'miles':
                break;
            case 'kilometers' :
                $distance = $distance * 1.609344;
        }
        return (round($distance, 2));
    }

    function get_driver_total_driven($driver_id) {
        $result = $this->CI->db->select('SUM(total_distance) as TotNum')
                        ->from(TBL_DRIVERASSIGNEDTRIP)->where('driver_accepted', '1')->where('is_trip_completed', '1')->where('driver_id', $driver_id)->get()->row_object();
        return $result->TotNum;
    }

    function get_driver_total_driven_trip($driver_id) {
        $result = $this->CI->db->select('COUNT(assigned_trip_id) as TotNum')
                        ->from(TBL_DRIVERASSIGNEDTRIP)->where('driver_accepted', '1')->where('is_trip_completed', '1')->where('driver_id', $driver_id)->get()->row_object();
        return $result->TotNum;
    }

    function get_driver_total_deliveries($driver_id) {
        $result = $this->CI->db->select('COUNT(driver_trip_clients_id) as TotNum')
                        ->from(TBL_DRIVERASSIGNEDTRIP . ' as dat')->join(TBL_DRIVERTRIPCLIENT . ' as dtc', 'dtc.assigned_trip_id=dat.assigned_trip_id')->where('dat.driver_accepted', '1')->where('dat.is_trip_completed', '1')->where('dtc.trip_status', '1')->where('dat.driver_id', $driver_id)->get()->row_object();
        return $result->TotNum;
    }

    function get_driver_total_paid_pending($driver_id) {
        return $this->CI->db->select('SUM(tp.total_amount) as total_amount, SUM(tp.total_paid) as total_paid')
                        ->from(TBL_TRIPPAYMENT . ' as tp')->join(TBL_DRIVERASSIGNEDTRIP . ' as dat', 'dat.assigned_trip_id=tp.assigned_trip_id', 'left')->where('dat.driver_accepted', '1')->where('dat.is_trip_completed', '1')->where('dat.driver_id', $driver_id)->get()->row_object();
    }

    function is_trip_payment_done_by_assigned_trip_id($assigned_trip_id) {
        $result = $this->CI->db->select('')
                        ->from(TBL_TRIPPAYMENT)->where('assigned_trip_id', $assigned_trip_id)->where('payment_status', '1')->get()->row_object();
        if (isset($result->trip_payment_id)) {
            return true;
        } else {
            return false;
        }
    }

    function is_trip_completed_by_assigned_trip_id($assigned_trip_id) {
        $result = $this->CI->db->select('')
                        ->from(TBL_DRIVERASSIGNEDTRIP)->where('assigned_trip_id', $assigned_trip_id)->where('is_trip_completed', '1')->get()->row_object();
        if (isset($result->trip_payment_id)) {
            return true;
        } else {
            return false;
        }
    }

    function is_all_location_assigned_driver($route_id) {
        $result = $this->CI->db->select('COUNT(deliveries_id) as TotNum')
                        ->from(TBL_DELIVERIESMASTER)->where('route_id', $route_id)->where('is_driver_assigned', '0')->where('is_plan_confirmed', '0')->get()->row_object();
        if ($result->TotNum > 0) {
            return false;
        } else {
            return true;
        }
    }

    function get_route_name($route_id) {
        $result = $this->CI->db->select('route_name')
                        ->from(TBL_CLIENTROUTE)->where('route_id', $route_id)->get()->row_object();
        return $result->route_name;
    }

    function all_organisation_by_userid($user_id) {
        return $this->CI->db->select('om.*,ou.default_organisation as default_organisation')
                        ->from(TBL_ORGANISATIONUSER . ' as ou')->join(TBL_ORGANISATIONMASTER . ' as om','om.org_id=ou.org_id')->where('ou.user_id', $user_id)->get()->result_object();
    }

    function permission_assigned_by_org_id_role_id_module_id($org_id = '', $role_id = '', $module_id = '') {
        $obj = $this->CI->db->select('*')
                        ->from(TBL_ASSIGNPERMISSION)->where('org_id', $org_id)->where('role_id', $role_id)->where('module_id', $module_id)->get()->row_object();

        if (is_object($obj) > 0) {
            return $obj;
        } else {
            return new stdClass();
        }
    }

    function permission_access_view_add_edit_delete($org_id = '', $role_id = '', $module_id = '', $type = '') {
        $this->CI->db->select('*')
                ->from(TBL_ASSIGNPERMISSION)->where('org_id', $org_id)->where('role_id', $role_id)->where('module_id', $module_id);
        $textName = $type . '_status';
        if ($type == 'view') {
            $this->CI->db->where($type . '_status', '1');
            $obj = $this->CI->db->get()->row_object();
            if (!empty($obj) && $obj->add_status == '1') {
                return true;
            } else {
                return false;
            }
        }
        if ($type == 'add') {
            $this->CI->db->where($type . '_status', '1');
            $obj = $this->CI->db->get()->row_object();
            if (!empty($obj) && $obj->add_status == '1') {
                return true;
            } else {
                return false;
            }
        }
        if ($type == 'edit') {
            $this->CI->db->where($type . '_status', '1');
            $obj = $this->CI->db->get()->row_object();
            if (!empty($obj) && $obj->add_status == '1') {
                return true;
            } else {
                return false;
            }
        }
        if ($type == 'delete') {
            $this->CI->db->where($type . '_status', '1');
            $obj = $this->CI->db->get()->row_object();
            if (!empty($obj) && $obj->add_status == '1') {
                return true;
            } else {
                return false;
            }
        }
        if ($type == '') {
            return true;
        }
    }
    function get_featured_category_items($category_id) {
        
        return $this->CI->db->select('*')
                ->from(TBL_PRODUCTMASTER)->where('category_id',$category_id)->limit(3)->get()->result_object();
        
    }
    
    function get_order_items($order_id) {
        return $this->CI->db->select('*')
                ->from(TBL_ORDERDETAIL .' as od')->join(TBL_PRODUCTMASTER . ' as pm','pm.product_id=od.product_id','left')->where('od.order_id',$order_id)->get()->result_object();
        
    }
}

/* End of file Mylibrary.php */