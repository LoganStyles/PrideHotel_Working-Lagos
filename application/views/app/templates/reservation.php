<?php
$current = $received[0];
extract($current);

$count = 1;
?>

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    RESERVATIONS/FOLIO &nbsp;&nbsp;[Guest Rooms: <?php echo $header_title;?>]
                    <div>
                        <div class="pull-right">
                            <?php if (count($collection) > 0) { ?>
                                <?php
                                $content = $status_span = $active_span = "";
                                foreach ($collection as $row):
                                    $userid = $row["ID"];
                                    $reservation_id = $row["reservation_id"];
                                    $nights = $row["nights"];
                                    switch ($type) {
                                        case "confirmed":
                                        case "arriving":
                                            $arrival = date('d/m/Y', strtotime($row["arrival"]));
                                            $departure = date('d/m/Y', strtotime($row["departure"]));
                                            break;
                                        case "staying":
                                            $arrival = date('d/m/Y', strtotime($row["actual_arrival"]));
//                                            $departure = date('d/m/Y', strtotime($row["actual_departure"]));

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
                                            . "$count</td>"; //   
                                    $content.="<td>$arrival</td>";
                                    $content.="<td>$nights</td>";
                                    $content.="<td>$departure</td>";
                                    $content.="<td>$room_number</td>";
                                    $content.="<td>$roomtype</td>";
                                    $content.="<td>$reservation_id</td>";
                                    $content.="<td>$client_name</td>";
                                    $content.="<td>$status</td>";
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
                                        $buttons.="<a onclick=\"verify('user','1');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-check\"></i>&nbsp;Verify</a>&nbsp;";
                                        $buttons.="<a onclick=\"manager('user','active');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-unlock\"></i>&nbsp;Unblock</a>&nbsp;";
                                        $buttons.="<a onclick=\"manager('user','locked');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-lock\"></i>&nbsp;Block</a>&nbsp;";
                                        $buttons.="<a onclick=\"deleteModal('collection');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                                <th>S/N</th>
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



