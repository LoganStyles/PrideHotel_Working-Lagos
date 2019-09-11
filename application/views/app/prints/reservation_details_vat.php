<?php 
$current = $collection[0];
extract($current);


$arrival = (strtotime($actual_arrival) > strtotime($arrival)) ? (date('d/m/Y', strtotime($actual_arrival))) : (date('d/m/Y', strtotime($arrival)));
$departure = (strtotime($actual_departure) > strtotime($departure)) ? (date('d/m/Y', strtotime($actual_departure))) : (date('d/m/Y', strtotime($departure)));
$duration = $arrival . " - " . $departure;

$checkin = date("H:i:s", strtotime($actual_arrival));

$vat = $price_total * 0.05;
?>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">                               
            <div class="panel-body">
                    <div class="form"> 
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Client Name</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $client_name; ?>" />
                            </div>

                            <label class="col-sm-2 control-label">Room No.</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $room_title; ?>" />
                            </div>
                            <label class="col-sm-2 control-label">Room Type</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $roomtype; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Adults</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $adults; ?>" />
                            </div>

                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $status; ?>" />
                            </div>
                            <label class="col-sm-2 control-label">Duration</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $duration; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Checkin</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $checkin; ?>" />
                            </div>

                            <label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $remarks; ?>" />
                            </div>
                            <label class="col-sm-2 control-label">Room Price</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $price_room; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>
                        
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Total Price</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $price_total; ?>" />
                            </div>

                            <label class="col-sm-2 control-label">Comp Nights</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $comp_nights; ?>" />
                            </div>
                            <label class="col-sm-2 control-label">Blocked POS</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $block_pos; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>

                        <div class="form-group ">
                            <label class="col-sm-2 control-label">VAT</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $vat; ?>" />
                            </div>

                           
                            <div class="clearfix"></div>                           

                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label">Price Rate</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $price_r; ?>" />
                            </div>

                            <label class="col-sm-2 control-label">Weekday</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $weekday; ?>" />
                            </div>
                            <label class="col-sm-2 control-label">Weekend</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" type="text" value="<?php echo $weekend; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>
                    </div>
            </div>
        </section>
    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <section class="panel">  <h3>Payments</h3>           
            <?php if(count($collection_payments) >0) { ?>
            <?php 
                $content = "";
                $count = 1;
                            
            foreach($collection_payments as $payments): 
                $description = $payments['description'];
                $debit = $payments['debit'];
                $date_created = date('d/m/Y', strtotime($payments['date_created']));
            
                    $content.="<tr class=\"booking_radio\">";                
                    $content.="<td>$description</td>";
                    $content.="<td>$debit</td>";
                    $content.="<td>$date_created</td>";
                    $content.="</tr>";
                
                 $count++;
              endforeach;  
                ?>           
            
            <?php } ?>
            <div class="panel-body"><p style="font-weight: 700;color: #f00;"> </p>
                <table class="table  table-hover general-table table-bordered table-condensed">
                    <thead>
                        <tr>                   
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($collection_payments) > 0) { ?>
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
            $buttons = "<a onclick=\"printAction('print','" . base_url() . "resv');\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
            $buttons.="<a href=\"" . base_url() . "resv\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-times\"></i>&nbsp;Close</a>&nbsp;";

            echo $buttons;
            ?>
        </div>
    </div>
</div>
</div>

<!--body wrapper end-->


