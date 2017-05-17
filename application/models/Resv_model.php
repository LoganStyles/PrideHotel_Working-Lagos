<?php

/**
 * Description of Resv_model
 *
 * @author EMMANUEL
 */
class Resv_model extends App_model {

    public function __construct() {
        $this->load->database();
    }

    public function search($search_phrase, $table) {
        $results = array();

        $this->db->select('ID,title,phone');
        $this->db->like('title', $search_phrase);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0)
            $results = $query->result_array();
        return json_encode($results);
    }

    public function deleteResv() {
        $reason = $this->input->post('delete_resv_reason');
        $resv_id = $this->input->post('delete_resv_id');
        $type = $this->input->post('delete_resv_type');
        $oldvalue = $this->input->post('delete_resv_oldvalue');
        $newvalue = $this->input->post('delete_resv_newvalue');
        $description = "Reservation " . $resv_id . " was deleted by " . $this->session->us_signature;
        //update reservation status
        $this->updateItems("reservation", $resv_id, "status", "cancelled");
        //update reservation remarks
        $this->updateItems("reservation", $resv_id, "remarks", $reason);
        //log this action
        $log_id = $this->createLog($type, "delete", $description, $oldvalue, $newvalue, $reason);
        return $log_id;
    }

    private function createLog($module, $action, $description, $oldvalue, $newvalue, $reason) {
        $data = array(
            'section' => $module,
            'action' => $action,
            'description' => $description,
            'old_value' => $oldvalue,
            'new_value' => $newvalue,
            'reason' => $reason,
            'signature_created' => $this->session->us_signature,
            'date_created' => date("Y-m-d H:i:s")
        );
        $this->db->insert("logitems", $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function getModalItems($type, $return_json = FALSE, $ID = 0, $filter_val = FALSE) {
        /* gets all fields for a table with filters,limit & offsets
         * ::used for page navigations etc */

        $results['data'] = array();
        $results['count'] = 0;
        $filter = ($ID > 0) ? ("") : ("WHERE 1=1");

        switch ($type) {
            case 'roomtype':
                $q = "SELECT rti.ID,rti.title,rti.description,count(rti.ID) AS rooms,count(rti.beds)AS beds,"
                        . "count(CASE WHEN ri.status='1' THEN ri.status END)AS vacant,"
                        . "count(CASE WHEN ri.status='2' THEN ri.status END)AS vacant_dirty "
                        . "from roomitems as ri left join roomtypeitems as rti "
                        . "on (ri.roomtype=rti.ID) group by ri.roomtype order by ri.ID ";
                break;
            case 'room_number':
                if ($filter_val) {
                    $filter .= " and rti.title='$filter_val'";
                }
                $q = "SELECT ri.ID,CONCAT(ri.title,'.',rti.title) as title, ri.description,ri.bed,"
                        . "rrs.title as room_status from roomitems as ri left join roomtypeitems as rti "
                        . "on (ri.roomtype=rti.ID) left join ref_roomstatus as rrs "
                        . "on (ri.status=rrs.ID) $filter";
                break;
            case 'price_rate':
                if ($filter_val) {
                    $filter .= " and rti.title='$filter_val' and pi.enable='yes'";
                }
                $q = "SELECT pi.ID, rti.title,pi.weekday,pi.weekend,pi.holiday,pi.description "
                        . "from priceitems as pi left join roomtypeitems as rti "
                        . "on(pi.title=rti.ID) $filter ";
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

    public function savePerson($type) {
        /* updates site details */
        $tableitems = strtolower($type) . "items";

        $ID = $this->input->post('person_ID');
        $title = $this->input->post('person_title');
        $sex = $this->input->post('person_sex');
        $title_ref = $this->input->post('person_title_ref');
        $email = $this->input->post('person_email');
        $phone = $this->input->post('person_phone');
        $occupation = $this->input->post('person_occupation');
        $passport_no = $this->input->post('person_passport_no');
        $pp_issued_at = $this->input->post('person_pp_issued_at');
        $visa = $this->input->post('person_visa');
        $resident_permit_no = $this->input->post('person_resident_permit_no');
        $spg_no = $this->input->post('person_spg_no');
        $destination = $this->input->post('person_destination');
        $payment_method = $this->input->post('person_payment_method');
        $group_name = $this->input->post('person_group_name');
        $plate_number = $this->input->post('person_plate_number');
        $remarks = $this->input->post('person_remarks');
        $birth_location = $this->input->post('person_birth_location');
        $street = $this->input->post('person_street');
        $city = $this->input->post('person_city');
        $state = $this->input->post('person_state');
        $country = $this->input->post('person_country');

        $birthday_temp = $this->input->post('person_birthday');
        $temp_birthday = str_replace('/', '-', $birthday_temp);
        $birthday = date('Y-m-d', strtotime($temp_birthday));

        $issued_temp = $this->input->post('person_pp_issued_date');
        $temp_issued = str_replace('/', '-', $issued_temp);
        $issued_date = date('Y-m-d', strtotime($temp_issued));

        $expiry_temp = $this->input->post('person_pp_expiry_date');
        $temp_expiry = str_replace('/', '-', $expiry_temp);
        $expiry_date = date('Y-m-d', strtotime($temp_expiry));


        if ($ID > 0) {
            //update   
            $data = array(
                'title' => $title,
                'title_ref' => $title_ref,
                'email' => $email,
                'phone' => $phone,
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'sex' => $sex,
                'occupation' => $occupation,
                'birthday' => $birthday,
                'birth_location' => $birth_location,
                'passport_no' => $passport_no,
                'pp_issued_at' => $pp_issued_at,
                'pp_issued_date' => $issued_date,
                'pp_expiry_date' => $expiry_date,
                'visa' => $visa,
                'resident_permit_no' => $resident_permit_no,
                'spg_no' => $spg_no,
                'destination' => $destination,
                'payment_method' => $payment_method,
                'group_name' => $group_name,
                'plate_number' => $plate_number,
                'remarks' => $remarks,
                'signature_created' => $this->session->us_signature,
                'date_modified' => date("Y-m-d H:i:s")
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
            $data = array(
                'title' => $title,
                'title' => $title,
                'title_ref' => $title_ref,
                'email' => $email,
                'phone' => $phone,
                'street' => $street,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'sex' => $sex,
                'occupation' => $occupation,
                'birthday' => $birthday,
                'birth_location' => $birth_location,
                'passport_no' => $passport_no,
                'pp_issued_at' => $pp_issued_at,
                'pp_issued_date' => $issued_date,
                'pp_expiry_date' => $expiry_date,
                'visa' => $visa,
                'resident_permit_no' => $resident_permit_no,
                'spg_no' => $spg_no,
                'destination' => $destination,
                'payment_method' => $payment_method,
                'group_name' => $group_name,
                'plate_number' => $plate_number,
                'remarks' => $remarks,
                'signature_created' => $this->session->us_signature,
                'date_created' => date("Y-m-d H:i:s")
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveGuest($type) {
        /* updates guest details */

        $reservation_ID = $this->input->post('guest_ID');
        $guest_arrival = $this->input->post('guest_arrival');
        $temp_date = str_replace('/', '-', $guest_arrival);
        $arrival = date('Y-m-d', strtotime($temp_date));
        $nights = $this->input->post('guest_nights');
        $departure = date('Y-m-d', strtotime($arrival . ' + ' . $nights . ' days'));
        $room_number = $this->input->post('guest_room_number_id');
        $roomtype = $this->input->post('guest_roomtype_id');
        $client_type = $this->input->post('guest_client_type');
        $client_name = $this->input->post('guest_client_name');
        $agency_name = $this->input->post('guest_agency_name');
        $agency_contact = $this->input->post('guest_agency_contact');
        $guest1 = $this->input->post('guest_guest1');
        $guest2 = $this->input->post('guest_guest2');
        $adults = $this->input->post('guest_adults');
        $children = $this->input->post('guest_children');
        $guest_count = intval($adults + $children);
        $status = $this->input->post('guest_status');
        //price
        $price_rate_id = $this->input->post('guest_price_rate_id');
        $folio_room = $this->input->post('guest_folio_room');
        $folio_extra = $this->input->post('guest_folio_extra');
        $folio_other = $this->input->post('guest_folio_other');
        $weekday = $this->input->post('guest_weekday');
        $weekend = $this->input->post('guest_weekend');
        $holiday = $this->input->post('guest_holiday');
        $price_room = $this->input->post('guest_price_room');
        $price_extra = $this->input->post('guest_price_extra');
        $price_total = $this->input->post('guest_price_total');
        $invoice = $this->input->post('guest_invoice');
        $comp_nights = $this->input->post('guest_comp_nights');
        $comp_visits = $this->input->post('guest_comp_visits');
        $block_pos = $this->input->post('guest_block_pos');

        if ($reservation_ID > 0) {
            //update reservation
            $data = array(
                'arrival' => $arrival,
                'nights' => $nights,
                'departure' => $departure,
                'room_number' => $room_number,
                'roomtype' => $roomtype,
                'client_type' => $client_type,
                'client_name' => $client_name,
                'agency_name' => $agency_name,
                'agency_contact' => $agency_contact,
                'guest1' => $guest1,
                'guest2' => $guest2,
                'adults' => $adults,
                'children' => $children,
                'guest_count' => $guest_count,
                'status' => $status,
                'signature_modified' => $this->session->us_signature,
                'date_modified' => date("Y-m-d H:i:s")
            );
            $this->db->where('reservation_id', $reservation_ID);
            $this->db->update("reservationitems", $data);

            //update prices
            $data = array(
                'price_rate' => $price_rate_id,
                'folio_room' => $folio_room,
                'folio_extra' => $folio_extra,
                'folio_other' => $folio_other,
                'weekday' => $weekday,
                'weekend' => $weekend,
                'holiday' => $holiday,
                'price_room' => $price_room,
                'price_extra' => $price_extra,
                'price_total' => $price_total,
                'invoice' => $invoice,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'block_pos' => $block_pos
            );
            $this->db->where('reservation_id', $reservation_ID);
            $this->db->update("reservationpriceitems", $data);
            return $reservation_ID;
        } elseif ($reservation_ID == 0) {
            //insert reservation
            //get last reservation id
            $reservation_id = 1;
            $this->db->select('reservation_id');
            $this->db->from('reservationitems');
            $this->db->order_by('ID', 'DESC');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $results = $query->row_array();
                $reservation_id = intval($results["reservation_id"]) + 1;
            }
            $padded_reservation_id = str_pad($reservation_id, 12, "0", STR_PAD_LEFT);

            $data = array(
                'reservation_id' => $padded_reservation_id,
                'arrival' => $arrival,
                'nights' => $nights,
                'departure' => $departure,
                'room_number' => $room_number,
                'roomtype' => $roomtype,
                'client_type' => $client_type,
                'client_name' => $client_name,
                'agency_name' => $agency_name,
                'agency_contact' => $agency_contact,
                'guest1' => $guest1,
                'guest2' => $guest2,
                'adults' => $adults,
                'children' => $children,
                'guest_count' => $guest_count,
                'status' => $status,
                'signature_created' => $this->session->us_signature,
                'date_created' => date("Y-m-d H:i:s")
            );
            $this->db->insert("reservationitems", $data);

            //insert prices
            $data = array(
                'reservation_id' => $padded_reservation_id,
                'price_rate' => $price_rate_id,
                'folio_room' => $folio_room,
                'folio_extra' => $folio_extra,
                'folio_other' => $folio_other,
                'weekday' => $weekday,
                'weekend' => $weekend,
                'holiday' => $holiday,
                'price_room' => $price_room,
                'price_extra' => $price_extra,
                'price_total' => $price_total,
                'invoice' => $invoice,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'block_pos' => $block_pos
            );
            $this->db->insert("reservationpriceitems", $data);
            return $padded_reservation_id;
        } else {
            return false;
        }
    }

    public function getReservations($type, $offset = 0, $limit_val = FALSE) {
        /* gets all fields for a reservation with filters,limit & offsets
         * ::used for page navigations etc */
        $app_date = $this->getAppInfo();

        $tableitems = "reservationitems";
        $limit = $filter = "";
        $sort = " order by ID DESC";
        $results['data'] = array();
        $results['count'] = 0;

        if ($limit_val) {
            $limit = "LIMIT $offset,$limit_val";
        }

        switch ($type) {
            case "confirmed":
            case "cancelled":
            case "provisional":
                $sort = "and status='$type' AND account_type='ROOM' order by ID DESC";
                break;
            case "arriving":
                $sort = "and status='confirmed' and arrival='$app_date' AND account_type='ROOM' order by ID DESC";
                break;
            case "departing":
                $sort = "and status='staying' and departure<='$app_date' AND account_type='ROOM' order by ID DESC";
                break;
            case "all":
                $sort = " AND account_type='ROOM' order by ID DESC";
                break;
            case "staying":
                $sort = " and status='$type' and departure >='$app_date' and arrival <='$app_date' AND account_type='ROOM' order by ID DESC";
                break;
            default:
                break;
        }

        $q = "SELECT * from $tableitems where 1=1 $sort $limit";
        $q_total = "SELECT * from $tableitems where 1=1 $sort ";
//                    echo $q;echo '<br>';
//                    echo $q_total;
//                    exit;
        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        return $results;
    }

    public function checkin($r_ID, $room_id) {
        if ($this->isRoomVacant($room_id)) {
            $this->updateItems("reservation", $r_ID, "status", "staying");
            $this->updateItems("room", $room_id, "status", 3);
            //update reservation just in case room was changed
            $this->updateItems("reservation", $r_ID, "room_number", $room_id);
            return TRUE;
        }
        return FALSE;
    }

    private function isRoomVacant($room_id) {
        /* check if a room is vacant or vacant_dirty */
        $test = FALSE;
//        $q = "SELECT ro.status from roomitems as ro "
//                . "left join reservationitems as ri "
//                . "on (ro.ID=ri.room_number) "
//                . "where ri.reservation_id='$resv_id'";
        $q = "SELECT status from roomitems where ID='$room_id'";
//        echo $q;exit;

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $status = intval($result["status"]);
            if ($status == 1 || $status == 2) {
                $test = TRUE;
            }
        }
        return $test;
    }

    public function getClientResvInfo($resv_id) {
        /* get info for reservation,prices, etc for a client */
        $q = "SELECT ri.*,ri.room_number as room_number_id,ri.roomtype as roomtype_id,"
                . "ro.title as room_number,"
                . "rt.title as roomtype,rp.*,rp.price_rate as price_rate_id,"
                . "pi.title as price_title from reservationitems as ri "
                . "left join reservationpriceitems as rp "
                . "on (ri.reservation_id = rp.reservation_id) "
                . "left join roomitems as ro "
                . "on (ri.room_number = ro.ID) "
                . "left join roomtypeitems as rt "
                . "on (ri.roomtype = rt.ID) "
                . "left join priceitems as pi "
                . "on (rp.price_rate = pi.ID)"
                . "where ri.reservation_id='$resv_id'";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            return $query->result_array();
    }

}
