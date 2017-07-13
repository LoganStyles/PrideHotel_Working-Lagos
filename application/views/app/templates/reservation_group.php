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
                    RESERVATIONS/FOLIO &nbsp;&nbsp;Groups&nbsp;
                    [<?php echo $total;?>&nbsp;]
                    <?php if (count($collection) > 0) { ?>
                                <?php
                                $content = $status_span = $active_span = "";
                                foreach ($collection as $row):
                                    $active = $checked ="";
                                    $userid = $row["ID"];
                                    $reservation_id = $row["reservation_id"];
                                    $nights = $row["nights"];
                                    $folio_room = $row["folio_room"];
                                    $departure = date('d/m/Y', strtotime($row["departure"]));
                                    $arrival = date('d/m/Y', strtotime($row["actual_arrival"]));

                                    switch ($type) {
                                        case "confirmed":
                                        case "arriving":
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
                                    $room_number_only = $row["room_number"];
                                    $roomtype = getTitle($roomtypes, $row["roomtype"]);
                                    
                                    //check for a row has been clicked before
                                    if (isset($_SESSION['group_resv_active_row'])) {
                                        if (($_SESSION['group_resv_active_row'] == $reservation_id)) {
                                            $active = "active";
                                            $checked = "checked";
                                        }
                                    } elseif ($count === 1) {
                                        $active = "active";
                                        $checked = "checked";
                                    }

                                    $content.="<tr class=\"booking_radio $active\">";
                                    $content.="<td class=\"booking_hidden_arrival\"><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$reservation_id\">"
                                            . "<input class=\"folio_hidden_folio_room\" type=\"hidden\" value=\"$folio_room\">"
                                            . "$arrival</td>";
                                    $content.="<td>$nights</td>";
                                    $content.="<td class=\"booking_hidden_departure\">$departure</td>";
                                    $content.="<td>$roomtype</td>";
                                    $content.="<td>$reservation_id</td>";
                                    $content.="<td class=\"booking_hidden_client\">$client_name</td>";
                                    $content.="<td class=\"booking_hidden_status\">$status</td>";
                                    $content.="<td>$remarks</td>";
                                    $content.="<td>$signature_created</td>";
                                    $content.="</tr>";
                                    $count++;
                                endforeach;
                                ?>
                            <?php } ?>
                    <div>
                        <div class="pull-right">
                            
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = ""; //                    
                                    if ($count > 1) {
                                        if($type =="staying"){
                                        $buttons.="<a onclick=\"newGroupResv('$offset','confirmed');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-plus-square\"></i>&nbsp;New Guest</a>&nbsp;";
                                        } 
                                        $buttons.="<a onclick=\"processGroupResv('view','$offset','$type');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-eye\"></i>&nbsp;View</a>&nbsp;";                                        
                                        if($type !=="cancelled"){
                                           $buttons.="<a onclick=\"processGroupResv('edit','$offset','$type');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;"; 
                                        }                                        
                                        if ($delete == "1") {
                                            $buttons.="<a onclick=\"deleteReservation();\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
                                        }                                   
                                        $buttons.="<a onclick=\"getFolio('$offset','$type','ALL','$room_number_only','$departure');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-folder-open-o\"></i>&nbsp;Folio</a>&nbsp;";
                                        $buttons.="<a onclick=\"printReservation('$type','group');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
                                                                               
                                        $buttons.="<a onclick=\"groupCheckInOut();\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-exchange\"></i>&nbsp;Check-In/Out</a>&nbsp;";
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
                                <th>Arrival</th>
                                <th>Nights</th>
                                <th>Departure</th>
                                <th>Room Type</th>
                                <th>Resv.#</th>
                                <th>Group Name</th>
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