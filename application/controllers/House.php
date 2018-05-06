<?php

class House extends App {
    /* controller for house accounts
     */

    private function showPage($data, $page, $top_nav = FALSE) {
        //displays resv pages        
        if (!file_exists(APPPATH . 'views/app/templates/' . $page . '.php')) {
            echo base_url() . 'views/app/templates/' . $page . '.php';
            show_404();
        }
        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        if ($top_nav) {
            $this->load->view('app/templates/top_reservation_house', $data);
        }
        $this->load->view('app/templates/' . $page, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function index() {
        //default method
        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords("houses");
        $data["bar_title"] = ucwords("house");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data['received'][0]['type'] = "reservation";
        $data["action"] = "";
        $this->showPage($data, "top_reservation_house", 0);
    }

    public function showReservation($type, $resv_ID = 0, $page_number = 0, $action = "", $mode = "", $errors = FALSE) {
        /* 
         * shows house reservation form 
         */
        $this->checkAccess($this->session->reservation, 2);
        $this->session->back_uri = base_url() . uri_string();

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords("house");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["action"] = $action;
        $data['received'][0]['arrival_error'] = "";
        $data['received'][0]['client_name_error'] = "";
        $data['received'][0]['form_error'] = "";

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_page_number = $type . "_page_number";
        $item_client_type = $type . "_client_type";
        $item_status = $type . "_status";
        $item_arrival = $type . "_arrival";
        $item_departure = $type . "_departure";
        $item_client_name = $type . "_client_name";
        $item_nights = $type . "_nights";
        $item_folio_room = $type . "_folio_room";
        $item_remarks = $type . "_remarks";

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['arrival_error'] = $this->session->arrival_error;
            $data['received'][0]['client_name_error'] = $this->session->client_name_error;
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['page_number'] = $this->input->post($item_page_number);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['client_type'] = $this->input->post($item_client_type);
            $data['received'][0]['status'] = $this->input->post($item_status);
            $data['received'][0]['remarks'] = $this->input->post($item_remarks);
            $data['received'][0]['folio_room'] = $this->input->post($item_folio_room);
            $data['received'][0]['client_name'] = $this->input->post($item_client_name);
            $data['received'][0]['nights'] = $this->input->post($item_nights);
            $data['arrivaldate'] = $this->input->post($item_arrival);
            $data['departuredate'] = $this->input->post($item_departure);
        } elseif (!empty($resv_ID)) {
            $data['received'] = $this->resv_model->getHouseResvInfo($resv_ID);
            $data['received'][0]['ID'] = $resv_ID;
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
            $data['resv_status'] = $data['received'][0]['status'];
            $data['received'][0]['arrival_error'] = "";
            $data['received'][0]['client_name_error'] = "";
            $data['received'][0]['form_error'] = "";
        } else {
            $data['received'][0]['ID'] = $resv_ID;
            $data['received'][0]['nights'] = "1";
            $data['received'][0]['client_type'] = "";
            $data['received'][0]['client_name'] = "";
            $data['received'][0]['status'] = "confirmed";
            $data['received'][0]['remarks'] = "";
            $data['received'][0]['folio_room'] = "BILL1";
        }

        //defaults
        $data['received'][0]['type'] = "reservation";
        $data['received'][0]['action'] = $action;
        $data['received'][0]['page_number'] = $page_number;
        $data['received'][0]['mode'] = $mode;
        $curr_status = $data['received'][0]['status'];
        if ($curr_status === "departed" || $curr_status === "ledger") {
            $data['received'][0]['action'] = "view";
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/top_reservation_house', $data);
        if (!empty($mode)) {
            $this->load->view('app/templates/' . $type, $data);
        }
        $this->load->view('app/scripts/footer', $data);
    }

    public function processHouse() {
        //check status..could be useful later
        //chk if key fields are empty,if arrival date,nights is valid
        //??invalid status
        //save data
        //if status=confirmed & arrival is app_date, attempt check in
        $this->checkAccess($this->session->reservation, 3);
        $data = $this->data;
        $app_date = strtotime($data['app_date']);

        $ID = $this->input->post('house_ID');
        $type = $this->input->post('house_type');
        $action = $this->input->post('house_action');
        $mode = $this->input->post('house_mode');
        $page_number = $this->input->post('house_page_number');
        $client_name = trim($this->input->post('house_client_name'));        
        $status = $this->input->post('house_status');
        $errors = FALSE;

        if (empty($client_name)) {            
            $this->session->set_flashdata('house_client_name_error', "Invalid Client Name value");
            $errors = TRUE;
        }

        $arrival_temp = $this->input->post('house_arrival');
        $temp_date = str_replace('/', '-', $arrival_temp);
        $arrival = strtotime($temp_date);
        
        $this->form_validation->set_rules('house_nights', 'Nights', 'is_natural_no_zero|required');
        
        if ($errors || $this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showReservation("house", $ID, $page_number, $action, $mode, $errors);
        } else {
            $res_result = $this->resv_model->saveHouse($type);
            $res_id = $res_result['reservation_id'];
            $this->session->set_flashdata('house_resv_active_row', $res_id);

            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "house/" . $mode;
                redirect($redirect);
            } else {
                $errors = TRUE;
                $this->showReservation("house", $ID, $page_number, $action, $mode, $errors);
            }
        }
    }
    
    public function viewLists($type, $offset = 0) {
        /* displays paginised list of house reservation items 
         * 
         */
        $this->session->resv_back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords("house");
        $data["module"] = "reservation";
        $data["type"] = $type;

        $limit = 10;
        $page = "reservation_house";
        $data["received"][0]["type"] = $type;
        $data["received"][0]["offset"] = $offset;

        $results = $this->resv_model->getHouseReservations($type, $offset, $limit);
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'house/viewLists/' . $type;
        $page_nav["total_rows"] = $results['count'];
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();
        //show page
        $this->showPage($data, $page, 1); 
    }
    
    public function checkIn($mode, $resv_ID, $errors = FALSE) {
        /* checkin houses & gets reservation details, set mode 
         * displays checkin form
         */        
        $this->session->back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);
        
        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords("checkin");
        $data["bar_title"] = ucwords("house");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["mode"] = $mode;

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->form_error;
            $data['received'][0]['ID'] = $this->input->post('checkin_ID');
            $data['received'][0]['reservation_id'] = $this->input->post('checkin_reservation_id');
            $data['received'][0]['mode'] = $this->input->post('checkin_mode');
            $data['received'][0]['nights'] = $this->input->post('checkin_nights');
            $data['received'][0]['client_name'] = $this->input->post('checkin_client_name');
            $data['received'][0]['roomtype'] = $this->input->post('checkin_roomtype');
            $data['received'][0]['price_rate'] = $this->input->post('checkin_price_rate');
            $data['received'][0]['status'] = $this->input->post('checkin_status');
            $data['arrivaldate'] = $this->input->post('checkin_arrival');
            $data['departuredate'] = $this->input->post('checkin_departure');
        } else {
            $data['received'] = $this->resv_model->getClientResvInfo($resv_ID,"GROUP");
            $data['received'][0]['form_error'] = "";
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
        }
        $this->showPage($data, "house_checkin", 1);        
    }
    
    public function processCheckin() {
        //checks a guest in
        $this->checkAccess($this->session->reservation, 3);
        
        $mode = $this->input->post('checkin_mode');
        $reservation_id = $this->input->post('checkin_reservation_id');
        if ($this->resv_model->houseCheckin($reservation_id)) {
            //GO TO STAYING 
            $redirect = "house/staying";
            redirect($redirect);
        } else {
            $this->session->set_flashdata('form_error', "Invalid checkin");
            $errors = TRUE;
            $this->checkIn($mode, $reservation_id, $errors);
        }
    }
    
    public function processResvDelete() {
        //cancells a reservation
        $this->checkAccess($this->session->delete_group, 1);

        $this->form_validation->set_rules('delete_resv_reason', 'Reason', 'required');
        $redirect = $this->session->back_uri;

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('delete_error', validation_errors());
            redirect($redirect);
        } else {
            $res_id = $this->resv_model->deleteResv();
            if ($res_id) {
                $redirect = "house/cancelled";
                redirect($redirect);
            } else {
                $this->session->set_flashdata('delete_error', "Delete Operation Failed");
                redirect($redirect);
            }
        }
    }
}
