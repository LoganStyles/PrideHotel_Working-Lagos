<?php

/**
 * Description of Report
 *
 * @author EMMANUEL
 */
class Report extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function printAllItems($type, $offset = 0) {

        $this->chkLoggedIn();
        $access = $this->session->reports;
        if ($access < 2) {//read access
            $redirect = "app";
            redirect($redirect);
        }
        
        $config = array();
        $limit = 20;

        $data = $this->data;
        $data["header_title"] = strtoupper("housekeeping");
        $results = $this->app_model->getDisplayedItems('room'); //get room info
        $data['roomtypes'] = $this->app_model->getDisplayedItems('roomtype')['data'];//possible modify
        $data['room_status'] = $this->app_model->getDisplayedItems('room_status')['data'];

        $data[$type] = $results['data'];
        $config["base_url"] = base_url() . 'report/printAllItems/' . $type;
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

        if (!file_exists(APPPATH . 'views/app/prints/' . $type . '.php')) {
            echo base_url() . 'views/app/prints/' . $type . '.php';
            show_404();
        }

        $this->load->view('app/scripts/header_print', $data);
        $this->load->view('app/prints/' . $type, $data);
        $this->load->view('app/scripts/footer', $data);
    }

}
