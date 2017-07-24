<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Service extends REST_Controller {

    function __construct() {
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function users_get() {
        $type = $this->get('type');
        $val = $this->get('val');

        if (empty($val)) {
            // Invalid room_number/reservation_id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        } else {
            $results = $this->resv_model->verifyRoom($type, $val);
            // Set the response and exit
            $this->response($results, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
    }

}