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
                    LEDGER 
                    [<?php echo count($collection);?>]
                    <?php if (count($collection) > 0) { ?>
                                <?php
                                $content = "";
                                foreach ($collection as $row):
                                    $reservation_id = $row["reservation_id"];
                                    $nights = $row["nights"];
                                    $departure = date('d/m/Y', strtotime($row["actual_departure"]));
                                    $arrival = date('d/m/Y', strtotime($row["actual_arrival"]));
                                    if (empty($row["actual_arrival"])) {
                                                $arrival = date('d/m/Y', strtotime($row["arrival"]));
                                            }
                                             if (empty($row["actual_departure"])) {
                                                $departure = date('d/m/Y', strtotime($row["departure"]));
                                            }

                                    $client_name = $row["client_name"];
                                    $room = $row["room"];
                                    $folio_room = $row["folio_room"];
                                    $BILL1 = $row["BILL1"];
                                    $BILL2 = $row["BILL2"];
                                    $BILL3 = $row["BILL3"];
                                    $BILL4 = $row["BILL4"];
                                    $INV = $row["INV"];
                                    

                                    if ($count == 1) {
                                        $active = "active";
                                        $checked = "checked";
                                    } else {
                                        $active = "";
                                        $checked = "";
                                    }

                                    $content.="<tr class=\"booking_radio $active\">"
                                            . "<input class=\"booking_hidden_id\" type=\"hidden\" value=\"$reservation_id\">"
                                            . "<input class=\"folio_hidden_folio_room\" type=\"hidden\" value=\"$folio_room\">";
                                    $content.="<td class=\"booking_hidden_client\">$client_name</td>";
                                    $content.="<td>$arrival</td>";
                                    $content.="<td>$nights</td>";
                                    $content.="<td>$departure</td>";
                                    $content.="<td>$room</td>";
                                    $content.="<td>$reservation_id</td>";
                                    $content.="<td>$BILL1</td>";
                                    $content.="<td>$BILL2</td>";
                                    $content.="<td>$BILL3</td>";
                                    $content.="<td>$BILL4</td>";
                                    $content.="<td>$INV</td>";
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
                                        $buttons.="<a onclick=\"getFolio('0','all','ALL','$room','$departure');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-folder-open-o\"></i>&nbsp;View</a>&nbsp;";
                                        $buttons.="<a onclick=\"ledgerCheckin();\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-long-arrow-right\"></i>&nbsp;Check In</a>&nbsp;";
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
                                <th>Client Name</th>
                                <th>Arrival</th>
                                <th>Night</th>
                                <th>Departure</th>
                                <th>Room</th>
                                <th>Resv.#</th>
                                <th>BILL1</th>
                                <th>BILL2</th>
                                <th>BILL3</th>
                                <th>BILL4</th>
                                <th>INV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($collection) > 0) { ?>
                                <?php echo $content; ?>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>

        </div>
        </section>
    </div>
</div>
<!--body wrapper end-->



