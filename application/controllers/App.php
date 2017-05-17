<?php

class App extends MY_Controller {
    /* controller for app
     * displays reservation area by default
     * if no other section is loaded
     */

    public function __construct() {
        parent::__construct();
        $this->data['roomtypes'] = $this->app_model->getDisplayedItems('roomtype')['data'];
        $this->data['accountsale'] = $this->app_model->getDisplayedItems('account_sale')['data'];
        $this->data['roomclasses'] = $this->app_model->getDisplayedItems('roomclass')['data'];
    }

    public function index() {
        if (!isset($_SESSION['us_signature'])) {
            $this->showLogin(); //user has not logged in so redirect to login
        } else {
            $data = $this->data;
            $data["header_title"] = ucwords("reservation");
            $data["type"] = "reservation";
            $data["module"] = "reservation";
            $data['received'][0]['type'] = "reservation";
            $data["action"] = "";
            
            if (!file_exists(APPPATH . 'views/app/templates/top_reservation.php')) {
            echo base_url() . 'views/app/templates/top_reservation.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/top_reservation' , $data);
        $this->load->view('app/scripts/footer', $data);
        }
    }    
    
    public function processUpdate($type, $ID, $value) {
        $result = $this->app_model->updateItems($type, $ID,"status", $value);
        if ($result) {
            $this->session->set_flashdata('form_success', 'Operation Successful');
//            if(){}
            $redirect = "app/housekeeping";
            redirect($redirect);
        }
    }

    public function filters($type, $ID, $value) {
        if (!empty($value)) {
            switch ($type) {
                case 'housekeeping':
                    $filter = " and status='" . $value . "'";
                    break;

                default:
                    break;
            }
        } else {
            $filter = "";
        }

        $this->fetchJsonData($type, $ID, $filter);
    }

    public function fetchJsonData($type, $ID, $filter = FALSE) {
        if (!isset($this->session->us_signature)) {
            $redirect = "app";
            redirect($redirect);
        }

        switch ($type) {
            case 'user':
            case 'roomtype':
            case 'room':
            case 'account_payment':
            case 'account_sale':
            case 'account_plu_number':
            case 'terminals':
            case 'price':
            case 'housekeeping':
                $result = $this->app_model->getJoinedItems($type, TRUE, $ID, $filter);
                break;
            default:
                $result = $this->app_model->getDisplayedItems($type, TRUE, $ID);
                break;
        }
        echo $result;
    }

    public function login($type) {
        //authenticates users        
        if (isset($this->session->us_signature)) {
            //do nothing
        } else {
            $item_signature = "login_signature";
            $item_password = "login_password";
            $this->form_validation->set_rules($item_signature, 'Username', 'required');
            $this->form_validation->set_rules($item_password, 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->error_message = validation_errors();
                $errors = TRUE;
                $this->showLogin($errors);
            } else {
                $login_signature = $this->input->post('login_signature');
                $login_password = $this->input->post('login_password');

                $res_id = $this->app_model->getLoginItems($type, $login_signature, $login_password);
                if ($res_id) {
                    $redirect = "app";
                    redirect($redirect);
                } else {
                    $errors = TRUE;
                    $this->showLogin($errors);
                }
            }
        }
    }

    public function showLogin($errors = NULL) {
        /* displays login form */
        $data = $this->data;
        $item_signature = "login_signature";
        $item_password = "login_password";

        if ($errors) {
            $data['received'][0]['signature'] = $this->input->post($item_signature);
            $data['received'][0]['password'] = $this->input->post($item_password);
            $data['received'][0]['login_error'] = $this->session->error_message;
        } else {//fresh login
            $data['received'][0]['signature'] = "";
            $data['received'][0]['password'] = "";
            $data['received'][0]['login_error'] = "";
        }
        $this->load->view('app/login', $data);
    }

    public function logout() {
        //delete sesssions
        $res = $this->app_model->logout();
        if ($res) {
            $this->session->sess_destroy();
            $redirect = "app";
            redirect($redirect);
        }
    }

    public function showSite($ID, $type, $errors = NULL) {
        /* displays section items */
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }

        $page = $type;
        $item_id = $type . "_ID";
        $item_title = $type . "_title";
        $item_street1 = $type . "_street1";
        $item_street2 = $type . "_street2";
        $item_state = $type . "_state";
        $item_country = $type . "_country";
        $item_tel1 = $type . "_tel1";
        $item_tel2 = $type . "_tel2";
        $item_email = $type . "_email";
        $item_facebook = $type . "_facebook";
        $item_url = $type . "_url";
        $item_logo = $type . "_logo";
        $item_bank_account = $type . "_bank_account";
        $item_twitter = $type . "_twitter";
        $item_type = $type . "_type";

        //get titles for navigation
        $data = $this->data;
        $data["header_title"] = "Configuration";
        $data["type"] = $type;
        $data["page_number"] = 0;
        $data['countries'] = $this->app_model->getDisplayedItems('ref_country')['data'];
        $data["action"] = "";

        if ($ID == "0" && !$errors) {//new item so set defaults
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['street1'] = "";
            $data['received'][0]['street2'] = "";
            $data['received'][0]['state'] = "";
            $data['received'][0]['country'] = "";
            $data['received'][0]['tel1'] = "";
            $data['received'][0]['tel2'] = "";
            $data['received'][0]['email'] = "";
            $data['received'][0]['facebook'] = "";
            $data['received'][0]['url'] = "";
            $data['received'][0]['logo'] = "";
            $data['received'][0]['bank_account'] = "";
            $data['received'][0]['twitter'] = "";
            $data['received'][0]['filename'] = "";
        } elseif ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['street1'] = $this->input->post($item_street1);
            $data['received'][0]['street2'] = $this->input->post($item_street2);
            $data['received'][0]['state'] = $this->input->post($item_state);
            $data['received'][0]['country'] = $this->input->post($item_country);
            $data['received'][0]['tel1'] = $this->input->post($item_tel1);
            $data['received'][0]['tel2'] = $this->input->post($item_tel2);
            $data['received'][0]['email'] = $this->input->post($item_email);
            $data['received'][0]['facebook'] = $this->input->post($item_facebook);
            $data['received'][0]['url'] = $this->input->post($item_url);
            $data['received'][0]['logo'] = $this->input->post($item_logo);
            $data['received'][0]['bank_account'] = $this->input->post($item_bank_account);
            $data['received'][0]['twitter'] = $this->input->post($item_twitter);
            $data['received'][0]['filename'] = $this->input->post('filename');
        } else {//existing about item                        
            $data['received'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['data']; //get current section items
            $data['received'][0]['form_error'] = "";
            if (empty($data['received'][0]['ID'])) {//no items exist
                $redirect = "app";
                redirect($redirect);
            }
        }
        if (!file_exists(APPPATH . 'views/app/templates/' . $page . '.php')) {
            echo base_url() . 'views/app/templates/' . $page . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $page, $data);
        $this->load->view('app/scripts/footer');
    }

    public function saveSite() {
        //save site data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }

        $ID = $this->input->post('site_ID');
        $type = $this->input->post('site_type');

        if ($ID > 0) {
            $this->form_validation->set_rules('site_title', 'Hotel name', 'trim|required');
        } else {
            $this->form_validation->set_rules('site_title', 'Hotel name', 'trim|required|is_unique[siteitems.title]');
        }

        $this->form_validation->set_rules('site_country', "Country", 'greater_than[0]');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->showSite($ID, $type, $errors);
        } else {
            //upload image if exists
            $imagepresent = FALSE;
            if (!empty($_FILES['site_filename']['name'][0])) {
                $config['upload_path'] = './images/UPLOADS/';
                $config['allowed_types'] = 'gif|jpg|png|JPEG';
                $config['max_size'] = 2048;
                $config['max_width'] = 2048;
                $config['max_height'] = 2048;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('site_filename')) {//IF image was notuploaded
                    $error = array('error' => $this->upload->display_errors());
                    $errors = TRUE;
                    $this->showSite($ID, $type, $errors);
                } else {
                    $imagedata = array('upload_data' => $this->upload->data());
                    $imagepresent = TRUE;
                }
            }

            $res_id = $this->app_model->updateSite($type, $imagepresent);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showSite/" . $res_id . "/" . $type;
                redirect($redirect);
            }
        }
    }

    public function processRole() {
        //save role data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('role_ID');
        $type = $this->input->post('role_type');
        $page_number = $this->input->post('role_page_number');
        $action = $this->input->post('role_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('role_title', 'User Group', 'trim|required');
        } else {
            $this->form_validation->set_rules('role_title', 'User Group', 'trim|required|is_unique[roleitems.title]');
        }

        $this->form_validation->set_rules('role_description', 'Description', 'trim');
        $this->form_validation->set_rules('role_reserv_folio', 'Reservation/Folio', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_reports', 'Reports', 'in_list[1,2]');
        $this->form_validation->set_rules('role_utilities', 'Utilities', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_maintenance', 'Maintenance', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_monitors', 'Monitors', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_configuration', 'Configuration', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_prices', 'Prices', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_overview', 'Overview', 'in_list[1,2,3,4]');
        $this->form_validation->set_rules('role_delete_group', 'Delete', 'in_list[0,1]');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showRole($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveRole($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showRole/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processRoom() {
        //save room data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('room_ID');
        $type = $this->input->post('room_type');
        $page_number = $this->input->post('room_page_number');
        $action = $this->input->post('room_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('room_title', 'Room Number', 'trim|required');
        } else {
            $this->form_validation->set_rules('room_title', 'Room Number', 'trim|required|is_unique[roomitems.title]');
        }
        $this->form_validation->set_rules('room_roomtype', "Room Type", 'greater_than[0]');
        $this->form_validation->set_rules('room_roomclass', "Room Class", 'greater_than[0]');
        $this->form_validation->set_rules('room_description', 'Description', 'trim');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showRoom($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveRoom($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showRoom/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processHousekeeping() {
        //save room data        
        $this->chkLoggedIn();

        $access = $this->session->utilities;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('housekeeping_ID');
        $type = $this->input->post('housekeeping_type');
        $page_number = $this->input->post('housekeeping_page_number');
        $action = $this->input->post('housekeeping_action');

        $this->form_validation->set_rules('housekeeping_remark', 'Remark', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showHousekeeping($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->updateHousekeeping("room");
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showHousekeeping/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processAccountPlu() {
        //save account_plu_number data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('account_plu_number_ID');
        $type = $this->input->post('account_plu_number_type');
        $page_number = $this->input->post('account_plu_number_page_number');
        $action = $this->input->post('account_plu_number_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('account_plu_number_title', 'Account Name', 'trim|required');
        } else {
            $this->form_validation->set_rules('account_plu_number_title', 'Account Name', 'trim|required|is_unique[account_plu_numberitems.title]');
        }
        $this->form_validation->set_rules('account_plu_number_description', 'Description', 'trim');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showAccountplu($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveAccountPlu($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showAccountplu/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processAccountPayment() {
        //save account_payment data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('account_payment_ID');
        $type = $this->input->post('account_payment_type');
        $page_number = $this->input->post('account_payment_page_number');
        $action = $this->input->post('account_payment_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('account_payment_title', 'Account Name', 'trim|required');
            $this->form_validation->set_rules('account_payment_code', 'Account Code', 'trim|required');
        } else {
            $this->form_validation->set_rules('account_payment_title', 'Account Name', 'trim|required|is_unique[account_paymentitems.title]');
            $this->form_validation->set_rules('account_payment_code', 'Account Code', 'trim|required|is_unique[account_paymentitems.code]');
        }
        $this->form_validation->set_rules('account_payment_description', 'Description', 'trim');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showAccountpayment($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveAccountPayment($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showAccountpayment/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processAccountSale() {
        //save account_sale data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('account_sale_ID');
        $type = $this->input->post('account_sale_type');
        $page_number = $this->input->post('account_sale_page_number');
        $action = $this->input->post('account_sale_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('account_sale_title', 'Account Name', 'trim|required');
            $this->form_validation->set_rules('account_sale_code', 'Account Code', 'trim|required');
        } else {
            $this->form_validation->set_rules('account_sale_title', 'Account Name', 'trim|required|is_unique[account_saleitems.title]');
            $this->form_validation->set_rules('account_sale_code', 'Account Code', 'trim|required|is_unique[account_saleitems.code]');
        }
        $this->form_validation->set_rules('account_sale_description', 'Description', 'trim');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showAccountsale($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveAccountSale($type);
            if ($res_id) {
                $this->data['accountsale'] = $this->app_model->getDisplayedItems('account_sale')['data'];
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showAccountsale/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processPrice() {
        //save price data
        $this->chkLoggedIn();
        $access = $this->session->prices;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }

        $ID = $this->input->post('price_ID');
        $type = $this->input->post('price_type');
        $page_number = $this->input->post('price_page_number');
        $action = $this->input->post('price_action');

        $this->form_validation->set_rules('price_title', 'Room Type', 'greater_than[0]|required');
        $this->form_validation->set_rules('price_acctsale', 'Account Name', 'greater_than[0]|required');
        $this->form_validation->set_rules('price_description', 'Description', 'trim');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showPrice($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->savePrice($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showPrice/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processTypeclass($type) {
        //save data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }

        $typeid = $type . "_ID";
        $typetype = $type . "_type";
        $typepage_number = $type . "_page_number";
        $typeaction = $type . "_action";
        $typetitle = $type . "_title";
        $typedescription = $type . "_description";

        switch ($type) {
            case 'account_type':
                $display_title = "Account Type";
                $unique_field = 'trim|required|is_unique[account_typeitems.title]';
                break;
            case 'roomclass':
                $display_title = "Room Class";
                $unique_field = 'trim|required|is_unique[roomclassitems.title]';
                break;
            case 'account_discount':
                $display_title = "Account Discount";
                $unique_field = 'trim|required|is_unique[account_discountitems.title]';
                break;
            case 'account_class':
                $display_title = "Account Class";
                $unique_field = 'trim|required|is_unique[account_classitems.title]';
                break;
            case 'account_salescategory':
                $display_title = "Account Sales Category";
                $unique_field = 'trim|required|is_unique[account_salescategoryitems.title]';
                break;
            case 'account_plu_group':
                $display_title = "Account PLU Group";
                $unique_field = 'trim|required|is_unique[account_plu_groupitems.title]';
                break;
        }

        $ID = $this->input->post($typeid);
        $page_number = $this->input->post($typepage_number);
        $action = $this->input->post($typeaction);

        if ($ID > 0) {
            $this->form_validation->set_rules($typetitle, $display_title, 'trim|required');
        } else {
            $this->form_validation->set_rules($typetitle, $display_title, $unique_field);
        }

        $this->form_validation->set_rules($typedescription, 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showTypeclass($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveTypeclass($type);
            if ($res_id) {
                if ($type === "roomclass") {
                    $this->data['roomclasses'] = $this->app_model->getDisplayedItems('roomclass')['data'];
                }
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showTypeclass/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processRoomtype() {
        //save roomtype data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }
        $ID = $this->input->post('roomtype_ID');
        $type = $this->input->post('roomtype_type');
        $page_number = $this->input->post('roomtype_page_number');
        $action = $this->input->post('roomtype_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('roomtype_title', 'Room Type', 'trim|required');
        } else {
            $this->form_validation->set_rules('roomtype_title', 'Room Type', 'trim|required|is_unique[roomtypeitems.title]');
        }

        $this->form_validation->set_rules('roomtype_description', 'Description', 'trim');
        $this->form_validation->set_rules('roomtype_roomclass', "Room Class", 'greater_than[0]');

        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showRoomtype($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveRoomtype($type);
            if ($res_id) {
                $this->data['roomtypes'] = $this->app_model->getDisplayedItems('roomtype')['data'];
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showRoomtype/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function processUser() {
        //save user data
        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 3) {//write access
            $redirect = "app";
            redirect($redirect);
        }

        $ID = $this->input->post('user_ID');
        $type = $this->input->post('user_type');
        $page_number = $this->input->post('user_page_number');
        $action = $this->input->post('user_action');

        if ($ID > 0) {
            $this->form_validation->set_rules('user_title', 'User Name', 'trim|required');
        } else {
            $this->form_validation->set_rules('user_title', 'User Name', 'trim|required|is_unique[useritems.title]');
        }

        $this->form_validation->set_rules('user_title', 'User Name', 'trim|required');
        $this->form_validation->set_rules('user_signature', 'Signature', 'trim|required');
        $this->form_validation->set_rules('user_keyword', 'Keyword', 'trim|required');
        $this->form_validation->set_rules('user_role', 'Role', 'greater_than[0]');


        if ($this->form_validation->run() == FALSE) {
            $errors = TRUE;
            $this->session->set_flashdata('error_message', validation_errors());
            $this->showUser($type, $ID, $page_number, $action, $errors);
        } else {
            $res_id = $this->app_model->saveUser($type);
            if ($res_id) {
                $this->session->set_flashdata('form_success', 'Operation Successful');
                $redirect = "app/showUser/" . $type . "/" . $res_id . "/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        }
    }

    public function showRole($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        //defaults
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_title = $type . "_title";
        $item_action = $type . "_action";
        $item_description = $type . "_description";
        $item_reserv_folio = $type . "_reserv_folio";
        $item_reports = $type . "_reports";
        $item_utilities = $type . "_utilities";
        $item_maintenance = $type . "_maintenance";
        $item_monitors = $type . "_monitors";
        $item_configuration = $type . "_configuration";
        $item_prices = $type . "_prices";
        $item_overview = $type . "_overview";
        $item_delete_group = $type . "_delete_group";
        $item_type = $type . "_type";

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['reserv_folio'] = $this->input->post($item_reserv_folio);
            $data['received'][0]['reports'] = $this->input->post($item_reports);
            $data['received'][0]['utilities'] = $this->input->post($item_utilities);
            $data['received'][0]['maintenance'] = $this->input->post($item_maintenance);
            $data['received'][0]['monitors'] = $this->input->post($item_monitors);
            $data['received'][0]['configuration'] = $this->input->post($item_configuration);
            $data['received'][0]['prices'] = $this->input->post($item_prices);
            $data['received'][0]['overview'] = $this->input->post($item_overview);
            $data['received'][0]['delete_group'] = $this->input->post($item_delete_group);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['reserv_folio'] = "";
            $data['received'][0]['reports'] = "";
            $data['received'][0]['utilities'] = "";
            $data['received'][0]['maintenance'] = "";
            $data['received'][0]['monitors'] = "";
            $data['received'][0]['configuration'] = "";
            $data['received'][0]['prices'] = "";
            $data['received'][0]['overview'] = "";
            $data['received'][0]['delete_group'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showTypeclass($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showRoomtype($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";
        $item_beds = $type . "_beds";
        $item_roomclass = $type . "_roomclass";
        $item_remark = $type . "_remark";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['beds'] = $this->input->post($item_beds);
            $data['received'][0]['roomclass'] = $this->input->post($item_roomclass);
            $data['received'][0]['remark'] = $this->input->post($item_remark);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['beds'] = "1";
            $data['received'][0]['roomclass'] = "";
            $data['received'][0]['remark'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showRoom($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        //defaults
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";
        $item_bed = $type . "_bed";
        $item_remark = $type . "_remark";
        $item_roomclass = $type . "_roomclass";
        $item_roomtype = $type . "_roomtype";
        $item_acctname = $type . "_acctname";
        $item_frontview = $type . "_frontview";
        $item_backview = $type . "_backview";
        $item_groundfloor = $type . "_groundfloor";
        $item_firstfloor = $type . "_firstfloor";
        $item_secondfloor = $type . "_secondfloor";
        $item_thirdfloor = $type . "_thirdfloor";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['bed'] = $this->input->post($item_bed);
            $data['received'][0]['remark'] = $this->input->post($item_remark);
            $data['received'][0]['roomclass'] = $this->input->post($item_roomclass);
            $data['received'][0]['roomtype'] = $this->input->post($item_roomtype);
            $data['received'][0]['acctname'] = $this->input->post($item_acctname);
            $data['received'][0]['frontview'] = $this->input->post($item_frontview);
            $data['received'][0]['backview'] = $this->input->post($item_backview);
            $data['received'][0]['groundfloor'] = $this->input->post($item_groundfloor);
            $data['received'][0]['firstfloor'] = $this->input->post($item_firstfloor);
            $data['received'][0]['secondfloor'] = $this->input->post($item_secondfloor);
            $data['received'][0]['thirdfloor'] = $this->input->post($item_thirdfloor);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['bed'] = "";
            $data['received'][0]['remark'] = "";
            $data['received'][0]['roomclass'] = "";
            $data['received'][0]['roomtype'] = "";
            $data['received'][0]['acctname'] = "";
            $data['received'][0]['frontview'] = "";
            $data['received'][0]['backview'] = "";
            $data['received'][0]['groundfloor'] = "";
            $data['received'][0]['firstfloor'] = "";
            $data['received'][0]['secondfloor'] = "";
            $data['received'][0]['thirdfloor'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showHousekeeping($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->utilities;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords("Utilities");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_remark = $type . "_remark";

        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['remark'] = $this->input->post($item_remark);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems("room", FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['remark'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems("room", FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showTerminals($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->monitors;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords("Terminals");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;
        $data['received'][0]['count'] = 0;


        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showAccountplu($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data['accountplugroups'] = $this->app_model->getDisplayedItems('account_plu_group')['data'];
        //defaults
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";
        $item_plu_group = $type . "_plu_group";
        $item_acctsale = $type . "_acctsale";
        $item_price = $type . "_price";
        $item_cost = $type . "_cost";
        $item_enable = $type . "_enable";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['plu_group'] = $this->input->post($item_plu_group);
            $data['received'][0]['acctsale'] = $this->input->post($item_acctsale);
            $data['received'][0]['cost'] = $this->input->post($item_cost);
            $data['received'][0]['price'] = $this->input->post($item_price);
            $data['received'][0]['enable'] = $this->input->post($item_enable);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['plu_group'] = "";
            $data['received'][0]['acctsale'] = "";
            $data['received'][0]['cost'] = "";
            $data['received'][0]['price'] = "";
            $data['received'][0]['enable'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showAccountpayment($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data['accounttypes'] = $this->app_model->getDisplayedItems('account_type')['data'];
        $data['accountclasses'] = $this->app_model->getDisplayedItems('account_class')['data'];
        //defaults
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";
        $item_code = $type . "_code";
        $item_alias = $type . "_alias";
        $item_accounttype = $type . "_accounttype";
        $item_debit_credit = $type . "_debit_credit";
        $item_cash_declaration = $type . "_cash_declaration";
        $item_enable = $type . "_enable";
        $item_accountclass = $type . "_accountclass";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['code'] = $this->input->post($item_code);
            $data['received'][0]['accountclass'] = $this->input->post($item_accountclass);
            $data['received'][0]['alias'] = $this->input->post($item_alias);
            $data['received'][0]['accounttype'] = $this->input->post($item_accounttype);
            $data['received'][0]['debit_credit'] = $this->input->post($item_debit_credit);
            $data['received'][0]['cash_declaration'] = $this->input->post($item_cash_declaration);
            $data['received'][0]['enable'] = $this->input->post($item_enable);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['code'] = "";
            $data['received'][0]['accountclass'] = "";
            $data['received'][0]['alias'] = "";
            $data['received'][0]['accounttype'] = "";
            $data['received'][0]['debit_credit'] = "";
            $data['received'][0]['cash_declaration'] = "";
            $data['received'][0]['enable'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showAccountsale($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data['accounttypes'] = $this->app_model->getDisplayedItems('account_type')['data'];
        $data['accountclasses'] = $this->app_model->getDisplayedItems('account_class')['data'];
        $data['discountcats'] = $this->app_model->getDisplayedItems('account_discount')['data'];
        $data['salescats'] = $this->app_model->getDisplayedItems('account_salescategory')['data'];
        //defaults
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";
        $item_code = $type . "_code";
        $item_alias = $type . "_alias";
        $item_accounttype = $type . "_accounttype";
        $item_accountclass = $type . "_accountclass";
        $item_debit_credit = $type . "_debit_credit";
        $item_vattype = $type . "_vattype";
        $item_vatpercent = $type . "_vatpercent";
        $item_enable = $type . "_enable";
        $item_cash_declaration = $type . "_cash_declaration";
        $item_salescategory = $type . "_salescategory";
        $item_discountcategory = $type . "_discountcategory";
        $item_default_price = $type . "_default_price";
        $item_service_charge = $type . "_service_charge";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['code'] = $this->input->post($item_code);
            $data['received'][0]['accountclass'] = $this->input->post($item_accountclass);
            $data['received'][0]['accounttype'] = $this->input->post($item_accounttype);
            $data['received'][0]['alias'] = $this->input->post($item_alias);
            $data['received'][0]['debit_credit'] = $this->input->post($item_debit_credit);
            $data['received'][0]['vattype'] = $this->input->post($item_vattype);
            $data['received'][0]['vatpercent'] = $this->input->post($item_vatpercent);
            $data['received'][0]['salescategory'] = $this->input->post($item_salescategory);
            $data['received'][0]['discountcategory'] = $this->input->post($item_discountcategory);
            $data['received'][0]['default_price'] = $this->input->post($item_default_price);
            $data['received'][0]['service_charge'] = $this->input->post($item_service_charge);
            $data['received'][0]['enable'] = $this->input->post($item_enable);
            $data['received'][0]['cash_declaration'] = $this->input->post($item_cash_declaration);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['code'] = "";
            $data['received'][0]['accountclass'] = "";
            $data['received'][0]['accounttype'] = "";
            $data['received'][0]['alias'] = "";
            $data['received'][0]['debit_credit'] = "";
            $data['received'][0]['vattype'] = "";
            $data['received'][0]['vatpercent'] = "";
            $data['received'][0]['salescategory'] = "";
            $data['received'][0]['discountcategory'] = "";
            $data['received'][0]['default_price'] = "";
            $data['received'][0]['service_charge'] = "";
            $data['received'][0]['cash_declaration'] = "";
            $data['received'][0]['enable'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showPrice($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->prices;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        $data["header_title"] = ucwords("price");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_action = $type . "_action";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_description = $type . "_description";
        $item_acctsale = $type . "_acctsale";
        $item_comp_nights = $type . "_comp_nights";
        $item_comp_visits = $type . "_comp_visits";
        $item_enable = $type . "_enable";
        $item_adults = $type . "_adults";
        $item_children = $type . "_children";
        $item_special = $type . "_special";
        $item_weekday = $type . "_weekday";
        $item_weekend = $type . "_weekend";
        $item_holiday = $type . "_holiday";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['description'] = $this->input->post($item_description);
            $data['received'][0]['acctsale'] = $this->input->post($item_acctsale);
            $data['received'][0]['comp_nights'] = $this->input->post($item_comp_nights);
            $data['received'][0]['comp_visits'] = $this->input->post($item_comp_visits);
            $data['received'][0]['enable'] = $this->input->post($item_enable);
            $data['received'][0]['adults'] = $this->input->post($item_adults);
            $data['received'][0]['children'] = $this->input->post($item_children);
            $data['received'][0]['special'] = $this->input->post($item_special);
            $data['received'][0]['weekday'] = $this->input->post($item_weekday);
            $data['received'][0]['weekend'] = $this->input->post($item_weekend);
            $data['received'][0]['holiday'] = $this->input->post($item_holiday);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['description'] = "";
            $data['received'][0]['acctsale'] = "";
            $data['received'][0]['comp_nights'] = 0;
            $data['received'][0]['comp_visits'] = "";
            $data['received'][0]['enable'] = "";
            $data['received'][0]['adults'] = 0;
            $data['received'][0]['children'] = 0;
            $data['received'][0]['special'] = 0;
            $data['received'][0]['weekday'] = 0;
            $data['received'][0]['weekend'] = 0;
            $data['received'][0]['holiday'] = 0;
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function showUser($type, $ID = 0, $page_number = 0, $action = "", $errors = FALSE) {
        /* displays paginised list of items */

        $this->chkLoggedIn();
        $access = $this->session->configuration;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }

        $data = $this->data;
        //defaults
        $data["header_title"] = ucwords("configuration");
        $data["type"] = $type;
        $data["page_number"] = $page_number;
        $data['roles'] = $this->app_model->getDisplayedItems('role')['data'];
        $data["action"] = $action;

        $item_id = $type . "_ID";
        $item_type = $type . "_type";
        $item_title = $type . "_title";
        $item_action = $type . "_action";
        $item_signature = $type . "_signature";
        $item_keyword = $type . "_keyword";
        $item_role = $type . "_role";


        if ($errors) {
            $data['received'][0]['form_error'] = $this->session->error_message;
            $data['received'][0]['title'] = $this->input->post($item_title);
            $data['received'][0]['type'] = $this->input->post($item_type);
            $data['received'][0]['action'] = $this->input->post($item_action);
            $data['received'][0]['ID'] = $this->input->post($item_id);
            $data['received'][0]['signature'] = $this->input->post($item_signature);
            $data['received'][0]['keyword'] = $this->input->post($item_keyword);
            $data['received'][0]['role'] = $this->input->post($item_role);
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        } else {
            $data['received'][0]['form_error'] = "";
            $data['received'][0]['title'] = "";
            $data['received'][0]['type'] = $type;
            $data['received'][0]['action'] = $action;
            $data['received'][0]['ID'] = 0;
            $data['received'][0]['signature'] = "";
            $data['received'][0]['keyword'] = "";
            $data['received'][0]['role'] = "";
            $data['received'][0]['count'] = $this->app_model->getDisplayedItems($type, FALSE, $ID)['count'];
        }

        if (!file_exists(APPPATH . 'views/app/templates/' . $type . '.php')) {
            echo base_url() . 'views/app/templates/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_scripts_side_navigation', $data);
        $this->load->view('app/templates/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

    public function processDelete() {
        //delete a particular item
        $this->chkLoggedIn();
        $type = $this->input->post("delete_type");
        switch ($type) {
            case 'roomclass':
            case 'account_type':
            case 'account_discount':
            case 'account_class':
            case 'account_salescategory':
            case 'account_plu_group':
                $show = "showTypeclass";
                break;
            case 'account_payment':
                $show = "showAccountpayment";
                break;
            case 'account_sale':
                $show = "showAccountsale";
                break;
            case 'account_plu_number':
                $show = "showAccountplu";
                break;
            default:
                $show = "show" . ucfirst($type);
                break;
        }

        $page_number = $this->input->post('delete_page');

        if (isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1') {
            $action = "delete";

            $res_id = $this->app_model->deleteItem();
            if ($res_id) {
                $redirect = "app/" . $show . "/" . $type . "/0/" . $page_number . "/" . $action;
                redirect($redirect);
            }
        } else {
            $action = "access_denied";
            $redirect = "app/" . $show . "/" . $type . "/0/" . $page_number . "/" . $action;
            redirect($redirect);
        }
    }

    public function page404() {
        $this->load->view('app/page404');
    }

}
