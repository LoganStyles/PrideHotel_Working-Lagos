<?php $trans_count=$debit_count=$credit_count=0;?>

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
                                $folioid = $row["ID"];
                                $reservation_id = $row["reservation_id"];
                                $date = (strtotime($row["date_modified"]) > strtotime($row["date_created"])) ? (date('d/m/Y', strtotime($row["date_modified"]))) : (date('d/m/Y', strtotime($row["date_created"])));
                                $signature=(!empty($row['signature_modified']))?($row['signature_modified']):($row['signature_created']);
                                $description = $row['description'];
                                $client_name = $row["client_name"];
                                $room_title = $row["room_title"];
                                $debit = $row["debit"];
                                $credit = $row["credit"];

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$folioid\">"
                                        . "$date</td>";
                                $content.="<td>$signature</td>";
                                $content.="<td>$room_title</td>";
                                $content.="<td>$reservation_id</td>";
                                $content.="<td>$client_name</td>";
                                $content.="<td>$description</td>";
                                $content.="<td>$debit</td>";
                                $content.="<td>$credit</td>";
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
                            <th>Date</th>
                            <th>Signature</th>
                            <th>Room</th>
                            <th>Resv#</th>
                            <th>Client Name</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
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
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="pull-right">
                        <?php if (count($collection2) > 0) { ?>
                            <?php
                            $content = "";
                            $count = 1;
                            
                            foreach ($collection2 as $row):
                                $folioid = $row["ID"];
                                $description = $row['description'];
                                $transactions = $row["transactions"];  
                                $trans_count+=floatval($transactions);
                                $debit = $row["folio_debit"];
                                $debit_count+=floatval($debit);
                                $credit = $row["folio_credit"];
                                $credit_count+=floatval($credit);

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$folioid\">"
                                        . "$description</td>";
                                $content.="<td>$transactions</td>";
                                $content.="<td>$debit</td>";
                                $content.="<td>$credit</td>";
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
                            <th>Description</th>
                            <th>Transactions</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($collection2) > 0) { ?>
                            <?php echo $content; ?>
                        <?php } ?>
                        <tr class="booking_radio" style="font-weight: 700;">
                            <td>Totals</td>
                            <td><?php echo $trans_count;?></td>
                            <td><?php echo number_format($debit_count,2);?></td>
                            <td><?php echo number_format($credit_count,2);?></td>
                        </tr>
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


