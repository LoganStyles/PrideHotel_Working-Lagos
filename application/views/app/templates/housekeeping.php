<?php
$access = $this->session->utilities;
$disabled = "disabled";
if ($access < 2) {
    //read access
    $redirect = "app";
    redirect($redirect);
}


$current = $received[0];
extract($current);
$roomclass_list = displayOptions($roomclasses, 0);
$roomtype_list = displayOptions($roomtypes, 0);
$accountsales_list = displayOptions($accountsale, 0);

if ($form_error) {
    $danger_style = "alert alert-danger error";
    $display_modal = "block";
    $modal_mode = "in";
} else {
    $danger_style = $display_modal = $modal_mode = "";
}
?>

<!-- page heading start-->
<div class="page-heading">
    <h3> <?php echo $header_title; ?></h3>
    <ul class="breadcrumb">
        <li class="active">
            Housekeeping
        </li>
    </ul>
</div>
<!-- page heading end-->

<!--body wrapper start-->
<div class="wrapper">

    <div class="row">
        <div class="col-sm-10">
            <section class="panel">
                <header class="panel-heading">
                    <!--Housekeeping-->
                    <div>
                        <div id="housekeeping_loader"></div>
                        <div class="col-lg-3 col-sm-3">
                            <select class="form-control " name="housekeeping_action" id="housekeeping_action">
                                <option value="0" <?php
                                if ($action === "0") {
                                    echo 'selected';
                                }
                                ?>>ALL</option>
                                <option value="1" <?php
                                if ($action === "1") {
                                    echo 'selected';
                                }
                                ?>>VACANT</option>
                                <option value="2" <?php
                                if ($action === "2") {
                                    echo 'selected';
                                }
                                ?>>VACANT DIRTY</option>
                                <option value="3" <?php
                                if ($action === "3") {
                                    echo 'selected';
                                }
                                ?>>OCCUPIED</option>
                                <option value="4" <?php
                                if ($action === "4") {
                                    echo 'selected';
                                }
                                ?>>OCCUPIED DIRTY</option>
                                <option value="5" <?php
                                if ($action === "5") {
                                    echo 'selected';
                                }
                                ?>>RESERVED</option>
                                <option value="6" <?php
                                if ($action === "6") {
                                    echo 'selected';
                                }
                                ?>>OUT OF USE</option>
                                <option value="7" <?php
                                if ($action === "7") {
                                    echo 'selected';
                                }
                                ?>>BLOCKED</option>
                            </select>
                        </div> 
                        <div class="pull-right">
                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "";
                                    if ($count >= 1) {
                                        $buttons.="<a id=\"housekeeping_edit\" onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        $buttons.="<a id=\"housekeeping_resv\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-building-o\"></i>&nbsp;Resv. Info</a>&nbsp;";
                                        $buttons.="<a id=\"housekeeping_details\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-book\"></i>&nbsp;Details</a>&nbsp;";
                                        $buttons.="<a id=\"housekeeping_print\" onclick=\"printAll('room');\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-print\"></i>&nbsp;Print</a>&nbsp;";
                                        $buttons.="<a id=\"housekeeping_status\" onclick=\"\" type=\"button\" class=\"btn btn-warning \"><i class=\"fa fa-bitbucket\"></i>&nbsp;Vacant</a>&nbsp;";
                                        $buttons.="<a id=\"housekeeping_block\" onclick=\"\" type=\"button\" class=\"btn btn-danger \"><i class=\"fa fa-ban\"></i>&nbsp;Block</a>&nbsp;";
                                    }
                                    echo $buttons;
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>

                    </div>
                </header>


                <div class="panel-body">
                    <div class="" id="housekeeping_data">

                    </div>

                </div>
                <div class="row" class="col-sm-6">
                    <div class="col-sm-3" style="font-weight: 700;margin-left: 2%;">Update Room Status</div>
                    <div class="col-sm-3"><select class="form-control col-lg-3 col-sm-3" name="housekeeping_room_status" id="housekeeping_room_status">
                            
                            <option value="1" <?php
                            if ($action === "1") {
                                echo 'selected';
                            }
                            ?>>VACANT</option>
                            <option value="2" <?php
                            if ($action === "2") {
                                echo 'selected';
                            }
                            ?>>VACANT DIRTY</option>
                            <option value="3" <?php
                            if ($action === "3") {
                                echo 'selected';
                            }
                            ?>>OCCUPIED</option>
                            <option value="4" <?php
                            if ($action === "4") {
                                echo 'selected';
                            }
                            ?>>OCCUPIED DIRTY</option>
                            <option value="5" <?php
                            if ($action === "5") {
                                echo 'selected';
                            }
                            ?>>RESERVED</option>
                            <option value="6" <?php
                            if ($action === "6") {
                                echo 'selected';
                            }
                            ?>>OUT OF USE</option>
                            <option value="7" <?php
                            if ($action === "7") {
                                echo 'selected';
                            }
                            ?>>BLOCKED</option>
                        </select></div>
                    <div>
                        <button id="housekeeping_room_status_button" type="button" class="btn btn-default col-sm-2">Update</button>
                    </div> 
                </div>
                
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- housekeeping_modal Modal -->
<div id="housekeeping_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Remarks</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'housekeeping_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processHousekeeping', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="housekeeping_ID"  id="housekeeping_ID" value="<?php echo $ID; ?>">
                        <input type="hidden" name="housekeeping_type" id="housekeeping_type" value="<?php echo $type; ?>">
                        <input type="hidden" name="housekeeping_page_number" id="housekeeping_page_number" value="<?php echo $page_number; ?>">                                             


                        <div class="form-group ">
                            <label for="housekeeping_remark" class="col-sm-2 control-label">Remark</label>
                            <div class="col-sm-10">
                                <input  class=" form-control" id="housekeeping_remark" value="<?php echo $remark; ?>" name="housekeeping_remark" type="text" />
                            </div>
                        </div> 
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#housekeeping_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--housekeeping_modal modal-->

<!-- housekeeping_room_modal Modal -->
<div id="housekeeping_room_modal" class="modal fade"  role="dialog">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Room Details</h4>
            </div>

            <div class="modal-body" > 
                <div class="panel-body">
                    <div class="form">
                        <div class="form-group ">
                            <label for="housekeeping_room_title" class="col-sm-3 control-label">Room Number</label>
                            <div class="col-sm-3">
                                <input disabled class=" form-control" id="housekeeping_room_title" name="housekeeping_room_title" type="text" />
                            </div>

                            <label for="housekeeping_room_roomtype" class="col-sm-3 control-label">Room Type</label>
                            <div class="col-lg-3 col-sm-3">
                                <select disabled class="form-control " name="housekeeping_room_roomtype" id="housekeeping_room_roomtype">
                                    <?php echo $roomtype_list; ?>
                                </select>                                
                            </div>
                        </div> 

                        <div class="form-group ">
                            <label for="housekeeping_room_roomclass" class="col-sm-3 control-label">Room Class</label>
                            <div class="col-lg-3 col-sm-3">
                                <select disabled class="form-control " name="housekeeping_room_roomclass" id="housekeeping_room_roomclass">
                                    <?php echo $roomclass_list; ?>
                                </select>                                
                            </div>

                            <label class="col-sm-3 control-label col-lg-3" for="housekeeping_room_acctname">Account Name</label>
                            <div class="col-lg-3 col-sm-3">
                                <select disabled class="form-control " name="housekeeping_room_acctname" id="housekeeping_room_acctname">
                                    <?php echo $accountsales_list; ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-group ">
                            <label for="housekeeping_room_remark" class="col-sm-2 control-label">Remark</label>
                            <div class="col-sm-10">
                                <input disabled class=" form-control" id="housekeeping_room_remark" name="housekeeping_room_remark" type="text" />
                            </div>
                        </div>


                        <div class="form-group ">
                            <label for="housekeeping_room_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input disabled class=" form-control" id="housekeeping_room_description" name="housekeeping_room_description" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>
<!--housekeeping_room_modal modal-->
