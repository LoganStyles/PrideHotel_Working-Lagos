<?php
$current = $received[0];
extract($current);
$roomclass_list=displayOptions($roomclasses,0);
$roomtype_list=displayOptions($roomtypes,0);
$accountsales_list=displayOptions($accountsale,0);

if ($form_error) {
    $danger_style = "alert alert-danger error";
    $display_modal="block";
    $modal_mode="in";
} else {
    $danger_style = $display_modal=$modal_mode="";
}
?>

<!-- page heading start-->
<div class="page-heading">
    <h3> <?php echo $header_title; ?></h3>
    <ul class="breadcrumb">
        <li class="active">
            Rooms
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
                    <!--Rooms-->
                    <div>
                        <div id="room_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('room','#room_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"room_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"room_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
                                        }                                        
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
                    <div class="" id="room_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- room_modal Modal -->
<div id="room_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Rooms</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'room_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processRoom', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="room_ID"  id="room_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="room_type" id="room_type" value="<?php echo $type;?>">
                        <input type="hidden" name="room_action" id="room_action" value="<?php echo $action;?>">
                        <input type="hidden" name="room_page_number" id="room_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="room_title" class="col-sm-3 control-label">Room Number</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="room_title" value="<?php echo $title; ?>" name="room_title" type="text" />
                            </div>
                            
                            <label for="room_roomtype" class="col-sm-3 control-label">Room Type</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_roomtype" id="room_roomtype">
                                    <?php echo $roomtype_list; ?>
                                </select>                                
                            </div>
                        </div> 
                        
                        <div class="form-group ">
                            <label for="room_roomclass" class="col-sm-3 control-label">Room Class</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_roomclass" id="room_roomclass">
                                    <?php echo $roomclass_list; ?>
                                </select>                                
                            </div>
                        
                            <label class="col-sm-3 control-label col-lg-3" for="room_acctname">Account Name</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_acctname" id="room_acctname">
                                    <?php echo $accountsales_list; ?>
                                </select>
                            </div>
                        
                        </div>
                        
                        <div class="form-group ">
                            <label for="room_remark" class="col-sm-2 control-label">Remark</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="room_remark" value="<?php echo $remark; ?>" name="room_remark" type="text" />
                            </div>
                        </div>
                        

                        <div class="form-group ">
                            <label for="room_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="room_description" value="<?php echo $description; ?>" name="room_description" type="text" />
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="room_frontview">Front View</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_frontview" id="room_frontview">
                                    <option value="0" <?php
                                    if ($frontview === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($frontview === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="room_backview">Back View</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_backview" id="room_backview">
                                    <option value="0" <?php
                                    if ($backview === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($backview === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="room_groundfloor">Ground Floor</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_groundfloor" id="room_groundfloor">
                                    <option value="0" <?php
                                    if ($groundfloor === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($groundfloor === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="room_firstfloor">1st Floor</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_firstfloor" id="room_firstfloor">
                                    <option value="0" <?php
                                    if ($firstfloor === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($firstfloor === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="room_secondfloor">Second Floor</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_secondfloor" id="room_secondfloor">
                                    <option value="0" <?php
                                    if ($secondfloor === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($secondfloor === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div>
                            
                            <label class="col-sm-3 control-label col-lg-3" for="room_thirdfloor">Third Floor</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="room_thirdfloor" id="room_thirdfloor">
                                    <option value="0" <?php
                                    if ($thirdfloor === "0") {
                                        echo 'selected';
                                    }
                                    ?>>NO</option>
                                    <option value="1" <?php
                                    if ($thirdfloor === "1") {
                                        echo 'selected';
                                    }
                                    ?>>YES</option>                                    
                                </select>
                            </div> 
                        </div>
                        
                        <div class="form-group ">
                            <label class="col-sm-3 control-label col-lg-3" for="room_bed">Beds</label>
                            <div class="col-sm-3">
                                <input class=" form-control" id="room_bed" value="<?php echo $bed; ?>" name="room_bed" type="number" />
                            </div>                             
                        </div>
                        
                        
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#room_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->