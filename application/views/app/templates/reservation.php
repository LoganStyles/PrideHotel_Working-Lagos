<?php
$delete = (isset($this->session->delete_group) ? ($this->session->delete_group) : (0));
$form_error = (isset($this->session->delete_error) ? ($this->session->delete_error) : (""));

$current = $received[0];
extract($current);

$count = 1;

if ($form_error) {
    $danger_style = "alert alert-danger error";
    $display_modal = "block";
    $modal_mode = "in";
} else {
    $danger_style = $display_modal = $modal_mode = "";
}
?>

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    RESERVATIONS/FOLIO &nbsp;&nbsp;[Guest Rooms: <?php echo $header_title; ?>]&nbsp;&nbsp;
                    [<?php echo $total;?>&nbsp;Guests]
                    <div>
                        <div class="pull-right">
                            <?php if (count($collection) > 0) { ?>
                                <?php
                                $content = $status_span = $active_span = "";
                                foreach ($collection as $row):
                                    $userid = $row["ID"];
                                    $reservation_id = $row["reservation_id"];
                                    $nights = $row["nights"];
                                    $departure = date('d/m/Y', strtotime($row["departure"]));

                                    switch ($type) {
                                        case "confirmed":
                                        case "arriving":
                                        case "provisional":
                                            $arrival = date('d/m/Y', strtotime($row["arrival"]));
                                            break;
                                        case "staying":
                                        case "departing":
                                            $arrival = date('d/m/Y', strtotime($row["actual_arrival"]));
                                        case "all":
                                        case "cancelled":
                                            if (empty($row["actual_arrival"])) {
                                                $arrival = date('d/m/Y', strtotime($row["arrival"]));
                                            }
                                            if (empty($row["actual_departure"])) {
                                                $departure = date('d/m/Y', strtotime($row["departure"]));
                                            }
                                        default:
                                            break;
                                    }

                                    $client_name = $row["client_name"];
                                    $status = $row["status"];
                                    $remarks = $row["remarks"];
                                    $signature_created = $row["signature_created"];
                                    $room_number = getTitle($rooms, $row["room_number"]);
                                    $roomtype = getTitle($roomtypes, $row["roomtype"]);

                                    if ($count == 1) {
                                        $active = "active";
                                        $checked = "checked";
                                    } else {
                                        $active = "";
                                        $checked = "";
                                    }

                                    $content.="<tr class=\"booking_radio $active\">";
                                    $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$reservation_id\">"
                                            . "$arrival</td>"; //   
//                                    $content.="<td></td>";
                                    $content.="<td>$nights</td>";
                                    $content.="<td>$departure</td>";
                                    $content.="<td>$room_number</td>";
                                    $content.="<td>$roomtype</td>";
                                    $content.="<td>$reservation_id</td>";
                                    $content.="<td>$client_name</td>";
                                    $content.="<td class=\"booking_hidden_status\">$status</td>";
                                    $content.="<td>$remarks</td>";
                                    $content.="<td>$signature_created</td>";
                                    $content.="</tr>";

                                    $count++;
                                endforeach;
                                ?>
                            <?php } ?>
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = ""; //                    
                                    if ($count > 1) {
                                        $buttons.="<a onclick=\"processResv('view','$offset','$type');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-eye\"></i>&nbsp;View</a>&nbsp;";
                                        $buttons.="<a href=\" " . base_url() . 'resv/guest/new' . " \" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-plus-square\"></i>&nbsp;New</a>&nbsp;";
                                        if($type !=="cancelled"){
                                           $buttons.="<a onclick=\"processResv('edit','$offset','$type');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;"; 
                                        }
                                        
                                        if ($delete == "1") {
                                            $buttons.="<a onclick=\"deleteReservation();\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
                                        }

                                        $buttons.="<a onclick=\"deleteModal('collection');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-trash-o\"></i>&nbsp;Folio</a>&nbsp;";
                                        $buttons.="<a onclick=\"deleteModal('collection');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-trash-o\"></i>&nbsp;Print</a>&nbsp;";
                                    }
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>


                        </div>
                        <div class="clearfix"></div>

                    </div>
                </header>


                <div class="panel-body">
                    <table class="table  table-hover general-table table-bordered table-condensed">
                        <thead>
                            <tr>                                
                                <!--<th>S/N</th>-->
                                <th>Arrival</th>
                                <th>Nights</th>
                                <th>Departure</th>
                                <th>Room No.</th>
                                <th>Room Type</th>
                                <th>Resv.#</th>
                                <th>Guest Name</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($collection) > 0) { ?>
                                <?php echo $content; ?>
                            <?php } ?>
                        </tbody>
                    </table>

                    <?php
                    if (strlen($pagination)) {
                        echo $pagination;
                    }
                    ?>

                </div>

        </div>
        </section>
    </div>
</div>
<!--body wrapper end-->

<div role="dialog" id="delete_resv_modal" class="modal fade <?php echo $modal_mode; ?>" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Delete Dialog</h4>
            </div>
            <div class="modal-body">

                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'delete_resv_form');
                echo '<div class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('resv/processResvDelete', $attributes);
                ?>
                <div class="panel-body">
                    <div class="row">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <h4>Are You Sure You Want To Delete This Item? Provide a reason</h4>
                                    <input type="text" class="form-control" name="delete_resv_reason" id="delete_resv_reason">
                                    <input type="hidden" value="" name="delete_resv_id" id="delete_resv_id">
                                    <input type="hidden" value="" name="delete_resv_type" id="delete_resv_type">
                                    <input type="hidden" value="" name="delete_resv_oldvalue" id="delete_resv_oldvalue">
                                    <input type="hidden" value="" name="delete_resv_newvalue" id="delete_resv_newvalue">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="YES" />
                <button type="button" class="btn btn-default" onclick="closeResvModal('#delete_resv_modal');">NO</button>
                </form> 
            </div>
        </div>
    </div>
</div>



