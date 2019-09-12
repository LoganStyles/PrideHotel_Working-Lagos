<?php
class Report extends App {
//controller for printing
    public function __construct() {
        parent::__construct();
        $this->data["rooms"] = $this->app_model->getDisplayedItems('room'); //get room info
        $this->data['print'] = "yes";
        $this->data["paper_type"] = "plain";
    }

    public function printAllItems($type, $offset = 0) {
        //currently prints housekeeping only
        $this->checkAccess($this->session->reports, 2);
        $limit = FALSE;
        $data = $this->data;
        $data["header_title"] = strtoupper("housekeeping");
        $data["type"] = $type;
        $data['room_status'] = $this->app_model->getDisplayedItems('room_status')['data'];
        $data[$type] = $data['rooms']['data'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'report/printAllItems/' . $type;
        $page_nav["total_rows"] = $data['rooms']['count'];
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();

        $this->showPage($data, $type);
    }

    public function printReservations($type,$guest_type, $offset = 0) {
        //prints reservations
        $this->checkAccess($this->session->reports, 2);
        $limit = FALSE;
        $page = "reservation";

        $data = $this->data;
        $data["header_title"] = strtoupper($type);
        $data["type"] = $type;
        $data["rooms_r"] = $data['rooms']['data'];
        if($guest_type==="guest"){
          $results = $this->resv_model->getReservations($type, $offset, $limit);  
        }elseif($guest_type==="house"){
          $results = $this->resv_model->getHouseReservations($type, $offset, $limit);  
        }else{
          $results = $this->resv_model->getGroupReservations($type, $offset, $limit);
        } 
        $data["collection"] = $results['data'];
        $data["sum_data"] = $results['sum'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'report/printReservations/' . $type.'/'.$guest_type;
        $page_nav["total_rows"] = $results['count'];
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();

        $this->showPage($data, $page);
    }

    public function printFolios($resv_id, $paper_type, $filter) {
        //prints folios
        $this->checkAccess($this->session->reports, 2);

        $limit = FALSE;
        $page = "folio";

        $data = $this->data;
        $data["header_title"] = strtoupper("Folio");
        $data["type"] = "folio";
        $data["paper_type"] = $paper_type;
        $data["bill_type"] = strtoupper($filter);

        if ($filter == "all") {
            $filter = FALSE;
        }
        $results = $this->resv_model->getFoliosForPrint($resv_id, $filter);

        $data["collection"] = $results['data'];
        $totals = $results['totals'];

        $data['sale_total'] = $totals['SALE_TOTAL'];
        $data['payment_total'] = $totals['PAYMENT_TOTAL'];
        $data['balance_left'] = $totals['FOLIO_DIFF'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'report/printFolios/' . $resv_id . '/' . $paper_type;
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();

        $this->showPage($data, $page);
    }
    
    public function printReceipt() {
        //prints receipts        
        $this->checkAccess($this->session->reservation, 2);
        $folio_IDs = json_decode($_POST['selected_rows']); 
        $resv_id=$_POST['reservation_id'];

        $page = "receipt";

        $data = $this->data;
        $data["header_title"] = strtoupper("Guest Reservation Receipt");
        $data["type"] = "reservation";
        $data["paper_type"]=$_POST['paper_type'];
        
        $results = $this->resv_model->getFoliosForReceipt($resv_id, $folio_IDs);

        $data["collection"] = $results['data'];
        $data['payment_total'] = $results['payment_total']['debit'];

        $personal = $results['personal'];
        $data['client_name'] = $personal['client_name'];
        $data['date_created'] = date("d/m/Y", strtotime($personal['date_created']));
        $data['actual_arrival'] = date("d/m/Y", strtotime($personal['actual_arrival']));
        $data['actual_departure'] = (strtotime($personal["actual_departure"]) > strtotime($personal["departure"])) ? (date('d/m/Y', strtotime($personal["actual_departure"]))) : (date('d/m/Y', strtotime($personal["departure"])));
        $data['nights'] = $personal['nights'];
        $data['reservation_id'] = $personal['reservation_id'];
        $data['room_number'] = $personal['folio_room_number'];
        $data['room_type'] = $personal['folio_room_type'];

        $page_nav = $this->page_nav;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();

        $this->showPage($data, $page);
    }

    public function printCheckout($resv_id, $paper_type, $filter = NULL) {
        //prints checkout details
        $this->checkAccess($this->session->reservation, 2);

        $limit = FALSE;
        $page = "checkout";

        $data = $this->data;
        $data["header_title"] = strtoupper("Checkout");
        $data["type"] = "reservation";
        $data["paper_type"] = $paper_type;
        $results = $this->resv_model->checkout($resv_id, $filter);

        $data["collection"] = $results['data'];
        $totals = $results['totals'];
        $data['sale_total'] = $totals['SALE_TOTAL'];
        $data['payment_total'] = $totals['PAYMENT_TOTAL'];
        $data['balance_left'] = $totals['FOLIO_DIFF'];

        $personal = $results['personal'];
        $data['client_name'] = $personal['client_name'];
        $data['actual_arrival'] = date("Y-m-d", strtotime($personal['actual_arrival']));
        $data['actual_departure'] = date("Y-m-d", strtotime($personal['actual_departure']));
        $data['nights'] = $personal['nights'];
        $data['room_number'] = $personal['folio_room_number'];

        $page_nav = $this->page_nav;
        $page_nav["base_url"] = base_url() . 'report/printCheckout/' . $resv_id . '/' . $paper_type;
        $page_nav["per_page"] = $limit;
        $this->pagination->initialize($page_nav);
        $data['pagination'] = $this->pagination->create_links();

        $this->showPage($data, $page);
    }
    
    public function getReservationReports($resv_id) {
        $this->checkAccess($this->session->reservation, 2);
        $results = $this->resv_model->getReports('reservation',$resv_id);
        $results2 = $this->resv_model->getReports('resev_payments',$resv_id);
                
        $page = "reservation_details";
        
        $data = $this->data;
        $data["header_title"] = strtoupper('reservation');
        $data["type"] = 'reservation';
        
        $data["collection"] = $results['data'];
        $data["collection_payments"] = $results2['data'];
            
        $this->showPage($data, $page);
    }

    public function getReservationReportsShowVAT($resv_id) {
        $this->checkAccess($this->session->reservation, 2);
        $results = $this->resv_model->getReports('reservation',$resv_id);
        $results2 = $this->resv_model->getReports('resev_payments',$resv_id);
                
        $page = "reservation_details_vat";
        
        $data = $this->data;
        $data["header_title"] = strtoupper('reservation');
        $data["type"] = 'reservation';
        
        $data["collection"] = $results['data'];
        $data["collection_payments"] = $results2['data'];
            
        $this->showPage($data, $page);
    }


    public function getReports() {
        //prints reports
        $this->checkAccess($this->session->reports, 2);
        $type = $this->input->post('report_type');
        $from = $this->input->post('report_from');
        $to = $this->input->post('report_to');
        switch ($type) {
            case 'arrivals':
            case 'departures':
            case 'staying guests':
                $page = "report";
                break;
            case 'sales summary':
            case 'sales_fnb_summary':
                $page = "report_sales";
                break;
            case 'cashier summary':
                $page = "report_cashier";
                break;
            case 'audit trail':
                $page = "report_audit";
                break;
            case 'ledger_guest':
            case 'ledger_group':
                $page = "report_ledger";
                break;
            case 'police':
                $page = "report_police";
                break;
            case 'client history':
                $page = "report_client";
                break;
            default:
                break;
        }

        $data = $this->data;
        $data["header_title"] = strtoupper($type . " (" . $from . " - " . $to . ")");
        $data["type"] = $type;

        if ($type == "ledger_guest" || $type == "ledger_group") {
            $ledger_type=  str_replace('ledger_', '', $type);
            $data["collection"] = $this->resv_model->getLedger($ledger_type);
        } else {
            $results = $this->resv_model->getReports($type);
            $data["collection"] = $results['data'];            
        }

        if ($type == "sales summary" || $type == "cashier summary" || $type == "sales_fnb_summary") {
            $data["collection2"] = $results['totals'];
        }

        $this->showPage($data, $page);
    }

    // public function getReportsApi() {
    //     //prints reports
    //     // $this->checkAccess($this->session->reports, 2);

    //     $type = $this->input->post('report_type');
    //     $from = $this->input->post('report_from');
    //     $to = $this->input->post('report_to');

    //     switch ($type) {
    //         case 'arrivals':
    //         case 'departures':
    //         case 'staying guests':
    //             $page = "report";
    //             break;
    //         case 'sales summary':
    //         case 'sales_fnb_summary':
    //             $page = "report_sales";
    //             break;
    //         case 'cashier summary':
    //             $page = "report_cashier";
    //             break;
    //         case 'audit trail':
    //             $page = "report_audit";
    //             break;
    //         case 'ledger_guest':
    //         case 'ledger_group':
    //             $page = "report_ledger";
    //             break;
    //         case 'police':
    //             $page = "report_police";
    //             break;
    //         case 'client history':
    //             $page = "report_client";
    //             break;
    //         default:
    //             break;
    //     }

    //     $data = $this->data;
    //     $data["header_title"] = strtoupper($type . " (" . $from . " - " . $to . ")");
    //     $data["type"] = $type;

    //     if ($type == "ledger_guest" || $type == "ledger_group") {
    //         $ledger_type=  str_replace('ledger_', '', $type);
    //         $data["collection"] = $this->resv_model->getLedger($ledger_type);
    //     } else {
    //         $results = $this->resv_model->getReports($type);
    //         $data["collection"] = $results['data'];            
    //     }

    //     if ($type == "sales summary" || $type == "cashier summary" || $type == "sales_fnb_summary") {
    //         $data["collection2"] = $results['totals'];
    //     }

    //     $this->showPage($data, $page);
    // }

    private function showPage($data, $page) {
        //        displays print out
        if (!file_exists(APPPATH . 'views/app/prints/' . $page . '.php')) {
            echo base_url() . 'views/app/prints/' . $page . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_print', $data);
        $this->load->view('app/prints/' . $page, $data);
        $this->load->view('app/scripts/footer', $data);
    }

}
