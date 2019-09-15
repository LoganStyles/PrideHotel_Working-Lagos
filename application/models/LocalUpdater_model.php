<?php

/**
 * Description of LocalUpdater model
 *
 * @author EMMANUEL OKPUKPAN
 */

class LocalUpdater_model extends App_model {

    public function __construct() {
        $this->load->database();
    }

    /*insert new items from local db*/
    public function insert($table,$unique_table_key,$post_data){

        $affected_rows=[];
        $response_data=array(
            "status"=>false,
            "message"=>"",
            "affected_rows"=>$affected_rows,
            "affected_rows_count"=>0
        );
        $affected_rows_count=0;

        foreach($post_data as $row):
            //lets confirm that row does not exist
            $current_reservation_id=$row[$unique_table_key];

            $this->db->select('ID');
            $this->db->where($unique_table_key,$current_reservation_id);
            $query = $this->db->get($table);

            if ($query->num_rows() > 0) {
                //already exists
                continue;
            } else {
                $this->db->insert($table, $row);

                if($this->db->affected_rows() >0){
                    $affected_rows_count++;
                    array_push($affected_rows,$row);
                }
            }
        endforeach;

        //update response obj
        if($affected_rows_count > 0){
            $response_data["status"]=true;
            $response_data["message"]="Success";
            $response_data["affected_rows_count"]=$affected_rows_count;
            $response_data["affected_rows"]=$affected_rows;
        }

        return $response_data ;
        // return json_encode($response_data) ;

    }

    /*insert new items from local db*/
    public function update($table,$unique_table_key,$post_data){

        $affected_rows=[];
        $response_data=array(
            "status"=>false,
            "message"=>"",
            "affected_rows"=>$affected_rows,
            "affected_rows_count"=>0
        );
        $affected_rows_count=0;

        foreach($post_data as $row):
            $current_reservation_id=$row[$unique_table_key];

            $this->db->where($unique_table_key, $current_reservation_id);
            $this->db->update($table, $row);

            if($this->db->affected_rows() >0){
                $affected_rows_count++;
                array_push($affected_rows,$row);
            }
        endforeach;

        //update response obj
        if($affected_rows_count > 0){
            $response_data["status"]=true;
            $response_data["message"]="Success";
            $response_data["affected_rows_count"]=$affected_rows_count;
            $response_data["affected_rows"]=$affected_rows;
        }

        return $response_data ;
    }
}