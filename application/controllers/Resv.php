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
//      search client name
        $table = $type . "items";
        $cleaned_search_phrase = $this->security->xss_clean($search_phrase);
        $results = $this->resv_model->search($cleaned_search_phrase, $table);
        echo $results;
    }

    public function getFieldValue($type, $id, $field) {
        $result = $this->resv_model->getFieldValue($type, $id, $field);
        echo $result;
    }
    
    private function showPage($data, $page,$top_nav=FALSE) {
        //displays resv pages        
        if (!file_exists(APPPATH . 'views/app/templates/' .$page. '.php')) {
            echo base_url() . 'views/app/templates/' .$page. '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        if($top_nav){
          $this->load->view('app/templates/top_reservation', $data);  
        }        
        $this->load->view('app/templates/'. $page, $data);
        $this->load->view('app/scripts/footer', $data);
    }
    

    public function checkIn($mode, $resv_ID, $errors = FALSE) {
        /* checkin guest & gets reservation details, set mode 
         * displays checkin form
         */        
        $this->session->back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);
        
        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords("checkin");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["mode"] = $mode;
        $data["new_client"] = (isset($this->session->new_client)) ? ($this->session->new_client) : ("");

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->form_error;
            $data['received'][0]['ID'] = $this->input->post('checkin_ID');
            $data['received'][0]['comp_nights'] = $this->input->post('checkin_comp_nights');
            $data['received'][0]['reservation_id'] = $this->input->post('checkin_reservation_id');
            $data['received'][0]['price_title'] = $this->input->post('checkin_price_title');
            $data['received'][0]['room_number_id'] = $this->input->post('checkin_room_number_id');
            $data['received'][0]['mode'] = $this->input->post('checkin_mode');
            $data['received'][0]['nights'] = $this->input->post('checkin_nights');
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
            $data['received'] = $this->resv_model->getClientResvInfo($resv_ID,"ROOM");
            $data['received'][0]['form_error'] = "";
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
        }
        $this->showPage($data, "checkin", 1);        
    }

    public function processCheckin() {
        //checks a guest in
        $this->checkAccess($this->session->reservation, 3);
        
        $room_number_id = $this->input->post('checkin_room_number_id');
        $mode = $this->input->post('checkin_mode');
        $comp_nights = $this->input->post('checkin_comp_nights');
        $reservation_id = $this->input->post('checkin_reservation_id');
        if ($this->resv_model->checkin($reservation_id, $room_number_id,$comp_nights)) {
            //GO TO STAYING 
            $redirect = "resv/staying";
            redirect($redirect);
        } else {
            $this->session->set_flashdata('form_error', "This Room is not vacant, select another room");
            $errors = TRUE;
            $this->checkIn($mode, $reservation_id, $errors);
        }
    }

    public function folios($resv_ID, $page_number, $mode, $errors = FALSE) {
        /* get folio details, set mode */
        $this->session->back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords("checkin");
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["mode"] = $mode;
        $data["new_client"] = (isset($this->session->new_client)) ? ($this->session->new_client) : ("");

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
            $data['received'] = $this->resv_model->getClientResvInfo($resv_ID,"ROOM");
            $data['received'][0]['form_error'] = "";
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
        }
        $this->showPage($data, "checkin", 1); 
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
                $redirect = "resv/cancelled";
                redirect($redirect);
            } else {
                $this->session->set_flashdata('delete_error', "Delete Operation Failed");
                redirect($redirect);
            }
        }
    }

    public function processPersonDelete() {
//        delete a guest
        $this->checkAccess($this->session->delete_group, 1);

        $this->form_validation->set_rules('delete_person_reason', 'Reason', 'required');
        $redirect = $this->session->back_uri;

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('delete_person_error', validation_errors());
            redirect($redirect);
        } else {
            $res_id = $this->resv_model->deletePerson();
            if ($res_id) {
                $redirect = "resv/person";
                redirect($redirect);
            } else {
                $this->session->set_flashdata('delete_person_error', "Delete Operation Failed");
                redirect($redirect);
            }
        }
    }

    public function showReservation($type, $resv_ID = 0,$master_id = 0, $page_number = 0, $action = "", $mode = "", $errors = FALSE) {
        /* displays paginised list of items
         * shows reservation form 
         */
        $this->checkAccess($this->session->reservation, 2);
        $this->session->back_uri = base_url() . uri_string();

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords($type);
        $data["type"] = "reservation";
        $data["module"] = "reservation";
        $data["action"] = $action;
        $data['received'][0]['price_title'] = "";
        $data['received'][0]['arrival_error'] = "";
        $data['received'][0]['client_name_error'] = "";
        $data['received'][0]['roomtype_error'] = "";
        $data['received'][0]['price_rate_error'] = "";
        $data['received'][0]['nights_error'] = "";
        $data['received'][0]['form_error'] = "";

        $item_id = $type . "_ID";
        $item_master_id = $type . "_master_id";
        $item_action = $type . "_action";
        $item_page_number = $type . "_page_number";
        $item_client_type = $type . "_client_type";
        $item_status = $type . "_status";
        $item_arrival = $type . "_arrival";
        $item_departure = $type . "_departure";
        $item_client_name = $type . "_client_name";
        $item_nights = $type . "_nights";
        $item_remarks = $type . "_remarks";
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
        $item_discount_type = $type . "_discount_type";
        $item_discount = $type . "_discount";
        $item_discount_ratio = $type . "_discount_ratio";
        $item_max_discount_value = $type . "_max_discount_value";
        $item_weekday_no_deductions = $type . "_weekday_no_deductions";
        $item_weekend_no_deductions = $type . "_weekend_no_deductions";
        $item_holiday_no_deductions = $type . "_holiday_no_deductions";
        $item_price_room_no_deductions = $type . "_price_room_no_deductions";
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
//            echo 'errors show reservation '. $errors. ' '.$this->session->error_message;exit;
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['arrival_error'] = $this->session->arrival_error;
            $data['received'][0]['client_name_error'] = $this->session->client_name_error;
            $data['received'][0]['roomtype_error'] = $this->session->roomtype_error;
            $data['received'][0]['price_rate_error'] = $this->session->price_rate_error;
            $data['received'][0]['nights_error'] = $this->session->nights_error;
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['remarks'] = $this->input->post($item_remarks);
            $data['received'][0]['page_number'] = $this->input->post($item_page_number);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['master_id'] = $this->input->post($item_master_id);
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
            $data['received'][0]['discount_type'] = $this->input->post($item_discount_type);
            $data['received'][0]['discount'] = $this->input->post($item_discount);
            $data['received'][0]['discount_ratio'] = $this->input->post($item_discount_ratio);
            $data['received'][0]['max_discount_value'] = $this->input->post($item_max_discount_value);
            $data['received'][0]['weekday_no_deductions'] = $this->input->post($item_weekday_no_deductions);
            $data['received'][0]['weekend_no_deductions'] = $this->input->post($item_weekend_no_deductions);
            $data['received'][0]['holiday_no_deductions'] = $this->input->post($item_holiday_no_deductions);
            $data['received'][0]['price_room_no_deductions'] = $this->input->post($item_price_room_no_deductions);
            $data['received'][0]['comp_nights'] = $this->input->post($item_comp_nights);
            $data['received'][0]['roomtype_id'] = $this->input->post($item_roomtype_id);
            $data['received'][0]['room_number_id'] = $this->input->post($item_room_number_id);
            $data['received'][0]['price_rate_id'] = $this->input->post($item_price_rate_id);
            $data['arrivaldate'] = $this->input->post($item_arrival);
            $data['departuredate'] = $this->input->post($item_departure);
        } elseif (!empty($resv_ID)) {
            $data['received'] = $this->resv_model->getClientResvInfo($resv_ID,"ROOM");
            $data['received'][0]['ID'] = $resv_ID;
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
            $data['resv_status'] = $data['received'][0]['status'];
            $data['received'][0]['arrival_error'] = "";
            $data['received'][0]['client_name_error'] = "";
            $data['received'][0]['roomtype_error'] = "";
            $data['received'][0]['price_rate_error'] = "";
            $data['received'][0]['nights_error'] = "";
            $data['received'][0]['form_error'] = "";
        } elseif (!empty($master_id)) {//this executes only once, when adding new guest to group
            $data['received'] = $this->resv_model->getClientResvInfo($master_id,"GROUP");
            $data['received'][0]['ID'] = $resv_ID;
            $data['arrival'] = $data['received'][0]['arrival'];
            $data['departure'] = $data['received'][0]['departure'];
            $data['received'][0]['master_id'] = $master_id;
            $data['received'][0]['client_name'] = "";
            $data['resv_status'] = $mode;
            $data['received'][0]['status']=$mode;
            $data['received'][0]['arrival_error'] = "";
            $data['received'][0]['client_name_error'] = "";
            $data['received'][0]['roomtype_error'] = "";
            $data['received'][0]['price_rate_error'] = "";
            $data['received'][0]['nights_error'] = "";
            $data['received'][0]['form_error'] = "";
        }else {
            $data['received'][0]['ID'] = $resv_ID;
            $data['received'][0]['master_id'] = "";
            $data['received'][0]['nights'] = "1";
            $data['received'][0]['client_type'] = "";
            $data['received'][0]['client_name'] = "";
            $data['received'][0]['agency_name'] = "";
            $data['received'][0]['agency_contact'] = "";
            $data['received'][0]['guest1'] = "";
            $data['received'][0]['guest2'] = "";
            $data['received'][0]['remarks'] = "";
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
            $data['received'][0]['discount_type'] = "none";
            $data['received'][0]['discount'] = "0";
            $data['received'][0]['discount_ratio'] = "0";
            $data['received'][0]['max_discount_value'] = "0";
            $data['received'][0]['weekday_no_deductions'] = "0";
            $data['received'][0]['weekend_no_deductions'] = "0";
            $data['received'][0]['holiday_no_deductions'] = "0";
            $data['received'][0]['price_room_no_deductions'] = "0";
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
        $curr_status=$data['received'][0]['status'];
        if($curr_status==="departed" || $curr_status==="ledger"){
            $data['received'][0]['action'] = "view";
        }

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
        $this->checkAccess($this->session->reservation, 3);
        $data = $this->data;
        $app_date = strtotime($data['app_date']);

        $ID = $this->input->post('guest_ID');
        $guest_master_id = $this->input->post('guest_master_id');
        $type = $this->input->post('guest_type');
        $action = $this->input->post('guest_action');
        $mode = $this->input->post('guest_mode');
        $page_number = $this->input->post('guest_page_number');
        $client_name = trim($this->input->post('guest_client_name'));
        $roomtype = trim($this->input->post('guest_roomtype'));
        $price_rate = trim($this->input->post('guest_price_rate'));
        $status = $this->input->post('guest_status');
        $guest_nights = $this->input->post('guest_nights');
        $errors = FALSE;
        
        $this->form_validation->set_rules('guest_roomtype_id', 'Room Type', 'is_natural_no_zero|required');
        $this->form_validation->set_rules('guest_adults', 'Adults', 'is_natural|required');
        $this->form_validation->set_rules('guest_children', 'Children', 'is_natural|required');
        $this->form_validation->set_rules('guest_price_rate_id', 'Price Rate', 'is_natural_no_zero|required');
        $this->form_validation->set_rules('guest_nights', 'Nights', 'is_natural_no_zero|required');

        if (empty($client_name)) {
            $this->session->set_flashdata('client_name_error', "Invalid Client Name value");
            $errors = TRUE;
        }
        if (empty($roomtype)) {
            $this->session->set_flashdata('roomtype_error', "Invalid Room type value");
            $errors = TRUE;
        }
        if (empty($price_rate)) {
            $this->session->set_flashdata('price_rate_error', "Invalid Price rate value");
            $errors = TRUE;
        }
        if (empty($guest_nights)) {
            $this->session->set_flashdata('nights_error', "Invalid Nights value");
            $errors = TRUE;
        }

        $arrival_temp = $this->input->post('guest_arrival');
        $temp_date = str_replace('/', '-', $arrival_temp);
        $arrival = strtotime($temp_date);        

        if ($errors || $this->form_validation->run() == FALSE) {            
            $errors = TRUE;
//            echo validation_errors();exit;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showReservation("guest", $ID,$guest_master_id, $page_number, $action, $mode, $errors);
        } else {
            $res_result = $this->resv_model->saveGuest($type);
            $res_id = $res_result['reservation_id'];
            $this->session->set_flashdata('resv_active_row', $res_id);
            $client_exists = $res_result['client_exists'];
            if (!empty($client_exists)) {
                $this->session->set_flashdata('new_client', $client_exists);
            }

            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                if (($status === "confirmed") && ($arrival === $app_date)) {
                    $redirect = "resv/checkin/" . $mode . "/" . $res_id;
                } else {
                    $redirect = "resv/" . $mode;
                }
                redirect($redirect);
            } else {
                $errors = TRUE;
                $this->showReservation("guest", $ID, $page_number, $action, $mode, $errors);
            }
        }
    }  
    

    public function processFolioPayment() {
        //validates folio payment
        $this->checkAccess($this->session->reservation, 3);
        
        $resv_ID = $this->input->post('folio_payment_resv');
        $page_number = $this->input->post('folio_payment_page_number');
        $mode = $this->input->post('folio_payment_type');
        $client_name = $this->input->post('folio_payment_client_name');
        $folio_room = $this->input->post('folio_payment_new_folio');
        $bills_type = $this->input->post('folio_payment_bills_type');
        $room_number = $this->input->post('folio_payment_room_number');
        $master_id = $this->input->post('folio_payment_master_id');

        $this->form_validation->set_rules('folio_payment_amount', 'Amount', 'greater_than[-1]|required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('folio_payment_error_message', validation_errors());
            $this->viewFolios($resv_ID, $master_id,$page_number, $mode, $client_name,$bills_type,$folio_room,$room_number);
        } else {
            $res_id = $this->resv_model->saveFolio('folio_payment');
            $this->session->set_flashdata('folio_active_row', $res_id);

            if ($res_id) {
                $redirect = $this->session->folio_back_uri;
                redirect($redirect);
            } else {
                $this->viewFolios($resv_ID, $master_id,$page_number, $mode, $client_name,$bills_type,$folio_room,$room_number);
            }
        }
    }

    public function processFolioSale() {
        //validates folio sale
        $this->checkAccess($this->session->reservation, 3);
        
        $resv_ID = $this->input->post('folio_sale_resv');
        $page_number = $this->input->post('folio_sale_page_number');
        $mode = $this->input->post('folio_sale_type');
        $client_name = $this->input->post('folio_sale_client_name');
        $bills_type = $this->input->post('folio_sale_bills_type');
        $folio_room = $this->input->post('folio_sale_new_folio');
        $room_number = $this->input->post('folio_sale_room_number');
        $master_id = $this->input->post('folio_sale_master_id');

        $this->form_validation->set_rules('folio_sale_plu', 'PLU No', 'required');
        $this->form_validation->set_rules('folio_sale_account', 'Account', 'greater_than[0]|required');
        $this->form_validation->set_rules('folio_sale_price', 'Price', 'greater_than[0]|required');
        $this->form_validation->set_rules('folio_sale_qty', 'Quantity', 'greater_than[0]|required');
        $this->form_validation->set_rules('folio_sale_amount', 'Amount', 'greater_than[0]|required');
        $this->form_validation->set_rules('folio_sale_description', 'Description', 'trim|alpha_numeric_spaces');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('folio_sale_error_message', validation_errors());
            $this->viewFolios($resv_ID, $master_id,$page_number, $mode, $client_name,$bills_type,$folio_room,$room_number);
        } else {
            $res_id = $this->resv_model->saveFolio('folio_sale');
            $this->session->set_flashdata('folio_active_row', $res_id);

            if ($res_id) {
                $redirect = $this->session->folio_back_uri;
                redirect($redirect);
            } else {
                $this->viewFolios($resv_ID, $master_id,$page_number, $mode, $client_name,$bills_type,$folio_room,$room_number);
            }
        }
    }

    public function viewLists($type, $offset = 0) {
        /* displays paginised list of reservation items 
         * also displays client personal info
         */
        $this->session->resv_back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords('guest');
        $data["module"] = "reservation";
        $data["type"] = $type;
        $data["new_client"] = (isset($this->session->new_client)) ? ($this->session->new_client) : ("");
        $data['countries'] = $this->app_model->getDisplayedItems('ref_country')['data'];

        $limit = 10;
        if ($type == "person") {
            $this->session->back_uri = base_url() . uri_string();
            $page = $type;
            $page_number = "0";
            if (isset($this->session->client_error_message)) {
                $data['received'][0]['form_error'] = $this->session->client_error_message;
                $data['received'][0]['search_title'] = $this->input->post('search_title');//search phrase
                $data['received'][0]['title'] = $this->input->post('person_title');
                $data['received'][0]['type'] = $this->input->post('person_type');
                $data['received'][0]['action'] = $this->input->post('person_action');
                $data['received'][0]['page_number'] = $this->input->post('person_page_number');
                $data['received'][0]['ID'] = $this->input->post('person_ID');
                $data['received'][0]['title_ref'] = $this->input->post('person_title_ref');
                $data['received'][0]['email'] = $this->input->post('person_email');
                $data['received'][0]['phone'] = $this->input->post('person_phone');
                $data['received'][0]['city'] = $this->input->post('person_city');
                $data['received'][0]['state'] = $this->input->post('person_state');
                $data['received'][0]['country'] = $this->input->post('person_country');
                $data['received'][0]['street'] = $this->input->post('person_street');
                $data['received'][0]['sex'] = $this->input->post('person_sex');
                $data['received'][0]['occupation'] = $this->input->post('person_occupation');
                $data['received'][0]['birth_location'] = $this->input->post('person_birth_location');
                $data['received'][0]['passport_no'] = $this->input->post('person_passport_no');
                $data['received'][0]['pp_issued_at'] = $this->input->post('person_pp_issued_at');
                $data['received'][0]['spg_no'] = $this->input->post('person_spg_no');
                $data['received'][0]['visa'] = $this->input->post('person_visa');
                $data['received'][0]['resident_permit_no'] = $this->input->post('person_resident_permit_no');
                $data['received'][0]['destination'] = $this->input->post('person_destination');
                $data['received'][0]['group_name'] = $this->input->post('person_group_name');
                $data['received'][0]['plate_number'] = $this->input->post('person_plate_number');
                $data['received'][0]['remarks'] = $this->input->post('person_remarks');
                $data['received'][0]['payment_method'] = $this->input->post('person_payment_method');
            } else {
                $data['received'][0]['form_error'] = "";
                $data['received'][0]['title'] = "";
                $data['received'][0]['search_title'] = "";
                $data['received'][0]['type'] = $type;
                $data['received'][0]['action'] = "insert";
                $data['received'][0]['page_number'] = $page_number;
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
            }
            //check for deletes
            if (isset($this->session->delete_person_error)) {
                $data['received'][0]['person_form_error'] = $this->session->delete_person_error();
                $data['received'][0]['search_form_error'] = "";
            } else {
                $data['received'][0]['person_form_error'] = "";
                $data['received'][0]['search_form_error'] = "";
            }
        } else {
            $page = "reservation";
        }
        $data["received"][0]["type"] = $type;
        $data["received"][0]["offset"] = $offset;

        $results = $this->resv_model->getReservations($type, $offset, $limit);
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'resv/viewLists/' . $type;
        $page_nav["total_rows"] = $results['count'];
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();
        //show page
        $this->showPage($data, $page, 1); 
    }
    
     public function processPersonSearch($type="person", $offset = 0) {
        /* displays paginised list of reservation items 
         * also displays client personal info
         */
         
        $this->session->resv_back_uri = base_url() . uri_string();
        $this->checkAccess($this->session->reservation, 2);

        $data = $this->data;
        $data['room_stats'] = $this->app_model->getRoomMonitor();
        $data["header_title"] = ucwords($type);
        $data["bar_title"] = ucwords('guest');
        $data["module"] = "reservation";
        $data["type"] = $type;
        $data["new_client"] = (isset($this->session->new_client)) ? ($this->session->new_client) : ("");
        $data['countries'] = $this->app_model->getDisplayedItems('ref_country')['data'];
        
        $search_title = $this->input->get('search_title');//search phrase

        $limit = 10;
        if ($type == "person") {
            $this->session->back_uri = current_full_url();
//            echo $this->session->back_uri;exit;
            $page = $type;
            $page_number = "0";
            if (isset($this->session->client_error_message)) {
                $data['received'][0]['form_error'] = $this->session->client_error_message;
                $data['received'][0]['search_title'] = $this->input->get('search_title');//search phrase
                $data['received'][0]['title'] = $this->input->post('person_title');
                $data['received'][0]['type'] = $this->input->post('person_type');
                $data['received'][0]['action'] = $this->input->post('person_action');
                $data['received'][0]['page_number'] = $this->input->post('person_page_number');
                $data['received'][0]['ID'] = $this->input->post('person_ID');
                $data['received'][0]['title_ref'] = $this->input->post('person_title_ref');
                $data['received'][0]['email'] = $this->input->post('person_email');
                $data['received'][0]['phone'] = $this->input->post('person_phone');
                $data['received'][0]['city'] = $this->input->post('person_city');
                $data['received'][0]['state'] = $this->input->post('person_state');
                $data['received'][0]['country'] = $this->input->post('person_country');
                $data['received'][0]['street'] = $this->input->post('person_street');
                $data['received'][0]['sex'] = $this->input->post('person_sex');
                $data['received'][0]['occupation'] = $this->input->post('person_occupation');
                $data['received'][0]['birth_location'] = $this->input->post('person_birth_location');
                $data['received'][0]['passport_no'] = $this->input->post('person_passport_no');
                $data['received'][0]['pp_issued_at'] = $this->input->post('person_pp_issued_at');
                $data['received'][0]['spg_no'] = $this->input->post('person_spg_no');
                $data['received'][0]['visa'] = $this->input->post('person_visa');
                $data['received'][0]['resident_permit_no'] = $this->input->post('person_resident_permit_no');
                $data['received'][0]['destination'] = $this->input->post('person_destination');
                $data['received'][0]['group_name'] = $this->input->post('person_group_name');
                $data['received'][0]['plate_number'] = $this->input->post('person_plate_number');
                $data['received'][0]['remarks'] = $this->input->post('person_remarks');
                $data['received'][0]['payment_method'] = $this->input->post('person_payment_method');
            } else {
                $data['received'][0]['form_error'] = "";
                $data['received'][0]['title'] = "";
                $data['received'][0]['search_title'] = $search_title;
                $data['received'][0]['type'] = $type;
                $data['received'][0]['action'] = "insert";
                $data['received'][0]['page_number'] = $page_number;
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
            }
            //check for deletes
            if (isset($this->session->delete_person_error)) {
                $data['received'][0]['person_form_error'] = $this->session->delete_person_error();
                $data['received'][0]['search_form_error'] = "";
            } else {
                $data['received'][0]['person_form_error'] = "";
                $data['received'][0]['search_form_error'] = "";
            }
        } 
        
        $data["received"][0]["type"] = $type;
        $data["received"][0]["offset"] = $offset;

        $results = $this->resv_model->searchAppClients($search_title,$type, $offset, $limit);
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = current_full_url();
        $page_nav["total_rows"] = $results['count'];
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();
        //show page
        $this->showPage($data, $page, 1); 
    }
    
    public function confirmMoveFolioRoom() {    
        $res = $this->resv_model->confirmMoveFolioRoom($_POST['room_id']);
        echo $res;
    }

    public function moveFolios() {
        $folio_IDs = json_decode($_POST['selected_rows']);
        $resv=$_POST['reservation_id'];
        $folio_type=$_POST['folio'];
        $move_reason=$_POST['move_reason'];
        
        $res = $this->resv_model->moveFolios($resv, $folio_IDs,$folio_type,$move_reason);
        echo $res;
    }
       
    public function updateOverdueDepartures() {
        $resv_IDs = json_decode($_POST['selected_rows']);        
        $res = $this->resv_model->updateOverdueDepartures($resv_IDs);
        echo $res;
    }
    
    public function manualRoomCharge() {
        $reason=$_POST['manual_charge_reason'];
        $reservation=$_POST['manual_charge_reservation'];        
        $res = $this->resv_model->manualRoomCharge($reservation,$reason);
        echo $res;
    }

    public function serviceCharge() {
        $reason=$_POST['service_charge_reason'];
        $reservation=$_POST['service_charge_reservation']; 
        // $reason="yes";
        // $reservation="000000000020";
        $res = $this->resv_model->serviceCharge($reservation,$reason);
        echo $res;
    }
    
    
    public function confirmOperations() {
    //    $reason="yes";
    //    $type="backup";
        $reason=$_POST['reason'];
        $type=$_POST['type'];
        
        switch ($type) {
            case 'backup':
                $res = $this->resv_model->backup();
                break;
            case 'charge':
                $res = $this->resv_model->autoRoomCharge();                
                break;
            case 'close':
                $res = $this->resv_model->closeAccount();
                break;
            case 'reactivate':
                $resv_id=$_POST['resv_id'];
                $res = $this->resv_model->reactivateAccount($resv_id,$reason);
                break;
            case 'master':
                $resv_id=$_POST['resv_id'];
                $master_id=$_POST['master_id'];
                $res = $this->resv_model->masterFolios($resv_id,$master_id,$reason);
                break;
            case 'return':
                $folio_IDs = json_decode($_POST['selected_rows']);
                $res = $this->resv_model->returnFolios($folio_IDs,$reason);
                break;
            default:
                break;
        }    
        if($res['response']==="success"){
           $this->session->set_flashdata('form_success', $res['message']); 
        }        
        echo json_encode($res);
    }
    
    public function showLedger($type) {
        /* displays paginised list of items */
        $this->checkAccess($this->session->overview, 2);
        
        $data = $this->data;
        $data["header_title"] = ucwords("ledger ".$type);
        $data["module"] = "ledger";
        $data["type"] = "ledger ".$type;
        $data["page_number"] = 0;
        $data["action"] = "";
        $data['received'][0]['count'] = 0;
        $page="ledger";
        
        $data["collection"] = $this->resv_model->getLedger($type);
        //show page
        $this->showPage($data, $page, 0); 
    }
    
    public function showReports() {
        /* displays paginised list of items */
        $this->checkAccess($this->session->reports, 2);

        $data = $this->data;
        $data["header_title"] = ucwords("Reports");
        $data["type"] = "reports";
        $data["received"][0]["type"] = "report";     
        $data["collection"] = $this->resv_model->getUsers();
        $page="report";
        //show page
        $this->showPage($data, $page, 0); 
    }

    public function viewFolios($resv_ID,$master_id, $page_number, $mode, $client_name, $bills_type, $folio_room,$room_number=0, $offset = 0) {
        /* displays paginised list of folios items,
         * stores mode & resv ID,client name,folio_room bill
         * gets folios from all bills or specific ones */
        if (!isset($this->session->folio_payment_error_message) && (!isset($this->session->folio_sale_error_message))) {
            $this->session->folio_back_uri = base_url() . uri_string();
        }
        $this->checkAccess($this->session->reservation, 2);
        $client_name=urldecode ($client_name);

        $data = $this->data;
        $data["header_title"] = preg_replace('/[^A-Za-z.\s?]/', '', $client_name) . ": " . $resv_ID;
        $data["module"] = "reservation";
        $data["type"] = "folio";
        $data["mode"] = $mode;
        $data["received"][0]["type"] = $mode;
        $data["received"][0]["offset"] = $offset;
        $data["received"][0]["client_name"] = preg_replace('/[^A-Za-z.\s?]/', '', $client_name);
        $data["received"][0]["client_reservation_id"] = $resv_ID;
        $data["received"][0]["bills"] = $bills_type;
        $data["received"][0]["folio_room"] = $folio_room;
        $data["received"][0]["move_rooms"] = 0;
        $data["received"][0]["room_number"] = $room_number;
        $data["received"][0]["master_id"] = $master_id;
        $data['payment_accounts'] = $this->app_model->getDisplayedItems('account_payment')['data'];
        $data['sale_accounts'] = $this->app_model->getDisplayedItems('account_sale')['data'];
        $data['plu_numbers'] = $this->app_model->getDisplayedItems('account_plu_number')['data'];
        $data['plu_groups'] = $this->app_model->getDisplayedItems('account_plu_group')['data'];
        $row_data = $this->app_model->getARow('reservation',$resv_ID);
        $data["received"][0]["departure"] = $row_data['departure'];

        if (isset($this->session->folio_payment_error_message)) {
            $data['received'][0]['payment_form_error'] = $this->session->folio_payment_error_message;
            $data['received'][0]['amount'] = $this->input->post('folio_payment_amount');
            $data['received'][0]['account'] = $this->input->post('folio_payment_account');
        } else {
            $data['received'][0]['payment_form_error'] = "";
            $data['received'][0]['amount'] = 0;
            $data['received'][0]['account'] = 1;
        }

        if (isset($this->session->folio_sale_error_message)) {
            $data['received'][0]['sale_form_error'] = $this->session->folio_sale_error_message;
            $data['received'][0]['ID'] = $this->input->post('folio_sale_ID');
            $data['received'][0]['plu'] = $this->input->post('folio_sale_plu');
            $data['received'][0]['sale_account'] = $this->input->post('folio_sale_account');
            $data['received'][0]['sale_account_title'] = $this->input->post('folio_sale_account_title');
            $data['received'][0]['plu_group'] = $this->input->post('folio_sale_plu_group');
            $data['received'][0]['sale_price'] = $this->input->post('folio_sale_price');
            $data['received'][0]['sale_qty'] = $this->input->post('folio_sale_qty');
            $data['received'][0]['sale_amount'] = $this->input->post('folio_sale_amount');
            $data['received'][0]['plu_description'] = $this->input->post('folio_sale_description');
        } else {
            $data['received'][0]['sale_form_error'] = "";
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['plu'] = "";
            $data['received'][0]['sale_account'] = 0;
            $data['received'][0]['sale_account_title'] = "";
            $data['received'][0]['plu_group'] = 1;
            $data['received'][0]['sale_price'] = 0;
            $data['received'][0]['sale_qty'] = 1;
            $data['received'][0]['sale_amount'] = 0;
            $data['received'][0]['plu_description'] = "";
        }


        $limit = 30;
        $page = "folio";
        if ($bills_type !== "ALL") {
            $results = $this->resv_model->getFoliosForBILL($resv_ID, $offset, $limit, $bills_type);
        } else {
            $results = $this->resv_model->getFolios($resv_ID, $offset, $limit);
        }
        
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];
        $data["resv_room_title"] = $results['room'];
        //totals
        $totals = $results['totals'];
        $data["sale_total"] = $totals['SALE_TOTAL'];
        $data["payment_total"] = $totals['PAYMENT_TOTAL'];
        $data["vat_total"] = $totals['VAT_TOTAL'];
        $data["service_charge_total"] = $totals['SERVICE_CHARGE_TOTAL'];
        $data["sub_total"] = $totals['SUB_TOTAL'];
        $data["folio_diff"] = $totals['FOLIO_DIFF'];
        $data["red_bal"] = $totals['RED_BAL'];
        //bill totals deductions
        $deductions = $results['deductions'];
        $data["bill1"] = (isset($deductions['BILL1'])) ? ($deductions['BILL1']) : (0);
        $data["bill2"] = (isset($deductions['BILL2'])) ? ($deductions['BILL2']) : (0);
        $data["bill3"] = (isset($deductions['BILL3'])) ? ($deductions['BILL3']) : (0);
        $data["bill4"] = (isset($deductions['BILL4'])) ? ($deductions['BILL4']) : (0);
        $data["inv"] = (isset($deductions['INV'])) ? ($deductions['INV']) : (0);

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'resv/viewFolios/' . $resv_ID . '/'. $master_id . '/' . $page_number . '/' . $mode . '/' . $client_name . '/' . $bills_type.'/'.$folio_room. '/' . $room_number;
        $page_nav["per_page"] = $limit;
        $page_nav["total_rows"] = $results['count'];
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();
        //show page
        $this->showPage($data, $page, 0);
    }

    public function viewFoliosCheckout($resv_ID, $client_name,$room_number) {
        /* displays folio bills for checkout*/    
        $this->checkAccess($this->session->reservation, 2);

        $data = $this->data;
        $data["header_title"] = "Checkout";
        $data["module"] = "reservation";
        $data["type"] = "folio";
        $client_name=urldecode ($client_name);
        $data["received"][0]["client_name"] = preg_replace('/[^A-Za-z.\s?]/', '', $client_name);
        $data["received"][0]["client_reservation_id"] = $resv_ID;
        $data["received"][0]["room_number"] = $room_number;

        $page = "checkout";
        $deductions = $this->resv_model->getFolioDeductions($resv_ID);

        //bill totals deductions
        $data["bill1"] = (isset($deductions['BILL1'])) ? ($deductions['BILL1']) : (0);
        $data["bill2"] = (isset($deductions['BILL2'])) ? ($deductions['BILL2']) : (0);
        $data["bill3"] = (isset($deductions['BILL3'])) ? ($deductions['BILL3']) : (0);
        $data["bill4"] = (isset($deductions['BILL4'])) ? ($deductions['BILL4']) : (0);
        $data["inv"] = (isset($deductions['INV'])) ? ($deductions['INV']) : (0);
        //show page
        
        $this->showPage($data, $page, 0);
    }

    
    public function viewOverdueDepartures($offset = 0) {
        /* displays paginised list of overdue reservations*/
        $this->checkAccess($this->session->maintenance, 2);

        $data = $this->data;
        $data["header_title"] = "Overdue Departures";
        $data["module"] = "maintenance";
        $data["type"] = "overdue";
        $data["received"][0]["type"] = "overdue";
        
        $limit = 20;
        $page = "overdue_departures";
        $results = $this->resv_model->getOverdueDepartures($offset, $limit);
        $data["collection"] = $results['data'];
        $data["total"] = $results['count'];
        
        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'resv/viewOverdueDepartures';
        $page_nav["per_page"] = $limit;
        $page_nav["total_rows"] = $results['count'];
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();
        //show page
        $this->showPage($data, $page, 0);
    }

    
    public function processPerson() {
        //save data
        $this->checkAccess($this->session->reservation, 3);
        $redirect = $this->session->back_uri;

        $ID = $this->input->post('person_ID');
        $type = $this->input->post('person_type');

        if ($ID > 0) {
            $this->form_validation->set_rules('person_title', 'Name', 'trim|required');
        } else {
            $this->form_validation->set_rules('person_title', 'Name', 'trim|required|is_unique[personitems.title]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('client_error_message', validation_errors());
            $redirect = $this->session->back_uri;
            redirect($redirect);
        } else {
            $res_id = $this->resv_model->savePerson($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                redirect($redirect);
            } else {
                $redirect = $this->session->back_uri;
                redirect($redirect);
            }
        }
    }

    public function fetchModalData($type, $ID, $filter = FALSE) {
        $this->checkAccess($this->session->reservation, 2);
        switch ($type) {
            case 'roomtype':
                $result = $this->resv_model->getModalItems($type, TRUE, $ID, $filter);
                break;
            case 'room_number':
            case 'price_rate':
                $result = $this->resv_model->getModalItems($type, TRUE, $ID, $filter);
                break;
            default:
                break;
        }
        echo $result;
    }

}
