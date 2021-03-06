<?php

/**
 * Description of Resv_model
 *
 * @author EMMANUEL OKPUKPAN
 */
class Resv_model extends App_model
{

    public function __construct()
    {
        $this->load->database();
    }

    private function filterTextValues($param)
    { //just for extra filtering
        return preg_replace('/[^A-Za-z0-9.,-_\s?]/', '', $param);
    }

    public function deleteResv()
    {
        $reason = $this->input->post('delete_resv_reason');
        $resv_id = $this->input->post('delete_resv_id');
        $type = $this->input->post('delete_resv_type');
        $oldvalue = $this->input->post('delete_resv_oldvalue');
        $newvalue = $this->input->post('delete_resv_newvalue');
        $description = "Reservation " . $resv_id . " was deleted by " . $this->session->us_signature;

        //update reservation status
        $this->db->set('status', 'cancelled');
        $this->db->set('remarks', $reason);
        $this->db->where('reservation_id', $resv_id);
        $this->db->update('reservationitems');

        //send to report api        
        $section = "reservation_item";
        $action = "update_report";
        $endpoint_type = 'reservationitems';
        $data_for_update = array(
            "status" => 'cancelled',
            "remarks" => $reason
        );

        $this->getIDAndUpdateReports($section, $action, $data_for_update, 'reservationitems', 'reservation_id', $resv_id, $endpoint_type);


        //log this action
        $log_id = $this->createLog($type, "delete", $description, $oldvalue, $newvalue, $reason);
        return $log_id;
    }

    public function deletePerson()
    {
        $reason = $this->input->post('delete_person_reason');
        $person_id = $this->input->post('delete_person_id');
        $type = $this->input->post('delete_person_type');
        $title = $this->input->post('delete_person_title');
        $description = "Guest " . $title . " was deleted by " . $this->session->us_signature;
        //delete this person
        $tableitems = $type . "items";
        $this->db->where('ID', $person_id);
        $this->db->delete($tableitems);

        //log this action
        $log_id = 0;
        if ($log_id) {
            $log_id = $this->createLog($type, "delete", $description, "", "", $reason);
        }
        return $log_id;
    }

    //logs certain operations for auditing
    private function createLog($module, $action, $description, $oldvalue, $newvalue, $reason)
    {

        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');
        $data = array(
            'section' => $module,
            'action' => $action,
            'description' => $description,
            'old_value' => $oldvalue,
            'new_value' => $newvalue,
            'reason' => $reason,
            'signature_created' => $this->session->us_signature,
            'date_created' => $curr_date
        );
        $this->db->insert("logitems", $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    /* gets all fields for a table with filters,limit & offsets
         * ::used for page navigations etc */
    public function getModalItems($type, $return_json = FALSE, $ID = 0, $filter_val = FALSE)
    {

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

    // saves folio both sales & payment
    public function saveFolio($type)
    {

        $table = "reservationfolioitems";
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');
        $folio_action = str_replace("folio_", "", $type);

        $ID = $type . "_ID";
        $reserv = $type . "_resv";
        $description = $type . "_description";
        $plu_group = $type . "_plu_group";
        $plu = $type . "_plu";
        $amount = $type . "_amount";
        $account_id = $type . "_account";
        $qty = $type . "_qty";
        $price = $type . "_price";
        $new_folio = $type . "_new_folio";
        $log_action = $type . "_log_action";

        $folio_ID = $this->input->post($ID);
        $reservation_id = $this->input->post($reserv);
        $description = $this->input->post($description);
        $account_id = $this->input->post($account_id);
        $amount = $this->input->post($amount);
        $plu_group = (!empty($this->input->post($plu_group))) ? ($this->input->post($plu_group)) : (0);
        $plu = (!empty($this->input->post($plu))) ? ($this->input->post($plu)) : (0);
        $qty = (!empty($this->input->post($qty))) ? ($this->input->post($qty)) : (0);
        $price = (!empty($this->input->post($price))) ? ($this->input->post($price)) : (0);
        $sub_folio = (!empty($this->input->post($new_folio))) ? ($this->input->post($new_folio)) : ("BILL1");
        if ($description == "CASH REFUND") {
            $debit = 0;
            $credit = $amount;
        } else {
            $debit = ($folio_action == "payment") ? ($amount) : (0);
            $credit = ($folio_action == "sale") ? ($amount) : (0);
        }
        $log_action = $this->input->post($log_action);

        $pak = $links = $reference = $charge = $audit = $reason = "";
        $terminal = "001";
        $status = "active";

        if ($folio_ID == 0) {
            $data = array(
                'reservation_id' => $reservation_id,
                'date_created' => $curr_date,
                'description' => $description,
                'plu_group' => $plu_group,
                'plu' => $plu,
                'price' => $price,
                'debit' => $debit,
                'credit' => $credit,
                'pak' => $pak,
                'sub_folio' => $sub_folio,
                'account_number' => $account_id,
                'links' => $links,
                'qty' => $qty,
                'signature_created' => $this->session->us_signature,
                'reference' => $reference,
                'charge' => $charge,
                'audit' => $audit,
                'action' => $folio_action,
                'reason' => $reason,
                'terminal' => $terminal,
                'status' => $status
            );

            $this->db->insert($table, $data);
            $insert_id = $this->db->insert_id();

            //log if account was already closed
            if ($log_action === "yes") {
                $module = "folio";
                $log_amount = ($debit > 0) ? ($debit) : ($credit);
                $log_description = "User " . $this->session->us_signature . " added a " . $folio_action . " folio, "
                    . "amount: " . $log_amount . " description: " . $description . ", reservation id: " . $reservation_id;
                $log_id = $this->createLog($module, "insert", $log_description, "", $log_amount, "");
            }
            return $insert_id;
        } else if ($folio_ID > 0) {
            $data = array(
                'reservation_id' => $reservation_id,
                'date_modified' => $curr_date,
                'description' => $description,
                'plu_group' => $plu_group,
                'plu' => $plu,
                'price' => $price,
                'debit' => $debit,
                'credit' => $credit,
                'pak' => $pak,
                'account_number' => $account_id,
                'links' => $links,
                'qty' => $qty,
                'signature_created' => $this->session->us_signature,
                'reference' => $reference,
                'charge' => $charge,
                'audit' => $audit,
                'action' => $folio_action,
                'reason' => $reason,
                'terminal' => $terminal,
                'status' => $status
            );


            $this->db->where('ID', $folio_ID);
            $this->db->update($table, $data);

            //log if account was already closed
            if ($log_action === "yes") {
                $module = "folio";
                $log_amount = ($debit > 0) ? ($debit) : ($credit);
                $log_description = "User " . $this->session->us_signature . " updated a " . $folio_action . " folio, "
                    . "amount: " . $log_amount . " description: " . $description . ", reservation id: " . $reservation_id;
                $log_id = $this->createLog($module, "update", $log_description, "", $log_amount, "");
            }
            return $folio_ID;
        } else {
            return false;
        }
    }

    //saves pos sales to folio
    public function savePOSFolio($pos_data)
    {

        $table = "reservationfolioitems";
        $pak = $links = $reference = $audit = $reason = "";
        $charge = 'POS1';
        $plu_group = $debit = $plu = 0;
        $terminal = "001";
        $status = "active";

        $data = array(
            'reservation_id' => $pos_data["reservation_id"],
            'description' => $pos_data["description"],
            'plu_group' => $plu_group,
            'price' => $pos_data["price"],
            'plu' => $plu,
            'debit' => $debit,
            'credit' => $pos_data["price"],
            'pak' => $pak,
            'sub_folio' => 'BILL1',
            'source_app' => 'fnb', //indicates fnb payment
            'account_number' => $pos_data["sale_acct_id"], //food=13,drinks=14
            'links' => $links,
            'qty' => $pos_data["qty"],
            'reference' => $reference,
            'terminal' => $terminal,
            'charge' => $charge,
            'action' => 'sale',
            'reason' => $reason,
            'signature_created' => $pos_data["sig"],
            'audit' => $audit,
            'status' => $status,
            'date_created' => $pos_data["date_created"]
        );
        $this->db->insert($table, $data);

        //send to report api
        // $section=$table;
        // $action="insert_into_report";
        // $endpoint_type=$table;
        // $this->sendToReports("POST",$section,$action,$endpoint_type,$data);
    }

    /* updates client personal details */
    public function savePerson($type)
    {

        $tableitems = strtolower($type) . "items";
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $ID = $this->input->post('person_ID');
        $title = $this->filterTextValues($this->input->post('person_title'));
        $sex = $this->input->post('person_sex');
        $title_ref = $this->input->post('person_title_ref');
        $email = $this->input->post('person_email');
        $phone = $this->input->post('person_phone');
        $occupation = $this->filterTextValues($this->input->post('person_occupation'));
        $passport_no = $this->filterTextValues($this->input->post('person_passport_no'));
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
        $street = $this->filterTextValues($this->input->post('person_street'));
        $city = $this->filterTextValues($this->input->post('person_city'));
        $state = $this->filterTextValues($this->input->post('person_state'));
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
                'date_modified' => $curr_date
            );
            $this->db->where('ID', $ID);
            $this->db->update($tableitems, $data);
            return $ID;
        } elseif ($ID == 0) {
            //insert
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
                'date_created' => $curr_date
            );
            $this->db->insert($tableitems, $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }
    }

    public function saveGuest($type)
    {
        /* updates guest details */
        $res_result = array();
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $reservation_ID = $this->input->post('guest_ID');
        $master_id = (!empty($this->input->post('guest_master_id'))) ? ($this->input->post('guest_master_id')) : ("");
        $guest_arrival = $this->input->post('guest_arrival');
        $temp_date = str_replace('/', '-', $guest_arrival);
        $arrival = date('Y-m-d', strtotime($temp_date));
        $nights = $this->input->post('guest_nights');
        $departure = date('Y-m-d', strtotime($arrival . ' + ' . $nights . ' days'));
        $room_number = $this->input->post('guest_room_number_id');
        $roomtype = $this->input->post('guest_roomtype_id');
        $client_type = $this->input->post('guest_client_type');
        $client_name = $this->filterTextValues($this->input->post('guest_client_name'));
        $agency_name = $this->filterTextValues($this->input->post('guest_agency_name'));
        $remarks = $this->filterTextValues($this->input->post('guest_remarks'));
        $agency_contact = $this->filterTextValues($this->input->post('guest_agency_contact'));
        $guest1 = $this->filterTextValues($this->input->post('guest_guest1'));
        $guest2 = $this->filterTextValues($this->input->post('guest_guest2'));
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
        $discount = $this->input->post('guest_discount');
        $discount_type = $this->input->post('guest_discount_type');
        $discount_ratio = $this->input->post('guest_discount_ratio');
        $max_discount_value = $this->input->post('guest_max_discount_value');
        $weekday_no_deductions = $this->input->post('guest_weekday_no_deductions');
        $weekend_no_deductions = $this->input->post('guest_weekend_no_deductions');
        $holiday_no_deductions = $this->input->post('guest_holiday_no_deductions');
        $price_room_no_deductions = $this->input->post('guest_price_room_no_deductions');

        $invoice = $this->input->post('guest_invoice');
        $is_vat_exempted = $this->input->post('guest_is_vat_exempted');
        $comp_nights = $this->input->post('guest_comp_nights');
        $comp_visits = $this->input->post('guest_comp_visits');
        $block_pos = $this->input->post('guest_block_pos');

        if ($reservation_ID > 0) {
            //update reservation
            $data = array(
                'arrival' => $arrival,
                'master_id' => $master_id,
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
                'remarks' => $remarks,
                'adults' => $adults,
                'children' => $children,
                'guest_count' => $guest_count,
                'status' => $status,
                'signature_modified' => $this->session->us_signature,
                'date_modified' => $curr_date
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
                'discount' => $discount,
                'discount_type' => $discount_type,
                'discount_ratio' => $discount_ratio,
                'max_discount_value' => $max_discount_value,
                'weekday_no_deductions' => $weekday_no_deductions,
                'weekend_no_deductions' => $weekend_no_deductions,
                'holiday_no_deductions' => $holiday_no_deductions,
                'price_room_no_deductions' => $price_room_no_deductions,
                'invoice' => $invoice,
                'is_vat_exempted' => $is_vat_exempted,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'block_pos' => $block_pos
            );
            $this->db->where('reservation_id', $reservation_ID);
            $this->db->update("reservationpriceitems", $data);
            $res_result['reservation_id'] = $reservation_ID;
            $res_result['client_exists'] = "";
            return $res_result;
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
                'master_id' => $master_id,
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
                'remarks' => $remarks,
                'adults' => $adults,
                'children' => $children,
                'guest_count' => $guest_count,
                'status' => $status,
                'signature_created' => $this->session->us_signature,
                'date_created' => $curr_date
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
                'discount' => $discount,
                'discount_type' => $discount_type,
                'discount_ratio' => $discount_ratio,
                'max_discount_value' => $max_discount_value,
                'weekday_no_deductions' => $weekday_no_deductions,
                'weekend_no_deductions' => $weekend_no_deductions,
                'holiday_no_deductions' => $holiday_no_deductions,
                'price_room_no_deductions' => $price_room_no_deductions,
                'invoice' => $invoice,
                'is_vat_exempted' => $is_vat_exempted,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'block_pos' => $block_pos
            );

            $this->db->insert("reservationpriceitems", $data);
            //chk for existing client name
            $this->db->select('*');
            $this->db->where('LOWER(title)', strtolower($client_name));
            $query = $this->db->get('personitems');
            if ($query->num_rows() > 0) {
                $res_result['reservation_id'] = $padded_reservation_id;
                $res_result['client_exists'] = "";
            } else {
                $res_result['reservation_id'] = $padded_reservation_id;
                $res_result['client_exists'] = $client_name;
            }
            return $res_result;
        } else {
            return false;
        }
    }

    //09/10/2018...AM not sure where this is currently being implemented
    //but will use the logic
    public function searchAppClients($search_phrase, $type, $offset = 0, $limit_val = FALSE)
    {
        $results = array();
        $limit = $filter = "";
        $sort = " order by ID ASC";
        $results['data'] = array();
        $results['count'] = 0;

        if ($limit_val) {
            $limit = "LIMIT $offset,$limit_val";
        }

        $tableitems = $type . "items";
        $cleaned_search_phrase = $this->security->xss_clean($search_phrase);

        //        $this->db->select('ID,title,phone');
        //        $this->db->like('title', $search_phrase);
        //        $query = $this->db->get($table);

        $q = "SELECT * from $tableitems where title like '%$cleaned_search_phrase%' $sort $limit";
        $q_total = "SELECT * from $tableitems where title like '%$cleaned_search_phrase%' $sort ";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        //        if ($query->num_rows() > 0)
        //            $results = $query->result_array();
        //        return json_encode($results);
        return $results;
    }

    /* gets all fields for a reservation with filters,limit & offsets
         * ::used for page navigations etc */
    public function getReservations($type, $offset = 0, $limit_val = FALSE)
    {

        $app_date = date('Y-m-d', strtotime($this->getAppInfo()));

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
                $sort = "and ri.status='$type' AND ri.account_type='ROOM' order by ri.ID DESC";
                break;
            case "arriving":
                $sort = "and ri.status='confirmed' and ri.arrival='$app_date' AND ri.account_type='ROOM' "
                    . "order by ri.ID DESC";
                break;
            case "departing":
                $sort = "and ri.status='staying' and ri.departure<='$app_date' AND ri.account_type='ROOM' "
                    . "order by ri.ID DESC";
                break;
            case "all":
                $sort = " AND ri.account_type='ROOM' order by ri.ID DESC";
                break;
            case "staying":
                $sort = " and ri.status='$type' and DATE(ri.actual_arrival) <='$app_date' "
                    . "AND ri.account_type='ROOM' order by ri.ID DESC";
                break;
            case "person":
                $tableitems = "personitems";
            default:
                break;
        }


        if ($type == "person") {
            $q = "SELECT * from $tableitems where 1=1 $sort $limit";
            $q_total = "SELECT * from $tableitems where 1=1 $sort ";
        } else {
            $q = "SELECT rp.folio_room,ri.* from reservationpriceitems as rp "
                . "left join reservationitems as ri "
                . "on (rp.reservation_id = ri.reservation_id) "
                . "where 1=1 $sort $limit";

            $q_total = "SELECT rp.folio_room,ri.* from reservationpriceitems as rp "
                . "left join reservationitems as ri "
                . "on (rp.reservation_id = ri.reservation_id) "
                . "where 1=1 $sort ";

            $q_sum_resv_nights = "SELECT COUNT(ri.reservation_id) as sum_resv,sum(ri.nights) as sum_nights "
                . "from reservationitems as ri where ri.account_type='ROOM' $sort";
        }

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        if ($type != "person") {
            $query = $this->db->query($q_sum_resv_nights);
            if ($query->num_rows() > 0)
                $results['sum'] = $query->row_array();
        }

        return $results;
    }

    /* gets all fields for a reservation with filters,limit & offsets
         * ::used for page navigations etc */
    public function getGroupReservations($type, $offset = 0, $limit_val = FALSE)
    {

        $app_date = date('Y-m-d', strtotime($this->getAppInfo()));

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
                $sort = "and ri.status='$type' AND ri.account_type='GROUP' order by ri.ID DESC";
                break;
            case "arriving":
                $sort = "and ri.status='confirmed' and ri.arrival='$app_date' AND ri.account_type='GROUP' "
                    . "order by ri.ID DESC";
                break;
            case "departing":
                $sort = "and ri.status='staying' and ri.departure<='$app_date' AND ri.account_type='GROUP' "
                    . "order by ri.ID DESC";
                break;
            case "all":
                $sort = " AND ri.account_type='GROUP' order by ri.ID DESC";
                break;
            case "staying":
                $sort = " and ri.status='$type' and DATE(ri.actual_arrival) <='$app_date' "
                    . "AND ri.account_type='GROUP' order by ri.ID DESC";
                break;
            default:
                break;
        }

        $q = "SELECT rp.folio_room,ri.* from reservationpriceitems as rp "
            . "left join reservationitems as ri "
            . "on (rp.reservation_id = ri.reservation_id) "
            . "where 1=1 $sort $limit";

        $q_total = "SELECT rp.folio_room,ri.* from reservationpriceitems as rp "
            . "left join reservationitems as ri "
            . "on (rp.reservation_id = ri.reservation_id) "
            . "where 1=1 $sort ";

        $q_sum_resv_nights = "SELECT COUNT(ri.reservation_id) as sum_resv,sum(ri.nights) as sum_nights "
            . "from reservationitems as ri where ri.account_type='GROUP' $sort";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        $query = $this->db->query($q_sum_resv_nights);
        if ($query->num_rows() > 0)
            $results['sum'] = $query->row_array();

        return $results;
    }

    /* updates group details */
    public function saveGroup($type)
    {

        $res_result = array();
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $reservation_ID = $this->input->post('group_ID');
        $group_arrival = $this->input->post('group_arrival');
        $temp_date = str_replace('/', '-', $group_arrival);
        $arrival = date('Y-m-d', strtotime($temp_date));
        $nights = $this->input->post('group_nights');
        $departure = date('Y-m-d', strtotime($arrival . ' + ' . $nights . ' days'));
        $roomtype = $this->input->post('group_roomtype_id');
        $client_type = $this->input->post('group_client_type');
        $client_name = $this->input->post('group_client_name');
        $status = $this->input->post('group_status');
        $remarks = $this->input->post('group_remarks');
        //price
        $price_rate_id = $this->input->post('group_price_rate_id');
        $folio_room = $this->input->post('group_folio_room');
        $folio_extra = $this->input->post('group_folio_extra');
        $folio_other = $this->input->post('group_folio_other');
        $weekday = $this->input->post('group_weekday');
        $weekend = $this->input->post('group_weekend');
        $holiday = $this->input->post('group_holiday');
        $price_room = $this->input->post('group_price_room');
        $price_extra = $this->input->post('group_price_extra');
        $price_total = $this->input->post('group_price_total');
        $discount = $this->input->post('group_discount');
        $discount_type = $this->input->post('group_discount_type');
        $discount_ratio = $this->input->post('group_discount_ratio');
        $max_discount_value = $this->input->post('group_max_discount_value');
        $weekday_no_deductions = $this->input->post('group_weekday_no_deductions');
        $weekend_no_deductions = $this->input->post('group_weekend_no_deductions');
        $holiday_no_deductions = $this->input->post('group_holiday_no_deductions');
        $price_room_no_deductions = $this->input->post('group_price_room_no_deductions');

        // $is_vat_exempted = $this->input->post('guest_is_vat_exempted');
        $price_total = $this->input->post('group_price_total');
        $comp_nights = $this->input->post('group_comp_nights');
        $comp_visits = $this->input->post('group_comp_visits');

        if ($reservation_ID > 0) {
            //update reservation
            $data = array(
                'arrival' => $arrival,
                'nights' => $nights,
                'departure' => $departure,
                'roomtype' => $roomtype,
                'client_type' => $client_type,
                'remarks' => $remarks,
                'status' => $status,
                'status' => $status,
                'signature_modified' => $this->session->us_signature,
                'date_modified' => $curr_date
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
                'discount' => $discount,
                'discount_type' => $discount_type,
                'discount_ratio' => $discount_ratio,
                'max_discount_value' => $max_discount_value,
                'weekday_no_deductions' => $weekday_no_deductions,
                'weekend_no_deductions' => $weekend_no_deductions,
                'holiday_no_deductions' => $holiday_no_deductions,
                'price_room_no_deductions' => $price_room_no_deductions,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits
            );
            $this->db->where('reservation_id', $reservation_ID);
            $this->db->update("reservationpriceitems", $data);
            $res_result['reservation_id'] = $reservation_ID;
            $res_result['client_exists'] = "";
            return $res_result;
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
                'account_type' => 'GROUP',
                'nights' => $nights,
                'departure' => $departure,
                'roomtype' => $roomtype,
                'client_type' => $client_type,
                'client_name' => $client_name,
                'status' => $status,
                'remarks' => $remarks,
                'signature_created' => $this->session->us_signature,
                'date_created' => $curr_date
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
                'discount' => $discount,
                'discount_type' => $discount_type,
                'discount_ratio' => $discount_ratio,
                'max_discount_value' => $max_discount_value,
                'weekday_no_deductions' => $weekday_no_deductions,
                'weekend_no_deductions' => $weekend_no_deductions,
                'holiday_no_deductions' => $holiday_no_deductions,
                'price_room_no_deductions' => $price_room_no_deductions,
                'comp_nights' => $comp_nights,
                'comp_visits' => $comp_visits,
                'block_pos' => 'no',
                'auto_deposit' => 'no'
            );
            $this->db->insert("reservationpriceitems", $data);
            $res_result['reservation_id'] = $padded_reservation_id;
            return $res_result;
        } else {
            return false;
        }
    }

    /* gets all fields for a reservation with filters,limit & offsets
         * ::used for page navigations etc */
    public function getHouseReservations($type, $offset = 0, $limit_val = FALSE)
    {

        $app_date = date('Y-m-d', strtotime($this->getAppInfo()));

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
                $sort = "and ri.status='$type' AND ri.account_type='HOUSE' order by ri.ID DESC";
                break;
            case "departed":
                $sort = "and ri.status='departed' and DATE(ri.actual_departure)<='$app_date' AND ri.account_type='HOUSE' "
                    . "order by ri.ID DESC";
                break;
            case "all":
                $sort = " AND ri.account_type='HOUSE' order by ri.ID DESC";
                break;
            case "staying":
                $sort = " and ri.status='$type' and DATE(ri.actual_arrival) <='$app_date' "
                    . "AND ri.account_type='HOUSE' order by ri.ID DESC";
                break;
            default:
                break;
        }

        $q = "SELECT ri.* from reservationitems as ri where 1=1 $sort $limit";

        $q_total = "SELECT ri.* from reservationitems as ri where 1=1 $sort ";

        $q_sum_resv_nights = "SELECT COUNT(ri.reservation_id) as sum_resv,sum(ri.nights) as sum_nights "
            . "from reservationitems as ri where ri.account_type='HOUSE' $sort";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        $query = $this->db->query($q_sum_resv_nights);
        if ($query->num_rows() > 0)
            $results['sum'] = $query->row_array();

        return $results;
    }

    /* updates house details */
    public function saveHouse($type)
    {

        $res_result = array();
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $reservation_ID = $this->input->post('house_ID');
        $house_arrival = $this->input->post('house_arrival');
        $temp_date = str_replace('/', '-', $house_arrival);
        $arrival = date('Y-m-d', strtotime($temp_date));
        $nights = $this->input->post('house_nights');
        $departure = date('Y-m-d', strtotime($arrival . ' + ' . $nights . ' days'));
        $client_type = $this->input->post('house_client_type');
        $client_name = $this->input->post('house_client_name');
        $status = $this->input->post('house_status');
        $house_remarks = $this->input->post('house_remarks');
        //price
        $folio_room = $this->input->post('house_folio_room');

        if ($reservation_ID > 0) {
            //update reservation
            $data = array(
                'arrival' => $arrival,
                'nights' => $nights,
                'departure' => $departure,
                'client_type' => $client_type,
                'client_name' => $client_name,
                'status' => $status,
                'remarks' => $house_remarks,
                'signature_modified' => $this->session->us_signature,
                'date_modified' => $curr_date
            );
            $this->db->where('reservation_id', $reservation_ID);
            $this->db->update("reservationitems", $data);

            //update reports
            $section = "reservation_item";
            $action = "update_report";
            $data_for_update = $data;
            $endpoint_type = 'reservationitems';
            $this->getIDAndUpdateReports($section, $action, $data_for_update, 'reservationitems', 'reservation_id', $reservation_ID, $endpoint_type);


            $res_result['reservation_id'] = $reservation_ID;
            $res_result['client_exists'] = "";
            return $res_result;
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
                'account_type' => 'HOUSE',
                'nights' => $nights,
                'departure' => $departure,
                'client_type' => $client_type,
                'client_name' => $client_name,
                'status' => $status,
                'remarks' => $house_remarks,
                'signature_created' => $this->session->us_signature,
                'date_created' => $curr_date,
                'actual_arrival' => $curr_date
            );
            $this->db->insert("reservationitems", $data);

            //send to report api
            $section = "reservation_item";
            $action = "insert_into_report";
            $this->sendToReports("POST", $section, $action, $data);

            $res_result['reservation_id'] = $padded_reservation_id;
            return $res_result;
        } else {
            return false;
        }
    }

    public function getFolioDeductions($reservation_id)
    {
        $total_sale_bill1 = $total_sale_bill2 = $total_sale_bill3 = $total_sale_bill4 = $total_sale_inv = 0;
        $total_vat_bill1 = $total_vat_bill2 = $total_vat_bill3 = $total_vat_bill4 = $total_vat_inv = 0;
        $total_service_charge_bill1 = $total_service_charge_bill2 = $total_service_charge_bill3 = $total_service_charge_bill4 = $total_service_charge_inv = 0;
        $total_payment_bill1 = $total_payment_bill2 = $total_payment_bill3 = $total_payment_bill4 = $total_payment_inv = 0;
        $total_refund_bill1 = $total_refund_bill2 = $total_refund_bill3 = $total_refund_bill4 = $total_refund_inv = 0;

        $q_sale = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN credit
                    END)AS BILL1,SUM(CASE WHEN sub_folio='BILL2' THEN credit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN credit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN credit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN credit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND (action='sale' AND status<>'closed' AND description<>'CASH REFUND')";

        $query_sale_bills = $this->db->query($q_sale);
        if ($query_sale_bills->num_rows() > 0) {
            $result = $query_sale_bills->row_array();
            $total_sale_bill1 = $result['BILL1'];
            $total_sale_bill2 = $result['BILL2'];
            $total_sale_bill3 = $result['BILL3'];
            $total_sale_bill4 = $result['BILL4'];
            $total_sale_inv = $result['INV'];
        }


        $q_vat = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN vat END)AS BILL1,
                    SUM(CASE WHEN sub_folio='BILL2' THEN vat END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN vat END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN vat END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN vat END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND (action='sale' AND status<>'closed' AND description<>'CASH REFUND')";


        $query_vat_bills = $this->db->query($q_vat);
        if ($query_vat_bills->num_rows() > 0) {
            $result = $query_vat_bills->row_array();
            $total_vat_bill1 = $result['BILL1'];
            $total_vat_bill2 = $result['BILL2'];
            $total_vat_bill3 = $result['BILL3'];
            $total_vat_bill4 = $result['BILL4'];
            $total_vat_inv = $result['INV'];
        }


        $q_service_charge = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN credit END)AS BILL1,
                    SUM(CASE WHEN sub_folio='BILL2' THEN credit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN credit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN credit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN credit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND (action='sale' AND status<>'closed' AND description ='SERVICE CHARGE')";


        $query_service_charge_bills = $this->db->query($q_service_charge);
        if ($query_service_charge_bills->num_rows() > 0) {
            $result = $query_service_charge_bills->row_array();
            $total_service_charge_bill1 = $result['BILL1'];
            $total_service_charge_bill2 = $result['BILL2'];
            $total_service_charge_bill3 = $result['BILL3'];
            $total_service_charge_bill4 = $result['BILL4'];
            $total_service_charge_inv = $result['INV'];
        }

        $q_payment = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN debit END)AS BILL1,
                    SUM(CASE WHEN sub_folio='BILL2' THEN debit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN debit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN debit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN debit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND action='payment' AND status<>'closed'";

        $query_payment_bills = $this->db->query($q_payment);
        if ($query_payment_bills->num_rows() > 0) {
            $result = $query_payment_bills->row_array();
            $total_payment_bill1 = $result['BILL1'];
            $total_payment_bill2 = $result['BILL2'];
            $total_payment_bill3 = $result['BILL3'];
            $total_payment_bill4 = $result['BILL4'];
            $total_payment_inv = $result['INV'];
        }

        $q_refund = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN credit END)AS BILL1,
                    SUM(CASE WHEN sub_folio='BILL2' THEN credit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN credit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN credit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN credit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND action='payment' AND status<>'closed' AND description = 'CASH REFUND'";

        $query_refund_bills = $this->db->query($q_refund);
        if ($query_refund_bills->num_rows() > 0) {
            $result = $query_refund_bills->row_array();
            $total_refund_bill1 = $result['BILL1'];
            $total_refund_bill2 = $result['BILL2'];
            $total_refund_bill3 = $result['BILL3'];
            $total_refund_bill4 = $result['BILL4'];
            $total_refund_inv = $result['INV'];
        }

        /* make deductions */
        $amount_received_bill1 =  ($total_payment_bill1 - $total_refund_bill1);
        $amount_received_bill2 =  ($total_payment_bill2 - $total_refund_bill2);
        $amount_received_bill3 =  ($total_payment_bill3 - $total_refund_bill3);
        $amount_received_bill4 =  ($total_payment_bill4 - $total_refund_bill4);
        $amount_received_inv   =  ($total_payment_inv - $total_refund_inv);

        $sub_total_bill1 = $total_sale_bill1 + $total_vat_bill1 + $total_service_charge_bill1;
        $sub_total_bill2 = $total_sale_bill2 + $total_vat_bill2 + $total_service_charge_bill2;
        $sub_total_bill3 = $total_sale_bill3 + $total_vat_bill3 + $total_service_charge_bill3;
        $sub_total_bill4 = $total_sale_bill4 + $total_vat_bill4 + $total_service_charge_bill4;
        $sub_total_inv = $total_sale_inv + $total_vat_inv + $total_service_charge_inv;

        $bill1_diff = $amount_received_bill1 - $sub_total_bill1;
        $bill2_diff = $amount_received_bill2 - $sub_total_bill2;
        $bill3_diff = $amount_received_bill3 - $sub_total_bill3;
        $bill4_diff = $amount_received_bill4 - $sub_total_bill4;
        $inv_diff = $amount_received_inv - $sub_total_inv;

        $deductions = array(
            'BILL1' => $bill1_diff,
            'BILL2' => $bill2_diff,
            'BILL3' => $bill3_diff,
            'BILL4' => $bill4_diff,
            'INV' => $inv_diff
        );
        return $deductions;
    }

    public function getFolios($reservation_id, $offset = 0, $limit_val = FALSE)
    {
        $sale_total = $refund_total = $payment_total = $vat_total = $service_charge_total = $sub_total = 0;

        $limit = "";
        $sort = "order by ID ASC";
        $results['data'] = array();
        $results['count'] = 0;
        $results['room'] = "";

        if ($limit_val) {
            $limit = "LIMIT $offset,$limit_val";
        }

        $q_room = "SELECT ro.title as resv_room_title FROM reservationitems as ri "
            . "left join roomitems as ro on (ri.room_number =ro.ID) "
            . "WHERE ri.reservation_id='$reservation_id'";

        $query_room =  $this->db->query($q_room);
        if ($query_room->num_rows() > 0) {
            $res = $query_room->row_array();
            $results['room'] = $res['resv_room_title'];
        }

        $q = "SELECT ri.status as folio_status,rf.*,rp.discount_type,rp.discount_ratio FROM reservationitems as ri "
            . "left join reservationfolioitems as rf "
            . "on (ri.reservation_id=rf.reservation_id) "
            . "left join reservationpriceitems as rp "
            . "on (ri.reservation_id=rp.reservation_id) "
            . " WHERE rf.reservation_id='$reservation_id' "
            . " $sort $limit";

        $q_total = "SELECT ri.status as folio_status,rf.* FROM reservationitems as ri "
            . "left join reservationfolioitems as rf "
            . "on (ri.reservation_id=rf.reservation_id) "
            . " WHERE rf.reservation_id='$reservation_id' "
            . " $sort";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $results['data'] = $query->result_array();
        }

        $query_total = $this->db->query($q_total);
        if ($query_total->num_rows() > 0) {
            $results['count'] = $query_total->num_rows();
        }

        //get deductions
        $results['deductions'] = $this->getFolioDeductions($reservation_id);

        $q_sale_total = "SELECT SUM(credit) AS SUM FROM reservationfolioitems WHERE (action='sale') "
            . "AND reservation_id='$reservation_id' ";

        $query_sale_total = $this->db->query($q_sale_total);
        if ($query_sale_total->num_rows() > 0) {
            $result = $query_sale_total->row_array();
            $sale_total = $result['SUM'];
        }

        $q_vat_total = "SELECT SUM(vat) AS SUM FROM reservationfolioitems WHERE (action='sale') "
            . "AND reservation_id='$reservation_id' ";

        $query_vat_total = $this->db->query($q_vat_total);
        if ($query_vat_total->num_rows() > 0) {
            $result = $query_vat_total->row_array();
            $vat_total = $result['SUM'];
        }

        $q_service_charge_total = "SELECT SUM(credit) AS SUM FROM reservationfolioitems WHERE (action='sale') "
            . "AND reservation_id='$reservation_id' and reservationfolioitems.description ='SERVICE CHARGE'";

        $query_service_charge_total = $this->db->query($q_service_charge_total);
        if ($query_service_charge_total->num_rows() > 0) {
            $result = $query_service_charge_total->row_array();
            $service_charge_total = $result['SUM'];
        }

        $q_payment_total = "SELECT SUM(debit) AS SUM FROM reservationfolioitems "
            . "WHERE action='payment' AND description<>'CASH REFUND' "
            . "AND reservation_id='$reservation_id' ";

        $query_payment_total = $this->db->query($q_payment_total);
        if ($query_payment_total->num_rows() > 0) {
            $result = $query_payment_total->row_array();
            $payment_total = $result['SUM'];
        }

        $q_refund_total = "SELECT SUM(credit) AS SUM FROM reservationfolioitems "
            . "WHERE (description='CASH REFUND') AND reservation_id='$reservation_id' "
            . "";

        $query_refund_total = $this->db->query($q_refund_total);
        if ($query_refund_total->num_rows() > 0) {
            $result = $query_refund_total->row_array();
            $refund_total = $result['SUM'];
        }

        $amount_received = floatval($payment_total - $refund_total);
        $sub_total = $sale_total + $vat_total + $service_charge_total;
        $folio_diff = floatval($sub_total - $amount_received);
        $red_bal = ($folio_diff > 0) ? ("red") : ("");

        $totals = array(
            'SALE_TOTAL' => number_format($sale_total, 2),
            'PAYMENT_TOTAL' => number_format($amount_received, 2),
            'VAT_TOTAL' => number_format($vat_total, 2),
            'SERVICE_CHARGE_TOTAL' => number_format($service_charge_total, 2),
            'FOLIO_DIFF' => number_format($folio_diff, 2),
            'SUB_TOTAL' => number_format($sub_total, 2),
            'RED_BAL' => $red_bal
        );
        $results['totals'] = $totals;

        return $results;
    }

    public function getFoliosForBILL($reservation_id, $offset = 0, $limit_val = FALSE, $filter_val = FALSE)
    {

        $total_sale_bill = 0;
        $total_payment_bill = 0;
        $total_refund_bill = 0;
        $total_vat_bill = 0;
        $total_service_charge_bill = 0;
        $sale_total = $refund_total = $payment_total = $vat_total = $service_charge_total = $sub_total = 0;

        $limit = "";
        $sort = "order by ID ASC";
        $results['data'] = array();
        $results['count'] = 0;
        $results['room'] = "";

        if ($limit_val) {
            $limit = "LIMIT $offset,$limit_val";
        }
        if ($filter_val) {
            $sort = " and sub_folio='$filter_val' order by ID ASC";
        }

        $q_room = "SELECT ro.title as resv_room_title FROM reservationitems as ri "
            . "left join roomitems as ro on (ri.room_number =ro.ID) "
            . "WHERE ri.reservation_id='$reservation_id'";

        $query_room =  $this->db->query($q_room);
        if ($query_room->num_rows() > 0) {
            $res = $query_room->row_array();
            $results['room'] = $res['resv_room_title'];
        }

        $q = "SELECT ri.status as folio_status,rf.*,rp.discount_type,rp.discount_ratio FROM reservationitems as ri "
            . "left join reservationfolioitems as rf "
            . "on (ri.reservation_id=rf.reservation_id) "
            . "left join reservationpriceitems as rp "
            . "on (ri.reservation_id=rp.reservation_id) "
            . " WHERE rf.reservation_id='$reservation_id' "
            . " $sort $limit";

        $q_total = "SELECT ri.status as folio_status,rf.* FROM reservationitems as ri "
            . "left join reservationfolioitems as rf "
            . "on (ri.reservation_id=rf.reservation_id) "
            . " WHERE rf.reservation_id='$reservation_id' "
            . " 'closed' $sort";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $results['data'] = $query->result_array();
        }

        $query_total = $this->db->query($q_total);
        if ($query_total->num_rows() > 0) {
            $results['count'] = $query_total->num_rows();
        }

        $q_sale = "SELECT SUM(CASE WHEN sub_folio='$filter_val' THEN credit END)AS $filter_val"
            . " FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND (action='sale'  AND description<>'CASH REFUND')";

        $query_sale_bills = $this->db->query($q_sale);
        if ($query_sale_bills->num_rows() > 0) {
            $result = $query_sale_bills->row_array();
            $total_sale_bill = $result[$filter_val];
        }

        $q_vat = "SELECT SUM(CASE WHEN sub_folio='$filter_val' THEN vat END)AS $filter_val"
            . " FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND (action='sale'  AND description<>'CASH REFUND')";

        $query_vat_bills = $this->db->query($q_vat);
        if ($query_vat_bills->num_rows() > 0) {
            $result = $query_vat_bills->row_array();
            $total_vat_bill = $result[$filter_val];
        }

        $q_service_charge = "SELECT SUM(CASE WHEN sub_folio='$filter_val' THEN credit END)AS $filter_val"
            . " FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND (action='sale'  AND description ='SERVICE CHARGE')";

        $query_service_charge_bills = $this->db->query($q_service_charge);
        if ($query_service_charge_bills->num_rows() > 0) {
            $result = $query_service_charge_bills->row_array();
            $total_service_charge_bill = $result[$filter_val];
        }

        $q_payment = "SELECT SUM(CASE WHEN sub_folio='$filter_val' THEN debit END)AS $filter_val"
            . " FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND action='payment' ";

        $query_payment_bills = $this->db->query($q_payment);
        if ($query_payment_bills->num_rows() > 0) {
            $result = $query_payment_bills->row_array();
            $total_payment_bill = $result[$filter_val];
        }

        $q_refund = "SELECT SUM(CASE WHEN sub_folio='$filter_val' THEN credit END)AS $filter_val"
            . " FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
            . "AND action='payment'  AND description = 'CASH REFUND'";

        $query_refund_bills = $this->db->query($q_refund);
        if ($query_refund_bills->num_rows() > 0) {
            $result = $query_refund_bills->row_array();
            $total_refund_bill = $result[$filter_val];
        }

        /* make deductions */
        $amount_received_bill = floatval($total_payment_bill - $total_refund_bill);
        $sub_total_bill = $total_sale_bill + $total_vat_bill + $total_service_charge_bill;
        $bill_diff = floatval($sub_total_bill - $amount_received_bill);

        $deductions = array(
            $filter_val => $bill_diff
        );
        $results['deductions'] = $deductions;

        $q_sale_total = "SELECT SUM(credit) AS SUM FROM reservationfolioitems WHERE (action='sale') "
            . "AND reservation_id='$reservation_id'  $sort";

        $query_sale_total = $this->db->query($q_sale_total);
        if ($query_sale_total->num_rows() > 0) {
            $result = $query_sale_total->row_array();
            $sale_total = $result['SUM'];
        }

        $q_vat_total = "SELECT SUM(vat) AS SUM FROM reservationfolioitems WHERE (action='sale') "
            . "AND reservation_id='$reservation_id'  $sort";

        $query_vat_total = $this->db->query($q_vat_total);
        if ($query_vat_total->num_rows() > 0) {
            $result = $query_vat_total->row_array();
            $vat_total = $result['SUM'];
        }

        $q_service_charge_total = "SELECT SUM(credit) AS SUM FROM reservationfolioitems WHERE (action='sale') "
            . "AND reservation_id='$reservation_id' AND description ='SERVICE CHARGE'  $sort";

        $query_service_charge_total = $this->db->query($q_service_charge_total);
        if ($query_service_charge_total->num_rows() > 0) {
            $result = $query_service_charge_total->row_array();
            $service_charge_total = $result['SUM'];
        }

        $q_payment_total = "SELECT SUM(debit) AS SUM FROM reservationfolioitems "
            . "WHERE action='payment' AND description<>'CASH REFUND' "
            . "AND reservation_id='$reservation_id'  $sort";

        $query_payment_total = $this->db->query($q_payment_total);
        if ($query_payment_total->num_rows() > 0) {
            $result = $query_payment_total->row_array();
            $payment_total = $result['SUM'];
        }

        $q_refund_total = "SELECT SUM(credit) AS SUM FROM reservationfolioitems "
            . "WHERE (description='CASH REFUND') AND reservation_id='$reservation_id' "
            . " $sort";

        $query_refund_total = $this->db->query($q_refund_total);
        if ($query_refund_total->num_rows() > 0) {
            $result = $query_refund_total->row_array();
            $refund_total = $result['SUM'];
        }

        $amount_received = floatval($payment_total - $refund_total);
        $sub_total = $sale_total + $vat_total + $service_charge_total;
        $folio_diff = floatval($sub_total - $amount_received);
        $red_bal = ($folio_diff > 0) ? ("red") : ("");

        $totals = array(
            'SALE_TOTAL' => number_format($sale_total, 2),
            'PAYMENT_TOTAL' => number_format($amount_received, 2),
            'VAT_TOTAL' => number_format($vat_total, 2),
            'SERVICE_CHARGE_TOTAL' => number_format($service_charge_total, 2),
            'FOLIO_DIFF' => number_format($folio_diff, 2),
            'SUB_TOTAL' => number_format($sub_total, 2),
            'RED_BAL' => $red_bal
        );

        $results['totals'] = $totals;

        return $results;
    }

    /*
         * select * rows where ID in array and action is payment
         * sum all the rows
         */
    public function getFoliosForReceipt($receiver_resv, $folio_IDs)
    {

        $res['response'] = "error";
        $res['message'] = "Receipt Generation failed";
        $res['data'] = [];
        $res['personal'] = array(
            'client_name' => '',
            'actual_arrival' => date('Y-m-d'),
            'actual_departure' => date('Y-m-d'),
            'date_created' => date('Y-m-d'),
            'departure' => date('Y-m-d'),
            'nights' => 0,
            'folio_room_number' => '',
            'reservation_id' => '',
            'folio_room_type' => ''
        );
        $res['payment_total'] = array('debit' => 0);

        //confirm reservation exists as a staying or confirmed guest
        $receiver_resvation_id = $this->security->xss_clean($receiver_resv);
        $this->db->select('ID');
        $this->db->where('reservation_id', $receiver_resvation_id);
        $this->db->where('status', 'staying');
        $this->db->or_where('status', 'confirmed');
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() <= 0) {
            $res['message'] = "Account owner is not a staying or confirmed guest";
            return $res;
        }

        //get selected payments
        $this->db->select('*');
        $this->db->where_in('ID', $folio_IDs);
        $this->db->where('action', 'payment');
        $query = $this->db->get('reservationfolioitems');
        if ($query->num_rows() > 0) {
            $res['data'] = $query->result_array();

            $q = "SELECT ri.reservation_id,ri.client_name,ri.actual_arrival,ri.actual_departure,ri.departure,ri.nights,ro.title as folio_room_number, "
                . "ri.date_created,rt.title as folio_room_type FROM reservationitems as ri left join roomitems as ro "
                . "on (ri.room_number = ro.ID) left join roomtypeitems as rt "
                . "on (ri.roomtype = rt.ID) "
                . " WHERE ri.reservation_id='$receiver_resvation_id' ";

            $query_personal = $this->db->query($q);
            if ($query_personal->num_rows() > 0) {
                $res['personal'] = $query_personal->row_array();
            }

            $this->db->select_sum('debit');
            $this->db->where_in('ID', $folio_IDs);
            $this->db->where('action', 'payment');
            $query = $this->db->get('reservationfolioitems');
            if ($query->num_rows() > 0) {
                $res['payment_total'] = $query->row_array();
            }

            $res['response'] = "success";
            $res['message'] = "Receipt Successful";
        }
        return $res;
    }

    public function getFoliosForPrint($reservation_id, $filter_val = FALSE)
    {

        $sale_total = $refund_total = $payment_total = $vat_total = $service_charge_total = $sub_total = 0;

        $sort = "order by rf.ID ASC";
        if ($filter_val) {
            $sort = " and rf.sub_folio = '$filter_val' order by rf.ID ASC";
        }

        $results['data'] = array();
        $results['count'] = 0;

        $q = "SELECT ro.title as folio_room_number,ri.client_name,rf.* FROM reservationitems as ri "
            . "left join reservationfolioitems as rf "
            . "on (ri.reservation_id=rf.reservation_id) "
            . "left join reservationpriceitems as rp "
            . "on (ri.reservation_id=rp.reservation_id) "
            . "left join roomitems as ro on (ri.room_number = ro.ID) "
            . " WHERE rf.reservation_id='$reservation_id' "
            . " $sort";


        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $results['data'] = $query->result_array();
        }

        $q_sale_total = "SELECT SUM(rf.credit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='sale' "
            . "AND rf.reservation_id='$reservation_id' $sort";

        $query_sale_total = $this->db->query($q_sale_total);
        if ($query_sale_total->num_rows() > 0) {
            $result = $query_sale_total->row_array();
            $sale_total = $result['SUM'];
        }

        $q_service_charge = "SELECT SUM(rf.credit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='sale' "
            . "and rf.description ='SERVICE CHARGE' AND rf.reservation_id='$reservation_id' $sort";

        $query_service_charge = $this->db->query($q_service_charge);
        if ($query_service_charge->num_rows() > 0) {
            $result = $query_service_charge->row_array();
            $service_charge_total = $result['SUM'];
        }

        $q_vat_total = "SELECT SUM(rf.vat) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='sale' "
            . "AND rf.reservation_id='$reservation_id' $sort";

        $query_vat_total = $this->db->query($q_vat_total);
        if ($query_vat_total->num_rows() > 0) {
            $result = $query_vat_total->row_array();
            $vat_total = $result['SUM'];
        }

        $q_payment_total = "SELECT SUM(rf.debit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='payment' AND rf.description<>'CASH REFUND' "
            . "AND rf.reservation_id='$reservation_id' $sort";

        $query_payment_total = $this->db->query($q_payment_total);
        if ($query_payment_total->num_rows() > 0) {
            $result = $query_payment_total->row_array();
            $payment_total = $result['SUM'];
        }

        $q_refund_total = "SELECT SUM(rf.credit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE (rf.description='CASH REFUND') AND rf.reservation_id='$reservation_id' $sort";

        $query_refund_total = $this->db->query($q_refund_total);
        if ($query_refund_total->num_rows() > 0) {
            $result = $query_refund_total->row_array();
            $refund_total = $result['SUM'];
        }

        $amount_received = floatval($payment_total - $refund_total);
        $sub_total = $sale_total + $vat_total + $service_charge_total;
        $folio_diff = floatval($amount_received - $sub_total);

        $totals = array(
            'SALE_TOTAL' => number_format($sale_total, 2),
            'PAYMENT_TOTAL' => number_format($amount_received, 2),
            'FOLIO_DIFF' => number_format($folio_diff, 2),
            'VAT' => number_format($vat_total, 2),
            'SERVICE_CHARGE' => number_format($service_charge_total, 2),
            'SUB_TOTAL' => number_format($sub_total, 2)
        );
        $results['totals'] = $totals;

        return $results;
    }

    /* get resv & folio details
         * calc total sales,received & bal
         * update room status to vacant_dirty(2)
         * update resv status to departed,set actual_departure,
         * update folios to closed
         */
    public function checkout($reservation_id, $modifier = FALSE)
    {

        $sale_total = $refund_total = $payment_total = $service_charge_total = $sub_total = 0;

        $app_day = date("Y-m-d", strtotime($this->getAppInfo())) . " " . date("H:i:s");
        if (!empty($modifier)) {
            $resv_status = $folio_status = "ledger";
        } else {
            $resv_status = "departed";
            $folio_status = "closed";
        }

        //get room_number & arrival
        $this->db->select('room_number,actual_arrival');
        $this->db->where('reservation_id', $reservation_id);
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $room_number = $row['room_number'];

            //calc nights spent
            $date1 = date_create($row['actual_arrival']);
            $date2 = date_create($app_day);
            $diff = date_diff($date1, $date2);
            $nights = $diff->format("%R%a");
            //update resv status to departed/ledger,set actual_departure,nights just to be accurate
            $data = array(
                'status' => $resv_status,
                'actual_departure' => $app_day,
                'nights' => $nights
            );
            $this->db->where('reservation_id', $reservation_id);
            $this->db->update('reservationitems', $data);

            if ($room_number > 0) {
                //update room status to vacant_dirty(2)
                $this->db->set('status', 2);
                $this->db->where('ID', $room_number);
                $this->db->update('roomitems');
            }

            //update folios to closed/ledger
            $this->db->set('status', $folio_status);
            if ($folio_status === 'ledger') {
                $this->db->set('sub_folio', 'INV');
            }
            $this->db->where('reservation_id', $reservation_id);
            $this->db->update('reservationfolioitems');
        }

        $sort = "order by rf.ID ASC";

        $results['data'] = array();
        $results['count'] = 0;

        //get resv & folio details
        $this->db->select('*');
        $this->db->join('reservationpriceitems', 'reservationpriceitems.reservation_id = reservationfolioitems.reservation_id');
        $this->db->where('reservationfolioitems.reservation_id', $reservation_id);
        $query = $this->db->get('reservationfolioitems');

        if ($query->num_rows() > 0) {
            $results['data'] = $query->result_array();
        }
        $q = "SELECT ri.client_name,ri.actual_arrival,ri.actual_departure,ri.nights,ro.title as folio_room_number "
            . "FROM reservationitems as ri left join roomitems as ro "
            . "on (ri.room_number = ro.ID) WHERE ri.reservation_id='$reservation_id' ";

        $query_personal = $this->db->query($q);
        if ($query_personal->num_rows() > 0) {
            $results['personal'] = $query_personal->row_array();
        }

        //calc total sales,received & bal
        $q_sale_total = "SELECT SUM(rf.credit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='sale' AND rf.reservation_id='$reservation_id' $sort";

        $query_sale_total = $this->db->query($q_sale_total);
        if ($query_sale_total->num_rows() > 0) {
            $result = $query_sale_total->row_array();
            $sale_total = $result['SUM'];
        }

        $q_service_charge = "SELECT SUM(rf.credit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='sale' "
            . "and rf.description ='SERVICE CHARGE' AND rf.reservation_id='$reservation_id' $sort";

        $query_service_charge = $this->db->query($q_service_charge);
        if ($query_service_charge->num_rows() > 0) {
            $result = $query_service_charge->row_array();
            $service_charge_total = $result['SUM'];
        }

        $q_vat_total = "SELECT SUM(rf.vat) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='sale' "
            . "AND rf.reservation_id='$reservation_id' $sort";

        $query_vat_total = $this->db->query($q_vat_total);
        if ($query_vat_total->num_rows() > 0) {
            $result = $query_vat_total->row_array();
            $vat_total = $result['SUM'];
        }

        $q_payment_total = "SELECT SUM(rf.debit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE rf.action='payment' AND rf.description<>'CASH REFUND' "
            . "AND rf.reservation_id='$reservation_id' $sort";

        $query_payment_total = $this->db->query($q_payment_total);
        if ($query_payment_total->num_rows() > 0) {
            $result = $query_payment_total->row_array();
            $payment_total = $result['SUM'];
        }

        $q_refund_total = "SELECT SUM(rf.credit) AS SUM FROM reservationfolioitems as rf "
            . "WHERE (rf.description='CASH REFUND') AND rf.reservation_id='$reservation_id' $sort";

        $query_refund_total = $this->db->query($q_refund_total);
        if ($query_refund_total->num_rows() > 0) {
            $result = $query_refund_total->row_array();
            $refund_total = $result['SUM'];
        }

        $amount_received = floatval($payment_total - $refund_total);
        $sub_total = $sale_total + $vat_total + $service_charge_total;
        $folio_diff = floatval($amount_received - $sub_total);

        $totals = array(
            'SALE_TOTAL' => number_format($sale_total, 2),
            'PAYMENT_TOTAL' => number_format($amount_received, 2),
            'FOLIO_DIFF' => number_format($folio_diff, 2),
            'VAT' => number_format($vat_total, 2),
            'SERVICE_CHARGE' => number_format($service_charge_total, 2),
            'SUB_TOTAL' => number_format($sub_total, 2)
        );

        // $amount_received = floatval($payment_total - $refund_total);
        // $folio_diff = floatval($amount_received - $sale_total);

        // $totals = array(
        //     'SALE_TOTAL' => number_format($sale_total, 2),
        //     'PAYMENT_TOTAL' => number_format($amount_received, 2),
        //     'FOLIO_DIFF' => number_format($folio_diff, 2),
        //     'VAT' => number_format($vat_total, 2)
        // );
        $results['totals'] = $totals;

        return $results;
    }

    public function getLedger($type)
    {
        $room = $client_name = $arrival = $departure = $actual_arrival = $actual_departure = $nights = "";
        $ledgers = array();
        $acct_type = "GROUP";

        $this->db->select('*');
        $this->db->from('reservationitems');
        if ($type == "guest") {
            $acct_type = "ROOM";
            $this->db->join('roomitems', 'reservationitems.room_number=roomitems.ID');
        }
        $this->db->join('reservationpriceitems', 'reservationitems.reservation_id=reservationpriceitems.reservation_id');
        $this->db->where('reservationitems.account_type', $acct_type);
        $this->db->where('reservationitems.status', 'ledger');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach ($results as $row) :
                $reservation_id = $row['reservation_id'];
                if ($type == "guest") {
                    $room = $row['title'];
                }

                $client_name = $row['client_name'];
                $arrival = $row['arrival'];
                $departure = $row['departure'];
                $actual_arrival = $row['actual_arrival'];
                $actual_departure = $row['actual_departure'];
                $nights = $row['nights'];
                $folio_room = $row['folio_room'];

                //get balances of bills

                $total_sale_bill1 = $total_sale_bill2 = $total_sale_bill3 = $total_sale_bill4 = $total_sale_inv = 0;
                $total_payment_bill1 = $total_payment_bill2 = $total_payment_bill3 = $total_payment_bill4 = $total_payment_inv = 0;
                $total_refund_bill1 = $total_refund_bill2 = $total_refund_bill3 = $total_refund_bill4 = $total_refund_inv = 0;

                $q_sale = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN credit
                    END)AS BILL1,SUM(CASE WHEN sub_folio='BILL2' THEN credit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN credit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN credit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN credit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
                    . "AND (action='sale' AND status<>'closed' AND description<>'CASH REFUND')";

                $query_sale_bills = $this->db->query($q_sale);
                if ($query_sale_bills->num_rows() > 0) {
                    $result = $query_sale_bills->row_array();
                    $total_sale_bill1 = $result['BILL1'];
                    $total_sale_bill2 = $result['BILL2'];
                    $total_sale_bill3 = $result['BILL3'];
                    $total_sale_bill4 = $result['BILL4'];
                    $total_sale_inv = $result['INV'];
                }

                $q_payment = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN debit END)AS BILL1,
                    SUM(CASE WHEN sub_folio='BILL2' THEN debit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN debit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN debit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN debit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
                    . "AND action='payment' AND status<>'closed'";

                $query_payment_bills = $this->db->query($q_payment);
                if ($query_payment_bills->num_rows() > 0) {
                    $result = $query_payment_bills->row_array();
                    $total_payment_bill1 = $result['BILL1'];
                    $total_payment_bill2 = $result['BILL2'];
                    $total_payment_bill3 = $result['BILL3'];
                    $total_payment_bill4 = $result['BILL4'];
                    $total_payment_inv = $result['INV'];
                }

                $q_refund = "SELECT SUM(CASE WHEN sub_folio='BILL1' THEN credit END)AS BILL1,
                    SUM(CASE WHEN sub_folio='BILL2' THEN credit END)AS BILL2,
                    SUM(CASE WHEN sub_folio='BILL3' THEN credit END)AS BILL3,
                    SUM(CASE WHEN sub_folio='BILL4' THEN credit END)AS BILL4,
                    SUM(CASE WHEN sub_folio='INV' THEN credit END)AS INV
                    FROM reservationfolioitems WHERE reservation_id='$reservation_id' "
                    . "AND action='payment' AND status<>'closed' AND description = 'CASH REFUND'";

                $query_refund_bills = $this->db->query($q_refund);
                if ($query_refund_bills->num_rows() > 0) {
                    $result = $query_refund_bills->row_array();
                    $total_refund_bill1 = $result['BILL1'];
                    $total_refund_bill2 = $result['BILL2'];
                    $total_refund_bill3 = $result['BILL3'];
                    $total_refund_bill4 = $result['BILL4'];
                    $total_refund_inv = $result['INV'];
                }

                /* make deductions */
                $bill1_diff = $total_sale_bill1 - ($total_payment_bill1 - $total_refund_bill1);
                $bill2_diff = $total_sale_bill2 - ($total_payment_bill2 - $total_refund_bill2);
                $bill3_diff = $total_sale_bill3 - ($total_payment_bill3 - $total_refund_bill3);
                $bill4_diff = $total_sale_bill4 - ($total_payment_bill4 - $total_refund_bill4);
                $inv_diff = $total_sale_inv - ($total_payment_inv - $total_refund_inv);

                $ledger = array(
                    'BILL1' => $bill1_diff,
                    'BILL2' => $bill2_diff,
                    'BILL3' => $bill3_diff,
                    'BILL4' => $bill4_diff,
                    'INV' => $inv_diff,
                    'client_name' => $client_name,
                    'room' => $room,
                    'arrival' => $arrival,
                    'departure' => $departure,
                    'actual_arrival' => $actual_arrival,
                    'actual_departure' => $actual_departure,
                    'reservation_id' => $reservation_id,
                    'nights' => $nights,
                    'folio_room' => $folio_room
                );
                $ledgers[] = $ledger;
            endforeach;
        }
        return $ledgers;
    }

    /* check if a valid reservation exists for the room selected
         * i.e client is staying 
         */
    public function confirmMoveFolioRoom($room_id)
    {

        $res['response'] = "error";
        $res['message'] = "Reservation not found";

        $q = "SELECT reservation_id from reservationitems "
            . "where status ='staying' and room_number=("
            . "select ID from roomitems where status in ('3','4')"
            . "and ID='$room_id') order by ID desc LIMIT 1";
        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $res['response'] = "success";
            $res['reservation'] = $result['reservation_id'];
            $res['message'] = "Reservation found";
        }
        return json_encode($res);
    }

    public function moveFolios($receiver_resv, $folio_IDs, $folio_type, $reason)
    {
        /*
         * select * rows where ID in array
         * foreach of the rows get the resv then update links & resv
         */
        $res['response'] = "error";
        $res['message'] = "Move failed";
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        //confirm receiver reservation exists
        $receiver_resvation_id = $this->security->xss_clean($receiver_resv);
        $this->db->select('ID');
        $this->db->where('reservation_id', $receiver_resvation_id);
        $this->db->where('status', 'staying');
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() <= 0) {
            $res['message'] = "Receiver is not a staying guest";
            return json_encode($res);
        }

        $this->db->select('*');
        $this->db->where_in('ID', $folio_IDs);
        $query = $this->db->get('reservationfolioitems');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach ($results as $row) :
                $donor_resv = $row['reservation_id']; //donating reservation_id
                $donor_ID = $row['ID']; //donating id
                //update folios
                $reason_cleaned = $this->security->xss_clean($reason);
                $data = array(
                    'links' => $donor_resv,
                    'reservation_id' => $receiver_resvation_id,
                    'date_modified' => $curr_date,
                    'signature_modified' => $this->session->us_signature,
                    'sub_folio' => $folio_type,
                    'reason' => $reason_cleaned
                );
                $this->db->where('ID', $donor_ID);
                $this->db->update('reservationfolioitems', $data);
            endforeach;

            $res['response'] = "success";
            $res['message'] = "Move Successful";
        }
        return json_encode($res);
    }

    /*
         * select * rows where ID in array
         * foreach of the rows get the links then update resvs & empty links
         */
    public function returnFolios($folio_IDs, $return_reason)
    {

        $res['response'] = "error";
        $res['message'] = "return failed";
        $curr_date = date('Y-m-d', strtotime($this->getAppInfo())) . " " . date('H:i:s');

        $this->db->select('*');
        $this->db->where_in('ID', $folio_IDs);
        $query = $this->db->get('reservationfolioitems');

        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            foreach ($results as $row) :
                $reservation_id = $row['links']; //returning reservation_id
                $return_ID = $row['ID']; //donating id
                $links = "";

                //update folios if link is not empty
                if (!empty($reservation_id)) {
                    $return_reason_cleaned = $this->security->xss_clean($return_reason);
                    $data = array(
                        'reservation_id' => $reservation_id,
                        'links' => $links,
                        'date_modified' => $curr_date,
                        'signature_modified' => $this->session->us_signature,
                        'reason' => $return_reason_cleaned
                    );
                    $this->db->where('ID', $return_ID);
                    $this->db->update('reservationfolioitems', $data);
                }
            endforeach;

            $res['response'] = "success";
            $res['message'] = "Return Successful";
        }
        return $res;
    }

    public function updateOverdueDepartures($resv_IDs)
    {
        /*
         * select * rows where resvID in array
         * foreach of the rows set the departure to app_day & update nights
         */
        $res['response'] = "error";
        $res['message'] = "overdue update failed";
        $app_day = date('Y-m-d', strtotime($this->getAppInfo()));

        $this->db->select('*');
        $this->db->where_in('reservation_id', $resv_IDs);
        $query = $this->db->get('reservationitems');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();

            foreach ($results as $row) :
                $reservation_id = $row['reservation_id']; //reservation id
                //calc nights spent
                $date1 = date_create(date('Y-m-d', strtotime($row['actual_arrival'])));
                $date2 = date_create($app_day);
                $diff = date_diff($date1, $date2);
                $nights = $diff->format("%R%a");
                //update departure,nights
                $data = array(
                    'departure' => $app_day,
                    'nights' => $nights
                );
                $this->db->where('reservation_id', $reservation_id);
                $this->db->update('reservationitems', $data);



            endforeach;

            $res['response'] = "success";
            $res['message'] = "Update Overdue Successful";
        }
        return json_encode($res);
    }

    /**
     * fetch relevant folio entries
     * return response
     */
    public function exemptClientFromVatCharges($reservation_id, $reason)
    {

        $res['response'] = "error";
        $res['message'] = "Failed: VAT not exempted for reservation " . $reservation_id;

        //update reservation prices for this reservation
        $this->db->set('is_vat_exempted', 1);
        $this->db->where('reservation_id', $reservation_id);
        $this->db->update('reservationpriceitems');

        //get elligible records
        $query_folio = "SELECT ID,vat,vatpercent,description,reservation_id,price,credit from reservationfolioitems where reservation_id=" . $reservation_id;

        $query =  $this->db->query($query_folio);
        if ($query->num_rows() > 0) {
            $results = $query->result_array();

            foreach ($results as $result) :
                $this->removeVatCharges($result, $reason);
            endforeach;

            $res['response'] = "success";
            $res['message'] = "Successful, vat has been exempted from reservation " . $reservation_id;
        }

        return $res;
    }

    /**
     * update the folio entry with zero vat values,
     * log this action
     */

    private function removeVatCharges($selectedRow, $reason)
    {

        $reservation_id = $selectedRow['reservation_id'];
        $oldVat = $selectedRow['vat'];
        $oldVatPercent = $selectedRow['vatpercent'];
        $folio_ID = $selectedRow['ID'];
        $description = $selectedRow['description'];
        //uncomment this to remove service charge
        // $price = $selectedRow['price'];
        // $credit = $selectedRow['credit'];
        // $service_charge_account_number=0;

        //set vat to zero for this reservation
        $this->db->set('vat', 0);
        $this->db->set('vatpercent', 0);
        $this->db->where('ID', $folio_ID);
        $this->db->update('reservationfolioitems');

        //uncomment this to remove service charge
        // $this->db->select('*');
        // $this->db->where('title', 'SC');
        // $query = $this->db->get('account_saleitems');

        // if ($query->num_rows() >= 0) {
        //     $row = $query->row_array();

        //     $service_charge_account_number = $row["ID"];
        // }

        // $this->db->set('price', 0);
        // $this->db->set('credit', 0);
        // $this->db->where('ID', $folio_ID);
        // $this->db->where('account_number', $service_charge_account_number);
        // $this->db->update('reservationfolioitems');

        //log this action
        $description = "Folio Entry with id: ".$folio_ID." for " . $description . " from reservation: " . $reservation_id . " with vat rate " . $oldVatPercent . "% and vat value of " . $oldVat;
        //uncomment this to remove service charge
        // $description.=" and price: ".$price.", credit: ".$credit;
        $description .= " was VAT EXEMPTED by " . $this->session->us_signature;
        $log_id = $this->createLog("FOLIO", "vat exemption", $description, $oldVat, 0, $reason);
    }

    public function serviceCharge($reservation_id, $reason = "")
    {

        $res['response'] = "error";
        $res['message'] = "service charge failed";

        $this->db->select('last_rooms_charge');
        $query = $this->db->get('maintenance');

        $service_charge_ratio = 0;
        $service_charge_account_number = 0;
        $folio_credit_total = 0;
        $service_charge_amount = 0;
        $description = $now = "";
        $existing_ID = 0;
        $folio_room = $is_vat_exempted = "";

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $last_rooms_charge = date("Y-m-d", strtotime($result['last_rooms_charge']));
            $now = $last_rooms_charge . " " . date('H:i:s');

            //get value of service charge from acct_sales table
            $this->db->select('*');
            $this->db->where('title', 'SC');
            $query = $this->db->get('account_saleitems');

            if ($query->num_rows() >= 0) {
                $row = $query->row_array();

                $service_charge_ratio = floatval($row["default_price"]) / 100;
                $service_charge_account_number = $row["ID"];
                $description = $row["description"];
            }

            //find existing service charge
            $this->db->select('ID');
            $this->db->where('reservation_id', $reservation_id);
            $this->db->where('account_number', $service_charge_account_number);
            $query = $this->db->get('reservationfolioitems');

            if ($query->num_rows() >= 0) {
                $row = $query->row_array();

                $existing_ID = $row["ID"];
            }

            //select sum of all sales that r not service charges where reserv_id is $reservation_id
            $q_totals = "SELECT SUM(credit) as folio_credit_sum"
                . " from reservationfolioitems as fo "
                . " where reservation_id = '$reservation_id' "
                . " and action='sale' AND account_number <> '$service_charge_account_number'";


            $query = $this->db->query($q_totals);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $folio_credit_total = $row["folio_credit_sum"];
                $service_charge_amount = floatval($folio_credit_total * $service_charge_ratio);
            }

            $q_charge = "SELECT folio_room,is_vat_exempted "
                . "from reservationpriceitems "
                . "where reservation_id='$reservation_id' ";

            $query = $this->db->query($q_charge);
            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $folio_room = $row["folio_room"];
                $is_vat_exempted = $row["is_vat_exempted"];
            }

            //uncomment this to apply vat exempted
            // if ($is_vat_exempted == 0) {

                //create array of values including acct_number & others to make a service charge entry in the folio

                $data = array(
                    'reservation_id' => $reservation_id,
                    'description' => $description,
                    'terminal' => "001",
                    'credit' => $service_charge_amount,
                    'price' => $service_charge_amount,
                    'qty' => 1,
                    'action' => 'sale',
                    'sub_folio' => $folio_room,
                    'account_number' => $service_charge_account_number,
                    'plu_group' => 1,
                    'plu' => 1,
                    'charge' => 'SC',
                    'pak' => '',
                    'reason' => $reason,
                    'signature_created' => $this->session->us_signature,
                    'date_created' => $now
                );

                //if ID is not null perform update else insert
                if ($existing_ID > 0) {
                    $this->db->where('ID', $existing_ID);
                    $this->db->update('reservationfolioitems', $data);
                } else {
                    $this->db->insert('reservationfolioitems', $data);
                    $insert_id = $this->db->insert_id();
                }

                //return response
                $res['response'] = "success";
                $res['message'] = "Service Charge Successful";
            // }
        }

        return json_encode($res);
    }

    /* confrim valid charge date
         * select price,room_type,resv etc for this reservation
         * insert into folio,update last_room_charge for this resv
         * update room to 'occupied dirty'
         */
    public function manualRoomCharge($resv_id, $reason)
    {

        $res['response'] = "error";
        $res['message'] = "room charge failed";
        //confrim valid charge date
        $this->db->select('last_rooms_charge,last_close_account');
        $query = $this->db->get('maintenance');

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $last_rooms_charge = date("Y-m-d", strtotime($result['last_rooms_charge']));
            $lastcloseday = date("Y-m-d", strtotime($result['last_close_account']));
            $presentday = date("Y-m-d", strtotime('now'));

            if (($last_rooms_charge <= $presentday) && ($last_rooms_charge <= $lastcloseday)) {
                $day_type = date("D", strtotime($lastcloseday));
                $target_day = "";
                $no_deductions = "";
                if ($day_type === "Fri" || $day_type === "Sat" || $day_type === "Sun") {
                    $target_day = "rp.weekend";
                    $no_deductions = "rp.weekend_no_deductions";
                } else {
                    $target_day = "rp.weekday";
                    $no_deductions = "rp.weekday_no_deductions";
                }
                $q_charge = "SELECT ri.reservation_id,$target_day as price, $no_deductions as no_deductions,ro.description,rp.folio_room,rp.comp_nights,rp.comp_visits,rp.comp_nights_charged,rp.discount_ratio, "
                    . "rp.is_vat_exempted,ri.room_number,acct_sale.ID as acct_number,acct_sale.vattype,acct_sale.vatpercent from reservationitems as ri "
                    . "left join reservationpriceitems as rp on (ri.reservation_id=rp.reservation_id)"
                    . "left join roomitems as ro on (ri.room_number=ro.ID) "
                    . "left join roomtypeitems as rt on (ro.roomtype=rt.ID) "
                    . "left join account_saleitems as acct_sale on(rt.title=acct_sale.title)"
                    . "where ri.status='staying' and ri.reservation_id='$resv_id' "
                    . "AND ri.last_room_charge < '$last_rooms_charge' AND ri.account_type='ROOM'";

                $query = $this->db->query($q_charge);
                if ($query->num_rows() > 0) {
                    $result = $query->row_array();

                    $pak = "";
                    $now = $last_rooms_charge . " " . date('H:i:s');
                    $this->roomCharges($result, $pak, $reason, $now);

                    $res['response'] = "success";
                    $res['message'] = "Manual Room Charge Successful";
                }
            }
        }
        return json_encode($res);
    }



    private function roomCharges($result, $pak, $reason, $now)
    {

        $terminal = "001";
        $pak = $pak;
        $charge = "ROOM";
        $qty = $plu_group = $plu = 1;
        $vat = 0;
        $discount = 0;
        $uncharged_complementary_nights_exist = false;
        $room_charge_price = 0;
        $curr_resv = $result['reservation_id'];
        $room_number = $result['room_number'];
        $comp_nights = $result['comp_nights'];
        $comp_visits = $result['comp_visits'];
        $comp_nights_charged = $result['comp_nights_charged'];
        $description = $result['description'];
        $is_vat_exempted = $result['is_vat_exempted'];

        //VAT
        $vattype = $result['vattype'];
        $vatpercent = $result['vatpercent'];

        //DISCOUNT
        $discount_ratio = $result['discount_ratio'];
        $discount_no_deductions = $result['no_deductions'];

        //chk for complementary nights
        if ($comp_visits == "yes" && ($comp_nights != $comp_nights_charged)) {
            $uncharged_complementary_nights_exist = true;
            $description += " [COMPLEMENTARY]";
        } else {
            $room_charge_price = $result['price'];

            //chk if exempted from vat
            if ($is_vat_exempted == 0) {

                //chk for exclusive vat
                if ($vattype == "excl" && ($vatpercent > 0)) {
                    $vat = floatval($room_charge_price) * floatval($vatpercent / 100);
                }
            } else {
                $vatpercent = 0;
            }


            //calc discounts
            if ($discount_ratio > 0) {
                $discount = floatval($discount_ratio) * floatval($discount_no_deductions);
            }
        }

        $data = array(
            'reservation_id' => $curr_resv,
            'description' => $description,
            'terminal' => $terminal,
            'credit' => $room_charge_price,
            'price' => $room_charge_price,
            'qty' => $qty,
            'action' => 'sale',
            'sub_folio' => $result['folio_room'],
            'account_number' => $result['acct_number'],
            'plu_group' => $plu_group,
            'plu' => $plu,
            'charge' => $charge,
            'pak' => $pak,
            'reason' => $reason,
            'signature_created' => $this->session->us_signature,
            'date_created' => $now,
            'vat' => $vat,
            'vatpercent' => $vatpercent,
            'discount_unit_charged' => $discount
        );
        $this->db->insert('reservationfolioitems', $data);
        $insert_id = $this->db->insert_id();

        if ($uncharged_complementary_nights_exist) {
            //update room_charge for this reservation
            $this->db->set('comp_nights_charged', $comp_nights_charged + 1);
            $this->db->where('reservation_id', $curr_resv);
            $this->db->update('reservationpriceitems');
        }

        //update room_charge for this reservation
        $this->db->set('last_room_charge', $now);
        $this->db->where('reservation_id', $curr_resv);
        $this->db->update('reservationitems');

        //update room status
        $this->db->set('status', 4);
        $this->db->where('ID', $room_number);
        $this->db->update('roomitems');
    }

    /* confrim valid charge date
         * get the day of the week so as to determine price of room
         * select price,room_type,resv etc for each reservation
         * insert into folio,update last_room_charge for each resv
         * update rooms to 'occupied dirty'
         */
    public function autoRoomCharge()
    {
        $res['response'] = "error";
        $res['message'] = "Failed: No Rooms Charged";
        //confrim valid charge date
        $this->db->select('last_rooms_charge,last_close_account');
        $query = $this->db->get('maintenance');
        if ($query->num_rows() > 0) {

            $result = $query->row_array();
            $last_rooms_charge = date("Y-m-d", strtotime($result['last_rooms_charge']));
            $lastcloseday = date("Y-m-d", strtotime($result['last_close_account']));
            $presentday = date("Y-m-d", strtotime('now'));
            $today = date('Y-m-d', strtotime("+1 day", strtotime($last_rooms_charge)));

            if (($last_rooms_charge <= $presentday) && ($last_rooms_charge <= $lastcloseday)) {
                $day_type = date("D", strtotime($lastcloseday));
                $target_day = "";
                $no_deductions = "";

                if ($day_type === "Fri" || $day_type === "Sat" || $day_type === "Sun") {
                    $target_day = "rp.weekend";
                    $no_deductions = "rp.weekend_no_deductions";
                } else {
                    $target_day = "rp.weekday";
                    $no_deductions = "rp.weekday_no_deductions";
                }
                $q_charge = "SELECT ri.reservation_id,$target_day as price,$no_deductions as no_deductions,ro.description,rp.folio_room,rp.comp_nights,rp.comp_visits,rp.comp_nights_charged,rp.discount_ratio, "
                    . "rp.is_vat_exempted,ri.room_number,acct_sale.ID as acct_number,acct_sale.vattype,acct_sale.vatpercent from reservationitems as ri "
                    . "left join reservationpriceitems as rp on (ri.reservation_id=rp.reservation_id)"
                    . "left join roomitems as ro on (ri.room_number=ro.ID) "
                    . "left join roomtypeitems as rt on (ro.roomtype=rt.ID) "
                    . "left join account_saleitems as acct_sale on(rt.title=acct_sale.title)"
                    . "where ri.status='staying' and ri.actual_arrival < '$today' AND rp.charge_from_date < '$today' "
                    . "AND ri.last_room_charge < '$last_rooms_charge' AND ri.account_type='ROOM'";

                //    echo $q_charge;exit;

                $query = $this->db->query($q_charge);
                if ($query->num_rows() > 0) {
                    $results = $query->result_array();

                    $charge_count = 0;
                    $pak = "A:";
                    $reason = "";
                    $time = date("H:i:s");
                    $now = $last_rooms_charge . " " . $time;

                    foreach ($results as $result) :
                        $this->roomCharges($result, $pak, $reason, $now);
                        $charge_count++;
                    endforeach;

                    //update maintenance
                    $this->db->set('charged_rooms_count', $charge_count);
                    $this->db->update('maintenance');

                    $res['response'] = "success";
                    $res['message'] = "Successful, " . $charge_count . " guest(s) room charged";
                }
            }
        }
        return $res;
    }


    /* get last_close_account,today & day_of_charge,
         * chk if any rooms have not been charged:yes(return)
         * if last_close_account < today get reservations to be closed
         * get the next close_account day & update these reservations
         * update maintenance set last_close_account & last_room_charge
         * chk for overdue-departures
         */
    public function closeAccount()
    {

        $res['response'] = "error";
        $res['message'] = "Account Closing Process Failed";
        $res['overdue_departures'] = "NO";

        //get last_close_account,today & day_of_charge
        $this->db->select('last_rooms_charge,last_close_account');
        $query = $this->db->get('maintenance');

        if ($query->num_rows() > 0) {

            $result = $query->row_array();
            $last_rooms_charge = date("Y-m-d", strtotime($result['last_rooms_charge']));
            $lastcloseday = date("Y-m-d", strtotime($result['last_close_account']));
            $today = date("Y-m-d", strtotime('now'));
            $thedayofcharge = date('Y-m-d', strtotime("+1 day", strtotime($last_rooms_charge)));
            $nextcloseday = date('Y-m-d', strtotime("+1 day", strtotime($lastcloseday))) . " " . date('H:i:s');

            /* chk if any elligible rooms have not been charged:yes(return) */
            $q_room_charge_chk = "SELECT ri.reservation_id FROM reservationitems as ri "
                . "LEFT JOIN reservationpriceitems as rp on (ri.reservation_id=rp.reservation_id) "
                . " WHERE ri.status ='staying' AND ri.actual_arrival < '$thedayofcharge' "
                . " AND rp.charge_from_date < '$thedayofcharge' AND ri.last_room_charge < '$last_rooms_charge' "
                . "AND ri.account_type='ROOM'";
            $query = $this->db->query($q_room_charge_chk);
            if ($query->num_rows() > 0) {
                //uncharged elligible rooms exist
                $res['response'] = "error";
                $res['message'] = "Closing Failed...Try charging rooms first";
                return $res;
            }

            if ($lastcloseday < $today) { //select accts to be closed

                $q_select_close = "SELECT reservation_id FROM reservationitems 
                WHERE status ='staying'	AND DATE(actual_arrival) <= '$lastcloseday' "
                    . "OR (status ='departed' AND DATE(actual_departure) = '$lastcloseday')";

                $query = $this->db->query($q_select_close);
                if ($query->num_rows() > 0) {

                    $results = $query->result_array();
                    foreach ($results as $result) :
                        $reservation_id = $result['reservation_id'];
                        $this->db->set('last_account_close', $nextcloseday);
                        $this->db->where('reservation_id', $reservation_id);
                        $this->db->update('reservationitems');


                    endforeach;

                    $res['response'] = "success";
                    $res['message'] = "Account Closing Successful";
                } else {
                    //no_reservations_found
                    $res['response'] = "error";
                    $res['message'] = "No Rooms To Close, Closing Account";
                }

                $data = array(
                    'last_close_account' => $nextcloseday,
                    'last_rooms_charge' => $nextcloseday
                );
                $this->db->update('maintenance', $data);
                //perform backup
                $backup_res = $this->backup();
                //chk for overdue-departures
                $q_overdue = "SELECT reservation_id FROM reservationitems WHERE status='staying' "
                    . "AND departure < '$lastcloseday' AND account_type='ROOM'";
                $query = $this->db->query($q_overdue);
                if ($query->num_rows() > 0) {
                    $res['overdue_departures'] = "YES";
                }
            }
        }
        return $res;
    }

    public function getOverdueDepartures($offset = 0, $limit_val = FALSE)
    {
        $limit = "";
        $sort = "order by ri.ID";
        $results['data'] = array();
        $results['count'] = 0;

        if ($limit_val) {
            $limit = "LIMIT $offset,$limit_val";
        }
        $app_day = date("Y-m-d", strtotime($this->getAppInfo()));
        $q_overdue = "SELECT ri.reservation_id,ro.title as room_number,ro.description as room_desc,ri.actual_arrival,ri.client_name,ri.departure "
            . "FROM reservationitems as ri LEFT JOIN roomitems as ro "
            . "on (ri.room_number = ro.ID) WHERE ri.status='staying' AND ri.departure < '$app_day' "
            . "AND ri.account_type='ROOM' $sort $limit";

        $q_total = "SELECT ri.reservation_id,ro.title as room_number,ro.description as room_desc,ri.actual_arrival,ri.client_name,ri.departure "
            . "FROM reservationitems as ri LEFT JOIN roomitems as ro "
            . "on (ri.room_number = ro.ID) WHERE ri.status='staying' AND ri.departure < '$app_day' "
            . "AND ri.account_type='ROOM' $sort";

        $query = $this->db->query($q_overdue);
        if ($query->num_rows() > 0)
            $results['data'] = $query->result_array();

        $query = $this->db->query($q_total);
        if ($query->num_rows() > 0)
            $results['count'] = $query->num_rows();

        return $results;
    }

    public function backup()
    {

        $res['response'] = "error";
        $message = "Backups Failed/Incomplete ";

        $app_day = date("Y-m-d", strtotime($this->getAppInfo()));
        $dbname = $this->config->item('database');

        $file_name = str_replace("-", "_", $app_day);
        $local_backup_dir = 'backups/';

        $tables = array();
        $q_show = "SHOW TABLES";
        $num_fields = 0;
        $return = "";
        $query = $this->db->query($q_show);

        if ($query->num_rows() > 0) {
            $results = $query->result_array();

            foreach ($results as $result) {
                $identifier = "Tables_in_" . $dbname;
                $tables[] = $result[$identifier];
            }

            //cycle through
            foreach ($tables as $table) {

                $q_select = "SELECT * FROM " . $table;
                $query_select = $this->db->query($q_select);
                $num_fields = $query_select->num_fields();

                $return .= 'DROP TABLE IF EXISTS ' . $table . ';';

                $q_create = "SHOW CREATE TABLE " . $table;
                $query = $this->db->query($q_create);
                $row2 = $query->row_array();

                $values_query =  $this->db->query($q_select);
                $table_rows = $values_query->result_array();
                $num_rows = $values_query->num_rows();

                $return .= "\n\n" . $row2['Create Table'] . ";\n\n";
                echo $return;
                exit;

                foreach ($table_rows as $row) :
                    $return .= 'INSERT INTO ' . $table . ' VALUES(';
                    $field_count = 0;

                    foreach ($row as $key => $value) {

                        $value = addslashes($row[$key]);
                        $row[$key] = preg_replace("/\n/", "/\\n/", $value);
                        if (isset($row[$key])) {
                            $return .= '"' . $row[$key] . '"';
                        } else {
                            $return .= '""';
                        }
                        if ($field_count < ($num_fields - 1)) {
                            $return .= ',';
                        }
                        $field_count++;
                    }
                    $return .= ");\n";
                endforeach;

                $return .= "\n\n\n";
            }

            //save file
            $handle = fopen($local_backup_dir . 'db-backup-' . $file_name . '-' . (md5(implode(',', $tables))) . '.sql', 'w+');
            fwrite($handle, $return);
            fclose($handle);

            if (!empty($return)) {
                $res['response'] = "success";
                $message = "Backup Successful";
            }
        }

        $res['message'] = $message;
        return $res;
    }



    /* get last_acct_close,actual_departure
         * chk if actual_departue > last_acct_close
         * yes(update),no(do nothing)
         * log this action
         */
    public function reactivateAccount($resv_id, $reason)
    {

        $res['response'] = "error";
        $res['message'] = "Invalid Reactivation Attempt";

        $this->db->select('*');
        $this->db->where('reservation_id', $resv_id);
        $query = $this->db->get('reservationitems');

        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $last_account_close = strtotime($row['last_account_close']);
            $actual_departure = strtotime($row['actual_departure']);
            $status = $row['status'];
            //chk if actual_departue > last_acct_close && status is departed
            if (($status == "departed") && ($actual_departure > $last_account_close)) {
                //yes(update),no(do nothing)
                //calc nights spent
                $arrival = date("Y-m-d", strtotime($row['actual_arrival']));
                $date1 = date_create($arrival);
                $date2 = date_create($row['departure']);
                $diff = date_diff($date1, $date2);
                $nights = $diff->format("%R%a");
                $arrival = date("Y-m-d", strtotime($row['actual_arrival'])) . " " . date("H:i:s");

                $data = array(
                    'status' => 'confirmed',
                    'nights' => $nights,
                    'actual_arrival' => $arrival
                );
                $this->db->where('reservation_id', $resv_id);
                $this->db->update('reservationitems', $data);

                //update folio as well
                $this->db->set('status', 'active');
                $this->db->where('reservation_id', $resv_id);
                $this->db->update('reservationfolioitems');
                //update response
                $res['response'] = "success";
                $res['message'] = "Account Reactivation Successful";
                //log this action
                $description = "Guest " . $resv_id . " was reactivated by " . $this->session->us_signature;
                $log_id = $this->createLog("reservation", "reactivate", $description, $status, 'staying', $reason);
            }
        }
        return $res;
    }

    /* get master_id for this resv
         * update all folios for this resv to the master_id         
         */
    public function masterFolios($resv_id, $master_id, $reason)
    {

        $res['response'] = "error";
        $res['message'] = "Invalid Master Action";

        $this->db->select('*');
        $this->db->where('reservation_id', $resv_id);
        $query = $this->db->get('reservationfolioitems');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            foreach ($result as $row) :
                $folio_ID = $row['ID'];
                //update folio
                $this->db->set('reservation_id', $master_id);
                $this->db->set('links', $resv_id);
                $this->db->where('ID', $folio_ID);
                $this->db->update('reservationfolioitems');
            endforeach;
            //update response
            $res['response'] = "success";
            $res['message'] = "Master Folio Movement Successful";
        }
        return $res;
    }

    public function checkin($r_ID, $room_id, $comp_nights)
    {
        if ($this->isRoomVacant($room_id)) {
            //get current time
            $charge_day = $app_day = date("Y-m-d", strtotime($this->getAppInfo()));

            /** modifying this process - rather than skip the complementary day, we will charge that day with zero amount
             * this is done in the room charge method
             */
            // if($comp_nights > 0){
            //     $date=date_create($charge_day);
            //     date_add($date,date_interval_create_from_date_string($comp_nights." days"));
            //     $charge_day=date_format($date,"Y-m-d");
            // }
            $now = $app_day . " " . date('H:i:s');
            $zeros = "0000-00-00 00:00:00";

            $data = array(
                'status' => "staying",
                'actual_arrival' => $now,
                'actual_departure' => $zeros,
                'room_number' => $room_id
            );
            $this->db->where('reservation_id', $r_ID);
            $this->db->update('reservationitems', $data);

            //update reports
            $section = "reservation_item";
            $action = "update_report";
            $data_for_update = $data;
            $endpoint_type = 'reservationitems';
            $this->getIDAndUpdateReports($section, $action, $data_for_update, 'reservationitems', 'reservation_id', $r_ID, $endpoint_type);



            //update folio status just in case
            $this->db->set('status', 'active');
            $this->db->where('reservation_id', $r_ID);
            $this->db->update('reservationfolioitems');

            $data2 = array(
                'charge_from_date' => $charge_day
            );
            $this->db->where('reservation_id', $r_ID);
            $this->db->update('reservationpriceitems', $data2);
            $this->updateItems("room", $room_id, "status", 3);
            return TRUE;
        }
        return FALSE;
    }

    public function groupCheckin($r_ID)
    {
        //get current time
        $app_day = date("Y-m-d", strtotime($this->getAppInfo()));
        $now = $app_day . " " . date('H:i:s');
        $zeros = "0000-00-00 00:00:00";

        $data = array(
            'status' => "staying",
            'actual_arrival' => $now,
            'actual_departure' => $zeros
        );
        $this->db->where('reservation_id', $r_ID);
        $this->db->update('reservationitems', $data);

        //update reports
        $section = "reservation_item";
        $action = "update_report";
        $data_for_update = $data;
        $endpoint_type = 'reservationitems';
        $this->getIDAndUpdateReports($section, $action, $data_for_update, 'reservationitems', 'reservation_id', $r_ID, $endpoint_type);


        return TRUE;
    }

    /* check if a room is vacant or vacant_dirty */
    private function isRoomVacant($room_id)
    {

        $test = FALSE;
        $q = "SELECT status from roomitems where ID='$room_id'";


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

    public function getFieldValue($type, $id, $field)
    {
        $table = $type . "items";
        $field_val = "";

        $q = "SELECT $field from $table where ID='$id' Limit 1";
        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $field_val = $result[$field];
        }
        return $field_val;
    }

    /* get all users except admins */
    public function getUsers()
    {
        $q = "SELECT title,signature FROM useritems "
            . "WHERE role >='28'";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            return $query->result_array();
    }

    /* get info for reservation,prices, etc for a client */
    public function getClientResvInfo($resv_id, $account_type)
    {

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
            . "where ri.reservation_id='$resv_id' AND account_type='$account_type'";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            return $query->result_array();
    }


    /* get info for reservation,prices, etc for a client */
    public function getGroupResvInfo($resv_id)
    {

        $q = "SELECT ri.*,ri.roomtype as roomtype_id,"
            . "rt.title as roomtype,rp.*,rp.price_rate as price_rate_id,"
            . "pi.title as price_title from reservationitems as ri "
            . "left join reservationpriceitems as rp "
            . "on (ri.reservation_id = rp.reservation_id) "
            . "left join roomtypeitems as rt "
            . "on (ri.roomtype = rt.ID) "
            . "left join priceitems as pi "
            . "on (rp.price_rate = pi.ID)"
            . "where ri.reservation_id='$resv_id' AND account_type='GROUP'";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            return $query->result_array();
    }

    /* get info for house account etc for a client */
    public function getHouseResvInfo($resv_id)
    {
        $q = "SELECT * from reservationitems where reservation_id='$resv_id' AND account_type='HOUSE'";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0)
            return $query->result_array();
    }

    /*gets reports for api*/
    // public function getReportsApi($type,$report_from,$report_to, $resv_id=NULL){

    //     $app_date = date('Y-m-d', strtotime($this->getAppInfo()));
    //     $report_user="all";
    //     $and_user="";
    //     $fo_and_user="";

    //     //convert report_from
    //     $temp_date = str_replace('/', '-', $report_from);
    //     $from_date=new DateTime($temp_date);
    //     $from_date->setTime(0,0,0);
    //     $from= $from_date->format('Y-m-d H:i:s');

    //     //convert report_to
    //     $temp_date = str_replace('/', '-', $report_to);
    //     $to_date=new DateTime($temp_date);
    //     $to_date->setTime(23,59,59);
    //     $to= $to_date->format('Y-m-d H:i:s');

    //     $results['data'] = array();
    //     $results['count'] = 0;
    //     $results['totals'] = [];


    //     switch ($type) {
    //         /*get only guests arriving in this duration:confirmed*/
    //         case "arrivals":
    //             $where = "and ri.arrival between '$from' AND '$to' $and_user "
    //                     . "and ri.status='confirmed' ORDER BY ri.arrival ASC";
    //             break;
    //         case "departures":
    //             $where = "and ri.departure between '$from' AND '$to' $and_user "
    //                     . " ORDER BY ri.departure ASC";
    //             break;
    //         case "staying guests":
    //             $where = " and ri.account_type ='ROOM' and DATE(ri.actual_arrival) <= '$from' "
    //                     . "AND (DATE(ri.actual_departure) >='$to' or ri.actual_departure='0000-00-00 00:00:00') "
    //                     . "$and_user ORDER BY ri.actual_arrival ASC";
    //             break;
    //         case "reservation":
    //         case "resev_payments":
    //             if($resv_id){
    //                $where = " and ri.reservation_id ='$resv_id'  "; 
    //             }                
    //             break;
    //         default:
    //             break;
    //     }

    //     if ($type == "sales summary") {
    //         $q = "SELECT fo.*,ro.title as room_title,ri.client_name from "
    //                 . "reservationfolioitems as fo left join "
    //                 . "reservationitems as ri on(fo.reservation_id =ri.reservation_id) "
    //                 . "left join roomitems as ro on(ri.room_number=ro.ID)"
    //                 . "where fo.date_created between '$from' and '$to' "
    //                 . "and fo.action='sale' $fo_and_user order by fo.date_created,fo.signature_created";

    //         $q_totals = "SELECT *,SUM(credit) as folio_credit,sum(debit) as folio_debit,"
    //                 . "count(description) as transactions from reservationfolioitems as fo "
    //                 . "where date_created between '$from' and '$to' "
    //                 . "and action='sale' $fo_and_user group by account_number";

    //     }else if ($type == "sales_fnb_summary") {
    //         $q = "SELECT fo.*,ro.title as room_title,ri.client_name from "
    //                 . "reservationfolioitems as fo left join "
    //                 . "reservationitems as ri on(fo.reservation_id =ri.reservation_id) "
    //                 . "left join roomitems as ro on(ri.room_number=ro.ID)"
    //                 . "where fo.date_created between '$from' and '$to' "
    //                 . "and fo.source_app = 'fnb'"
    //                 . "and fo.action='sale' $fo_and_user order by fo.date_created,fo.signature_created";

    //         $q_totals = "SELECT *,SUM(credit) as folio_credit,sum(debit) as folio_debit,"
    //                 . "count(description) as transactions from reservationfolioitems as fo "
    //                 . "where date_created between '$from' and '$to' "
    //                 . "and fo.source_app = 'fnb'"
    //                 . "and action='sale' $fo_and_user group by account_number";

    //     } else if ($type == "cashier summary") {
    //         $q = "SELECT fo.*,ro.title as room_title,ri.client_name from "
    //                 . "reservationfolioitems as fo left join "
    //                 . "reservationitems as ri on(fo.reservation_id =ri.reservation_id) "
    //                 . "left join roomitems as ro on(ri.room_number=ro.ID) "
    //                 . "where fo.date_created between '$from' and '$to' "
    //                 . "and fo.action='payment' $fo_and_user order by fo.date_created,fo.signature_created";

    //         $q_totals = "SELECT *,SUM(credit) as folio_credit,sum(debit) as folio_debit,"
    //                 . "count(description) as transactions from reservationfolioitems "
    //                 . "where date_created between '$from' and '$to' "
    //                 . "and action='payment' $fo_and_user group by account_number";					

    //     } else if ($type == "audit trail") {
    //         $q = "SELECT log.*, user.title as user_title from logitems as log "
    //                 . "left join useritems as user on(log.signature_created=user.signature) "
    //                 . "where log.date_created between '$from' and '$to' order by log.date_created";
    //     } else if ($type == "police") {
    //         $q = "SELECT distinct ri.*,ro.title as room_title,(CASE WHEN p.sex='m' THEN 'Male' WHEN p.sex='f' THEN 'Female' ELSE '' END) as gender,"
    //                 . "co.title as nationality,p.occupation,p.street,p.passport_no from reservationitems as ri "
    //                 . "left join personitems as p on (ri.client_name = p.title) "
    //                 . "left join ref_countryitems as co on(p.country = co.ID) "
    //                 . "left join roomitems as ro on(ri.room_number=ro.ID) "
    //                 . "where ri.account_type ='ROOM' AND DATE(ri.actual_arrival) >= '$from' "
    //                 . "AND '$to' >= DATE(ri.actual_arrival) $and_user  ORDER BY ri.reservation_id";
    //     } else if ($type == "client history") {
    //         $q = "SELECT distinct p.*,(CASE WHEN p.sex='m' THEN 'Male' WHEN p.sex='f' THEN 'Female' ELSE '' END) as gender,"
    //                 . "co.title as nationality,p.occupation,p.street,p.passport_no from reservationitems as ri "
    //                 . "left join personitems as p on (ri.client_name = p.title) "
    //                 . "left join ref_countryitems as co on(p.country = co.ID) "
    //                 . "where p.title <>'' AND DATE(ri.actual_arrival) >= '$from' AND '$to' >= DATE(ri.actual_arrival) ORDER BY p.title ";
    //     }else if ($type == "reservation") {
    //         $q = "SELECT DISTINCT ri.ID,ri.arrival,ri.nights,ri.departure,ri.client_name,ri.remarks,ri.adults,"
    //                 . "ri.signature_created,ri.signature_modified,ri.status,ri.actual_arrival,ri.actual_departure,"
    //                 . "rp.price_room,rp.price_total,p.description as price_r,rp.comp_nights,rp.block_pos,ro.title as room_title,"
    //                 . "rt.title as roomtype, rp.weekday,rp.weekend"
    //                 . " from reservationitems as "
    //                 . "ri left join reservationpriceitems as rp on (ri.reservation_id=rp.reservation_id)"
    //                 . " left join priceitems as p on (rp.price_rate = p.ID) "
    //                 . "left join reservationfolioitems as rf on (ri.reservation_id=rf.reservation_id)"
    //                 . "left join roomitems as ro on(ri.room_number=ro.ID)"
    //                 . "left join roomtypeitems as rt on(ri.roomtype =rt.ID)"
    //                 . " where 1=1 $where";
    //     } else if ($type =="resev_payments"){
    //         $q="SELECT rf.description,rf.debit,rf.credit,rf.date_created FROM reservationfolioitems as rf "
    //                 . "left join reservationitems as ri on(rf.reservation_id=ri.reservation_id) where 1=1 "
    //                 . "and rf.action='payment' $where ";
    //     }else {
    //         $q = "SELECT ri.*,ro.title as room_title,rt.title as roomtype FROM "
    //                 . "reservationitems as ri left join roomitems as ro "
    //                 . "on(ri.room_number=ro.ID) left join roomtypeitems as rt "
    //                 . "on(ri.roomtype =rt.ID) where 1=1 $where";
    //     }

    //     $query = $this->db->query($q);
    //     if ($query->num_rows() > 0) {
    //         $results['count'] = $query->num_rows();
    //         $results['data'] = $query->result_array();
    //     }
    //     if ($type == "sales summary" || $type == "cashier summary" || $type == "sales_fnb_summary") {
    //         $query = $this->db->query($q_totals);
    //         if ($query->num_rows() > 0) {
    //             $results['totals'] = $query->result_array();
    //         }
    //     }

    //     return $results;
    // }

    /* gets all fields for a reservation
         * ::used for reports etc */
    public function getReports($type, $resv_id = NULL)
    {

        $app_date = date('Y-m-d', strtotime($this->getAppInfo()));
        $where = "";

        $report_user = $this->input->post('report_user');
        if ($report_user == "all") {
            $and_user = "";
            $fo_and_user = "";
        } else {
            $and_user = "and ri.signature_created='$report_user'";
            $fo_and_user = "and fo.signature_created='$report_user'";
        }
        $report_from = $this->input->post('report_from');
        $temp_date = str_replace('/', '-', $report_from);
        $from_date = new DateTime($temp_date);
        $from_date->setTime(0, 0, 0);
        $from = $from_date->format('Y-m-d H:i:s');
        $from_date_only = $from_date->format('Y-m-d');

        $report_to = $this->input->post('report_to');
        $temp_date = str_replace('/', '-', $report_to);
        $to_date = new DateTime($temp_date);
        $to_date->setTime(23, 59, 59);
        $to = $to_date->format('Y-m-d H:i:s');
        $to_date_only = $to_date->format('Y-m-d');

        // echo 'to '.$to.' from '.$from;exit;

        $results['data'] = array();
        $results['count'] = 0;
        $results['totals'] = [];

        switch ($type) {
                /*get only guests arriving in this duration:confirmed*/
            case "arrivals":
                $where = "and cast(ri.arrival as date) between '$from' AND '$to' $and_user "
                    . "and ri.status='confirmed' ORDER BY ri.arrival ASC";
                break;
            case "departures":
                $where = "and ri.departure between '$from' AND '$to' $and_user "
                    . " ORDER BY ri.departure ASC";
                break;
            case "staying guests":
                // $where = " and ri.account_type ='ROOM' and DATE(ri.actual_arrival) <= '$from' "
                //         . "AND (DATE(ri.actual_departure) >='$to' or ri.actual_departure='0000-00-00 00:00:00') "
                //         . "$and_user ORDER BY ri.actual_arrival ASC";
                //modified this on 08/11/19

                // $where = " and ri.account_type ='ROOM' and ri.status='staying' and DATE(ri.actual_arrival) <= '$from' "
                //         . "$and_user ORDER BY ri.actual_arrival ASC";
                //modified this on 30/11/19

                //acct type is for guests,status is not cancelled, confirmed and is not null
                //arrival date is <= from date and is valid date
                //guest has not departed or departed before or on to_date 

                // $where = " and ri.account_type ='ROOM' and ri.status not in ('cancelled','confirmed','') and ri.status is not null "
                // . "and DATE(ri.actual_arrival) <='$from_date_only' "
                // ."and DATE(ri.actual_arrival) <>'0000-00-00' "
                // ."and (DATE(ri.actual_departure)='0000-00-00' or DATE(ri.actual_departure)>='$to_date_only') "
                // . "$and_user ORDER BY ri.actual_arrival ASC";
                //arrival date is <= from_date and to_date_only is >= last_room_charge..04/12/19
                $where = " and ri.account_type ='ROOM' and ri.status not in ('cancelled','confirmed','') and ri.status is not null "
                    . "and DATE(ri.actual_arrival) <='$from_date_only' "
                    . "and DATE(ri.actual_arrival) <>'0000-00-00' "
                    . "and (DATE(ri.last_room_charge)>='$to_date_only') "
                    . "$and_user ORDER BY ri.actual_arrival ASC";
                break;

            case "reservation":
            case "resev_payments":
                if ($resv_id) {
                    $where = " and ri.reservation_id ='$resv_id'  ";
                }
                break;
            default:
                break;
        }

        if ($type == "sales summary") {
            $q = "SELECT fo.*,ro.title as room_title,ri.client_name from "
                . "reservationfolioitems as fo left join "
                . "reservationitems as ri on(fo.reservation_id =ri.reservation_id) "
                . "left join roomitems as ro on(ri.room_number=ro.ID)"
                . "where fo.date_created between '$from' and '$to' "
                . "and fo.action='sale' $fo_and_user order by fo.date_created,fo.signature_created";

            $q_totals = "SELECT *,SUM(credit) as folio_credit,sum(debit) as folio_debit,"
                . "count(description) as transactions from reservationfolioitems as fo "
                . "where date_created between '$from' and '$to' "
                . "and action='sale' $fo_and_user group by account_number";
        } else if ($type == "sales_fnb_summary") {
            $q = "SELECT fo.*,ro.title as room_title,ri.client_name from "
                . "reservationfolioitems as fo left join "
                . "reservationitems as ri on(fo.reservation_id =ri.reservation_id) "
                . "left join roomitems as ro on(ri.room_number=ro.ID)"
                . "where fo.date_created between '$from' and '$to' "
                . "and fo.source_app = 'fnb'"
                . "and fo.action='sale' $fo_and_user order by fo.date_created,fo.signature_created";

            $q_totals = "SELECT *,SUM(credit) as folio_credit,sum(debit) as folio_debit,"
                . "count(description) as transactions from reservationfolioitems as fo "
                . "where date_created between '$from' and '$to' "
                . "and fo.source_app = 'fnb'"
                . "and action='sale' $fo_and_user group by account_number";
        } else if ($type == "cashier summary") {
            $q = "SELECT fo.*,ro.title as room_title,ri.client_name from "
                . "reservationfolioitems as fo left join "
                . "reservationitems as ri on(fo.reservation_id =ri.reservation_id) "
                . "left join roomitems as ro on(ri.room_number=ro.ID) "
                . "where fo.date_created between '$from' and '$to' "
                . "and fo.action='payment' $fo_and_user order by fo.date_created,fo.signature_created";

            $q_totals = "SELECT *,SUM(credit) as folio_credit,sum(debit) as folio_debit,"
                . "count(description) as transactions from reservationfolioitems "
                . "where date_created between '$from' and '$to' "
                . "and action='payment' $fo_and_user group by account_number";
        } else if ($type == "audit trail") {
            $q = "SELECT log.*, user.title as user_title from logitems as log "
                . "left join useritems as user on(log.signature_created=user.signature) "
                . "where log.date_created between '$from' and '$to' order by log.date_created";
        } else if ($type == "police") {
            $q = "SELECT distinct ri.*,ro.title as room_title,(CASE WHEN p.sex='m' THEN 'Male' WHEN p.sex='f' THEN 'Female' ELSE '' END) as gender,"
                . "co.title as nationality,p.occupation,p.street,p.passport_no from reservationitems as ri "
                . "left join personitems as p on (ri.client_name = p.title) "
                . "left join ref_countryitems as co on(p.country = co.ID) "
                . "left join roomitems as ro on(ri.room_number=ro.ID) "
                . "where ri.account_type ='ROOM' AND DATE(ri.actual_arrival) >= '$from' "
                . "AND '$to' >= DATE(ri.actual_arrival) $and_user  ORDER BY ri.reservation_id";
        } else if ($type == "client history") {
            $q = "SELECT distinct p.*,(CASE WHEN p.sex='m' THEN 'Male' WHEN p.sex='f' THEN 'Female' ELSE '' END) as gender,"
                . "co.title as nationality,p.occupation,p.street,p.passport_no from reservationitems as ri "
                . "left join personitems as p on (ri.client_name = p.title) "
                . "left join ref_countryitems as co on(p.country = co.ID) "
                . "where p.title <>'' AND DATE(ri.actual_arrival) >= '$from' AND '$to' >= DATE(ri.actual_arrival) ORDER BY p.title ";
        } else if ($type == "reservation") {
            $q = "SELECT DISTINCT ri.ID,ri.arrival,ri.nights,ri.departure,ri.client_name,ri.remarks,ri.adults,"
                . "ri.signature_created,ri.signature_modified,ri.status,ri.actual_arrival,ri.actual_departure,"
                . "rp.price_room,rp.price_total,rp.discount,p.description as price_r,rp.comp_nights,rp.block_pos,ro.title as room_title,"
                . "rt.title as roomtype, rp.weekday,rp.weekend,rf.vat"
                . " from reservationitems as "
                . "ri left join reservationpriceitems as rp on (ri.reservation_id=rp.reservation_id)"
                . " left join priceitems as p on (rp.price_rate = p.ID) "
                . "left join reservationfolioitems as rf on (ri.reservation_id=rf.reservation_id)"
                . "left join roomitems as ro on(ri.room_number=ro.ID)"
                . "left join roomtypeitems as rt on(ri.roomtype =rt.ID)"
                . " where 1=1 $where";
        } else if ($type == "resev_payments") {
            $q = "SELECT rf.description,rf.debit,rf.credit,rf.date_created FROM reservationfolioitems as rf "
                . "left join reservationitems as ri on(rf.reservation_id=ri.reservation_id) where 1=1 "
                . "and rf.action='payment' $where ";
        } else {
            $q = "SELECT ri.*,ro.title as room_title,rt.title as roomtype FROM "
                . "reservationitems as ri left join roomitems as ro "
                . "on(ri.room_number=ro.ID) left join roomtypeitems as rt "
                . "on(ri.roomtype =rt.ID) where 1=1 $where";
        }

        //  echo $q;exit;

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $results['count'] = $query->num_rows();
            $results['data'] = $query->result_array();
        }
        if ($type == "sales summary" || $type == "cashier summary" || $type == "sales_fnb_summary") {
            $query = $this->db->query($q_totals);
            if ($query->num_rows() > 0) {
                $results['totals'] = $query->result_array();
            }
        }

        return $results;
    }

    public function verifyRoom($type, $val)
    {
        $res['response'] = "error";
        $res['message'] = "Invalid Verification Request";

        $where = "";
        switch ($type) {
            case 'room':
                $where = " where ro.title='$val'";
                break;
            case 'reservation':
                $where = " where ri.reservation_id='$val'";
                break;
            default:
                break;
        }
        $q = "SELECT ri.reservation_id,ri.client_name,rp.block_pos,ro.title as room_number "
            . "from reservationitems as ri left join reservationpriceitems as rp "
            . "on (ri.reservation_id = rp.reservation_id) left join roomitems as ro "
            . "on (ri.room_number = ro.ID) $where and ri.status='staying' "
            . "and ri.account_type='ROOM' ORDER BY ri.ID desc limit 1";

        $query = $this->db->query($q);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();

            if ($result['block_pos'] === "no") {
                $res['response'] = "success";
                $res['message'] = "POS is allowed on this account";

                $res['reservation_id'] = $result['reservation_id'];
                $res['client_name'] = $result['client_name'];
                $res['room_number'] = $result['room_number'];
            } else {
                $res['message'] = "POS is blocked on this account";
            }
        }
        return $res;
    }

    //send an update to the report api
    private function getIDAndUpdateReports($section, $action, $data_for_update, $table, $where_field, $update_id, $endpoint_type)
    {

        $this->db->select('ID');
        $this->db->where($where_field, $update_id);
        $query = $this->db->get($table);

        $selected_id = 0;
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $selected_id = $row['ID'];
        }

        $action_type = "PUT";
        $this->sendToReports($action_type, $section, $action, $endpoint_type, $data_for_update, $selected_id);
    }


    /*send items to report db*/
    public function sendToReports($action_type, $section, $action, $endpoint_type, $data = null, $id_for_update = null)
    {

        $report_base_url = $this->config->item("reports_base_url"); //if this is not empty report configuration has been set

        //get the endpoint for this request
        $selected_endpoint_type = "";

        switch ($endpoint_type) {
            case 'reservationitems':
                $selected_endpoint_type = $this->config->item('reservationitems_endpoint');
                break;

            case 'reservationfolioitems':
                $selected_endpoint_type = $this->config->item('reservationfolioitems_endpoint');
                break;
        }

        if (!empty($data) && !empty($report_base_url) && !empty($selected_endpoint_type)) {

            $payload = json_encode($data);

            if ($action_type == "PUT") {
                $selected_endpoint_type .= "/" . $id_for_update;
            }

            $endpoint = $report_base_url . $selected_endpoint_type;

            // Prepare new cURL resource
            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);

            if ($action_type == "POST") {
                curl_setopt($ch, CURLOPT_POST, true);
            } elseif ($action_type == "DELETE") {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            } elseif ($action_type == "PUT") {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            // Set HTTP Header for POST request 
            curl_setopt(
                $ch,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($payload)
                    // 'Authorization: '.$api_token
                )
            );

            // Submit the POST request
            $result = curl_exec($ch);
            if (!$result) {
                //log this error
                $description = "Failed to update report app";
                $reason = "unknown";

                //log this action
                $log_id = $this->createLog($section, $action, $description, "", "", $reason);
            }

            // Close cURL session handle
            curl_close($ch);
        }
    }
}
