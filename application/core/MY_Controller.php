<?php

/**
 * Description of MY_Controller
 *
 * @author EMMANUEL
 */
class MY_Controller extends CI_Controller {
    /* generic controller */

    protected $data = [];

    function __construct() {
        parent::__construct();
        $this->data['site'] = $this->app_model->getDisplayedItems('site')['data']; //get site info
        $this->data['app_date']=  $this->app_model->getAppInfo();//app info 
        $this->data['module']="";
        $this->data['action']="";
        $this->data['arrival'] = "";
        $this->data['departure'] = "";
        $this->data['arrivaldate'] = "";
        $this->data['departuredate'] = "";
    }
    
    protected function chkLoggedIn() {
        if (!isset($this->session->us_signature)) {
            $redirect = "app";
            redirect($redirect);
        }
    }

}
