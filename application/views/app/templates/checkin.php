<?php
$current = $received[0];
extract($current);

$price_rate = getTitle($roomtypes, $price_title); //price title
?>

<!--body wrapper start-->
<div class="wrapper">    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="text-align:center">
                    <span>Check In</span>
                </header>

                <?php
                if ($form_error) {
                    $form_danger_style = "alert alert-danger error";
                } else {
                    $form_danger_style = "";
                }

                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'checkin_form');
                echo '<div id="error_div" class="' . $form_danger_style . '">' . $form_error . '</div>';
                if (isset($_SESSION["form_success"])) {
                    echo "<div class=\"alert alert-success\">" . $this->session->form_success . "</div>";
                }
                echo form_open('resv/processCheckIn', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">                        
                        <input type="hidden" name="checkin_ID"  id="checkin_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="checkin_mode" id="checkin_mode" value="<?php echo $mode; ?>">
                        <input type="hidden" name="checkin_comp_nights" id="checkin_comp_nights" value="<?php echo $comp_nights; ?>">
                        <input type="hidden" name="checkin_room_number_id" id="checkin_room_number_id" value="<?php echo $room_number_id; ?>">
                        <input type="hidden" name="checkin_price_title" id="checkin_price_title" value="<?php echo $price_title; ?>">

                        <div class="form-group ">
                            <label  for="checkin_arrival" class="col-sm-1 col-lg-1 control-label">Arrival</label>
                            <div class="col-sm-1 col-lg-1" name="checkin_arrival" id="checkin_arrival"></div>

                            <label for="checkin_nights" class="col-sm-1 col-lg-1 control-label">Nights</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkin_nights" name="checkin_nights" value="<?php echo $nights; ?>" type="number" />
                            </div>

                            <label for="checkin_departure" class="col-sm-1 col-lg-1 control-label">Departure</label>
                            <div class="col-sm-1 col-lg-1" name="checkin_departure" id="checkin_departure"></div>

                            <label for="checkin_reservation_id" class="col-sm-2 control-label">Reservation ID</label>
                            <div class="col-sm-2">
                                <input readonly class="form-control" id="checkin_reservation_id" name="checkin_reservation_id" type="text" value="<?php echo $reservation_id; ?>" />                                
                            </div>                             
                        </div> 

                        <div class="form-group ">
                            <label for="checkin_client_name" class="col-sm-2 control-label">Guest (1)</label>
                            <div class="col-sm-2">
                                <input readonly class="form-control" id="checkin_client_name" name="checkin_client_name" type="text" value="<?php echo $client_name; ?>" />                                
                            </div>  
                            <label for="checkin_guest2" class="col-sm-2 control-label">Guest (2)</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" id="checkin_guest2" name="checkin_guest2" type="text" value="<?php echo $guest2; ?>" />
                            </div>
                            <label for="checkin_comp_nights" class="col-sm-1 control-label">Comp.Nights</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkin_comp_nights" name="checkin_comp_nights" value="<?php echo $comp_nights; ?>" type="number" />
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="form-group ">
                            <label for="checkin_roomtype" class="col-sm-2 control-label">Room Type</label>
                            <div class="col-sm-2">
                                <input readonly class="form-control" id="checkin_roomtype" name="checkin_roomtype" value="<?php echo $roomtype; ?>" type="text" />
                            </div>                             

                            <label for="checkin_room_number" class="col-sm-1 col-lg-1 control-label">Room Number</label>
                            <div class="col-sm-2 col-lg-2">
                                <input readonly class=" form-control" id="checkin_room_number" name="checkin_room_number" type="text" value="<?php echo $room_number; ?>" />
                            </div>
                            <button class="btn btn-default pull-left" data-toggle="button" onclick="fetchModalGridData('checkin','room_number');">
                                <i class="fa fa-list"></i>
                            </button>

                            <label for="checkin_price_rate" class="col-sm-1 control-label">Price Rate</label>
                            <div class="col-sm-2">
                                <input readonly class="form-control" id="checkin_price_rate" name="checkin_price_rate" type="text" value="<?php echo $price_rate; ?>" />
                            </div>
                            <div class="clearfix"></div>                           

                        </div>

                        <div class="form-group ">
                            <label for="checkin_status" class="col-sm-1 control-label">Status</label>
                            <div class="col-lg-2 col-sm-2">
                                <select class="form-control " name="checkin_status" id="checkin_status" readonly>
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
                                </select>                                
                            </div>                          

                            <label for="checkin_weekday" class="col-sm-1 control-label">WEEKDAY</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" id="checkin_weekday" name="checkin_weekday" value="<?php echo $weekday; ?>" type="number" />
                            </div>

                            <label for="checkin_weekend" class="col-sm-1 control-label">WEEKEND</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" id="checkin_weekend" name="checkin_weekend" value="<?php echo $weekend; ?>" type="number" />
                            </div>

                            <label for="checkin_holiday" class="col-sm-1 control-label">HOLIDAY</label>
                            <div class="col-sm-2">
                                <input readonly class=" form-control" id="checkin_holiday" name="checkin_holiday" value="<?php echo $holiday; ?>" type="number" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Check In" />
                    <button type="button" class="btn btn-default" onclick="closeWindow('<?php echo $mode; ?>','guest','0');">Cancel</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
</div>
<!--body wrapper end-->

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






