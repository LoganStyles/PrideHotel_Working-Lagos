<?php
$current = $received[0];
extract($current);
$roomclass_list=displayOptions($roomclasses,0);

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
            Room Type
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
                    <!--Room Type-->
                    <div>
                        <div id="roomtype_loader"></div>
                        <div class="pull-right">

                            <div class="form-group ">
                                <div class="col-sm-12">
                                    <?php
                                    $buttons = "<a onclick=\"modalLoader('roomtype','#roomtype_modal','new',0);\" class=\"btn btn-default  \" type=\"button\"><i class=\"fa fa-plus\"></i>&nbsp;New</a>&nbsp;"; //                    
                                    if ($count >= 1) {                                        
                                        $buttons.="<a id=\"roomtype_edit\" onclick=\"\" type=\"button\" class=\"btn btn-success \"><i class=\"fa fa-edit\"></i>&nbsp;Edit</a>&nbsp;";
                                        if(isset($_SESSION["delete_group"]) && $_SESSION["delete_group"] === '1'){
                                            $buttons.="<a id=\"roomtype_delete\"onclick=\"\" type=\"button\" class=\"btn btn-primary \"><i class=\"fa fa-trash-o\"></i>&nbsp;Delete</a>&nbsp;";
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
                    <div class="" id="roomtype_data">

                    </div>

                </div>
            </section>
        </div>

    </div>
</div>

<!--body wrapper end-->

<!-- roomtype_modal Modal -->
<div id="roomtype_modal" class="modal fade <?php echo $modal_mode; ?>"  role="dialog" style="display:<?php echo $display_modal; ?>;">
    <div class="modal-dialog"> 

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header panel-heading dark">
                <h4 class="modal-title" style="text-align:center">Room Type</h4>
            </div>

            <div class="modal-body" > 
                <?php
                $attributes = array('class' => 'cmxform form-horizontal adminex-form', 'id' => 'roomtype_form');
                echo '<div id="error_div" class="' . $danger_style . '">' . $form_error . '</div>';
                echo form_open('app/processRoomtype', $attributes);
                ?>

                <div class="panel-body">
                    <div class="form">
                        <input type="hidden" name="roomtype_ID"  id="roomtype_ID" value="<?php echo $ID;?>">
                        <input type="hidden" name="roomtype_type" id="roomtype_type" value="<?php echo $type;?>">
                        <input type="hidden" name="roomtype_action" id="roomtype_action" value="<?php echo $action;?>">
                        <input type="hidden" name="roomtype_page_number" id="roomtype_page_number" value="<?php echo $page_number;?>">
                        <div class="form-group ">
                            <label for="roomtype_title" class="col-sm-3 control-label">Room Type</label>
                            <div class="col-sm-9">
                                <input class=" form-control" id="roomtype_title" value="<?php echo $title; ?>" name="roomtype_title" type="text" />
                            </div>
                        </div> 
                        
                        <div class="form-group ">
                            <label for="roomtype_beds" class="col-sm-2 control-label">Beds</label>
                            <div class="col-sm-4">
                                <input class=" form-control" id="roomtype_beds" value="<?php echo $beds; ?>" name="roomtype_beds" type="text" />
                            </div>
                        
                            <label class="col-sm-3 control-label col-lg-3" for="roomtype_roomclass">Room Class</label>
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control " name="roomtype_roomclass" id="roomtype_roomclass">
                                    <?php echo $roomclass_list; ?>
                                </select>
                            </div>
                        
                        </div>
                        
                        <div class="form-group ">
                            <label for="roomtype_remark" class="col-sm-2 control-label">Remark</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="roomtype_remark" value="<?php echo $remark; ?>" name="roomtype_remark" type="text" />
                            </div>
                        </div>
                        

                        <div class="form-group ">
                            <label for="roomtype_description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <input class=" form-control" id="roomtype_description" value="<?php echo $description; ?>" name="roomtype_description" type="text" />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="pull-right">
                    <input class="btn btn-success btn-sm" type="submit" name="submit" value="Save" />
                    <button type="button" class="btn btn-default" onclick="closeModal('#roomtype_modal');">Close</button>
                </div>
                <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--role_modal modal-->
