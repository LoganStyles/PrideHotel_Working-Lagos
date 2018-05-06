<?php
$current = $received[0];
extract($current);

$price_rate = getTitle($roomtypes, $price_title); //price title

$access = $this->session->reservation;
if ($access < 4) {//set readonly fields
    $readonly_field = "readonly";
} else {
    $readonly_field = "";
}

$disabled = "";
if ($action == "view") {
    $disabled = "disabled";
}

$client_name_class = $roomtype_class = $price_rate_class = "";

//chk for specific errors
if (!empty($client_name_error)) {
    $client_name_class = "brightyellow";
    $form_error.="**".$client_name_error."<br>";
}
if (!empty($roomtype_error)) {
    $roomtype_class = "brightyellow";
    $form_error.="**".$roomtype_error."<br>";
}
if (!empty($price_rate_error)) {
    $price_rate_class = "brightyellow";
    $form_error.="**".$price_rate_error."<br>";
}
if (!empty($nights_error)) {
//    $nights_class = "brightyellow";
    $form_error.="**".$nights_error."<br>";
}
?>

<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:left">
                    <?php if ($action == "insert") {
                        echo "Reservation (NEW)";
                    } ?>&nbsp;&nbsp;&nbsp;<span>Check In Time:</span>&nbsp;&nbsp;<span>14:00</span>
                    &nbsp;&nbsp;&nbsp;<span>Check Out Time:</span>&nbsp;<span>12:00</span>
                </header>

                <?php
                if ($form_error) {
                    $form_danger_style = "alert alert-danger error";
                } else {
                    $form_danger_style = "";
                }

                if ($arrival_error) {
                    $danger_style = "alert alert-danger error";
                } else {
                    $danger_style = "";
                }
               
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'guest_form');
                echo '<div id="error_div" class="' . $form_danger_style . '">' . $form_error . '</div>';
                echo '<div id="error_div" class="' . $danger_style . '">' . $arrival_error . '</div>';

                if (isset($_SESSION["form_success"])) {
                    echo "<div class=\"alert alert-success\">" . $this->session->form_success . "</div>";
                }
                echo form_open('resv/processGuest', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">                        
                        <input type="hidden" name="guest_ID"  id="guest_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="guest_type" id="guest_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="guest_action" id="guest_action" value="<?php echo $action; ?>">
                        <input type="hidden" name="guest_mode" id="guest_mode" value="<?php echo $mode; ?>">
                        <input type="hidden" name="guest_page_number" id="guest_page_number" value="<?php echo $page_number; ?>">
                        <input type="hidden" name="guest_roomtype_id" id="guest_roomtype_id" value="<?php echo $roomtype_id; ?>">
                        <input type="hidden" name="guest_room_number_id" id="guest_room_number_id" value="<?php echo $room_number_id; ?>">
                        <input type="hidden" name="guest_price_rate_id" id="guest_price_rate_id" value="<?php echo $price_rate_id; ?>">

                        <div class="form-group ">
                            <label  for="guest_arrival" class="col-sm-1 col-lg-1 control-label">Arrival</label>
                            <div class="col-sm-1 col-lg-1" name="guest_arrival" id="guest_arrival"></div>

                            <label for="guest_nights" class="col-sm-1 col-lg-1 control-label">Nights</label>
                            <div class="col-sm-2 col-lg-2">
                                <input  <?php echo $disabled; ?> class="form-control" id="guest_nights" name="guest_nights" value="<?php echo $nights; ?>" type="number" />
                            </div>

                            <label  for="guest_departure" class="col-sm-1 col-lg-1 control-label">Departure</label>
                            <div class="col-sm-1 col-lg-1" name="guest_departure" id="guest_departure"></div>

                            <label for="guest_client_type" class="col-sm-2 control-label">Client Type</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> <?php echo $readonly_field; ?> class="form-control " name="guest_client_type" id="guest_client_type">
                                    <option value="person" <?php
                                    if ($client_type === "person") {
                                        echo 'selected';
                                    }
                                    ?>>PERSON</option>
                                    <option value="group" <?php
                                    if ($client_type === "group") {
                                        echo 'selected';
                                    }
                                    ?>>GROUP</option>
                                </select>                                
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="guest_client_name" class="col-sm-2 control-label">Client Name</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class="<?php echo $client_name_class; ?> form-control" id="guest_client_name" name="guest_client_name" type="text" value="<?php echo $client_name; ?>" />                                
                            </div>  

                            <label for="guest_agency_name" class="col-sm-2 control-label">Agency Name</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_agency_name" name="guest_agency_name" type="text" value="<?php echo $agency_name; ?>" />
                            </div>
                            
                            <label for="guest_remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_remarks" name="guest_remarks" type="text" value="<?php echo $remarks; ?>" />
                            </div>

                            <div class="clearfix"></div>

                            <div class="row" style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-3 search_results" id='client_reservations_live'></div>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-3 search_results" id='agency_reservations_live'></div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="guest_agency_contact" class="col-sm-2 control-label">Agency Contact</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_agency_contact" name="guest_agency_contact" type="text" value="<?php echo $agency_contact; ?>" />
                            </div>

                            <label for="guest_guest1" class="col-sm-2 control-label">Guest (1)</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_guest1" name="guest_guest1" type="text" value="<?php echo $guest1; ?>" />
                            </div>
                            <label for="guest_master_id" class="col-sm-2 control-label">Master ID</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" id="guest_master_id" name="guest_master_id" type="text" value="<?php echo $master_id; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>

                        <div class="form-group ">
                            <label for="guest_guest2" class="col-sm-2 control-label">Guest (2)</label>
                            <div class="col-sm-3">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_guest2" name="guest_guest2" type="text" value="<?php echo $guest2; ?>" />
                            </div>

                            <label for="guest_adults" class="col-sm-1 col-lg-1 control-label">Adults</label>
                            <div class="col-sm-2 col-lg-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_adults" name="guest_adults" value="<?php echo $adults; ?>" type="number" />
                            </div>

                            <label for="guest_children" class="col-sm-1 col-lg-1 control-label">Children</label>
                            <div class="col-sm-2 col-lg-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_children" name="guest_children" value="<?php echo $children; ?>" type="number" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>

                        <div class="form-group ">
                            <label for="guest_roomtype" class="col-sm-2 control-label">Room Type</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class="<?php echo $roomtype_class; ?> form-control" id="guest_roomtype" name="guest_roomtype" value="<?php echo $roomtype; ?>" type="text" />
                            </div> 
                            <button class="btn btn-default pull-left" data-toggle="button" onclick="fetchModalGridData('guest','roomtype');">
                                <i class="fa fa-list"></i>
                            </button>

                            <label for="guest_room_number" class="col-sm-1 col-lg-1 control-label">Room Number</label>
                            <div class="col-sm-2 col-lg-2">
                                <input <?php echo $disabled; ?> readonly class=" form-control" id="guest_room_number" name="guest_room_number" type="text" value="<?php echo $room_number; ?>" />
                            </div>
                            <button class="btn btn-default pull-left" data-toggle="button" onclick="fetchModalGridData('guest','room_number');">
                                <i class="fa fa-list"></i>
                            </button>

                            <label for="guest_price_rate" class="col-sm-1 control-label">Price Rate</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class="<?php echo $price_rate_class; ?> form-control" id="guest_price_rate" name="guest_price_rate" type="text" value="<?php echo $price_rate; ?>" />
                            </div>
                            <button class="btn btn-default pull-left" data-toggle="button" onclick="fetchModalGridData('guest','price_rate');">
                                <i class="fa fa-list"></i>
                            </button>
                            <div class="clearfix"></div>                           

                        </div>

                        <div class="form-group ">
                            <label for="guest_status" class="col-sm-1 control-label">Status</label>
                            <div class="col-lg-2 col-sm-2">
                                <select class="form-control " name="guest_status" id="guest_status" disabled>
                                    <option value="confirmed" <?php
                                    if ($status === "confirmed") {
                                        echo 'selected';
                                    }
                                    ?>>CONFIRMED</option>
                                    <option value="staying" <?php
                                    if ($status === "staying") {
                                        echo 'selected';
                                    }
                                    ?>>STAYING</option>
                                    <option value="departed" <?php
                                    if ($status === "departed") {
                                        echo 'selected';
                                    }
                                    ?>>DEPARTED</option>
                                    <option value="cancelled" <?php
                                    if ($status === "cancelled") {
                                        echo 'selected';
                                    }
                                    ?>>CANCELLED</option>
                                    <option value="provisional" <?php
                                    if ($status === "provisional") {
                                        echo 'selected';
                                    }
                                    ?>>PROVISIONAL</option>
                                    <option value="ledger" <?php
                                    if ($status === "ledger") {
                                        echo 'selected';
                                    }
                                    ?>>LEDGER</option>
                                </select>                                
                            </div>                            

                            <label for="guest_folio_room" class="col-sm-1 control-label">Folio:Room</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="guest_folio_room" id="guest_folio_room">
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
                                    ?>>INV</option>-->
                                </select>                                
                            </div>

                            <label for="guest_folio_extra" class="col-sm-1 control-label">Folio:Extra</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="guest_folio_extra" id="guest_folio_extra">
                                    <option value="BILL1" <?php
                                    if ($folio_extra === "BILL1") {
                                        echo 'selected';
                                    }
                                    ?>>BILL1</option>
                                    <option value="BILL2" <?php
                                    if ($folio_extra === "BILL2") {
                                        echo 'selected';
                                    }
                                    ?>>BILL2</option>
                                    <option value="BILL3" <?php
                                    if ($folio_extra === "BILL3") {
                                        echo 'selected';
                                    }
                                    ?>>BILL3</option>
                                    <option value="BILL4" <?php
                                    if ($folio_extra === "BILL4") {
                                        echo 'selected';
                                    }
                                    ?>>BILL4</option>
                                </select>                                
                            </div>    

                            <label for="guest_folio_other" class="col-sm-1 control-label">Folio:Other</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="guest_folio_other" id="guest_folio_other">
                                    <option value="BILL1" <?php
                                    if ($folio_other === "BILL1") {
                                        echo 'selected';
                                    }
                                    ?>>BILL1</option>
                                    <option value="BILL2" <?php
                                    if ($folio_other === "BILL2") {
                                        echo 'selected';
                                    }
                                    ?>>BILL2</option>
                                    <option value="BILL3" <?php
                                    if ($folio_other === "BILL3") {
                                        echo 'selected';
                                    }
                                    ?>>BILL3</option>
                                    <option value="BILL4" <?php
                                    if ($folio_other === "BILL4") {
                                        echo 'selected';
                                    }
                                    ?>>BILL4</option>
                                </select>                                
                            </div>

                            <div class="clearfix"></div>                           

                        </div>


                        <div class="form-group ">                            

                            <label for="guest_weekday" class="col-sm-2 control-label">WEEKDAY</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="guest_weekday" name="guest_weekday" value="<?php echo $weekday; ?>" type="number" />
                            </div>

                            <label for="guest_weekend" class="col-sm-2 control-label">WEEKEND</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="guest_weekend" name="guest_weekend" value="<?php echo $weekend; ?>" type="number" />
                            </div>

                            <label for="guest_holiday" class="col-sm-2 control-label">HOLIDAY</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="guest_holiday" name="guest_holiday" value="<?php echo $holiday; ?>" type="number" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="guest_price_room" class="col-sm-2 control-label">Price :Room</label>
                            <div class="col-lg-2 col-sm-2">
                                <input <?php echo $disabled; ?> readonly class=" form-control" id="guest_price_room" name="guest_price_room" value="<?php echo $price_room; ?>" type="number" />                              
                            </div>

                            <label for="guest_price_extra" class="col-sm-2 control-label">Price: Extra</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="guest_price_extra" name="guest_price_extra" value="<?php echo $price_extra; ?>" type="number" />
                            </div>

                            <label for="guest_price_total" class="col-sm-2 control-label">Price: Total</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> readonly class=" form-control" id="guest_price_total" name="guest_price_total" value="<?php echo $price_total; ?>" type="number" />
                            </div>                            

                        </div>

                        <div class="form-group ">
                            <label for="guest_invoice" class="col-sm-1 control-label">Invoice</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="guest_invoice" id="guest_invoice">
                                    <option value="none" <?php
                                    if ($invoice === "none") {
                                        echo 'selected';
                                    }
                                    ?>>NONE</option>
                                    <option value="client" <?php
                                    if ($invoice === "client") {
                                        echo 'selected';
                                    }
                                    ?>>CLIENT</option>
                                    <option value="agency" <?php
                                    if ($invoice === "agency") {
                                        echo 'selected';
                                    }
                                    ?>>AGENCY</option>

                                </select>                                                                 
                            </div>

                            <label for="guest_comp_nights" class="col-sm-1 control-label">Comp.Nights</label>
                            <div class="col-sm-2 col-lg-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="guest_comp_nights" name="guest_comp_nights" value="<?php echo $comp_nights; ?>" type="number" />
                            </div>

                            <label for="guest_comp_visits" class="col-sm-1 control-label">Comp.Visits</label>
                            <div class="col-lg-2 col-sm-2">
                                <select disabled  class="form-control " name="guest_comp_visits" id="guest_comp_visits">
                                    <option value="no" <?php
                                    if ($comp_visits === "no") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="yes" <?php
                                    if ($comp_visits === "yes") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                   

                                </select>                                                                 
                            </div> 

                            <label for="guest_block_pos" class="col-sm-1 control-label">BLOCK POS</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="guest_block_pos" id="guest_block_pos">
                                    <option value="no" <?php
                                    if ($block_pos === "no") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="yes" <?php
                                    if ($block_pos === "yes") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                  

                                </select>                                                                 
                            </div> 

                        </div>


                    </div>
                </div>
                <div class="pull-right">
                    <?php if($action !="view"){?>
                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <?php } ?>
                    
                    <button type="button" class="btn btn-default" onclick='closeWindow("<?php echo $mode."\",\"guest\",\"".$page_number;?>");'>Cancel</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->

<div role="dialog" id="contact_prompt_modal" class="modal fade">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Message</h4>
            </div>
            <div class="modal-body">                
                <div class="panel-body">
                    <div class="row">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <h4>Sorry, You Do Not Have Permission For This Action!</h4>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="" class="btn btn-default" data-dismiss="modal">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCEL</button>                
            </div>
        </div>
    </div>
</div>

<div role="dialog" id="roomtype_popup_modal" class="modal fade">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Room Types</h4>
            </div>
            <div class="modal-body">                
                <header class="panel-heading">
                    <!--Rooms-->
                    <div>
                        <div class="pull-right">
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"\" id=\"roomtype_popup_select\" class=\"btn btn-success\" type=\"button\"><i class=\"fa fa-check\"></i>&nbsp;Select</a>&nbsp;"; //                                    
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </header>


                <div class="panel-body">
                    <div class="" id="roomtype_popup_data"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>                
            </div>
        </div>
    </div>
</div>

<div role="dialog" id="room_number_popup_modal" class="modal fade">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Rooms</h4>
            </div>
            <div class="modal-body">                
                <header class="panel-heading">
                    <!--Rooms-->
                    <div>
                        <div class="pull-right">
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"\" id=\"room_number_popup_select\" class=\"btn btn-success\" type=\"button\"><i class=\"fa fa-check\"></i>&nbsp;Select</a>&nbsp;"; //                                    
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </header>


                <div class="panel-body">
                    <div class="" id="room_number_popup_data"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>                
            </div>
        </div>
    </div>
</div>

<div role="dialog" id="price_rate_popup_modal" class="modal fade">
    <div class="modal-dialog" style="width: 800px;">
        <div class="modal-content">
            <div class="modal-header panel-heading dark" >                
                <h4 class="modal-title" style="text-align:center">Price Rates</h4>
            </div>
            <div class="modal-body">                
                <header class="panel-heading">
                    <!--Rooms-->
                    <div>
                        <div class="pull-right">
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"\" id=\"price_rate_popup_select\" class=\"btn btn-success\" type=\"button\"><i class=\"fa fa-check\"></i>&nbsp;Select</a>&nbsp;"; //                                    
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </header>


                <div class="panel-body">
                    <div class="" id="price_rate_popup_data"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>                
            </div>
        </div>
    </div>
</div>




