<?php
$delete = (isset($this->session->delete_group) ? ($this->session->delete_group) : (0));

$current = $received[0];
extract($current);
$payment_account_list = displayOptions($payment_accounts, $account);
$payment_account_description = getTitle($payment_accounts, $account, "description");
$plu_group_list = displayOptions($plu_groups, $plu_group);
$rooms_list = displayOptions($rooms, $move_rooms);
$count = 1;
$folio_status="";
$folio_active = $log_action="";

if ($sale_form_error) {
    $sale_danger_style = "alert alert-danger error";
    $sale_display_modal = "block";
    $sale_modal_mode = "in";
} else {
    $sale_danger_style = $sale_display_modal = $sale_modal_mode = "";
}

if ($payment_form_error) {
    $payment_danger_style = "alert alert-danger error";
    $payment_display_modal = "block";
    $payment_modal_mode = "in";
} else {
    $payment_danger_style = $payment_display_modal = $payment_modal_mode = "";
}

$red_balance = "";
if (!empty($red_bal)) {
    $red_balance = "color: #f00;font-weight: 600;";
}
?>

<!--body wrapper start-->
<div class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading" style="text-align: center;">
                    
                    <?php if (count($collection) > 0) { ?>
                        <?php
                        $content = "";
                        foreach ($collection as $row):
                            $active = $checked = $sale_account_title = "";
                            $folio_active = $log_action="";
                            $folio_id = $row["ID"];
                            $folio_status = $row["folio_status"];
                            $date = date('d/m/Y', strtotime($row["date_created"]));
                            $description = $row["description"];
                            $incl_vat = ($row["debit"] > 0) ? ($row["debit"]) : ($row["credit"]);
                            $pak = $row["pak"];
                            $sub_folio = $row["sub_folio"];
                            $links = $row["links"];
                            $qty = $row["qty"];

                            $charge = $row["charge"];
                            $folio_action = $row["action"];
                            $signature_created = $row["signature_created"];
                            $plu_group = $row["plu_group"];
                            $plu = $row["plu"];
                            $price = $row["price"];

                            //calc folio active/non-active
                            $folio_date = $row["date_created"];
//                            $folio_date = (strtotime($row["date_modified"]) > strtotime($row["date_created"])) ? ($row["date_modified"]) : ($row["date_created"]);
                            $time = date('H:i:s', strtotime($folio_date));
                            if ((strtotime($folio_date) >= strtotime($app_date)) && (($folio_status === "staying") || ($folio_status === "confirmed"))) {
                                $folio_active = "active";
                            }
                            if(($this->session->reservation ==4) && ($folio_status==="departed")){//special permission
                                $folio_active = "active";
                                $log_action="yes";
                            }
                            //get account_number & title & desc
                            $account_number = $row["account_number"];
                            if ($folio_action === "sale") {
                                $sale_account_title = getTitle($sale_accounts, $account_number, "title");
                            }

                            //check for a row has been clicked before
                            if (isset($_SESSION['folio_active_row'])) {
                                if (($_SESSION['folio_active_row'] == $folio_id)) {
                                    $active = "active";
                                    $checked = "checked";
                                }
                            } elseif ($count === 1) {
                                $active = "active";
                                $checked = "checked";
                            }

                            $content.="<tr class=\"folio_row $active\">"
                                    . "<td><input type=\"checkbox\" $checked >"
                                    . "<input class=\"folio_hidden_id\" type=\"hidden\" value=\"$folio_id\"></td>";
                            $content.="<td>"
                                    . "<input class=\"folio_hidden_action\" type=\"hidden\" value=\"$folio_action\">"
                                    . "<input class=\"folio_hidden_active\" type=\"hidden\" value=\"$folio_active\">"
                                    . "<input class=\"folio_hidden_account_number\" type=\"hidden\" value=\"$account_number\">"
                                    . "<input class=\"folio_hidden_plu_group\" type=\"hidden\" value=\"$plu_group\">"
                                    . "<input class=\"folio_hidden_plu\" type=\"hidden\" value=\"$plu\">"
                                    . "<input class=\"folio_hidden_price\" type=\"hidden\" value=\"$price\">"
                                    . "<input class=\"folio_hidden_resv\" type=\"hidden\" value=\"$client_reservation_id\">"
                                    . "<input class=\"folio_hidden_sale_account_title\" type=\"hidden\" value=\"$sale_account_title\">"
                                    . "$date</td>";
                            $content.="<td class=\"folio_description\">$description</td>";
                            $content.="<td class=\"folio_incl_vat\">$incl_vat</td>";
                            $content.="<td>$pak</td>";
                            $content.="<td>$sub_folio</td>";
                            $content.="<td>$links</td>";
                            $content.="<td class=\"folio_qty\">$qty</td>";
                            $content.="<td>$signature_created</td>";
                            $content.="<td>$time</td>";
                            $content.="<td>$charge</td>";
                            $content.="</tr>";

                            $count++;
                        endforeach;
                        ?>
                    <?php } ?>
                    FOLIO &nbsp;&nbsp;[ <?php echo $header_title; ?>]&nbsp;&nbsp;[ROOM: <?php echo $resv_room_title;?>]
                    <?php if(!empty($master_id)){
                        echo "Master ID [".$master_id."]";
                    } ?>
                    <div>
                        <div class="col-lg-2 col-sm-2">
                            <select  class="form-control " name="folio_bills" id="folio_bills">
                                <option value="ALL" <?php
                                if ($bills === "ALL") {
                                    echo 'selected';
                                }
                                ?>>ALL</option> 
                                <option value="BILL1" <?php
                                if ($bills === "BILL1") {
                                    echo 'selected';
                                }
                                ?>>BILL1</option> 
                                <option value="BILL2" <?php
                                if ($bills === "BILL2") {
                                    echo 'selected';
                                }
                                ?>>BILL2</option>                                    
                                <option value="BILL3" <?php
                                if ($bills === "BILL3") {
                                    echo 'selected';
                                }
                                ?>>BILL3</option>                                    
                                <option value="BILL4" <?php
                                if ($bills === "BILL4") {
                                    echo 'selected';
                                }
                                ?>>BILL4</option>
                                <option value="INV" <?php
                                if ($bills === "INV") {
                                    echo 'selected';
                                }
                                ?>>INVOICE</option>
                            </select>                                                                 
                        </div>  
                        <div class="pull-right">
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "";
                                    $buttons.="<a onclick=\"processFolio('new');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-plus-square\"></i>&nbsp;New</a>&nbsp;";
                                    $buttons.="<a onclick=\"processFolio('edit');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";

                                    if ($delete == "1") {
                                        $buttons.="<a onclick=\"processFolio('delete');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
                                    }
                                    $buttons.="<div class=\"btn-group\"><button class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-print\"></i>&nbsp;Print</button>"
                                            . "<button data-toggle=\"dropdown\" class=\"btn btn-default dropdown-toggle\" type=\"button\">"
                                            . "<span class=\"caret\"></span>"
                                            . "<span class=\"sr-only\">Toggle Dropdown</span>"
                                            . "</button>"
                                            . "<ul role=\"menu\" class=\"dropdown-menu\">"
                                            . "<li><a onclick=\"processPrintFolio('plain','all');\" href=\"#\">Plain Paper</a></li>"
                                            . "<li><a onclick=\"processPrintFolio('letter','all');\" href=\"#\">Letter Head</a></li>"
                                            . "</ul></div>&nbsp;";

                                    $buttons.="<div class=\"btn-group\"><button class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-print\"></i>&nbsp;Print Bills</button>"
                                            . "<button data-toggle=\"dropdown\" class=\"btn btn-default dropdown-toggle\" type=\"button\">"
                                            . "<span class=\"caret\"></span>"
                                            . "<span class=\"sr-only\">Toggle Dropdown</span>"
                                            . "</button>"
                                            . "<ul role=\"menu\" class=\"dropdown-menu\">"
                                            . "<li><a onclick=\"processPrintFolio('plain','BILL1');\" href=\"#\">BILL1</a></li>"
                                            . "<li><a onclick=\"processPrintFolio('letter','BILL1');\" href=\"#\">BILL1 (Letterhead)</a></li>"
                                            . "<li class=\"divider\"></li>"
                                            . "<li><a onclick=\"processPrintFolio('plain','BILL2');\"  href=\"#\">BILL2</a></li>"
                                            . "<li><a onclick=\"processPrintFolio('letter','BILL2');\" href=\"#\">BILL2 (Letterhead)</a></li>"
                                            . "<li class=\"divider\"></li>"
                                            . "<li><a onclick=\"processPrintFolio('plain','BILL3');\" href=\"#\">BILL3</a></li>"
                                            . "<li><a onclick=\"processPrintFolio('letter','BILL3');\" href=\"#\">BILL3 (Letterhead)</a></li>"
                                            . "<li class=\"divider\"></li>"
                                            . "<li><a onclick=\"processPrintFolio('plain','BILL4');\"  href=\"#\">BILL4</a></li>"
                                            . "<li><a onclick=\"processPrintFolio('letter','BILL4');\" href=\"#\">BILL4 (Letterhead)</a></li>"
                                            . "<li class=\"divider\"></li>"
                                            . "<li><a onclick=\"processPrintFolio('plain','INV');\" href=\"#\">INV</a></li>"
                                            . "<li><a onclick=\"processPrintFolio('letter','INV');\" href=\"#\">INV (Letterhead)</a></li>"
                                            . "<li class=\"divider\"></li>"
                                            . "</ul></div>&nbsp;";
                                    $buttons.="<a href=\"" . $this->session->resv_back_uri . "\" type=\"button\" class=\"btn btn-danger\"><i class=\"fa fa-times\"></i>&nbsp;Close</a>";
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
                                <th></th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>INCL VAT</th>
                                <th>PAK</th>
                                <th>Sub-Folio</th>
                                <th>Links</th>
                                <th>Qty</th>
                                <th>Signature</th>
                                <th>Time</th>
                                <th>Charge</th>
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
                <div>
                    <div class="col-sm-12" style="margin-bottom: 10px;">
                        <div class="form">
                            <div>
                                <label for="folio_bill1" class="col-sm-1 control-label">BILL1</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_bill1" name="folio_bill1" value="<?php echo $bill1; ?>" type="text" readonly="true"/>                                
                                </div>

                                <label for="folio_bill2" class="col-sm-1 control-label">BILL2</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_bill2" name="folio_bill2" value="<?php echo $bill2; ?>" type="text" readonly="true"/>                                
                                </div>

                                <label for="folio_bill3" class="col-sm-1 control-label">BILL3</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_bill3" name="folio_bill3" value="<?php echo $bill3; ?>" type="text" readonly="true"/>                                
                                </div>

                                <label for="folio_bill4" class="col-sm-1 control-label">BILL4</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_bill4" name="folio_bill4" value="<?php echo $bill4; ?>" type="text" readonly="true"/>                                
                                </div>
                            </div>

                            <div>
                                <label for="folio_inv" class="col-sm-1 control-label">INV</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_inv" name="folio_inv" value="<?php echo $inv; ?>" type="text" readonly="true"/>                                
                                </div>

                                <label for="folio_sale_total" class="col-sm-1 control-label">SALE</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_sale_total" name="folio_sale_total" value="<?php echo $sale_total; ?>" type="text" readonly="true"/>                                
                                </div>

                                <label for="folio_payment_total" class="col-sm-1 control-label">PAYMENT</label>
                                <div class="col-sm-2">
                                    <input  class=" form-control" id="folio_payment_total" name="folio_payment_total" value="<?php echo $payment_total; ?>" type="text" readonly="true"/>                                
                                </div>

                                <label for="folio_diff" class="col-sm-1 control-label">BALANCE</label>
                                <div class="col-sm-2">
                                    <input style="<?php echo $red_balance; ?>" class=" form-control" id="folio_diff" name="folio_diff" value="<?php echo $folio_diff; ?>" type="text" readonly="true"/>                                
                                </div>                               

                            </div>
                        </div>
                    </div>
                    <div >
                        <div class="col-sm-12">
                            <div class="col-lg-2 col-sm-2">
                                <select  class="form-control " name="new_folio_bills" id="new_folio_bills">

                                    <option value="BILL1" <?php
                                    if ($folio_room === "BILL1") {
                                        echo 'selected';
                                    }
                                    ?>>BILL1</option> 
                                    <option value="BILL2" <?php
                                    if ($folio_room === "BILL2") {
                                        echo 'selected';
                                    }
                                    ?>>BILL2</option>                                    
                                    <option value="BILL3" <?php
                                    if ($folio_room === "BILL3") {
                                        echo 'selected';
                                    }
                                    ?>>BILL3</option>                                    
                                    <option value="BILL4" <?php
                                    if ($folio_room === "BILL4") {
                                        echo 'selected';
                                    }
                                    ?>>BILL4</option>
<!--                                    <option value="INV" <?php
                                    if ($folio_room === "INV") {
                                        echo 'selected';
                                    }
                                    ?>>INVOICE</option>-->
                                </select>                                                                 
                            </div>
                            <div>
                                <?php
                                $checkout_params="'$client_reservation_id','$client_name','$room_number','$departure'";
                                $buttons = "";
                                if($folio_status==="staying" ){
                                    if(!empty($master_id)){
                                        $buttons.="<a onclick=\"showSingleDialog('confirm','master');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-sitemap\"></i>&nbsp;Master</a>&nbsp;";
                                    }                                
                                $buttons.="<a onclick=\"showDialog('#folio_receipt_modal','#folio_receipt_error');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-print\"></i>&nbsp;Print Receipt</a>&nbsp;";
                                $buttons.="<a onclick=\"showDialog('#folio_move_modal','#folio_move_error');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-external-link\"></i>&nbsp;Move</a>&nbsp;";
                                $buttons.="<a onclick=\"showSingleDialog('confirm','return');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-undo\"></i>&nbsp;Return</a>&nbsp;";
                                $buttons.="<a onclick=\"showDialog('#folio_manual_charge_modal','#folio_manual_charge_error');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-square-o\"></i>&nbsp;Room Charge</a>&nbsp;";
                                $buttons.="<a onclick=\"checkout(".$checkout_params.");\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-road\"></i>&nbsp;Check-out</a>&nbsp;";
                                }
                                echo $buttons;
                                ?>
                            </div>
                        </div>
                        <div class="pull-right">
                            <div class="">
                                <?php
                                $buttons = "";
                                $buttons.="<a onclick=\"newFolio('sale');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-shopping-cart\"></i>&nbsp;New Sale</a>&nbsp;";
                                $buttons.="<a onclick=\"newFolio('payment');\" type=\"button\" class=\"btn btn-default \"><i class=\"fa fa-money\"></i>&nbsp;New Payment</a>&nbsp;";
                                echo $buttons;
                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div> 
                    </div>

                </div>

        </div>
        </section>
    </div>
</div>
<!--body wrapper end-->



<!-- folio_payment_modal Modal -->
<div id="folio_payment_modal" class="modal fade <?php echo $payment_modal_mode; ?>"  role="dialog" style="display:<?php echo $payment_display_modal; ?>;">
    <div class="modal-dialog" style="width:600px;"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Payment: <?php echo $client_reservation_id; ?></h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'folio_payment_form');
                echo '<div id="error_div" class="' . $payment_danger_style . '">' . $payment_form_error . '</div>';
                echo form_open('resv/processFolioPayment', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="folio_payment_ID"  id="folio_payment_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="folio_payment_resv"  id="folio_payment_resv" value="<?php echo $client_reservation_id; ?>">
                        <input type="hidden" name="folio_payment_type" id="folio_payment_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="folio_payment_page_number" id="folio_payment_page_number" value="<?php echo $offset; ?>">
                        <input type="hidden" name="folio_payment_client_name" id="folio_payment_client_name" value="<?php echo $client_name; ?>">
                        <input type="hidden" name="folio_payment_new_folio" id="folio_payment_new_folio" value="<?php echo $folio_room; ?>">
                        <input type="hidden" name="folio_payment_bills_type" id="folio_payment_bills_type" value="<?php echo $bills; ?>">
                        <input type="hidden" name="folio_payment_room_number" id="folio_payment_room_number" value="<?php echo $room_number; ?>">
                        <input type="hidden" name="folio_payment_master_id" id="folio_payment_master_id" value="<?php echo $master_id; ?>">
                        <input type="hidden" name="folio_payment_log_action" id="folio_payment_log_action" value="<?php echo $log_action; ?>">

                        <div class="form-group ">
                            <label for="folio_payment_account" class="col-sm-2 control-label">Account</label>
                            <div class="col-lg-4 col-sm-4">
                                <select class="form-control " name="folio_payment_account" id="folio_payment_account">
                                    <?php echo $payment_account_list; ?>
                                </select>                                                                 
                            </div>

                            <label for="folio_payment_amount" class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-4">
                                <input  class=" form-control" id="folio_payment_amount" name="folio_payment_amount" value="<?php echo $amount; ?>" type="number" />                                
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="folio_payment_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-8">
                                <input  class=" form-control" id="folio_payment_description" value="<?php echo $payment_account_description; ?>" name="folio_payment_description" type="text" readonly="true" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--folio_payment_modal -->

<div role="dialog" id="folio_sale_modal" class="modal fade <?php echo $sale_modal_mode; ?>" style="display:<?php echo $sale_display_modal; ?>;">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">SALE: <?php echo $client_reservation_id; ?></h4>
            </div>
            <div class="modal-body">

                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'folio_sale_form');
                echo '<div class="' . $sale_danger_style . '">' . $sale_form_error . '</div>';
                echo form_open('resv/processFolioSale', $attributes);
                ?>
                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="folio_sale_ID"  id="folio_sale_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="folio_sale_resv"  id="folio_sale_resv" value="<?php echo $client_reservation_id; ?>">
                        <input type="hidden" name="folio_sale_type" id="folio_sale_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="folio_sale_page_number" id="folio_sale_page_number" value="<?php echo $offset; ?>">
                        <input type="hidden" name="folio_sale_client_name" id="folio_sale_client_name" value="<?php echo $client_name; ?>">
                        <input type="hidden" name="folio_sale_account" id="folio_sale_account" value="<?php echo $sale_account; ?>">
                        <input type="hidden" name="folio_sale_new_folio" id="folio_sale_new_folio" value="<?php echo $folio_room; ?>">
                        <input type="hidden" name="folio_sale_bills_type" id="folio_sale_bills_type" value="<?php echo $bills; ?>">
                        <input type="hidden" name="folio_sale_room_number" id="folio_sale_room_number" value="<?php echo $room_number; ?>">
                        <input type="hidden" name="folio_sale_master_id" id="folio_sale_master_id" value="<?php echo $master_id; ?>">
                        <input type="hidden" name="folio_sale_log_action" id="folio_sale_log_action" value="<?php echo $log_action; ?>">

                        <div class="form-group ">
                            <label for="folio_sale_plu_group" class="col-sm-2 control-label">PLU Group</label>
                            <div class="col-lg-4 col-sm-4">
                                <select  class="form-control " name="folio_sale_plu_group" id="folio_sale_plu_group">                                    
                                    <?php echo $plu_group_list; ?>
                                </select>                                                                 
                            </div>

                            <label for="folio_sale_plu" class="col-sm-2 control-label">PLU No.</label>
                            <div class="col-sm-4">
                                <input  class=" form-control" id="folio_sale_plu" name="folio_sale_plu" value="<?php echo $plu; ?>" type="text" readonly="true" />                                
                            </div> 
                        </div>

                        <div class="form-group ">
                            <label for="folio_sale_account_title" class="col-sm-2 control-label">Account</label>
                            <div class="col-sm-4">
                                <input  class=" form-control" id="folio_sale_account_title" name="folio_sale_account_title" value="<?php echo $sale_account_title; ?>" type="text" readonly="true" />                                
                            </div>

                            <label for="folio_sale_price" class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-4">
                                <input  class=" form-control" id="folio_sale_price" name="folio_sale_price" value="<?php echo $sale_price; ?>" type="number" />                                
                            </div>                                                       
                        </div>

                        <div class="form-group">
                            <label for="folio_sale_qty" class="col-sm-2 control-label">Quantity</label>
                            <div class="col-sm-4">
                                <input  class=" form-control" id="folio_sale_qty" name="folio_sale_qty" value="<?php echo $sale_qty; ?>" type="number" />                                
                            </div>

                            <label for="folio_sale_amount" class="col-sm-2 control-label">Amount</label>
                            <div class="col-sm-4">
                                <input  class=" form-control" id="folio_sale_amount" name="folio_sale_amount" value="<?php echo $sale_amount; ?>" type="number" readonly="true" />                                
                            </div>
                        </div>

                        <div class="form-group ">                            
                            <label for="folio_sale_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-8">
                                <input  class=" form-control" id="folio_sale_description" value="<?php echo $plu_description; ?>" name="folio_sale_description" type="text" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="SAVE" />
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
                </form> 
            </div>
        </div>
    </div>
</div>
<!--folio_sale_modal-->

<div role="dialog" id="folio_move_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">MOVE: RESV# <?php echo $client_reservation_id; ?></h4>
            </div>
            <div class="modal-body">
                <form class="cmxform form-horizontal adminex-form" id="folio_move_form" action="">
                    <div id="folio_move_error"></div>
                    <div class="panel-body">
                        <div class="form">
                            <div class="form-group ">
                                <label for="folio_move_room_number" class="col-sm-2 control-label">Room No.</label>
                                <div class="col-lg-4 col-sm-4">
                                    <select  class="form-control " name="folio_move_room_number" id="folio_move_room_number">                                    
                                        <?php echo $rooms_list; ?>
                                    </select>                                                                 
                                </div>

                                <label for="folio_move_reservation_id" class="col-sm-2 control-label">Reserv#</label>
                                <div class="col-sm-4">
                                    <input class=" form-control" id="folio_move_reservation_id" name="folio_move_reservation_id" value="" type="text" />                                
                                </div> 
                            </div>

                            <div class="form-group ">
                                <label for="folio_move_bills" class="col-sm-2 control-label">Sub-Folio</label>
                                <div class="col-lg-6 col-sm-6">
                                    <select  class="form-control " name="folio_move_bills" id="folio_move_bills">
                                        <option value="BILL1">BILL1</option> 
                                        <option value="BILL2">BILL2</option>                                    
                                        <option value="BILL3">BILL3</option>                                    
                                        <option value="BILL4">BILL4</option>
                                        <option value="INV">INVOICE</option>
                                    </select>                                                                 
                                </div>                                                     
                            </div>

                            <div class="form-group ">
                                <label for="folio_move_reason" class="col-sm-2 control-label">Reason</label>
                                <div class="col-sm-10">
                                    <input  class=" form-control" id="folio_move_reason" name="folio_move_reason" value="" type="text" />                                
                                </div>                                                      
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="SAVE" />
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
            </div>
            </form> 
        </div>
    </div>
</div>

<div role="dialog" id="folio_receipt_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">PRINT RECEIPT</h4>
            </div>
            <div class="modal-body">
                <form class="cmxform form-horizontal adminex-form" id="folio_receipt_form" action="">
                    <div id="folio_receipt_error"></div>
                    <div class="panel-body">
                        <div class="form">
                            <div class="form-group "> 
                                <input id="folio_receipt_reservation_id" value="<?php echo $client_reservation_id;?>" type="hidden" /> 
                            </div>

                            <div class="form-group ">
                                <label for="folio_receipt_paper_type" class="col-sm-3 control-label">Paper Type</label>
                                <div class="col-lg-6 col-sm-6">
                                    <select  class="form-control " name="folio_receipt_paper_type" id="folio_receipt_paper_type">
                                        <option value="plain">PLAIN PAPER</option> 
                                        <option value="letter">LETTER HEAD</option>
                                    </select>                                                                 
                                </div>                                                     
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="PRINT" />
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
            </div>
            </form> 
        </div>
    </div>
</div>

<div role="dialog" id="folio_manual_charge_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">ROOM CHARGE CONFIRMATION</h4>
            </div>
            <div class="modal-body">
                <h5><strong>Confirm Room Charge for <?php echo ucwords($client_name);?></strong></h5>
                <form class="cmxform form-horizontal adminex-form" id="folio_manual_charge_form" action="">
                    <input type="hidden" name="folio_manual_charge_resv"  id="folio_manual_charge_resv" value="<?php echo $client_reservation_id; ?>">
                    <div id="folio_manual_charge_error"></div>
                    <div class="panel-body">
                        <div class="form">                            
                            <div class="form-group ">
                                <label for="folio_manual_charge_reason" class="col-sm-2 control-label">Reason</label>
                                <div class="col-sm-10">
                                    <input  class=" form-control" id="folio_manual_charge_reason" name="folio_manual_charge_reason" type="text" />                                
                                </div>                                                      
                            </div>
                        </div>
                    </div>                
            </div>
            <div class="modal-footer">
                <input class="btn btn-success btn-sm" type="submit" name="submit" value="OK" />
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>
            </div>
            </form> 
        </div>
    </div>
</div>