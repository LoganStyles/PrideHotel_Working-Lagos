<?php ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="" style="text-align: center;font-weight: 700;">
                        <?php if (count($collection) > 0) {
                            $content = "";
                            $content.="<tr><td>GUEST NAME</td><td>".ucwords($client_name)."</td></tr>";
                            $content.="<tr><td>RESERVATION NUMBER</td><td>".$reservation_id."</td></tr>";
                            $content.="<tr><td>BOOKING MADE ON</td><td>".$date_created."</td></tr>";
                            $content.="<tr><td>CHECK IN DATE</td><td>".$actual_arrival."</td></tr>";
                            $content.="<tr><td>NUMBER OF NIGHTS</td><td>".$nights."</td></tr>";
                            $content.="<tr><td>CHECK OUT DATE</td><td>".$actual_departure."</td></tr>";
                            ?>
                            <?php
                            
                            $count = 1;
                            foreach ($collection as $row):
                                $description = $row["description"];
                                $debit = number_format($row["debit"], 2);
                                $credit = number_format($row["credit"], 2);

                                $content.="<tr>";
                                $content.="<td>PAYMENT</td>";
                                $content.="<td>".$debit."&nbsp;(".$description.")</td>";
                                $content.="</tr>";

                                $count++;
                            endforeach;
                            $content.="<tr><td>ROOM NUMBER</td><td>".$room_number."</td></tr>";
                            $content.="<tr><td>ROOM TYPE</td><td>".$room_type."</td></tr>";
                             ?>
                        <?php }else{ ?>
                        
                        <?php $content="<h4>Invalid Selection: <span style='color:#f00;'><strong>Please select payments</strong></span></h4>"; } ?>
                        
                    </div>
                    <div class="clearfix"></div>

                </div>
                
            </header>

            <div class="panel-body"><p style="font-weight: 700;color: #f00;"> </p>
                <table class="table  table-hover general-table table-bordered table-condensed">
                    <tbody>                        
                        <?php echo $content; ?>
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
<?php if (count($collection) > 0) { ?>
<div class="row" >
    <div style="margin-left: 30px;color: #000;font-weight: 700">
        <div>TOTAL RECEIVED: &nbsp;&nbsp;N<?php echo $payment_total; ?></div>
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
<?php } ?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="">
                <div>
                    <div class="" style="text-align: center;font-weight: 700;">
                        <?php if (count($collection) > 0) {
                            $content = "";
                            $content.="<tr><td>GUEST NAME</td><td>".ucwords($client_name)."</td></tr>";
                            $content.="<tr><td>RESERVATION NUMBER</td><td>".$reservation_id."</td></tr>";
                            $content.="<tr><td>BOOKING MADE ON</td><td>".$date_created."</td></tr>";
                            $content.="<tr><td>CHECK IN DATE</td><td>".$actual_arrival."</td></tr>";
                            $content.="<tr><td>NUMBER OF NIGHTS</td><td>".$nights."</td></tr>";
                            $content.="<tr><td>CHECK OUT DATE</td><td>".$actual_departure."</td></tr>";
                            ?>
                            <?php
                            
                            $count = 1;
                            foreach ($collection as $row):
                                $description = $row["description"];
                                $debit = number_format($row["debit"], 2);
                                $credit = number_format($row["credit"], 2);

                                $content.="<tr>";
                                $content.="<td>PAYMENT</td>";
                                $content.="<td>".$debit."&nbsp;(".$description.")</td>";
                                $content.="</tr>";

                                $count++;
                            endforeach;
                            $content.="<tr><td>ROOM NUMBER</td><td>".$room_number."</td></tr>";
                            $content.="<tr><td>ROOM TYPE</td><td>".$room_type."</td></tr>";
                             ?>
                        <?php }else{ ?>
                        
                        <?php $content="<h4>Invalid Selection: <span style='color:#f00;'><strong>Please select payments</strong></span></h4>"; } ?>
                        
                    </div>
                    <div class="clearfix"></div>

                </div>
                
            </header>

            <div class="panel-body"><p style="font-weight: 700;color: #f00;"> </p>
                <table class="table  table-hover general-table table-bordered table-condensed">
                    <tbody>                        
                        <?php echo $content; ?>
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
<?php if (count($collection) > 0) { ?>
<div class="row" >
    <div style="margin-left: 30px;color: #000;font-weight: 700">
        <div>TOTAL RECEIVED: &nbsp;&nbsp;N<?php echo $payment_total; ?></div>
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
<?php } ?>
<div class="row">
    <div class="pull-right" id="print_box">
        <div class="col-sm-12">
            <?php
            if (count($collection) > 0) {
                $buttons = "<a onclick=\"printAction('print','".$this->session->folio_back_uri."');\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
                $buttons.="<a href=\"" . $this->session->folio_back_uri . "\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";
            }else{
                $buttons="<a href=\"" . $this->session->folio_back_uri . "\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";
            }
            echo $buttons;
            ?>
        </div>
    </div>
</div>
</div>

<!--body wrapper end-->


