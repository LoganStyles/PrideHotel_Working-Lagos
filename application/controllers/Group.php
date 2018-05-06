<?php

class Group extends App {
    /* controller for groups
     */

    private function showPage($data, $page, $top_nav = FALSE) {
        //displays resv pages        
        if (!file_exists(APPPATH . 'views/app/templates/' . $page . '.php')) {
            echo base_url() . 'views/app/templates/' . $page . '.php';
            show_404();
        }
        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        if ($top_nav) {
            $this->load->view('app/templates/top_reservation_group', $data);
        }
        $this->load->view('app/templates/' . $page, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function index() {
        //default method
        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords("groups");
        $data["bar_title"] = ucwords("group");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data['received'][0]['type'] = "reservation";
        $data["action"] = "";
        $this->showPage($data, "top_reservation_group", 0);
    }

    public function showReservation($type, $resv_ID = 0, $page_number = 0, $action = "", $mode = "", $errors = FALSE) {
        /* displays paginised list of items
         * shows reservation form 
         */
        $this->checkAccess($this->session->reservation, 2);
        $this->session->back_uri = base_url() . uri_string();

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords("group");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["action"] = $action;
        $data['received'][0]['price_title'] = "";
        $data['received'][0]['arrival_error'] = "";
        $data['received'][0]['client_name_error'] = "";
        $data['received'][0]['roomtype_error'] = "";
        $data['received'][0]['price_rate_error'] = "";
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
        $item_roomtype = $type . "_roomtype";
        $item_price_rate = $type . "_price_rate";
        $item_weekday = $type . "_weekday";
        $item_weekend = $type . "_weekend";
        $item_holiday = $type . "_holiday";
        $item_price_room = $type . "_price_room";
        $item_price_extra = $type . "_price_extra";
        $item_price_total = $type . "_price_total";
        $item_comp_nights = $type . "_comp_nights";
        $item_folio_room = $type . "_folio_room";
        $item_folio_extra = $type . "_folio_extra";
        $item_folio_other = $type . "_folio_other";
        $item_comp_visits = $type . "_comp_visits";
        $item_comp_nights = $type . "_comp_nights";
        $item_roomtype_id = $type . "_roomtype_id";
        $item_price_rate_id = $type . "_price_rate_id";
        $item_remarks = $type . "_remarks";

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['arrival_error'] = $this->session->arrival_error;
            $data['received'][0]['client_name_error'] = $this->session->client_name_error;
            $data['received'][0]['roomtype_error'] = $this->session->roomtype_error;
            $data['received'][0]['price_rate_error'] = $this->session->price_rate_error;
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['page_number'] = $this->input->post($item_page_number);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['client_type'] = $this->input->post($item_client_type);
            $data['received'][0]['status'] = $this->input->post($item_status);
            $data['received'][0]['folio_room'] = $this->input->post($item_folio_room);
            $data['received'][0]['folio_extra'] = $this->input->post($item_folio_extra);
            $data['received'][0]['folio_other'] = $this->input->post($item_folio_other);
            $data['received'][0]['comp_visits'] = $this->input->post($item_comp_visits);
            $data['received'][0]['client_name'] = $this->input->post($item_client_name);
            $data['received'][0]['nights'] = $this->input->post($item_nights);
            $data['received'][0]['roomtype'] = $this->input->post($item_roomtype);
            $data['received'][0]['price_rate'] = $this->input->post($item_price_rate);
            $data['received'][0]['weekday'] = $this->input->post($item_weekday);
            $data['received'][0]['weekend'] = $this->input->post($item_weekend);
            $data['received'][0]['holiday'] = $this->input->post($item_holiday);
            $data['received'][0]['price_room'] = $this->input->post($item_price_room);
            $data['received'][0]['price_extra'] = $this->input->post($item_price_extra);
            $data['received'][0]['price_total'] = $this->input->post($item_price_total);
            $data['received'][0]['comp_nights'] = $this->input->post($item_comp_nights);
            $data['received'][0]['roomtype_id'] = $this->input->post($item_roomtype_id);
            $data['received'][0]['price_rate_id'] = $this->input->post($item_price_rate_id);
            $data['received'][0]['remarks'] = $this->input->post($item_remarks);
            $data['arrivaldate'] = $this->input->post($item_arrival);
            $data['departuredate'] = $this->input->post($item_departure);
        } elseif (!empty($resv_ID)) {
            $data['received'] = $this->resv_model->getGroupResvInfo($resv_ID);
            $data['received'][0]['ID'] = $resv_ID;
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
            $data['resv_status'] = $data['received'][0]['status'];
            $data['received'][0]['arrival_error'] = "";
            $data['received'][0]['client_name_error'] = "";
            $data['received'][0]['roomtype_error'] = "";
            $data['received'][0]['price_rate_error'] = "";
            $data['received'][0]['form_error'] = "";
        } else {
            $data['received'][0]['ID'] = $resv_ID;
            $data['received'][0]['nights'] = "1";
            $data['received'][0]['client_type'] = "";
            $data['received'][0]['client_name'] = "";
            $data['received'][0]['roomtype'] = "";
            $data['received'][0]['price_rate'] = "";
            $data['received'][0]['weekday'] = "0";
            $data['received'][0]['weekend'] = "0";
            $data['received'][0]['holiday'] = "0";
            $data['received'][0]['price_room'] = "0";
            $data['received'][0]['price_extra'] = "0";
            $data['received'][0]['price_total'] = "0";
            $data['received'][0]['comp_nights'] = "0";
            $data['received'][0]['status'] = "confirmed";
            $data['received'][0]['folio_room'] = "INV";
            $data['received'][0]['folio_extra'] = "INV";
            $data['received'][0]['folio_other'] = "INV";
            $data['received'][0]['comp_visits'] = "no";
            $data['received'][0]['roomtype_id'] = "";
            $data['received'][0]['price_rate_id'] = "";
            $data['received'][0]['remarks'] = "";
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
        $this->load->view('app/templates/top_reservation_group', $data);
        if (!empty($mode)) {
            $this->load->view('app/templates/' . $type, $data);
        }
        $this->load->view('app/scripts/footer', $data);
    }

    public function processGroup() {
        //check status..could be useful later
        //chk if key fields are empty,if arrival date,nights is valid
        //??invalid status
        //save data
        //if status=confirmed & arrival is app_date, attempt check in
        $this->checkAccess($this->session->reservation, 3);
        $data = $this->data;
        $app_date = strtotime($data['app_date']);

        $ID = $this->input->post('group_ID');
        $type = $this->input->post('group_type');
        $action = $this->input->post('group_action');
        $mode = $this->input->post('group_mode');
        $page_number = $this->input->post('group_page_number');
        $client_name = trim($this->input->post('group_client_name'));
        $roomtype = trim($this->input->post('group_roomtype'));
        $price_rate = trim($this->input->post('group_price_rate'));
        $status = $this->input->post('group_status');
        $errors = FALSE;

        if (empty($client_name)) {
            $this->session->set_flashdata('group_client_name_error', "Invalid Client Name value");
            $errors = TRUE;
        }
        if (empty($roomtype)) {
            $this->session->set_flashdata('group_roomtype_error', "Invalid Room type value");
            $errors = TRUE;
        }
        if (empty($price_rate)) {
            $this->session->set_flashdata('group_price_rate_error', "Invalid Price rate value");
            $errors = TRUE;
        }

        $arrival_temp = $this->input->post('group_arrival');
        $temp_date = str_replace('/', '-', $arrival_temp);
        $arrival = strtotime($temp_date);

        $this->form_validation->set_rules('group_roomtype_id', 'Room Type', 'is_natural_no_zero|required');
        $this->form_validation->set_rules('group_price_rate_id', 'Price Rate', 'is_natural_no_zero|required');
        $this->form_validation->set_rules('group_nights', 'Nights', 'is_natural_no_zero|required');

        if ($errors || $this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showReservation("group", $ID, $page_number, $action, $mode, $errors);
        } else {
            $res_result = $this->resv_model->saveGroup($type);
            $res_id = $res_result['reservation_id'];
            $this->session->set_flashdata('group_resv_active_row', $res_id);

            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "group/" . $mode;
                redirect($redirect);
            } else {
                $errors = TRUE;
                $this->showReservation("group", $ID, $page_number, $action, $mode, $errors);
            }
        }
    }
    
    public function viewLists($type, $offset = 0) {
        /* displays paginised list of group reservation items 
         * 
         */
        $this->session->resv_back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords("group");
        $data["module"] = "reservation";
        $data["type"] = $type;

        $limit = 10;
        $page = "reservation_group";
        $data["received"][0]["type"] = $type;
        $data["received"][0]["offset"] = $offset;

        $results = $this->resv_model->getGroupReservations($type, $offset, $limit);
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'group/viewLists/' . $type;
        $page_nav["total_rows"] = $results['count'];
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();
        //show page
        $this->showPage($data, $page, 1); 
    }
    
    public function checkIn($mode, $resv_ID, $errors = FALSE) {
        /* checkin groups & gets reservation details, set mode 
         * displays checkin form
         */        
        $this->session->back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);
        
        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords("checkin");
        $data["bar_title"] = ucwords("group");
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
        $this->showPage($data, "group_checkin", 1);        
    }
    
    public function processCheckin() {
        //checks a guest in
        $this->checkAccess($this->session->reservation, 3);
        
        $mode = $this->input->post('checkin_mode');
        $reservation_id = $this->input->post('checkin_reservation_id');
        if ($this->resv_model->groupCheckin($reservation_id)) {
            //GO TO STAYING 
            $redirect = "group/staying";
            redirect($redirect);
        } else {
            $this->session->set_flashdata('form_error', "Invalid checkin");
            $errors = TRUE;
            $this->checkIn($mode, $reservation_id, $errors);
        }
    }
}
