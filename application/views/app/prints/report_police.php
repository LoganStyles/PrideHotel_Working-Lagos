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
                                $occupation = $row["occupation"];
                                $street = $row["street"];
                                $passport_no = $row["passport_no"];
								$actual_arrival = date('d/m/Y',strtotime($row["actual_arrival"]));
                                if(!empty($row["actual_departure"]) && ($row["actual_departure"])!=="0000-00-00 00:00:00"){
									$departure_day = date('d/m/Y',strtotime($row["actual_departure"]));
                                    $checktime = date('H:i:s', strtotime($row["actual_departure"]));
									$departure=$departure_day." ".$checktime;
                                }else{$departure="";}
                                
                                $client_name = $row["client_name"];
                                $gender = $row["gender"];
                                $room_title = $row["room_title"];
                                $roomtype = $row["roomtype"];
                                $nationality = $row["nationality"];
								$status = $row["status"];
                                $checkin = date("H:i:s", strtotime($row["actual_arrival"]));
								$arrival=$actual_arrival." ".$checkin;

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$userid\">"
                                        . "$client_name</td>";
                                $content.="<td>$gender</td>";
                                $content.="<td>$nationality</td>";
                                $content.="<td>$occupation</td>";
                                $content.="<td>$street</td>";
                                $content.="<td>$passport_no</td>";
                                $content.="<td>$room_title</td>";
								$content.="<td>$arrival</td>";
                                $content.="<td>$departure</td>";
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
                            <th>Client Name</th>
                            <th>Gender</th>
                            <th>Nationality</th>
                            <th>Occupation</th>
                            <th>Street</th>
                            <th>Passport NO.</th>
                            <th>Room</th>
							<th>Arrival</th>
                            <th>Checkout</th>
                            <th>Status</th>
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


