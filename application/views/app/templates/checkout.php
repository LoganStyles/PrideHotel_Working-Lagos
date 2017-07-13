<?php
$current = $received[0];
extract($current);
$close_account = FALSE;

//no folios exist or folio bal is 0
if ($bill1 == 0 && $bill2 == 0 && $bill3 == 0 && $bill4 == 0 && $inv == 0) {
    $close_account = TRUE;
}
?>

<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:center">
                    <span>Check Out</span>
                </header>

                <div class="pull-right">
                    <div class="form-group ">
                        <div class="col-sm-12">
                            <?php
                            $buttons = "";
                            if ($close_account) {
                                $buttons.="<div class=\"btn-group\"><button class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-print\"></i>&nbsp;Check Out</button>"
                                        . "<button data-toggle=\"dropdown\" class=\"btn btn-default dropdown-toggle\" type=\"button\">"
                                        . "<span class=\"caret\"></span>"
                                        . "<span class=\"sr-only\">Toggle Dropdown</span>"
                                        . "</button>"
                                        . "<ul role=\"menu\" class=\"dropdown-menu\">"
                                        . "<li><a onclick=\"processPrintCheckout('plain','".$client_reservation_id."','');\" href=\"#\">Plain Paper</a></li>"
                                        . "<li><a onclick=\"processPrintCheckout('letter','".$client_reservation_id."','');\" href=\"#\">Letter Head</a></li>"
                                        . "</ul></div>&nbsp;";
                            }else{
                                $buttons.="<div class=\"btn-group\"><button class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-print\"></i>&nbsp;Post to Ledger</button>"
                                        . "<button data-toggle=\"dropdown\" class=\"btn btn-default dropdown-toggle\" type=\"button\">"
                                        . "<span class=\"caret\"></span>"
                                        . "<span class=\"sr-only\">Toggle Dropdown</span>"
                                        . "</button>"
                                        . "<ul role=\"menu\" class=\"dropdown-menu\">"
                                        . "<li><a onclick=\"processPrintCheckout('plain','".$client_reservation_id."','ledger');\" href=\"#\">Plain Paper</a></li>"
                                        . "<li><a onclick=\"processPrintCheckout('letter','".$client_reservation_id."','ledger');\" href=\"#\">Letter Head</a></li>"
                                        . "</ul></div>&nbsp;";                                
                            }

                            $buttons.="<a href=\"" . $this->session->resv_back_uri . "\" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-times\"></i>&nbsp;Cancel</a>";
                            echo $buttons;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                
                <form class="cmxform form-horizontal adminex-form">

                <div class="panel-body">
                    <div class="form"> 
                        <div class="form-group ">
                            <label for="checkout_client_name" class="col-sm-2 col-lg-2 control-label">Client Name</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_client_name" name="checkout_client_name" value="<?php echo $client_name; ?>" type="text" />
                            </div>

                            <label for="checkout_resv" class="col-sm-2 col-lg-2 control-label">Resv. ID</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_resv" name="checkout_resv" value="<?php echo $client_reservation_id; ?>" type="text" />
                            </div> 

                            <label for="checkout_room" class="col-sm-2 col-lg-2 control-label">Room</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_room" name="checkout_room" value="<?php echo $room_number; ?>" type="text" />
                            </div> 
                        </div> 

                        <div class="form-group ">
                            <label for="checkout_bill1" class="col-sm-2 col-lg-2 control-label">BILL1</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_bill1" name="checkout_bill1" value="<?php echo $bill1; ?>" type="number" />
                            </div>

                            <label for="checkout_bill2" class="col-sm-2 col-lg-2 control-label">BILL2</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_bill2" name="checkout_bill2" value="<?php echo $bill2; ?>" type="number" />
                            </div>   
                            
                            <label for="checkout_bill3" class="col-sm-2 col-lg-2 control-label">BILL3</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_bill3" name="checkout_bill3" value="<?php echo $bill3; ?>" type="number" />
                            </div>
                        </div> 

                        <div class="form-group ">                    

                            <label for="checkout_bill4" class="col-sm-2 col-lg-2 control-label">BILL4</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_bill4" name="checkout_bill4" value="<?php echo $bill4; ?>" type="number" />
                            </div>                            
                        
                            <label for="checkout_bill3" class="col-sm-2 col-lg-2 control-label">INV</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkout_bill3" name="checkout_bill3" value="<?php echo $inv; ?>" type="number" />
                            </div>                                                      
                        </div> 

                    </div>
                </div>
                <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->






