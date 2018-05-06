<?php
$current = $received[0];
extract($current);

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

$client_name_class = "";

//chk for specific errors
if (!empty($house_client_name_error)) {
    $client_name_class = "brightyellow";
    $form_error.="**".$client_name_error;
}
?>

<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:left">
                    <?php if ($action == "insert") {
                        echo "H-ACCOUNT (NEW)";
                    } ?>&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;
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

                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'house_form');
                echo '<div id="error_div" class="' . $form_danger_style . '">' . $form_error . '</div>';
                echo '<div id="error_div" class="' . $danger_style . '">' . $arrival_error . '</div>';
                if (isset($_SESSION["form_success"])) {
                    echo "<div class=\"alert alert-success\">" . $this->session->form_success . "</div>";
                }
                echo form_open('house/processHouse', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">                        
                        <input type="hidden" name="house_ID"  id="house_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="house_type" id="house_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="house_action" id="house_action" value="<?php echo $action; ?>">
                        <input type="hidden" name="house_mode" id="house_mode" value="<?php echo $mode; ?>">
                        <input type="hidden" name="house_page_number" id="house_page_number" value="<?php echo $page_number; ?>">

                        <div class="form-group ">
                            <label  for="house_arrival" class="col-sm-1 col-lg-1 control-label">From</label>
                            <div class="col-sm-1 col-lg-1" name="house_arrival" id="house_arrival"></div>
                            
                            <label for="house_nights" class="col-sm-1 col-lg-1 control-label">Days</label>
                            <div class="col-sm-2 col-lg-2">
                                <input  <?php echo $disabled; ?> class=" form-control" id="house_nights" name="house_nights" value="<?php echo $nights; ?>" type="number" />
                            </div>
                            
                            <label  for="house_departure" class="col-sm-1 col-lg-1 control-label">To</label>
                            <div class="col-sm-1 col-lg-1" name="house_departure" id="house_departure"></div>

                            <label for="house_client_type" class="col-sm-2 control-label">Client Type</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> <?php echo $readonly_field; ?> class="form-control " name="house_client_type" id="house_client_type">                                    
                                    <option value="person" <?php
                                    if ($client_type === "person") {
                                        echo 'selected';
                                    }
                                    ?>>PERSON</option>
                                </select>                                
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="house_client_name" class="col-sm-2 control-label">Client Name</label>
                            <div class="col-sm-3">
                                <input <?php echo $disabled; ?> class="<?php echo $client_name_class; ?> form-control" id="house_client_name" name="house_client_name" type="text" value="<?php echo $client_name; ?>" />                                
                            </div> 

                            <label for="house_remarks" class="col-sm-2 control-label">Remarks</label>
                                <div class="col-sm-3">
                                    <input <?php echo $disabled; ?> class="form-control" id="house_remarks" name="house_remarks" type="text" value="<?php echo $remarks; ?>" />                                
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
                            <label for="house_status" class="col-sm-1 control-label">Status</label>
                            <div class="col-lg-2 col-sm-2">
                                <select class="form-control " name="house_status" id="house_status" disabled>
                                    
                                    <option value="staying" <?php
                                    if ($status === "staying") {
                                        echo 'selected';
                                    }
                                    ?>>STANDARD</option>
                                    <option value="departed" <?php
                                    if ($status === "departed") {
                                        echo 'selected';
                                    }
                                    ?>>COMPLETED</option>
                                    <option value="cancelled" <?php
                                    if ($status === "cancelled") {
                                        echo 'selected';
                                    }
                                    ?>>CANCELLED</option>
                                    
                                    <option value="ledger" <?php
                                    if ($status === "ledger") {
                                        echo 'selected';
                                    }
                                    ?>>LEDGER</option>
                                </select>                                
                            </div>                            

                            <label for="house_folio_room" class="col-sm-1 control-label">Folio</label>
                            <div class="col-lg-2 col-sm-2">
                                <select <?php echo $disabled; ?> class="form-control " name="house_folio_room" id="house_folio_room">
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

                            <div class="clearfix"></div>                           

                        </div>
                        
                    </div>
                </div>
                <div class="pull-right">
                    <?php if($action !="view"){?>
                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <?php } ?>
                    
                    <button type="button" class="btn btn-default" onclick='closeWindow("<?php echo $mode."\",\"house\",\"".$page_number;?>");'>Cancel</button>
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
