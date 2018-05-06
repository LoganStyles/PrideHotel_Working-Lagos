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
if (!empty($group_client_name_error)) {
    $client_name_class = "brightyellow";
    $form_error.="**".$client_name_error;
}
if (!empty($group_roomtype_error)) {
    $roomtype_class = "brightyellow";
    $form_error.="**".$roomtype_error;
}
if (!empty($group_price_rate_error)) {
    $price_rate_class = "brightyellow";
    $form_error.="**".$price_rate_error;
}
?>

<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:left">
                    <?php if ($action == "insert") {
                        echo "Group Reservation (NEW)";
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

                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'group_form');
                echo '<div id="error_div" class="' . $form_danger_style . '">' . $form_error . '</div>';
                echo '<div id="error_div" class="' . $danger_style . '">' . $arrival_error . '</div>';
                if (isset($_SESSION["form_success"])) {
                    echo "<div class=\"alert alert-success\">" . $this->session->form_success . "</div>";
                }
                echo form_open('group/processGroup', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">                        
                        <input type="hidden" name="group_ID"  id="group_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="group_type" id="group_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="group_action" id="group_action" value="<?php echo $action; ?>">
                        <input type="hidden" name="group_mode" id="group_mode" value="<?php echo $mode; ?>">
                        <input type="hidden" name="group_page_number" id="group_page_number" value="<?php echo $page_number; ?>">
                        <input type="hidden" name="group_roomtype_id" id="group_roomtype_id" value="<?php echo $roomtype_id; ?>">
                        <input type="hidden" name="group_price_rate_id" id="group_price_rate_id" value="<?php echo $price_rate_id; ?>">

                        <div class="form-group ">
                            <label  for="group_arrival" class="col-sm-1 col-lg-1 control-label">Arrival</label>
                            <div class="col-sm-1 col-lg-1" name="group_arrival" id="group_arrival"></div>

                            <label for="group_nights" class="col-sm-1 col-lg-1 control-label">Nights</label>
                            <div class="col-sm-2 col-lg-2">
                                <input  <?php echo $disabled; ?> class=" form-control" id="group_nights" name="group_nights" value="<?php echo $nights; ?>" type="number" />
                            </div>

                            <label  for="group_departure" class="col-sm-1 col-lg-1 control-label">Departure</label>
                            <div class="col-sm-1 col-lg-1" name="group_departure" id="group_departure"></div>

                            <label for="group_client_type" class="col-sm-2 control-label">Client Type</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> <?php echo $readonly_field; ?> class="form-control " name="group_client_type" id="group_client_type">                                    
                                    <option value="group" <?php
                                    if ($client_type === "group") {
                                        echo 'selected';
                                    }
                                    ?>>GROUP</option>
                                </select>                                
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="group_client_name" class="col-sm-2 control-label">Client(Group) Name</label>
                            <div class="col-sm-3">
                                <input <?php echo $disabled; ?> class="<?php echo $client_name_class; ?> form-control" id="group_client_name" name="group_client_name" type="text" value="<?php echo $client_name; ?>" />                                
                            </div>                             

                            <div class="clearfix"></div>

                            <div class="row" style="margin-top: 5px;">
                                <div class="col-sm-12">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-3 search_results" id='client_reservations_live'></div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="group_roomtype" class="col-sm-2 control-label">Room Type</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class="<?php echo $roomtype_class; ?> form-control" id="group_roomtype" name="group_roomtype" value="<?php echo $roomtype; ?>" type="text" />
                            </div> 
                            <button class="btn btn-default pull-left" data-toggle="button" onclick="fetchModalGridData('group','roomtype');">
                                <i class="fa fa-list"></i>
                            </button>

                            <label for="group_price_rate" class="col-sm-1 control-label">Price Rate</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class="<?php echo $price_rate_class; ?> form-control" id="group_price_rate" name="group_price_rate" type="text" value="<?php echo $price_rate; ?>" />
                            </div>
                            <button class="btn btn-default pull-left" data-toggle="button" onclick="fetchModalGridData('group','price_rate');">
                                <i class="fa fa-list"></i>
                            </button>
                            <label for="group_remarks" class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="group_remarks" name="group_remarks" type="text" value="<?php echo $remarks; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>

                        <div class="form-group ">
                            <label for="group_status" class="col-sm-1 control-label">Status</label>
                            <div class="col-lg-2 col-sm-2">
                                <select class="form-control " name="group_status" id="group_status" disabled>
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

                            <label for="group_folio_room" class="col-sm-1 control-label">Folio:Room</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="group_folio_room" id="group_folio_room">
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
                                    <option value="INV" <?php
                                    if ($folio_room === "INV") {
                                        echo 'selected';
                                    }
                                    ?>>INV</option>
                                </select>                                
                            </div>

                            <label for="group_folio_extra" class="col-sm-1 control-label">Folio:Extra</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="group_folio_extra" id="group_folio_extra">
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
                                    <option value="INV" <?php
                                    if ($folio_extra === "INV") {
                                        echo 'selected';
                                    }
                                    ?>>INV</option>
                                </select>                                
                            </div>    

                            <label for="group_folio_other" class="col-sm-1 control-label">Folio:Other</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="group_folio_other" id="group_folio_other">
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
                                    <option value="INV" <?php
                                    if ($folio_other === "INV") {
                                        echo 'selected';
                                    }
                                    ?>>INV</option>
                                </select>                                
                            </div>

                            <div class="clearfix"></div>                           

                        </div>
                        
                        <div class="form-group ">                            

                            <label for="group_weekday" class="col-sm-2 control-label">WEEKDAY</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="group_weekday" name="group_weekday" value="<?php echo $weekday; ?>" type="number" />
                            </div>

                            <label for="group_weekend" class="col-sm-2 control-label">WEEKEND</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="group_weekend" name="group_weekend" value="<?php echo $weekend; ?>" type="number" />
                            </div>

                            <label for="group_holiday" class="col-sm-2 control-label">HOLIDAY</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="group_holiday" name="group_holiday" value="<?php echo $holiday; ?>" type="number" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="group_price_room" class="col-sm-2 control-label">Price :Room</label>
                            <div class="col-lg-2 col-sm-2">
                                <input <?php echo $disabled; ?> readonly class=" form-control" id="group_price_room" name="group_price_room" value="<?php echo $price_room; ?>" type="number" />                              
                            </div>

                            <label for="group_price_extra" class="col-sm-2 control-label">Price: Extra</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> <?php echo $readonly_field; ?> class=" form-control" id="group_price_extra" name="group_price_extra" value="<?php echo $price_extra; ?>" type="number" />
                            </div>

                            <label for="group_price_total" class="col-sm-2 control-label">Price: Total</label>
                            <div class="col-sm-2">
                                <input <?php echo $disabled; ?> readonly class=" form-control" id="group_price_total" name="group_price_total" value="<?php echo $price_total; ?>" type="number" />
                            </div>                            

                        </div>
                       
                        <div class="form-group ">
                            <label for="group_comp_nights" class="col-sm-1 control-label">Comp.Nights</label>
                            <div class="col-sm-2 col-lg-2">
                                <input <?php echo $disabled; ?> class=" form-control" id="group_comp_nights" name="group_comp_nights" value="<?php echo $comp_nights; ?>" type="number" />
                            </div>

                            <label for="group_comp_visits" class="col-sm-1 control-label">Comp.Visits</label>
                            <div class="col-lg-2 col-sm-2">
                                <select disabled  class="form-control " name="group_comp_visits" id="group_comp_visits">
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
                         </div>


                    </div>
                </div>
                <div class="pull-right">
                    <?php if($action !="view"){?>
                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <?php } ?>
                    
                    <button type="button" class="btn btn-default" onclick='closeWindow("<?php echo $mode."\",\"group\",\"".$page_number;?>");'>Cancel</button>
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




