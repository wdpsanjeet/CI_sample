<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//********************API Routes**********************
$route['api/registration'] = 'api/index/registration';
$route['api/otpVarified'] = 'api/index/otp_verification';
$route['api/login'] = 'api/index/login';
$route['api/updateProfile'] = 'api/index/update_profile';
$route['api/updateProfilepicture'] = 'api/index/update_profilepicture';
$route['api/resendOtp'] = 'api/index/resend_otp';
$route['api/activeTrip'] = 'api/index/active_trip';
$route['api/activeTripAccept'] = 'api/index/active_trip_update';
$route['api/startTrip'] = 'api/index/start_trip';
$route['api/updateClientTrip'] = 'api/index/update_client_trip';
$route['api/updateTripCompleted'] = 'api/index/update_trip_completed';
$route['api/getPayments'] = 'api/index/get_payments';
$route['api/getPastTrip'] = 'api/index/past_trip';
$route['api/getNotifications'] = 'api/index/notification';
$route['api/paymentRequest'] = 'api/index/payment_request';
$route['api/onlineStatusUpdate'] = 'api/index/online_status_update';
$route['api/getTripLocationDetail'] = 'api/index/trip_locations_by_assigned_trip_id';
?>