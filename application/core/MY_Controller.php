<?php

/**
 * generic controller
 *
 * @author EMMANUEL
 */
class MY_Controller extends CI_Controller {
    protected $data = [];
    protected $page_nav = [];

    function __construct() {
        parent::__construct();
        //set/get some globals
        $site_results = $this->app_model->getDisplayedItems('site'); //get site info
        $this->data['site'] = $site_results['data'];
        $this->data['expiration'] = $site_results['expiration'];
        $this->data['app_date']= date('Y-m-d',strtotime($this->app_model->getAppInfo()));//app date 
        $this->data['module']="";
        $this->data['action']="";
        $this->data['arrival'] = "";
        $this->data['resv_status'] = "";
        $this->data['departure'] = "";
        $this->data['arrivaldate'] = "";
        $this->data['departuredate'] = "";
        $this->data['print'] = "";
        $this->data['new_client'] = "";
        $this->data['bar_title'] = "";
        
        //pagination params
        $this->page_nav['full_tag_open'] = '<ul class="pagination">';
        $this->page_nav['full_tag_close'] = '</ul>';
        $this->page_nav['prev_link'] = '«Previous';
        $this->page_nav['prev_tag_open'] = '<li>';
        $this->page_nav['prev_tag_close'] = '</li>';
        $this->page_nav['next_link'] = 'Next»';
        $this->page_nav['next_tag_open'] = '<li>';
        $this->page_nav['next_tag_close'] = '</li>';
        $this->page_nav['cur_tag_open'] = '<li class="active"><a href="#">';
        $this->page_nav['cur_tag_close'] = '</a></li>';
        $this->page_nav['num_tag_open'] = '<li>';
        $this->page_nav['num_tag_close'] = '</li>';

        $this->page_nav['first_tag_open'] = '<li>';
        $this->page_nav['first_tag_close'] = '</li>';
        $this->page_nav['last_tag_open'] = '<li>';
        $this->page_nav['last_tag_close'] = '</li>';

        $this->page_nav['first_link'] = '&lt;&lt;';
        $this->page_nav['last_link'] = '&gt;&gt;';
    }
    
    protected function checkAccess($access,$level) {
        if (!isset($this->session->us_signature) || (intval($access) < intval($level))) {
            $redirect = "app";
            redirect($redirect);
        } 
    }
    
    public function backURI() {
        $redirect = (isset($this->session->back_uri)?($this->session->back_uri):("app"));
        redirect($redirect);
    }

}
