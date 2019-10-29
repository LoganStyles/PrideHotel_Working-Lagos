<?php ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="" style="text-align: center;font-weight: 700;">
                        <?php if (count($collection) > 0) { ?>
                            <?php
                            $content = $reservation_id = "";
                            $count = 1;
                            foreach ($collection as $row):
                                $discount=(!empty($row["discount_unit_charged"])?($row["discount_unit_charged"]):0);
                                $vat=(!empty($row["vatpercent"])?($row["vatpercent"]):0);
                                $folio_id = $row["ID"];
                                $reservation_id = $row["reservation_id"];
                                $description = $row["description"];
                                $debit = number_format($row["debit"], 2);
                                $credit = number_format($row["credit"], 2);
                                $date = (strtotime($row["date_modified"]) > strtotime($row["date_created"])) ? (date('d/m/Y', strtotime($row["date_modified"]))) : (date('d/m/Y', strtotime($row["date_created"])));

                                $signature = $row["signature_created"];
                                if (!empty($row["signature_modified"])) {
                                    $signature = $row["signature_modified"];
                                }

                                $content.="<tr class=\"booking_radio\">";
                                $content.="<td><input class=\"booking_hidden_id\" type=\"hidden\" value=\"$folio_id\">"
                                        . "$date</td>";
                                $content.="<td>$description</td>";
                                $content.="<td>$debit</td>";
                                $content.="<td>$credit</td>";
                                $content.="<td>$discount</td>";
                                $content.="<td>$vat</td>";
                                $content.="</tr>";

                                $count++;
                            endforeach;
                             ?>
                        <?php } ?>
                        
                    </div>
                    <div class="clearfix"></div>

                </div>
                
            </header>
            
            <div class="row" >
    <div style="margin-left: 30px;color: #000;font-weight: 600">
        <div>GUEST: &nbsp;&nbsp;<?php echo ucwords($client_name); ?></div>
        <div>DURATION: &nbsp;&nbsp;<?php echo date('d/m/Y',strtotime($actual_arrival))." - ".date('d/m/Y',strtotime($actual_departure))."&nbsp;&nbsp;"; ?></div>
        <div>NIGHTS: &nbsp;&nbsp;<?php echo $nights; ?></div>
        <div>ROOM: &nbsp;&nbsp;<?php echo $room_number; ?></div>
    </div>
</div>

            <div class="panel-body"><p style="font-weight: 700;color: #f00;"> </p>
                <table class="table  table-hover general-table table-bordered table-condensed">
                    <thead>
                        <tr>                   
                            <th>Date</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Discount</th>
                            <th>VAT (%)</th>
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
<div class="row" >
    <div style="margin-left: 30px;color: #000;font-weight: 700">
    
        <div>TOTAL SALES: &nbsp;&nbsp;N<?php echo $sale_total; ?></div>
        <div>TOTAL VAT: &nbsp;&nbsp;N<?php echo $vat_total; ?></div>
        <div>SERVICE CHARGE: &nbsp;&nbsp;N<?php echo $service_charge; ?></div>
        <div>SUB TOTAL: &nbsp;&nbsp;N<?php echo $sub_total; ?></div>
        <div>AMOUNT RECEIVED: &nbsp;&nbsp;N<?php echo $payment_total; ?></div>
        <div>BALANCE DUE: &nbsp;&nbsp;N<?php echo $balance_left; ?></div>

    </div>
</div>

<div class="row" style="margin-top: 5%;">
    <div class="col-sm-6 col-lg-6">
        <p>Guest Signature: ________________________________</p>
    </div>
    <div class="col-sm-6 col-lg-6">
        <p>Receptionist Signature: ________________________________</p>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-lg-12" style="text-align: center; margin-top: 5%;">
        <p>Thank you for your patronage </p>
    </div>
</div>

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


