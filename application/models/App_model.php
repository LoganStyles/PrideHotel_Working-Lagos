<?php

include_once("passHash.php"); //password hashing

class App_model extends CI_Model {

    private $expired_license=FALSE;
    //handles most queries & db operations
    public function __construct() {
        $this->load->database();
    }

    public function getARow($type, $key) {
        $row = array();
        $tableitems = strtolower($type) . "items";
        $this->db->select('*');
        $this->db->where('reservation_id', $key);
        $query = $this->db->get($tableitems);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
        }
        return $row;
    }

    public function getRoomReservation($room) {
        $q = "SELECT reservation_id from reservationitems "
                . "where room_number=(select ID from roomitems where title ='$room') "
                . "and status='staying' order by ID desc";
        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $resv_id = $row['reservation_id'];
            return $resv_id;
        }
        return false;
    }

    public function updateItems($type, $ID, $field, $value) {
//        updates a single field in a row
        $tableitems = strtolower($type) . "items";

        $this->db->set($field, $value);
        $this->db->where('ID', $ID);
        $res = $this->db->update($tableitems);
        return $res;
    }

    public function getAppInfo() {
//        returns app date
        $app_date = "";
        $this->db->select('last_close_account');
        $this->db->from('maintenance');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->row_array();
            $app_date = $results["last_close_account"];
        }
        return $app_date;
    }
    
    //fetches acct sales used in pos app
    public function getSaleAccounts() {
        $res = array();
        $q = "SELECT ID,description as title from account_saleitems";
        try {
            $query = $this->db->query($q);
            if ($query->num_rows() > 0) {
                $res["response"] = "success";
                $res["data"] = $query->result_array();
            } else {
                $res["response"] = "error";
                $res["message"] = "empty";
            }
        } catch (Exception $e) {
            $res["response"] = "error";
            $res["message"] = 'Error in SQL: ' . $err->getMessage();
        }

        return ($res);
    }

    public function getRoomMonitor() {
        //get metrics like no. of staying,arriving etc
        
        $staying_total = $room_total = $arrival_total = $departure_total = $vacant_total = $occupancy = 0;
        $occupied_total = 0;
        $app_day = date('Y-m-d', strtotime($this->getAppInfo()));
        $this->db->select('ID');
        $this->db->where('status', 'staying');
        $this->db->where('account_type', 'ROOM');
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() > 0) {
            $staying_total = $query->num_rows();
        }

        $this->db->select('ID');
        $this->db->where('status', 'confirmed');
        $this->db->where('arrival', $app_day);
        $this->db->where('account_type', 'ROOM');
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() > 0) {
            $arrival_total = $query->num_rows();
        }
        $this->db->select('ID');
        $this->db->where('status', 'staying');
        $this->db->where('departure', $app_day);
        $this->db->where('account_type', 'ROOM');
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() > 0) {
            $departure_total = $query->num_rows();
        }

        $this->db->select('ID');
        $this->db->where('status', 1);
        $this->db->or_where('status', 2);
        $query = $this->db->get('roomitems');
        if ($query->num_rows() > 0) {
            $vacant_total = $query->num_rows();
        }

        $this->db->select('ID');
        $this->db->where('status', 3);
        $this->db->or_where('status', 4);
        $query = $this->db->get('roomitems');
        if ($query->num_rows() > 0) {
            $occupied_total = $query->num_rows();
        }

        $this->db->select('ID');
        $query = $this->db->get('roomitems');
		$room_total=0;
        if ($query->num_rows() > 0) {
            $room_total = $query->num_rows();
            $occupancy = ceil(($occupied_total / $room_total) * 100);
        }else{	$occupancy=0;}        

        $room_stats = array(
            'staying' => $staying_total,
            'arrival' => $arrival_total,
            'departure' => $departure_total,
            'vacant' => $vacant_total,
            'occupancy' => $occupancy
        );

        return $room_stats;
    }
    
    public function updatePassword($type) {
        /* verify user's old password */
        $tableitems = strtolower($type) . "items";
        $login_signature = $this->session->us_signature;

        $q = "SELECT ID,title,signature,hashed_p,role FROM $tableitems "
                . "WHERE signature='$login_signature' LIMIT 1";
        //        echo $q;exit;

        $query = $this->db->query($q);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if (isset($result)) {
                $curr_id = $result["ID"];
                $curr_hashed_p = $result["hashed_p"];//stored password
                $pass_valid = validate_password($this->input->post('user_oldpassword'), $curr_hashed_p);

                if ($pass_valid) {
                    /* update user's password */
                    $hashed_p = create_hash($this->input->post('user_hashed_p'));//hash new password
                    $user_id = $curr_id;

                    $data = array(
                        'hashed_p' => $hashed_p,
                        'date_modified' => date("Y-m-d H:i:s")
                    );

                    $this->db->where('ID', $user_id);
                    $res = $this->db->update($tableitems, $data);
                    if ($res)   return true;
                }
            }
        } 
        return false;
    }

    public function getDisplayedItems($type, $return_json = FALSE, $ID = 0, $offset = 0, $limit_val = FALSE) {
        /* gets all fields for a table with filters,limit & offsets
         * ::used for page navigations etc */

        if ($type == "room_status") {
            $tableitems = "ref_roomstatus";
        } else {
            $tableitems = strtolower($type) . "items";
        }
        $limit = $filter = "";
        $sort = "order by ID";
        $results['data'] = array();
        $results['count'] = 0;

        if ($limit_val) {
            $limit = "LIMIT $offset,$limit_val";
        }

        if ($type == "role") {
            $sort = "and title <> 'SUPER' ";
        }

        if (empty($ID)) {
            $q = "SELECT * from $tableitems where 1=1 $sort $limit";
            $q_total = "SELECT * from $tableitems where 1=1 $sort ";
        } else {
            $q = "SELECT * from $tableitems where 1=1 and ID='$ID' $sort $limit ";
            $q_total = "SELECT * from $tableitems where 1=1 and ID='$ID' $sort";
        }
//                    echo $q;echo '<br>';
//                    echo $q_total;
//                    exit;
        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        //calc expiration
        $expiration_time = "";
        $this->db->select('*');
        $query = $this->db->get('maintenance');
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $last_close_acct = date("Y-m-d", strtotime($result['last_close_account']));
            $expire_date = date("Y-m-d", strtotime($result['expire_date']));

            $date_expire = new DateTime(strval($expire_date));
            $date_close = new DateTime(strval($last_close_acct));

            $diff = $date_expire->diff($date_close)->format("%a");

            if (intval($diff) <= 30 && intval($diff) >= 0) {
                $expiration_time = ucwords("Your software license will expire in $diff days, Please contact the Administrator to renew");
            }

            if (strval($last_close_acct) > strval($expire_date)) {
                $this->expired_license=TRUE;
                $expiration_time = ucwords("Your software License Has expired, Please contact the Administrator to renew");
            }
        }

        $results['expiration'] = $expiration_time;

        if ($return_json) {
            return json_encode($results['data']);
        } else {
            return $results;
        }
    }

    public function getJoinedItems($type, $return_json = FALSE, $ID = 0, $filter_val = FALSE) {
        /* gets all fields for a table with filters,limit & offsets
         * ::used for page navigations etc */

        $results['data'] = array();
        $results['count'] = 0;
        $filter = ($ID > 0) ? ("") : ("WHERE 1=1");

        if ($filter_val) {
            $filter .= $filter_val;
        }

        switch ($type) {
            case 'roomtype':
                if (empty($ID)) {
                    $q = "SELECT rt.*,rc.title as rc_title "
                            . "FROM roomtypeitems as rt "
                            . "left join roomclassitems as rc on (rt.roomclass=rc.ID) ";
                } else {
                    $q = "SELECT rt.*,rc.title as rc_title "
                            . "FROM roomtypeitems as rt "
                            . "left join roomclassitems as rc on (rt.roomclass=rc.ID) "
                            . "where rt.ID='$ID'";
                }
                break;
            case 'room':
            case 'housekeeping':
                if (empty($ID)) {
                    $q = "SELECT ro.*,rc.title as rc_title,rt.title as rt_title,ref_rs.title as room_status "
                            . "FROM roomitems as ro "
                            . "left join roomclassitems as rc on (ro.roomclass=rc.ID) "
                            . "left join roomtypeitems as rt on (ro.roomtype=rt.ID) "
                            . "left join ref_roomstatus as ref_rs on (ro.status=ref_rs.ID) "
                            . "$filter";
                } else {
                    $q = "SELECT ro.*,rc.title as rc_title,rt.title as rt_title,ref_rs.title as room_status "
                            . "FROM roomitems as ro "
                            . "left join roomclassitems as rc on (ro.roomclass=rc.ID) "
                            . "left join roomtypeitems as rt on (ro.roomtype=rt.ID) "
                            . "left join ref_roomstatus as ref_rs on (ro.status=ref_rs.ID) "
                            . "where ro.ID='$ID' $filter";
                }
                break;
            case 'price':
                if (empty($ID)) {
                    $q = "SELECT pr.*,rt.title as roomtype_title,acctsale.title as acctsale_title "
                            . "FROM priceitems as pr "
                            . "left join roomtypeitems as rt on (pr.title=rt.ID) "
                            . "left join account_saleitems as acctsale on (pr.acctsale=acctsale.ID)";
                } else {
                    $q = "SELECT pr.*,rt.title as roomtype_title,acctsale.title as acctsale_title "
                            . "FROM priceitems as pr "
                            . "left join roomtypeitems as rt on (pr.title=rt.ID) "
                            . "left join account_saleitems as acctsale on (pr.acctsale=acctsale.ID) "
                            . "where pr.ID='$ID'";
                }
                break;
            case 'terminals':
                $q = "SELECT user.*,role.title as role_title FROM useritems as user "
                        . "left join roleitems as role on (user.role=role.ID) "
                        . "WHERE role.title <> 'SUPER' AND last_login_time > last_logout_time "
                        . "AND last_logout_time <> '0000-00-00 00:00:00'";
                break;
            case 'account_plu_number':
                if (empty($ID)) {
                    $q = "SELECT plu.*,plu_group.title as plu_group_title,acctsale.title as acctsale_title "
                            . "FROM account_plu_numberitems as plu "
                            . "left join account_plu_groupitems as plu_group on (plu.plu_group=plu_group.ID) "
                            . "left join account_saleitems as acctsale on (plu.acctsale=acctsale.ID)";
                } else {
                    $q = "SELECT plu.*,plu_group.title as plu_group_title,acctsale.title as acctsale_title "
                            . "FROM account_plu_numberitems as plu "
                            . "left join account_plu_groupitems as plu_group on (plu.plu_group=plu_group.ID) "
                            . "left join account_saleitems as acctsale on (plu.acctsale=acctsale.ID) "
                            . "where plu.ID='$ID'";
                }
                break;

            case 'account_payment':
                if (empty($ID)) {
                    $q = "SELECT ap.*,ac.title as acctclass_title,at.title as accttype_title "
                            . "FROM account_paymentitems as ap "
                            . "left join account_classitems as ac on (ap.accountclass=ac.ID) "
                            . "left join account_typeitems as at on (ap.accounttype=at.ID)";
                } else {
                    $q = "SELECT ap.*,ac.title as acctclass_title,at.title as accttype_title "
                            . "FROM account_paymentitems as ap "
                            . "left join account_classitems as ac on (ap.accountclass=ac.ID) "
                            . "left join account_typeitems as at on (ap.accounttype=at.ID)"
                            . "where ap.ID='$ID'";
                }
                break;

            case 'account_sale':
                if (empty($ID)) {
                    $q = "SELECT accts.*,ac.title as acctclass_title,at.title as accttype_title,"
                            . "sc.title as salescategory_title, dc.title as discountcategory_title "
                            . "FROM account_saleitems as accts "
                            . "left join account_classitems as ac on (accts.accountclass=ac.ID) "
                            . "left join account_typeitems as at on (accts.accounttype=at.ID) "
                            . "left join account_salescategoryitems as sc on (accts.salescategory=sc.ID) "
                            . "left join account_discountitems as dc on (accts.discountcategory=dc.ID)";
                } else {
                    $q = "SELECT accts.*,ac.title as acctclass_title,at.title as accttype_title "
                            . "FROM account_saleitems as accts "
                            . "left join account_classitems as ac on (accts.accountclass=ac.ID) "
                            . "left join account_typeitems as at on (accts.accounttype=at.ID) "
                            . "left join account_salescategoryitems as sc on (accts.salescategory=sc.ID) "
                            . "left join account_discountitems as dc on (accts.discountcategory=dc.ID)"
                            . "where accts.ID='$ID'";
                }
                break;
            case 'user' :
                if (empty($ID)) {
                    $q = "SELECT users.ID,users.signature,users.title,roles.title as role_title,"
                            . "roles.ID as role FROM useritems as users "
                            . "left join roleitems as roles on (roles.ID=users.role) "
                            . "where roles.title <> 'SUPER'";
                } else {
                    $q = "SELECT users.ID,users.signature,users.title,roles.title as role_title,"
                            . "roles.ID as role FROM useritems as users "
                            . "left join roleitems as roles on (roles.ID=users.role)"
                            . "WHERE users.ID='$ID' AND roles.title <> 'SUPER'";
                }
                break;
            case 'folio_sale':
                $q = "SELECT pln.title as plu,pln.description,pln.acctsale as account, acs.title as account_title "
                        . "from account_plu_numberitems as pln "
                        . "left join account_saleitems as acs "
                        . "on(pln.acctsale = acs.ID) "
                        . "where pln.plu_group='$ID'";
                break;
        }
//        echo $q;exit;

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        if ($return_json) {
            return json_encode($results['data']);
        } else {
            return $results;
        }
    }

    public function getLoginItems($type, $login_signature, $login_password) {
        /* create sessions for authenticated users 
         * update user login data
         */
        if($this->expired_license){//check license
            $this->session->set_flashdata('error_message', 'Software License Has Expired');
            return false;
        }
        $tableitems = strtolower($type) . "items";

        $q = "SELECT ID,title,signature,hashed_p,role FROM $tableitems "
                . "WHERE signature='$login_signature' LIMIT 1";
//        echo $q;exit;

        $query = $this->db->query($q);

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            if (isset($result)) {
                $curr_id = $result["ID"];
                $curr_hashed_p = $result["hashed_p"];
                $pass_valid = validate_password($login_password, $curr_hashed_p);

                if ($pass_valid) {
                    //session data
                    $this->session->us_signature = $result["signature"];
                    $this->session->us_name = $result["title"];
                    $this->session->us_id = $curr_id;
                    $role = $result["role"];

                    //UPDATE USER'S IP AND LAST LOGIN
                    $curr_ip_add = $_SERVER['REMOTE_ADDR'];
                    $curr_time = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');
                    $data = array(
                        'last_login_ip' => $curr_ip_add,
                        'last_login_time' => $curr_time
                    );
                    $this->db->where('ID', $curr_id);
                    $this->db->update($tableitems, $data);
                    //get role data
                    $this->db->select('*');
                    $this->db->from('roleitems');
                    $this->db->where('ID', $role);
                    $query = $this->db->get();

                    if ($query->num_rows() > 0) {
                        $result = $query->row_array();
                        $this->session->role_title = $result["title"];
                        $this->session->reservation = $result["reserv_folio"];
                        $this->session->reports = $result["reports"];
                        $this->session->utilities = $result["utilities"];
                        $this->session->maintenance = $result["maintenance"];
                        $this->session->monitors = $result["monitors"];
                        $this->session->configuration = $result["configuration"];
                        $this->session->prices = $result["prices"];
                        $this->session->overview = $result["overview"];
                        $this->session->delete_group = $result["delete_group"];
                    }
                    return true;
                } else {
                    $this->session->set_flashdata('error_message', 'Invalid Username/Password');
                    return false;
                }
            } else {
                $this->session->set_flashdata('error_message', 'Login Failed');
                return false;
            }
        } else {
            $this->session->set_flashdata('error_message', 'Login Failed');
            return false;
        }
    }

    public function logout() {
        $res = false;
        $data = array(
            'last_logout_time' => date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s')
        );
        $this->db->where('signature', $this->session->us_signature);
        $res = $this->db->update("useritems", $data);
        return $res;
    }

    public function updateSite($type, $image_present) {
        /* updates site details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('site_ID');
        $title = $this->input->post('site_title');
        $street1 = $this->input->post('site_street1');
        $street2 = $this->input->post('site_street2');
        $show_passwords = $this->input->post('site_show_passwords');
        $state = $this->input->post('site_state');
        $country = $this->input->post('site_country');
        $tel1 = $this->input->post('site_tel1');
        $tel2 = $this->input->post('site_tel2');
        $email = $this->input->post('site_email');
        $facebook = $this->input->post('site_facebook');
        $url = $this->input->post('site_url');
        $bank_account = $this->input->post('site_bank_account');
        $twitter = $this->input->post('site_twitter');


        $type = strtolower($type);
        if ($image_present) {
            $image_filename = $this->upload->data('file_name');
        } else {
            $image_filename = $this->input->post('site_prev_filename');
        }

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'street1' => $street1,
                'street2' => $street2,
                'show_passwords' => $show_passwords,
                'email' => $email,
                'tel1' => $tel1,
                'tel2' => $tel2,
                'state' => $state,
                'country' => $country,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'url' => $url,
                'logo' => $image_filename,
                'bank_account' => $bank_account,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'street1' => $street1,
                'street2' => $street2,
                'show_passwords' => $show_passwords,
                'email' => $email,
                'tel1' => $tel1,
                'tel2' => $tel2,
                'state' => $state,
                'country' => $country,
                'facebook' => $facebook,
                'twitter' => $twitter,
                'url' => $url,
                'logo' => $image_filename,
                'bank_account' => $bank_account,
                'type' => $type,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveRole($type) {
        /* updates role details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('role_ID');
        $title = strtoupper($this->input->post('role_title'));
        $description = strtoupper($this->input->post('role_description'));
        $reserv_folio = $this->input->post('role_reserv_folio');
        $reports = $this->input->post('role_reports');
        $utilities = $this->input->post('role_utilities');
        $maintenance = $this->input->post('role_maintenance');
        $monitors = $this->input->post('role_monitors');
        $configuration = $this->input->post('role_configuration');
        $prices = $this->input->post('role_prices');
        $overview = $this->input->post('role_overview');
        $delete_group = $this->input->post('role_delete_group');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'reserv_folio' => $reserv_folio,
                'reports' => $reports,
                'utilities' => $utilities,
                'maintenance' => $maintenance,
                'monitors' => $monitors,
                'configuration' => $configuration,
                'prices' => $prices,
                'overview' => $overview,
                'delete_group' => $delete_group,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'reserv_folio' => $reserv_folio,
                'reports' => $reports,
                'utilities' => $utilities,
                'maintenance' => $maintenance,
                'monitors' => $monitors,
                'configuration' => $configuration,
                'prices' => $prices,
                'overview' => $overview,
                'delete_group' => $delete_group,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveRoom($type) {
        /* updates room details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('room_ID');
        $title = strtoupper($this->input->post('room_title'));
        $description = strtoupper($this->input->post('room_description'));
        $bed = $this->input->post('room_bed');
        $roomtype = $this->input->post('room_roomtype');
        $roomclass = $this->input->post('room_roomclass');
        $acctname = $this->input->post('room_acctname');
        $remark = $this->input->post('room_remark');
        $frontview = $this->input->post('room_frontview');
        $backview = $this->input->post('room_backview');
        $groundfloor = $this->input->post('room_groundfloor');
        $firstfloor = $this->input->post('room_firstfloor');
        $secondfloor = $this->input->post('room_secondfloor');
        $thirdfloor = $this->input->post('room_thirdfloor');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'bed' => $bed,
                'roomtype' => $roomtype,
                'roomclass' => $roomclass,
                'acctname' => $acctname,
                'remark' => $remark,
                'frontview' => $frontview,
                'backview' => $backview,
                'groundfloor' => $groundfloor,
                'firstfloor' => $firstfloor,
                'secondfloor' => $secondfloor,
                'thirdfloor' => $thirdfloor,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'bed' => $bed,
                'roomtype' => $roomtype,
                'roomclass' => $roomclass,
                'acctname' => $acctname,
                'remark' => $remark,
                'frontview' => $frontview,
                'backview' => $backview,
                'groundfloor' => $groundfloor,
                'firstfloor' => $firstfloor,
                'secondfloor' => $secondfloor,
                'thirdfloor' => $thirdfloor,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function updateHousekeeping($type) {
        /* updates housekeeping details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('housekeeping_ID');
        $remark = $this->input->post('housekeeping_remark');

        $data = array(
            'remark' => $remark,
            'date_modified' => $app_day
        );
        $this->db->where('ID', $ID);
        $this->db->update($tableitems, $data);
        return $ID;
    }

    public function saveAccountPlu($type) {
        /* updates account_plu_number details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('account_plu_number_ID');
        $title = strtoupper($this->input->post('account_plu_number_title'));
        $description = strtoupper($this->input->post('account_plu_number_description'));
        $plu_group = $this->input->post('account_plu_number_account_plu_group');
        $acctsale = $this->input->post('account_plu_number_acctsale');
        $price = $this->input->post('account_plu_number_price');
        $cost = $this->input->post('account_plu_number_cost');
        $enable = $this->input->post('account_plu_number_enable');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'plu_group' => $plu_group,
                'acctsale' => $acctsale,
                'price' => $price,
                'cost' => $cost,
                'enable' => $enable,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'plu_group' => $plu_group,
                'acctsale' => $acctsale,
                'price' => $price,
                'cost' => $cost,
                'enable' => $enable,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveAccountPayment($type) {
        /* updates account_payment details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('account_payment_ID');
        $title = strtoupper($this->input->post('account_payment_title'));
        $description = strtoupper($this->input->post('account_payment_description'));
        $code = $this->input->post('account_payment_code');
        $alias = $this->input->post('account_payment_alias');
        $accounttype = $this->input->post('account_payment_accounttype');
        $accountclass = $this->input->post('account_payment_accountclass');
        $debit_credit = $this->input->post('account_payment_debit_credit');
        $cash_declaration = $this->input->post('account_payment_cash_declaration');
        $enable = $this->input->post('account_payment_enable');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'code' => $code,
                'alias' => $alias,
                'accounttype' => $accounttype,
                'accountclass' => $accountclass,
                'debit_credit' => $debit_credit,
                'cash_declaration' => $cash_declaration,
                'enable' => $enable,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'code' => $code,
                'alias' => $alias,
                'accounttype' => $accounttype,
                'accountclass' => $accountclass,
                'debit_credit' => $debit_credit,
                'cash_declaration' => $cash_declaration,
                'enable' => $enable,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function savePrice($type) {
        /* updates price details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('price_ID');
        $title = strtoupper($this->input->post('price_title'));
        $description = strtoupper($this->input->post('price_description'));
        $acctsale = $this->input->post('price_acctsale');
        $comp_nights = $this->input->post('price_comp_nights');
        $comp_visits = $this->input->post('price_comp_visits');
        $enable = $this->input->post('price_enable');
        $adults = $this->input->post('price_adults');
        $children = $this->input->post('price_children');
        $special = $this->input->post('price_special');
        $weekday = $this->input->post('price_weekday');
        $weekend = $this->input->post('price_weekend');
        $holiday = $this->input->post('price_holiday');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'acctsale' => $acctsale,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'enable' => $enable,
                'adults' => $adults,
                'children' => $children,
                'special' => $special,
                'weekday' => $weekday,
                'weekend' => $weekend,
                'holiday' => $holiday,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'acctsale' => $acctsale,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'enable' => $enable,
                'adults' => $adults,
                'children' => $children,
                'special' => $special,
                'weekday' => $weekday,
                'weekend' => $weekend,
                'holiday' => $holiday,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveAccountSale($type) {
        /* updates account_sale details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('account_sale_ID');
        $title = strtoupper($this->input->post('account_sale_title'));
        $description = strtoupper($this->input->post('account_sale_description'));
        $code = $this->input->post('account_sale_code');
        $alias = $this->input->post('account_sale_alias');
        $accounttype = $this->input->post('account_sale_accounttype');
        $accountclass = $this->input->post('account_sale_accountclass');
        $debit_credit = $this->input->post('account_sale_debit_credit');
        $vattype = $this->input->post('account_sale_vattype');
        $vatpercent = $this->input->post('account_sale_vatpercent');
        $salescategory = $this->input->post('account_sale_salescategory');
        $discountcategory = $this->input->post('account_sale_discountcategory');
        $default_price = $this->input->post('account_sale_default_price');
        $service_charge = $this->input->post('account_sale_service_charge');
        $enable = $this->input->post('account_sale_enable');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'code' => $code,
                'alias' => $alias,
                'accounttype' => $accounttype,
                'accountclass' => $accountclass,
                'debit_credit' => $debit_credit,
                'vattype' => $vattype,
                'vatpercent' => $vatpercent,
                'salescategory' => $salescategory,
                'discountcategory' => $discountcategory,
                'default_price' => $default_price,
                'service_charge' => $service_charge,
                'enable' => $enable,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'code' => $code,
                'alias' => $alias,
                'accounttype' => $accounttype,
                'accountclass' => $accountclass,
                'debit_credit' => $debit_credit,
                'vattype' => $vattype,
                'vatpercent' => $vatpercent,
                'salescategory' => $salescategory,
                'discountcategory' => $discountcategory,
                'default_price' => $default_price,
                'service_charge' => $service_charge,
                'enable' => $enable,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveTypeclass($type) {
        /* updates generic details for some modules */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $typeid = $type . "_ID";
        $typetitle = $type . "_title";
        $typedescription = $type . "_description";

        $ID = $this->input->post($typeid);
        $title = strtoupper($this->input->post($typetitle));
        $description = strtoupper($this->input->post($typedescription));

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveRoomtype($type) {
        /* updates roomtype details */
        $tableitems = strtolower($type) . "items";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('roomtype_ID');
        $title = strtoupper($this->input->post('roomtype_title'));
        $description = strtoupper($this->input->post('roomtype_description'));
        $beds = $this->input->post('roomtype_beds');
        $roomclass = intval($this->input->post('roomtype_roomclass'));
        $remark = $this->input->post('roomtype_remark');

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'description' => $description,
                'beds' => $beds,
                'remark' => $remark,
                'roomclass' => $roomclass,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'description' => $description,
                'beds' => $beds,
                'remark' => $remark,
                'roomclass' => $roomclass,
                'type' => $type,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveUser($type) {
        /* updates user details */
        $app_day = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');
        $tableitems = strtolower($type) . "items";
        
        $show_pass = '0';
        $password='';
        $this->db->select('show_passwords');
        $query = $this->db->get('siteitems');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $show_pass=$row['show_passwords'];
        }

        $ID = $this->input->post('user_ID');
        $title = $this->input->post('user_title');
        $signature = $this->input->post('user_signature');
        if($show_pass=='1')
            $password=$this->input->post('user_keyword');
        $keyword = create_hash($this->input->post('user_keyword'));
        $role = intval($this->input->post('user_role'));

        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'signature' => $signature,
                'password' =>$password,
                'hashed_p' => $keyword,
                'role' => $role,
                'signature_created' => $this->session->us_signature,
                'date_modified' => $app_day
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'signature' => $signature,
                'password' =>$password,
                'hashed_p' => $keyword,
                'role' => $role,
                'signature_created' => $this->session->us_signature,
                'date_created' => $app_day
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function deleteItem() {
//deletes an item
        $item_id = "delete_id";
        $item_type = "delete_type";

        $id = $this->input->post($item_id);
        $type = strtolower($this->input->post($item_type));

        $tableitems = $type . "items";
        $this->db->where('ID', $id);
        $this->db->delete($tableitems);

        return true;
    }

}
