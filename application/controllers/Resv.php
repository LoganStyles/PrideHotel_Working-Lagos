<?php

class Resv extends App {
    /* controller for reservations
     */

    public function __construct() {
        parent::__construct();
        $this->data['rooms'] = $this->app_model->getDisplayedItems('room')['data'];
        $this->data['prices'] = $this->app_model->getDisplayedItems('price')['data'];
    }

    public function searchClient($type, $search_phrase) {
        $table = $type . "items";
        $search_phrase = $this->security->xss_clean($search_phrase);
        $results = $this->resv_model->search($search_phrase, $table);
        echo $results;
    }

    public function checkIn($mode, $resv_ID, $errors = FALSE) {
        /* get reservation details, set mode */

        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }
        $data = $this->data;
        $data["header_title"] = ucwords("checkin");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["mode"] = $mode;

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->form_error;
            $data['received'][0]['ID'] = $this->input->post('checkin_ID');
            $data['received'][0]['reservation_id'] = $this->input->post('checkin_reservation_id');
            $data['received'][0]['price_title'] = $this->input->post('checkin_price_title');
            $data['received'][0]['room_number_id'] = $this->input->post('checkin_room_number_id');
            $data['received'][0]['mode'] = $this->input->post('checkin_mode');
            $data['received'][0]['nights'] = $this->input->post('checkin_nights');
            $data['received'][0]['reservation_id'] = $this->input->post('checkin_reservation_id');
            $data['received'][0]['client_name'] = $this->input->post('checkin_client_name');
            $data['received'][0]['guest2'] = $this->input->post('checkin_guest2');
            $data['received'][0]['roomtype'] = $this->input->post('checkin_roomtype');
            $data['received'][0]['room_number'] = $this->input->post('checkin_room_number');
            $data['received'][0]['price_rate'] = $this->input->post('checkin_price_rate');
            $data['received'][0]['status'] = $this->input->post('checkin_status');
            $data['received'][0]['weekday'] = $this->input->post('checkin_weekday');
            $data['received'][0]['weekend'] = $this->input->post('checkin_weekend');
            $data['received'][0]['holiday'] = $this->input->post('checkin_holiday');
            $data['arrivaldate'] = $this->input->post('checkin_arrival');
            $data['departuredate'] = $this->input->post('checkin_departure');
        } else {
            $data['received'] = $this->resv_model->getClientResvInfo($resv_ID);
            $data['received'][0]['form_error'] = "";
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/checkin' . '.php')) {
            echo base_url() . 'views/app/templates/checkin' . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/top_reservation', $data);
        $this->load->view('app/templates/checkin', $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function processCheckin() {
        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $room_number_id = $this->input->post('checkin_room_number_id');
        $mode = $this->input->post('checkin_mode');
        $ID = $this->input->post('checkin_ID');
        $reservation_id = $this->input->post('checkin_reservation_id');
        if ($this->resv_model->checkin($ID, $room_number_id)) {
            //GO TO STAYING 
            $redirect = "resv/staying";
            redirect($redirect);
        } else {
            $this->session->set_flashdata('form_error', "Room is not vacant, select another");
            $errors = TRUE;
            $this->checkIn($mode, $reservation_id, $errors);
        }
    }

    public function processResvDelete() {
        $this->chkLoggedIn();
        $access = $this->session->delete_group;
        if ($access < 1) {//delete access
            $redirect = "app";
            redirect($redirect);
        }

        $this->form_validation->set_rules('delete_resv_reason', 'Reason', 'required');
        $redirect = $this->session->back_uri;

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('delete_error', validation_errors());            
            redirect($redirect);
        } else {
            $res_id = $this->resv_model->deleteResv();
            if ($res_id) {
                $redirect = "resv/cancelled";
                redirect($redirect);
            } else {
                $this->session->set_flashdata('delete_error', "Delete Operation Failed");
                redirect($redirect);
            }
        }
    }

    public function showReservation($type, $resv_ID = 0, $page_number = 0, $action = "", $mode = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }
        $data = $this->data;
        $data["header_title"] = ucwords($type);
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
        $item_agency_name = $type . "_agency_name";
        $item_agency_contact = $type . "_agency_contact";
        $item_guest1 = $type . "_guest1";
        $item_guest2 = $type . "_guest2";
        $item_adults = $type . "_adults";
        $item_children = $type . "_children";
        $item_roomtype = $type . "_roomtype";
        $item_room_number = $type . "_room_number";
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
        $item_invoice = $type . "_invoice";
        $item_comp_visits = $type . "_comp_visits";
        $item_comp_nights = $type . "_comp_nights";
        $item_block_pos = $type . "_block_pos";
        $item_roomtype_id = $type . "_roomtype_id";
        $item_room_number_id = $type . "_room_number_id";
        $item_price_rate_id = $type . "_price_rate_id";

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
            $data['received'][0]['invoice'] = $this->input->post($item_invoice);
            $data['received'][0]['comp_visits'] = $this->input->post($item_comp_visits);
            $data['received'][0]['block_pos'] = $this->input->post($item_block_pos);
            $data['received'][0]['client_name'] = $this->input->post($item_client_name);
            $data['received'][0]['nights'] = $this->input->post($item_nights);
            $data['received'][0]['agency_name'] = $this->input->post($item_agency_name);
            $data['received'][0]['agency_contact'] = $this->input->post($item_agency_contact);
            $data['received'][0]['guest1'] = $this->input->post($item_guest1);
            $data['received'][0]['guest2'] = $this->input->post($item_guest2);
            $data['received'][0]['adults'] = $this->input->post($item_adults);
            $data['received'][0]['children'] = $this->input->post($item_children);
            $data['received'][0]['roomtype'] = $this->input->post($item_roomtype);
            $data['received'][0]['room_number'] = $this->input->post($item_room_number);
            $data['received'][0]['price_rate'] = $this->input->post($item_price_rate);
            $data['received'][0]['weekday'] = $this->input->post($item_weekday);
            $data['received'][0]['weekend'] = $this->input->post($item_weekend);
            $data['received'][0]['holiday'] = $this->input->post($item_holiday);
            $data['received'][0]['price_room'] = $this->input->post($item_price_room);
            $data['received'][0]['price_extra'] = $this->input->post($item_price_extra);
            $data['received'][0]['price_total'] = $this->input->post($item_price_total);
            $data['received'][0]['comp_nights'] = $this->input->post($item_comp_nights);
            $data['received'][0]['roomtype_id'] = $this->input->post($item_roomtype_id);
            $data['received'][0]['room_number_id'] = $this->input->post($item_room_number_id);
            $data['received'][0]['price_rate_id'] = $this->input->post($item_price_rate_id);
            $data['arrivaldate'] = $this->input->post($item_arrival);
            $data['departuredate'] = $this->input->post($item_departure);
        } elseif (!empty($resv_ID)) {
            $data['received'] = $this->resv_model->getClientResvInfo($resv_ID);
            $data['received'][0]['ID'] = $resv_ID;
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
            $data['received'][0]['arrival_error'] = "";
            $data['received'][0]['client_name_error'] = "";
            $data['received'][0]['roomtype_error'] = "";
            $data['received'][0]['price_rate_error'] = "";
            $data['received'][0]['form_error'] = "";
        } else {
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['nights'] = "1";
            $data['received'][0]['client_type'] = "";
            $data['received'][0]['client_name'] = "";
            $data['received'][0]['agency_name'] = "";
            $data['received'][0]['agency_contact'] = "";
            $data['received'][0]['guest1'] = "";
            $data['received'][0]['guest2'] = "";
            $data['received'][0]['adults'] = "1";
            $data['received'][0]['children'] = "0";
            $data['received'][0]['roomtype'] = "";
            $data['received'][0]['room_number'] = "";
            $data['received'][0]['price_rate'] = "";
            $data['received'][0]['weekday'] = "0";
            $data['received'][0]['weekend'] = "0";
            $data['received'][0]['holiday'] = "0";
            $data['received'][0]['price_room'] = "0";
            $data['received'][0]['price_extra'] = "0";
            $data['received'][0]['price_total'] = "0";
            $data['received'][0]['comp_nights'] = "0";
            $data['received'][0]['status'] = "confirmed";
            $data['received'][0]['folio_room'] = "BILL1";
            $data['received'][0]['folio_extra'] = "BILL1";
            $data['received'][0]['folio_other'] = "BILL1";
            $data['received'][0]['invoice'] = "no";
            $data['received'][0]['comp_visits'] = "no";
            $data['received'][0]['block_pos'] = "no";
            $data['received'][0]['roomtype_id'] = "";
            $data['received'][0]['room_number_id'] = "";
            $data['received'][0]['price_rate_id'] = "";
        }

        //defaults
        $data['received'][0]['type'] = "reservation";
        $data['received'][0]['action'] = $action;
        $data['received'][0]['page_number'] = $page_number;
        $data['received'][0]['mode'] = $mode;

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/top_reservation', $data);
        if (!empty($mode)) {
            $this->load->view('app/templates/' . $type, $data);
        }
        $this->load->view('app/scripts/footer', $data);
    }

    public function processGuest() {
        //check status..could be useful later
        //chk if key fields are empty,if arrival date,nights is valid
        //??invalid status
        //save data
        //if status=confirmed & arrival is app_date, attempt check in
        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $data = $this->data;
        $app_date = strtotime($data['app_date']);

        $ID = $this->input->post('guest_ID');
        $type = $this->input->post('guest_type');
        $action = $this->input->post('guest_action');
        $mode = $this->input->post('guest_mode');
        $page_number = $this->input->post('guest_page_number');
        $client_name = trim($this->input->post('guest_client_name'));
        $roomtype = trim($this->input->post('guest_roomtype'));
        $price_rate = trim($this->input->post('guest_price_rate'));
        $status = $this->input->post('guest_status');
        $errors = FALSE;

        if (empty($client_name)) {
            $this->session->set_flashdata('client_name_error', "Error");
            $errors = TRUE;
        }
        if (empty($roomtype)) {
            $this->session->set_flashdata('roomtype_error', "Error");
            $errors = TRUE;
        }
        if (empty($price_rate)) {
            $this->session->set_flashdata('price_rate_error', "Error");
            $errors = TRUE;
        }

        $arrival_temp = $this->input->post('guest_arrival');
        $temp_date = str_replace('/', '-', $arrival_temp);
        $arrival = strtotime($temp_date);

        if ($arrival < $app_date) {
            //ensure arrival is not in the past
            $this->session->set_flashdata('arrival_error', "Invalid Arrival Date");
            $errors = TRUE;
        }

        $this->form_validation->set_rules('guest_roomtype_id', 'Room Type', 'is_natural_no_zero|required');
        $this->form_validation->set_rules('guest_adults', 'Adults', 'is_natural|required');
        $this->form_validation->set_rules('guest_children', 'Children', 'is_natural|required');
        $this->form_validation->set_rules('guest_price_rate_id', 'Price Rate', 'is_natural_no_zero|required');
        $this->form_validation->set_rules('guest_nights', 'Nights', 'is_natural_no_zero|required');

        if ($errors || $this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showReservation("guest", $ID, $page_number, $action, $mode, $errors);
        } else {
            $res_id = $this->resv_model->saveGuest($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                if (($status === "confirmed") && ($arrival === $app_date)) {
                    $redirect = "resv/checkin/" . $mode . "/" . $res_id;
                } else {
                    $redirect = "resv/" . $mode;
                }
                redirect($redirect);
            }
        }
    }

    public function showClients($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords("clients");
        $data["module"] = "reservation";
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;
        $data['countries'] = $this->app_model->getDisplayedItems('ref_country')['data'];

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_title_ref = $type . "_title_ref";
        $item_email = $type . "_email";
        $item_phone = $type . "_phone";
        $item_city = $type . "_city";
        $item_state = $type . "_state";
        $item_country = $type . "_country";
        $item_street = $type . "_street";
        $item_sex = $type . "_sex";
        $item_occupation = $type . "_occupation";
        $item_birth_location = $type . "_birth_location";
        $item_passport_no = $type . "_passport_no";
        $item_pp_issued_at = $type . "_pp_issued_at";
        $item_spg_no = $type . "_spg_no";
        $item_visa = $type . "_visa";
        $item_resident_permit_no = $type . "_resident_permit_no";
        $item_destination = $type . "_destination";
        $item_group_name = $type . "_group_name";
        $item_plate_number = $type . "_plate_number";
        $item_remarks = $type . "_remarks";
        $item_payment_method = $type . "_payment_method";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['title_ref'] = $this->input->post($item_title_ref);
            $data['received'][0]['email'] = $this->input->post($item_email);
            $data['received'][0]['phone'] = $this->input->post($item_phone);
            $data['received'][0]['city'] = $this->input->post($item_city);
            $data['received'][0]['state'] = $this->input->post($item_state);
            $data['received'][0]['country'] = $this->input->post($item_country);
            $data['received'][0]['street'] = $this->input->post($item_street);
            $data['received'][0]['sex'] = $this->input->post($item_sex);
            $data['received'][0]['occupation'] = $this->input->post($item_occupation);
            $data['received'][0]['birth_location'] = $this->input->post($item_birth_location);
            $data['received'][0]['passport_no'] = $this->input->post($item_passport_no);
            $data['received'][0]['pp_issued_at'] = $this->input->post($item_pp_issued_at);
            $data['received'][0]['spg_no'] = $this->input->post($item_spg_no);
            $data['received'][0]['visa'] = $this->input->post($item_visa);
            $data['received'][0]['resident_permit_no'] = $this->input->post($item_resident_permit_no);
            $data['received'][0]['destination'] = $this->input->post($item_destination);
            $data['received'][0]['group_name'] = $this->input->post($item_group_name);
            $data['received'][0]['plate_number'] = $this->input->post($item_plate_number);
            $data['received'][0]['remarks'] = $this->input->post($item_remarks);
            $data['received'][0]['payment_method'] = $this->input->post($item_payment_method);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['title_ref'] = "";
            $data['received'][0]['email'] = "";
            $data['received'][0]['phone'] = "";
            $data['received'][0]['city'] = "";
            $data['received'][0]['state'] = "";
            $data['received'][0]['country'] = 172;
            $data['received'][0]['street'] = "";
            $data['received'][0]['sex'] = "";
            $data['received'][0]['occupation'] = "";
            $data['received'][0]['birth_location'] = "";
            $data['received'][0]['passport_no'] = "";
            $data['received'][0]['pp_issued_at'] = "";
            $data['received'][0]['spg_no'] = "";
            $data['received'][0]['visa'] = "";
            $data['received'][0]['resident_permit_no'] = "";
            $data['received'][0]['destination'] = "";
            $data['received'][0]['group_name'] = "";
            $data['received'][0]['plate_number'] = "";
            $data['received'][0]['remarks'] = "";
            $data['received'][0]['payment_method'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/top_reservation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function viewLists($type, $offset = 0) {
        /* displays paginised list of reservation items */
        $this->session->back_uri = base_url() . uri_string();
        
        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords($type);
        $data["module"] = "reservation";
        $data["type"] = $type;

//        if (!$filter) {
//            $filter = "0";
//        }

        $config = array();
        $limit = 20;
        $page = "reservation";
        $data["received"][0]["type"] = $type;
        $data["received"][0]["offset"] = $offset;

        $results = $this->resv_model->getReservations($type, $offset, $limit);
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];

        $config["base_url"] = base_url() . 'resv/viewLists/' . $type;
        $config["total_rows"] = $results['count'];
        $config["per_page"] = $limit;

        //various pagination configuration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_link'] = '«Previous';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next»';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['first_link'] = '&lt;&lt;';
        $config['last_link'] = '&gt;&gt;';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        if (!file_exists(APPPATH . 'views/app/templates/' . $page . '.php')) {
            echo base_url() . 'views/app/templates/' . $page . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/top_reservation', $data);
        $this->load->view('app/templates/' . $page, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function processPerson() {
        //save data
        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }

        $ID = $this->input->post('person_ID');
        $type = $this->input->post('person_type');
        $action = $this->input->post('person_action');
        $page_number = $this->input->post('person_page_number');

        if ($ID > 0) {
            $this->form_validation->set_rules('person_title', 'Name', 'trim|required');
        } else {
            $this->form_validation->set_rules('person_title', 'Name', 'trim|required|is_unique[personitems.title]');
        }

        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showClients($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->resv_model->savePerson($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "resv/showClients/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function fetchModalData($type, $ID, $filter = FALSE) {
        $this->chkLoggedIn();
        $access = $this->session->reservation;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        switch ($type) {
            case 'roomtype':
                $result = $this->resv_model->getModalItems($type, TRUE, $ID, $filter);
                break;
            case 'room_number':
            case 'price_rate':
                $result = $this->resv_model->getModalItems($type, TRUE, $ID, $filter);
                break;
            default:
//                $result = $this->app_model->getDisplayedItems($type, TRUE, $ID);
                break;
        }
        echo $result;
    }

}
