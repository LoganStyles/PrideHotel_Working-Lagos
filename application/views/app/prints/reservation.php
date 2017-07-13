<?php ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="pull-right">
                        <?php if (count($collection) > 0) { ?>
                            <?php
                            $content = $status_span = $active_span = "";
                            $count = 1;
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
                                        $arrival = (strtotime($row["actual_arrival"]) > strtotime($row["arrival"])) ? (date('d/m/Y', strtotime($row["actual_arrival"]))) : (date('d/m/Y', strtotime($row["arrival"])));
//                                        
                                        $departure = (strtotime($row["actual_departure"]) > strtotime($row["departure"])) ? (date('d/m/Y', strtotime($row["actual_departure"]))) : (date('d/m/Y', strtotime($row["departure"])));
                                    default:
                                        break;
                                }

                                $client_name = $row["client_name"];
                                $status = $row["status"];
                                $remarks = $row["remarks"];
                                $signature_created = $row["signature_created"];
                                $room_number = getTitle($rooms_r, $row["room_number"]);
                                $roomtype = getTitle($roomtypes, $row["roomtype"]);

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$userid\">"
                                        . "$arrival</td>";
                                $content.="<td>$nights</td>";
                                $content.="<td>$departure</td>";
                                $content.="<td>$room_number</td>";
                                $content.="<td>$roomtype</td>";
                                $content.="<td>$reservation_id</td>";
                                $content.="<td>$client_name</td>";
                                $content.="<td>$status</td>";
                                $content.="</tr>";

                                $count++;
                            endforeach;
                            ?>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>

                </div>
            </header>


            <div class="panel-body"><p style="font-weight: 700;color: #f00;"> </p>
                <table class="table  table-hover general-table table-bordered table-condensed">
                    <thead>
                        <tr>                   
                            <th>Arrival</th>
                            <th>Nights</th>
                            <th>Departure</th>
                            <th>Room Number</th>
                            <th>Room Type</th>
                            <th>Resv#</th>
                            <th>Guest Name</th>
                            <th>Status</th>
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
        </section>
    </div>

</div>
<?php
if (count($sum_data) > 0) {
    $resv_sum = $sum_data['sum_resv'];
    $sum_nights = $sum_data['sum_nights'];
    ?>
    <div class="row" >
        <div style="margin-left: 30px;color: #000;font-weight: 700">
            <div>RESERVATIONS: &nbsp;&nbsp;<?php echo $resv_sum; ?></div>
            <div>NIGHTS: &nbsp;&nbsp;<?php echo $sum_nights; ?></div>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="pull-right" id="print_box">
        <div class="col-sm-12">
            <?php
            $buttons = "<a onclick=\"printAction('print','".$this->session->resv_back_uri."');\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
            $buttons.="<a href=\"" . $this->session->resv_back_uri . "\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";

            echo $buttons;
            ?>
        </div>
    </div>
</div>
</div>

<!--body wrapper end-->


