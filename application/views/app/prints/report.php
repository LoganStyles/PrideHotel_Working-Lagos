<?php ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="pull-right">
                        <?php if (count($collection) > 0) { ?>
                            <?php
                            $content = "";
                            $count = 1;
                            foreach ($collection as $row):
                                $userid = $row["ID"];
                                $reservation_id = $row["reservation_id"];
                                $actual_arrival = date('d/m/Y', strtotime($row["actual_arrival"]));
                                $departure = (strtotime($row["actual_departure"]) > strtotime($row["departure"])) ? (date('d/m/Y', strtotime($row["actual_departure"]))) : (date('d/m/Y', strtotime($row["departure"])));
                                $duration = $actual_arrival . " - " . $departure;
                                $client_name = $row["client_name"];
                                $status = $row["status"];
                                $room_title = $row["room_title"];
                                $roomtype = $row["roomtype"];
                                $adults = $row["adults"];
                                $checkin = date("H:i:s", strtotime($row["actual_arrival"]));

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$userid\">"
                                        . "$client_name</td>";
                                $content.="<td>$room_title</td>";
                                $content.="<td>$roomtype</td>";
                                $content.="<td>$reservation_id</td>";
                                $content.="<td>$adults</td>";
                                $content.="<td>$status</td>";
                                $content.="<td>$duration</td>";
                                $content.="<td>$checkin</td>";
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
                            <th>Client Name</th>
                            <th>Room</th>
                            <th>Room Type</th>
                            <th>Resv#</th>
                            <th>Adults</th>
                            <th>Status</th>
                            <th>Duration</th>
                            <th>Checkin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($collection) > 0) { ?>
                            <?php echo $content; ?>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </section>
    </div>

</div>

<div class="row">
    <div class="pull-right" id="print_box">
        <div class="col-sm-12">
            <?php
            $buttons = "<a onclick=\"printAction('print','" . base_url() . "resv/reports');\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
            $buttons.="<a href=\"" . base_url() . "resv/reports\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";

            echo $buttons;
            ?>
        </div>
    </div>
</div>
</div>

<!--body wrapper end-->


